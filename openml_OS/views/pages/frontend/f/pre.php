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
$this->results_all = array();
$this->results_runcount = array();

$this->implementation_total = $this->Implementation->numberOfRecords();

$icons = array( 'function' => 'fa fa-signal', 'implementation' => 'fa fa-cog', 'dataset' => 'fa fa-list-alt' );

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
        $name = $re->name;
        $icon = $icons[$type];
        $runs = 0;
        $description = '';
        if ($type == 'implementation'){
          $description = $this->Implementation->getColumnWhere('description', 'fullname = "'.$name.'"');
          $count = $this->Implementation->query('select count(rid) as nbruns, s.implementation_id as id from cvrun r, algorithm_setup s where r.learner = s.sid and s.implementation_id = (SELECT id FROM implementation WHERE fullName ="'.$name.'")');
          $runs = $count[0]->nbruns;
          $id = $count[0]->id;
          $this->implementation_count++;
        }
        elseif ($type == 'function'){
          $description = $this->Math_function->getColumnWhere('description', 'name = "'.$name.'"');
          $this->function_count++;
        }
        elseif ($type == 'dataset'){
          $description = $this->Dataset->getColumnWhere('description', 'name = "'.$name.'"');
          $count = $this->Dataset->query('select count(rid) as nbruns, did as id from cvrun r, dataset d where r.inputData=d.did and d.name="'.$name.'"');
          $id = $count[0]->id;
          $runs = $count[0]->nbruns;
          $this->dataset_count++;
        }
        
        $result = array(
          'type' => $type,
          'id' => $id,
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
  }
} else if ($this->terms != false and $this->terms == 'all'){ // all implementations
	$start_time = microtime(true);
	
	$implementation = $this->Implementation->query('SELECT i.id, i.fullName, i.description, COUNT(*) as runs FROM implementation i, cvrun r RIGHT JOIN algorithm_setup s ON r.learner = s.sid WHERE s.implementation_id = i.id and i.fullName<>\'weka.Evaluation(1.86)\' GROUP BY s.implementation_id ORDER BY i.fullName');
  if( $implementation != false ) {
	  foreach( $implementation as $i ) {
		  $result = array(
			  'id' => $i->id,
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
		
	$this->time = round(microtime(true) - $start_time,3);
} else{ // Popular
	$start_time = microtime(true);
	
	$implementation = $this->Implementation->query('SELECT i.id, i.fullName, i.description, COUNT(*) as runs FROM implementation i, cvrun r RIGHT JOIN algorithm_setup s ON r.learner = s.sid WHERE s.implementation_id = i.id and i.fullName<>\'weka.Evaluation(1.86)\' GROUP BY s.implementation_id ORDER BY runs DESC LIMIT 0,5');
  if( $implementation != false ) {
	  foreach( $implementation as $i ) {
		  $result = array(
			  'id' => $i->id,
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
		
	$this->time = round(microtime(true) - $start_time,3);
}

/// DETAIL

$this->type = 'implementation';
$this->record = false;
$this->displayName = false;
$this->measures = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
$this->current_measure = 'predictive_accuracy';

if(false !== strpos($_SERVER['REQUEST_URI'],'/f/')) {
	$this->id = end(explode('/', $_SERVER['REQUEST_URI']));
	$this->record = $this->Implementation->getByID($this->id);
	$this->displayName = $this->record->fullName;
	
	$this->dt_main['columns'] 		= array('r.rid','rid','sid','name','value');
	$this->dt_main['column_widths']		= array(1,1,0,60,30);
	$this->dt_main['column_content']	= array('<a data-toggle="modal" data-id="[CONTENT]" data-target="#runModal" class="openRunModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="d/[CONTENT1]">[CONTENT2]</a>',null);
	$this->dt_main['column_source'] 	= array('wrapper','db','db','doublewrapper','db');
	$this->dt_main['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(d.did, "~", d.name) as name, round(e.value,4) as value '.
										'FROM algorithm_setup l, evaluation e, cvrun r, dataset d '.
										'WHERE r.learner=l.sid  '.
										'AND l.implementation_id="'.$this->record->id.'"  '.
										'AND l.isDefault="true"' . 
										'AND r.inputdata=d.did  '.
										'AND d.isOriginal="true"  '.
										'AND e.source=r.rid  ';

	$this->dt_main_all['columns'] 		= array('r.rid','rid','sid','name','value');
	$this->dt_main_all['column_widths']		= array(1,1,0,60,30);
	$this->dt_main_all['column_content']	= array('<a data-toggle="modal" data-id="[CONTENT]" data-target="#runModal" class="openRunModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="d/[CONTENT1]">[CONTENT2]</a>',null);
	$this->dt_main_all['column_source'] 	= array('wrapper','db','db','doublewrapper','db');
	
	$this->dt_main_all['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(d.did, "~", d.name) as name, round(e.value,4) as value '.
										'FROM algorithm_setup l, evaluation e, cvrun r, dataset d  '.
										'WHERE r.learner=l.sid  '.
										'AND l.implementation_id="'.$this->record->id.'"  '.
										'AND r.inputdata=d.did  '.
										'AND d.isOriginal="true"  '.
										'AND e.source=r.rid  ';

	$this->dt_params = array();
	$this->dt_params['columns'] 		= array('name', 'generalName', 'defaultValue', 'min', 'max');
	$this->dt_params['column_widths']	= array(10,20,30,10,10,10,10);
	$this->dt_params['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_params['columns']) . '` FROM input WHERE implementation_id ="'.$this->record->id.'" ';
	
	$this->dt_qualities = array();
	$this->dt_qualities['columns'] 		= array('name','description','value');
	$this->dt_qualities['column_widths']= array(25,50,25);
	$this->dt_qualities['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_qualities['columns']) . '` FROM `algorithm_quality`,`quality` WHERE `algorithm_quality`.`quality` = `quality`.`name` AND `algorithm_quality`.`implementation_id`="'.$this->record->id.'"';


	
}

?>
