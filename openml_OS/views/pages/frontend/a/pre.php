<?php
$this->initialMsgClass = '';
$this->initialMsg = '';

if (!$this->ion_auth->logged_in()) {
	$this->initialMsgClass = 'alert alert-warning';
	$this->initialMsg = 'Before submitting content, please login first!';
}

/// SEARCH
$this->terms = safe($this->input->post('searchterms'));

$this->implementation_count = 0;
$this->function_count = 0;
$this->dataset_count = 0;
$this->results_all = array();
$this->results_runcount = array();

$this->implementation_total = $this->Implementation->numberOfRecords();
$this->dataset_total = $this->Dataset->numberOfRecords();
$this->function_total = 0; // fetched later on. 

$icons = array( 'function' => 'fa fa-signal', 'implementation' => 'fa fa-cog', 'dataset' => 'fa fa-list-alt' );

$this->active_tab = gu('tab');
if($this->active_tab == false) $this->active_tab = 'searchtab';

if( $this->terms != false and $this->terms != 'all') { // normal search
	$eval = APPPATH . 'third_party/OpenML/Java/evaluate.jar';
	$res = array();
	$code = 0;
	$command = 'java -jar '.APPPATH.'third_party/OpenML/Java/luceneSearch.jar search -index '.DATA_PATH.'search_index -query "' . $this->terms . '"';
	
	exec( $command, $res, $code );
	
	$results = json_decode( implode( "\n", $res ) );
  $this->total_count = 0;
  
  if( $results ) {
    $this->time = $results->time;
    $this->total_count = $results->nr_results;
    
    if($this->total_count > 0){	
    
      foreach( $results->results as $re ) {
        $type = $re->type;
	$link = "";
        $name = $re->name;
        $icon = $icons[$type];
        $nbruns = 0;
	$id = 0;
	$link = "";
        $description = '';
	$nbinstances = 0;
	$nbfeatures = 0;
	$nbmissing = 0;
	$nbclasses = 0;
        
	if ($type == 'implementation'){
	  $i = $this->Implementation->query('select count(rid) as nbruns, i.id as id, i.description from cvrun r, algorithm_setup s, implementation i where r.learner = s.sid and s.implementation_id = i.id and i.fullName ="'.$name.'"');
          if( $i != false ) {
	  	$description = $i[0]->description;
          	$nbruns = $i[0]->nbruns;
          	$id = $i[0]->id;
		$link = 'f/'.$id;
	  }
          $this->implementation_count++;
        }
     	else if ($type == 'dataset'){
	  $d = $this->Dataset->query('select d.did, d.name, d.description, count(rid) as nbruns, q.value as instances, q2.value as features, q3.value as missing, q4.value as classes from dataset d left join data_quality q on d.did=q.data left join data_quality q2 on d.did=q2.data left join data_quality q3 on d.did=q3.data left join data_quality q4 on d.did=q4.data, cvrun r where r.inputdata=d.did and q.quality=\'NumberOfInstances\' and q2.quality=\'NumberOfFeatures\' and q3.quality=\'NumberOfMissingValues\' and q4.quality=\'NumberOfClasses\' and r.inputData=d.did and d.name="'.$name.'" group by d.did');
          if( $d != false ) {
           $nbruns = $d[0]->nbruns;
           $id = $d[0]->did;
	   $nbinstances = $d[0]->instances;
	   $nbfeatures = $d[0]->features;
	   $nbmissing = $d[0]->missing;
	   $nbclasses = $d[0]->classes;
           $description = $d[0]->description;
	   $link = 'd/'.$id;
	  }
          $this->dataset_count++;
        }
        if (strlen($link)){
	  $result = array(
          'type' => $type,
          'id' => $id,
          'name' => $name,
          'icon' => $icon,
	  'link' => $link,
          'description' => $description,
          'runs' => $nbruns,
	  'instances' => $nbinstances,
	  'features' => $nbfeatures,
	  'missing' => $nbmissing,
	  'classes' => $nbclasses
          );
          $this->results_runcount[] = $nbruns;
          $this->results_all[] = $result;
	}
      }
      array_multisort($this->results_runcount, SORT_DESC, $this->results_all);
    }
  }
}


$this->evals = array();
$this->procs = array();
$this->dataqs = array();
$this->dataqvals = array();
$this->algoqs = array();
$this->algoqvals = array();


function cleanName($string){
	return $safe = preg_replace('/^-+|-+$/', '', strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $string)));
}

