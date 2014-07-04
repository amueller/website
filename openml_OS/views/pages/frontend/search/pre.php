<?php

function addToGET($keyvalue){
      $attr = $_GET;
      foreach($keyvalue as $key => $value){
		if(array_key_exists($key,$attr))
			 unset($attr[$key]);
		if($value)
	        	$attr[$key]=$value;
      }
      return http_build_query($attr); 
}

/// SEARCH
$this->terms = safe($this->input->get('q'));
$this->coreterms = "";
$this->filters = array();

$pieces = str_getcsv($this->terms, ' ');

if(false !== strpos($_SERVER['REQUEST_URI'],'/t/type')) {
	$tasktypeid = end(explode('/', $_SERVER['REQUEST_URI']));
	$pieces[] = "tasktype.tt_id:"+$tasktypeid;
}

foreach($pieces as $t){
	if(strpos($t,':') !== false){
	  $parts = explode(":",$t);
	  $this->filters[$parts[0]] = $parts[1];
	} else {
	  $this->coreterms .= $t;
	}	
}

$this->filterstring=implode(" ",$this->filters);

$this->listids = safe($this->input->get('listids'));
$this->size = (safe($this->input->get('size')) ? safe($this->input->get('size')) : 10);

// some fields can be set beforehand. If not, set them to appropriate defaults.

if($this->input->get('from'))
	$this->from = safe($this->input->get('from'));
if(!isset($this->from))
	$this->from = 0;
if($this->input->get('type'))
	$this->filtertype = safe($this->input->get('type'));
if(!isset($this->filtertype))
	$this->filtertype = false;
if($this->input->get('sort'))
	$this->sort = safe($this->input->get('sort'));
if(!isset($this->sort))
	$this->sort = false;


$this->order = safe($this->input->get('order'));
if($this->sort and !$this->order)
   $this->order = 'desc';

$this->curr_sort = "best match";
if($this->sort=='runs')
	$this->curr_sort = "most runs";
if($this->sort=='date')
	$this->curr_sort = "most recent";
if($this->order=='asc' and $this->sort=='runs')
	$this->curr_sort = "fewest runs";
if($this->order=='asc' and $this->sort=='runs')
	$this->curr_sort = "least recent";

$attrs = $_GET;
unset($attrs['from']);
$this->rel_uri = "search?".http_build_query($attrs);

$this->icons = array( 'flow' => 'fa fa-cogs', 'data' => 'fa fa-database', 'run' => 'fa fa-star', 'user' => 'fa fa-user', 'task' => 'fa fa-trophy', 'task_type' => 'fa fa-flag', 'measure' => 'fa fa-signal');

$this->measures = array( 'estimation_procedure' => 'a/estimation-procedures', 'evaluation_measure' => 'a/evaluation-measures', 'data_quality' => 'a/data-qualities', 'flow_quality' => 'a/flow-qualities');

$query = '"match_all" : { }';
if($this->listids and $this->coreterms != ''){
	$query = '"query_string" : {
	            "query" : "'.$this->coreterms.'"
	          }';
}
elseif($this->terms != 'match_all' and $this->coreterms != ''){
	$query = '"query_string" : {
	            "fields" : ["name^5", "first_name^5", "last_name^5", "description^2","_all"],
	            "query" : "'.$this->coreterms.'"
	          }';
}

$this->active_tab = gu('tab');
$jsonfilters = array();
if($this->filtertype)
	$jsonfilters[] = '{ "type" : { "value" : "'.$this->filtertype.'" } }';
foreach($this->filters as $k => $v){
	if(strpos($v,'>') !== false and is_numeric(str_replace('>','',$v)))
		$jsonfilters[] = '{ "range" : { "'.$k.'" : { "gt" : '.str_replace('>','',$v).' } } }';
	elseif(strpos($v,'<') !== false and is_numeric(str_replace('<','',$v)))
		$jsonfilters[] = '{ "range" : { "'.$k.'" : { "lt" : '.str_replace('<','',$v).' } } }';
	elseif(strpos($v,'..') !== false and is_numeric(str_replace('..','',$v))){
		$parts = explode("..",$v);
		if(count($parts) == 2)
			$jsonfilters[] = '{ "range" : { "'.$k.'" : { "gte" : '.$parts[0].', "lte" : '.$parts[1].' } } }';
		}
	else
		$jsonfilters[] = '{ "term" : { "'.$k.'" : "'.str_replace('_',' ',$v).'"} }';
}
$fjson = implode(",",$jsonfilters);
if(count($jsonfilters)>1)
	$fjson = '"filter" : { "and" : ['.$fjson.'] },';
elseif(count($jsonfilters)>0)
	$fjson = '"filter" : '.$fjson.',';

$params['index'] = 'openml';
$params['body']  = '{
    "from" : '. ($this->from ? $this->from : 0) .',
    "size" : '. $this->size .','.
    ($this->listids ? '"fields" : [],' : '').'
    "query" : {'.$query.'},'.
    ($this->sort ? '"sort" : { "'.$this->sort.'" : "'.$this->order.'" },' : '').
    ($fjson ? $fjson : '').'
    "highlight" : {
        "fields" : {
            "_all" : {}
        }
    },
    "facets" : {
        "type" : {
          "terms" : { "field" : "_type"}
        }
    }
}';

// print_r($params);

try {
	$this->results = $this->searchclient->search($params);

} catch (Exception $e) {
	$this->results = array();
	$this->results['hits'] = array();
	$this->results['hits']['total'] = 0;
	$this->results['facets'] = array();
	$this->results['facets']['type'] = array();
	$this->results['facets']['type']['total'] = 0;
	$this->results['facets']['type']['terms'] = array();
}
?>
