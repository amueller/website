<?php

$this->terms = safe($this->input->post('searchterms'));

$this->implementation_count = 0;
$this->function_count = 0;
$this->dataset_count = 0;
$this->results_all = array();
$this->results_runcount = array();

$this->implementation_total = $this->Implementation->numberOfRecords();
$this->dataset_total = $this->Dataset->numberOfRecords();
$this->function_total = 0; // fetched later on. 

$icons = array( 'function' => 'icon-signal', 'implementation' => 'icon-cog', 'dataset' => 'icon-list-alt' );

$this->active_tab = gu('tab');
if($this->active_tab == false) $this->active_tab = 'searchtab';


if( $this->terms != false ) {
	$eval = APPPATH . 'third_party/OpenML/Java/evaluate.jar';
	$res = array();
	$code = 0;
	$command = 'java -jar '.APPPATH.'third_party/OpenML/Java/luceneSearch.jar search -index '.DATA_PATH.'search_index -query "' . $this->terms . '"';
	
	exec( $command, $res, $code );
	
	$results = json_decode( implode( "\n", $res ) );
	$this->time = $results->time;
	$this->total_count = $results->nr_results;
	
	if($this->total_count > 0){	
	
		foreach( $results->results as $re ) {
			$type = $re->type;
			$name = $re->name;
			$icon = $icons[$type];
			$runs = 0;
			$description = '';
			if ($type == 'implementation'){
				$description = $this->Implementation->getColumnWhere('description', 'fullname = "'.$name.'"');
				$count = $this->Implementation->query('select count(rid) as nbruns from cvrun r, algorithm_setup s where r.learner = s.sid and s.implementation_id = (SELECT id FROM implementation WHERE fullName ="'.$name.'")');
				$runs = $count[0]->nbruns;
				$this->implementation_count++;
			}
			elseif ($type == 'function'){
				$description = $this->Math_function->getColumnWhere('description', 'name = "'.$name.'"');
				$this->function_count++;
			}
			elseif ($type == 'dataset'){
				$description = $this->Dataset->getColumnWhere('description', 'name = "'.$name.'"');
				$count = $this->Dataset->query('select count(rid) as nbruns from cvrun r, dataset d where r.inputData=d.did and d.name="'.$name.'"');
				$runs = $count[0]->nbruns;
				$this->dataset_count++;
			}
			
			$result = array(
				'type' => $type,
				'name' => $name,
				'icon' => $icon,
				'description' => $description[0],
				'runs' => $runs
			);
			$this->results_runcount[] = $runs;
			$this->results_all[] = $result;
		}
    array_multisort($this->results_runcount, SORT_DESC, $this->results_all);
	}
} else {
	$start_time = microtime(true);
	
	$datasets = $this->Dataset->query('SELECT dataset.name, dataset.description, COUNT(*) as runs FROM cvrun RIGHT JOIN dataset ON cvrun.inputData = dataset.did GROUP BY inputData ORDER BY runs DESC LIMIT 0,30');
  if( $datasets != false ) {
	  foreach( $datasets as $d ) {
		  $result = array(
			  'type' => 'dataset',
			  'name' => $d->name,
			  'icon' => $icons['dataset'],
			  'description' => $d->description,
			  'runs' => $d->runs
		  );
		  $this->results_all[] = $result;
		  $this->dataset_count++;
    }
	}
	
	$implementation = $this->Implementation->query('SELECT i.fullName, i.description, COUNT(*) as runs FROM implementation i, cvrun r RIGHT JOIN algorithm_setup s ON r.learner = s.sid WHERE s.implementation_id = i.id GROUP BY s.implementation_id ORDER BY runs DESC LIMIT 0,30');
  if( $implementation != false ) {
	  foreach( $implementation as $i ) {
		  $result = array(
			  'type' => 'implementation',
			  'name' => $i->fullName,
			  'icon' => $icons['implementation'],
			  'description' => $i->description,
			  'runs' => $i->runs
		  );
		  $this->results_all[] = $result;
		  $this->implementation_count++;
    }
	}
	
	$functions = $this->Math_function->getWhere('functionType = "EvaluationFunction"');
	$this->function_total = count($functions);
  if( $functions != false ) {
	  foreach( $functions as $f ) {
		  $result = array(
			  'type' => 'function',
			  'name' => $f->name,
			  'icon' => $icons['function'],
			  'description' => $f->description,
			  'runs' => 0
		  );
		  $this->results_all[] = $result;
		  $this->function_count++;
	  }
  }
	
	$this->time = round(microtime(true) - $start_time,3);
}

// task search
$this->ep = $this->Estimation_procedure->get();
$this->found_tasks = array();
$this->task_message = false;
$this->att = 'supervised_classification';

?>
