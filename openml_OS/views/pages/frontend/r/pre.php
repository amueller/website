<?php
$this->initialMsgClass = '';
$this->initialMsg = '';

if (!$this->ion_auth->logged_in()) {
	$this->initialMsgClass = 'alert alert-warning';
	$this->initialMsg = 'Before submitting content, please login first!';
}

$this->datasets 			= $this->Dataset->getColumnWhere( 'name', 'isOriginal = "true"', '`name` ASC' );
$this->datasetIds 			= $this->Dataset->getColumn( 'did', 'did' );
$this->datasetVersion		= $this->Dataset->getColumnFunction( 'CONCAT(`name`,"(",`version`,")")', '`name` ASC' );
$this->datasetVersionOriginal= $this->Dataset->getColumnFunctionWhere( 'CONCAT(`name`,"(",`version`,")")', 'isOriginal = "true"', '`name` ASC' );

$this->formats				= $this->Dataset->getDistinct( 'format' );
$this->licences				= $this->Dataset->getDistinct( 'licence' );

$this->evaluationMetrics	= $this->Math_function->getColumnWhere( 'name', 'functionType = "EvaluationFunction"' );
//$this->classificationEvaluationMetrics	= $this->Task_type_function->getColumnWhere( 'math_function', 'ttid = 1' );
//$this->regressionEvaluationMetrics	= $this->Task_type_function->getColumnWhere( 'math_function', 'ttid = 2' );

$this->taskTypes			= $this->Task_type->getColumn( 'name' );

$this->collections			= $this->Dataset->getDistinct( 'collection' );

$this->algorithms = array();
$this->implementations = array();
$implementationsAlgorithms  = $this->Implementation->getColumns( '`implementation`.`fullName`, `implementation`.`implements`', '`implements` ASC' );
foreach( $implementationsAlgorithms as $i ) {
	if( $i->implements != false )
		$this->algorithms[] = $i->implements;
	$this->implementations[] = $i->fullName;
}

/// SEARCH
$this->terms = safe($this->input->post('searchterms'));

$this->implementation_count = 0;
$this->function_count = 0;
$this->dataset_count = 0;
$this->total_count = 0;
$this->results_all = array();
$this->results_runcount = array();

$this->implementation_total = $this->Implementation->numberOfRecords();
$this->dataset_total = $this->Dataset->numberOfRecords();
$this->function_total = 0; // fetched later on. 

$icons = array( 'function' => 'fa fa-signal', 'implementation' => 'fa fa-cogs', 'dataset' => 'fa fa-database', 'run' => 'fa fa-star' );

$this->active_tab = gu('tab');
if($this->active_tab == false) $this->active_tab = 'searchtab';

if(false == strpos($_SERVER['REQUEST_URI'],'/r/') and $this->terms != false and $this->terms != 'all') { // normal search
	$eval = APPPATH . 'third_party/OpenML/Java/evaluate.jar';
	$res = array();
	$code = 0;
	$command = 'java -jar '.APPPATH.'third_party/OpenML/Java/luceneSearch.jar search -index '.DATA_PATH.'search_index -query "' . $this->terms . '"';
	
	exec( $command, $res, $code );
	
	$results = json_decode( implode( "\n", $res ) );
  
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
} else{ // Popular
	$start_time = microtime(true);
	
	$runs = $this->Dataset->query('SELECT r.rid, r.uploader, i.id, i.fullName, r.task_id, tt.name as taskname, d.did, d.name as dataname, r.start_time FROM run r, algorithm_setup als, implementation i, task t, task_type tt, task_inputs ti left join dataset d on ti.value = d.did WHERE status=\'OK\' and r.task_id=t.task_id and t.ttid=tt.ttid and t.task_id = ti.task_id and ti.input=\'source_data\' and r.setup = als.sid and als.implementation_id=i.id order by r.start_time desc limit 0,30');
  if( $runs != false ) {
	  foreach( $runs as $r ) {
		  $author = $this->Author->getById($r->uploader);
		  $result = array(
			  'type' => 'run',
			  'icon' => $icons['run'],
		          'id' => $r->rid,
			  'task' => $r->task_id,
			  'taskname' => $r->taskname,
			  'data' => $r->did,
			  'dataname' => $r->dataname,
			  'flow' => $r->id,
			  'flowname' => $r->fullName,
			  'uploader' =>  $author->first_name . ' ' . $author->last_name,
			  'time' => $r->start_time
		  );
		  $this->results_all[] = $result;
		  $this->total_count++;
    }
	}
		
	$this->time = round(microtime(true) - $start_time,3);
}

?>
