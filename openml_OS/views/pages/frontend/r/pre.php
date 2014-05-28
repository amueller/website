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
$this->total_count = 0;
$this->results_all = array();
$this->results_runcount = array();

$this->implementation_total = $this->Implementation->numberOfRecords();
$this->dataset_total = $this->Dataset->numberOfRecords();
$this->function_total = 0; // fetched later on. 

$icons = array( 'function' => 'fa fa-signal', 'implementation' => 'fa fa-cogs', 'dataset' => 'fa fa-database', 'run' => 'fa fa-star' );

$this->active_tab = gu('tab');
if($this->active_tab == false) $this->active_tab = 'searchtab';

$this->record = array();
$this->runsetup = array();
$this->runevaluations = array();

if(false !== strpos($_SERVER['REQUEST_URI'],'/r/')) { // DETAIL
	$this->run_id = end(explode('/', $_SERVER['REQUEST_URI']));
	$run = $this->Implementation->query('SELECT r.rid, r.uploader, d.did, d.name, d.version, r.setup, i.id, i.fullName, i.description, r.task_id, tt.name as taskname, r.start_time, r.status FROM run r left join task t on r.task_id=t.task_id left join task_type tt on t.ttid=tt.ttid left join task_inputs ti on (t.task_id=ti.task_id and ti.input=\'source_data\') left join dataset d on (ti.value = d.did), algorithm_setup s, implementation i WHERE rid='. $this->run_id .' and r.setup = s.sid and s.implementation_id = i.id');
     if( $run != false ) {
	$this->record = array(
		  'run_id' => $run[0]->rid,
		  'uploader' => $run[0]->uploader,
		  'data_id' => $run[0]->did,
		  'data_name' => $run[0]->name,
		  'data_version' => $run[0]->version,
		  'setup_id' => $run[0]->setup,
		  'flow_id' => $run[0]->id,
		  'flow_name' => $run[0]->fullName,
		  'flow_description' => $run[0]->description,
		  'task_id' => $run[0]->task_id,
		  'task_name' => $run[0]->taskname,
		  'start_time' => $run[0]->start_time,
		  'status' => $run[0]->status
		);
	$setup = $this->Implementation->query('SELECT iss.input, i.description, iss.value FROM input_setting iss, input i WHERE iss.setup='.  $this->record['setup_id'] . ' and iss.input = concat(i.implementation_id,\'_\',i.name)');
	if( $setup != false ) {
	   foreach( $setup as $i ) {
		$rsetup = array(
			  'input' => $i->input,
			  'description' => $i->description,
			  'value' => $i->value
			);
	        if($i->description == '') { $rsetup['description'] = 'No parameter description'; }
		$this->runsetup[] = $rsetup;
	  }
	}
	$evals = $this->Implementation->query('select function, round(value,4) as value, round(stdev, 4) as stdev, array_data from evaluation where source = '. $this->run_id);
	if( $evals != false ) {
	   foreach( $evals as $i ) {
		$revals = array(
			  'function' => $i->function,
			  'value' => $i->value, 
			  'stdev' => $i->stdev, 
			  'array_data' => $i->array_data
			);
		$this->runevaluations[] = $revals;
	  }
	}
     }
}
elseif( $this->terms != false and $this->terms != 'all') { // normal search
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
			  'uploader' => $this->db->query('SELECT CONCAT_WS(\' \',first_name, last_name) as name from users where id =' . $r->uploader)->name,
			  'time' => $r->start_time
		  );
		  $this->results_all[] = $result;
		  $this->total_count++;
    }
	}
		
	$this->time = round(microtime(true) - $start_time,3);
}

?>
