<?php

$this->load_javascript = array('js/libs/highcharts.js','js/libs/jquery.dataTables.min.js');
$this->load_css = array('css/jquery.dataTables.min.css','css/dataTables.colvis.min.css','css/dataTables.colvis.jqueryui.css','css/dataTables.responsive.min.css','css/dataTables.scroller.min.css','css/dataTables.tableTools.min.css');

$this->user_id = -1;
if ($this->ion_auth->logged_in()) {
	$this->user_id = $this->ion_auth->user()->row()->id;
}

/// SEARCH
$this->filtertype = 'task';
$this->sort = 'runs';
if($this->input->get('sort'))
	$this->sort = safe($this->input->get('sort'));

$this->active_tab = gu('tab');
if($this->active_tab == false) $this->active_tab = 'searchtab';

/// TYPE DETAIL

$this->record = array();
$this->taskio = array();

if(false !== strpos($_SERVER['REQUEST_URI'],'/t/type') || false !== strpos($_SERVER['REQUEST_URI'],'/t/search/type')) {
	$info = explode('/', $_SERVER['REQUEST_URI']);
	$this->id = explode('?',$info[array_search('t',$info)+1])[0];

	$type = $this->Implementation->query('SELECT * FROM task_type WHERE ttid=' . $this->id );
	if( $type != false ) {
		$this->record = array(
			  'id' => $type[0]->ttid,
			  'name' => $type[0]->name,
			  'description' => $type[0]->description,
			  'authors' => $type[0]->creator,
			  'contributors' => $type[0]->contributors
			);

	$io = $this->Implementation->query('SELECT i.name, i.description, i.type, i.io, i.requirement, t.description as typedescription  FROM task_type_inout i left join task_io_types t on i.type = t.name WHERE requirement <> "hidden" AND ttid=' . $this->id );
	if( $io != false ) {
	  foreach( $io as $i ) {
		$inout = array(
			  'name' => $i->name,
			  'description' => $i->description,
			  'typedescription' => $i->typedescription,
			  'type' => $i->type,
			  'category' => $i->io,
			  'requirement' => $i->requirement
			);
		$this->taskio[] = $inout;
	  }
	}
	}
}

/// TASK DETAIL

if(false === strpos($_SERVER['REQUEST_URI'],'type') && false !== strpos($_SERVER['REQUEST_URI'],'/t/')) {
	$info = explode('/', $_SERVER['REQUEST_URI']);
	$this->id = explode('?',$info[array_search('t',$info)+1])[0];
	$this->task_id = $this->id;

	$io = $this->Implementation->query('SELECT value FROM task_inputs WHERE task_id='.$this->task_id.' AND input = "source_data"' );
	if( $io != false ) {
	  $this->dataid = $io[0]->value;
	}

	//get data from ES
	$this->p = array();
	$this->p['index'] = 'openml';
	$this->p['type'] = 'task';
	$this->p['id'] = $this->task_id;
        
        $this->down = array();
        $this->down['index'] = 'openml';
        $this->down['type'] = 'downvote';
        $json = '{
                    "query": {
                      "bool": {
                        "must": [
                          { "match": { "knowledge_type":  "t" }},
                          { "match": { "knowledge_id": '.$this->id.'   }}
                        ]
                      }
                    }
                  }';
        $this->down['body'] = $json;
        if ($this->ion_auth->logged_in()) {
            $this->l = array();
            $this->l['index'] = 'openml';
            $this->l['type'] = 'like';
            $json = '{
                        "query": {
                          "bool": {
                            "must": [
                              { "match": { "knowledge_type":  "t" }},
                              { "match": { "knowledge_id": '.$this->id.'   }},
                              { "match": { "user_id": '.$this->ion_auth->user()->row()->id.'}}
                            ]
                          }
                        }
                      }';
            $this->l['body'] = $json;
        }
	try{
		$result = $this->searchclient->get($this->p);
		$this->task = $result['_source'];
                $this->downvotes = $this->searchclient->search($this->down)['hits']['hits'];
                if ($this->ion_auth->logged_in()) {
                  $this->activeuserlike = $this->searchclient->search($this->l)['hits']['hits'];
                }
	} catch (Exception $e) {}

	$task = $this->Implementation->query('SELECT t.task_id, t.ttid, tt.name, tt.description FROM task t, task_type tt WHERE t.ttid=tt.ttid and task_id=' . $this->task_id );
	if( $task != false ) {
		$this->record = array(
			  'task_id' => $task[0]->task_id,
			  'type_id' => $task[0]->ttid,
			  'type_name' => $task[0]->name,
			  'type_description' => $task[0]->description
			);
	$count = $this->Implementation->query('SELECT group_concat(rid) as runs, count(rid) as count from run where task_id=' . $this->task_id );
	$this->record['runcount'] = $count[0]->count;
	$this->record['runs'] = $count[0]->runs;

	$type = $this->Implementation->query('SELECT * FROM task_type WHERE ttid=' . $this->record['type_id'] );
	if( $type != false ) {
		$this->typedescription = $type[0]->description;
	}

	$this->default_measure = false;
	$io = $this->Implementation->query('SELECT io.name, io.type, io.description, tt.description as typedescription, io.io, io.requirement, ti.value FROM task_type_inout io left join task_inputs ti on (io.name = ti.input and ti.task_id=' . $this->task_id . ") left join task_io_types tt on io.type=tt.name WHERE io.ttid=" . $this->record['type_id'] );
	if( $io != false ) {
	  foreach( $io as $i ) {
		$inout = array(
			  'name' => $i->name,
			  'type' => $i->type,
			  'description' => $i->description,
			  'typedescription' => $i->typedescription,
			  'category' => $i->io,
			  'value' => $i->value,
			  'requirement' => $i->requirement
			);
		if($i->type == 'Dataset' && is_numeric($i->value)){
			$dataset = $this->Implementation->query('SELECT name, version FROM dataset where did=' . $i->value);
			$inout['dataset'] = $dataset[0]->name . " (" . $dataset[0]->version . ")";
			$this->sourcedata_id = $i->value;
			$this->sourcedata_name = $inout['dataset'];
		}
		elseif($i->type == 'Estimation Procedure'){
			$ep = $this->Implementation->query('SELECT name FROM estimation_procedure where id=' . $i->value);
			$inout['evalproc'] = $ep[0]->name;
		}
		if($inout['name'] == 'evaluation_measures' and strlen($inout['value'])>0)
				$this->default_measure = str_replace(' ','_',$inout['value']);

		$this->taskio[] = $inout;
	  }
	}
	}
}