if(false === strpos($_SERVER['REQUEST_URI'],'/a/') || false !== strpos($_SERVER['REQUEST_URI'],'/a/evaluation-measures')) {
	$this->name = end(explode('/', $_SERVER['REQUEST_URI']));
	$evalq = $this->Dataset->query('select * from math_function where functionType=\'EvaluationFunction\'');
	if( $evalq != false ) {
		  foreach( $evalq as $i ) {
			$eval = array(
				  'name' => $i->name,
				  'min' => $i->min,
				  'max' => $i->max,
				  'unit' => $i->unit,
				  'higherIsBetter' => $i->higherIsBetter,
				  'description' => $i->description
				);
			$this->evals[] = $eval;
			if (cleanName($eval['name']) == $this->name) $this->record = $eval;
		   }
	}
}	
if(false === strpos($_SERVER['REQUEST_URI'],'/a/') || false !== strpos($_SERVER['REQUEST_URI'],'/a/estimation-procedures')) {
	$this->name = end(explode('/', $_SERVER['REQUEST_URI']));
	$procq = $this->Dataset->query('SELECT p.name, p.repeats, p.folds, p.percentage, p.stratified_sampling, t.description, tt.name as typename FROM estimation_procedure p, estimation_procedure_type t, task_type tt WHERE p.type = t.name and p.ttid = tt.ttid');
	if( $procq != false ) {
		  foreach( $procq as $i ) {
			$proc = array(
				  'name' => $i->name . ' for ' . $i->typename,
				  'repeats' => $i->repeats,
				  'folds' => $i->folds,
				  'percentage' => $i->percentage,
				  'stratified' => $i->stratified_sampling,
				  'description' => $i->description,
				  'type_name' => $i->typename
				);
			$this->procs[] = $proc;
			if (cleanName($proc['name']) == $this->name) $this->record = $proc;
		   }
	}
}
if(false === strpos($_SERVER['REQUEST_URI'],'/a/') || false !== strpos($_SERVER['REQUEST_URI'],'/a/data-qualities')) {
	$this->name = end(explode('/', $_SERVER['REQUEST_URI']));
	$dataq = $this->Dataset->query('SELECT q.quality, count(q.quality) as count, qq.description FROM data_quality q, quality qq, dataset d where q.quality = qq.name and d.did = q.data and d.isOriginal=\'true\' group by quality');
	if( $dataq != false ) {
		  foreach( $dataq as $i ) {
			$q = array(
				  'name' => $i->quality,
				  'description' => $i->description,
				  'count' => $i->count,
				);
			$this->dataqs[] = $q;
			if (cleanName($q['name']) == $this->name) $this->record = $q;
		   }
	}
	if (isset($this->record)){
		$dataq = $this->Dataset->query('SELECT d.did, d.name, d.version, q.value FROM data_quality q, dataset d where d.did=q.data and quality=\''.$this->record['name'].'\' and d.isOriginal=\'true\' order by value * 1 asc');
		if( $dataq != false ) {
			  foreach( $dataq as $i ) {
				$q = array(
					  'did' => $i->did,
					  'data_name' => $i->name,
					  'data_version' => $i->version,
					  'value' => $i->value
					);
				$this->dataqvals[] = $q;
			   }
		}
	}
}
if(false === strpos($_SERVER['REQUEST_URI'],'/a/') || false !== strpos($_SERVER['REQUEST_URI'],'/a/flow-qualities')) {
	$this->name = end(explode('/', $_SERVER['REQUEST_URI']));
	$dataq = $this->Dataset->query('SELECT q.quality, count(q.quality) as count, qq.description FROM algorithm_quality q, quality qq where q.quality = qq.name group by quality');
	if( $dataq != false ) {
		  foreach( $dataq as $i ) {
			$q = array(
				  'name' => $i->quality,
				  'description' => $i->description,
				  'count' => $i->count,
				);
			$this->algoqs[] = $q;
			if (cleanName($q['name']) == $this->name) $this->record = $q;
		   }
	}
	if (isset($this->record)){
		$dataq = $this->Dataset->query('SELECT i.id, i.fullName, q.value FROM algorithm_quality q, implementation i where i.id=q.implementation_id and q.quality=\''.$this->record['name'].'\' order by value * 1 asc');
		if( $dataq != false ) {
			  foreach( $dataq as $i ) {
				$q = array(
					  'id' => $i->id,
					  'flow_name' => $i->fullName,
					  'value' => $i->value
					);
				$this->algoqvals[] = $q;
			   }
		}
	}
}



?>