// evaluations
$this->current_measure = 'predictive_accuracy';
if($this->default_measure)
	$this->current_measure = $this->default_measure;

$this->allmeasures = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');

// datatables
  $this->dt_main         = array();
  $this->dt_main['columns']     = array('r.rid','rid','sid','fullName','value');
  $this->dt_main['column_widths']    = array(1,1,0,30,30);
  $this->dt_main['column_content']  = array('<a data-toggle="modal" href="r/[CONTENT]/html" data-target="#runModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="f/[CONTENT1]">[CONTENT2]</a>',null,null);
  $this->dt_main['column_source']    = array('wrapper','db','db','doublewrapper','db','db');
  $this->dt_main['group_by']     = 'l.implementation_id, l.sid';

  $this->dt_main['base_sql']     =   'SELECT SQL_CALC_FOUND_ROWS MAX(`r`.`rid`) AS `rid`, `l`.`sid`, concat(`i`.`id`, "~", `i`.`fullName`) as fullName, round(max(`e`.`value`),4) AS `value` ' .
                    'FROM algorithm_setup `l`, evaluation `e`, run `r`, implementation `i` ' .
                    'WHERE `r`.`setup`=`l`.`sid` ' .
                    'AND `l`.`implementation_id` = `i`.`id` ' .
                    'AND `e`.`source`=`r`.`rid` ';

  $this->dt_main_all = array();
  $this->dt_main_all['columns']     = array('r.rid','rid','sid','fullName','value');
  $this->dt_main_all['column_content']= array('<a data-toggle="modal" href="r/[CONTENT]/html" data-target="#runModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="f/[CONTENT1]">[CONTENT2]</a>',null,null);
  $this->dt_main_all['column_source']  = array('wrapper','db','db','doublewrapper','db','db');
  //$this->dt_main_all['group_by']   = 'l.implementation'; NONE

  $this->dt_main_all['base_sql']   =   'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(`i`.`id`, "~", `i`.`fullName`) as fullName, round(`e`.`value`,4) AS `value` ' .
                    'FROM algorithm_setup `l`, evaluation `e`, run `r`, implementation `i` ' .
                    'WHERE `r`.`setup`=`l`.`sid` ' .
                    'AND `l`.`implementation_id` = `i`.`id` ' .
                    'AND `e`.`source`=`r`.`rid` ';
?>
