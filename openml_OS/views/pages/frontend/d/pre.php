<?php
$this->initialMsgClass = '';
$this->initialMsg = '';

if (!$this->ion_auth->logged_in()) {
	$this->initialMsgClass = 'alert alert-warning';
	$this->initialMsg = 'Before submitting content, please login first!';
}

/// SEARCH
$this->terms = safe($this->input->post('searchterms'));

$this->dataset_count = 0;
$this->results_all = array();
$this->results_runcount = array();

$this->dataset_total = $this->Dataset->numberOfRecords();

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
        $name = $re->name;
        $icon = $icons[$type];
        $runs = 0;
        $description = '';
        if ($type == 'dataset'){
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
  }
} else if ($this->terms != false and $this->terms == 'all'){ // all dataset
	$start_time = microtime(true);
	
	$dataset = $this->Dataset->query('select d.name, d.description, count(*) as runs, q.value as instances, q2.value as features, q3.value as missing, q4.value as classes from dataset d left join data_quality q on d.did=q.data left join data_quality q2 on d.did=q2.data left join data_quality q3 on d.did=q3.data left join data_quality q4 on d.did=q4.data, cvrun r where r.inputdata=d.did and q.quality=\'NumberOfInstances\' and q2.quality=\'NumberOfFeatures\' and q3.quality=\'NumberOfMissingValues\' and q4.quality=\'NumberOfClasses\' group by d.did');
  if( $dataset != false ) {
	  foreach( $dataset as $d ) {
		  $result = array(
			  'type' => 'dataset',
			  'name' => $d->name,
			  'icon' => $icons['dataset'],
			  'description' => $d->description,
			  'runs' => $d->runs,
			  'instances' => $d->instances,
			  'features' => $d->features,
			  'missing' => $d->missing,
			  'classes' => $d->classes
		  );
		  $this->results_all[] = $result;
		  $this->dataset_count++;
    }
	}
		
	$this->time = round(microtime(true) - $start_time,3);
} else{ // Popular
	$start_time = microtime(true);
	
	$dataset = $this->Dataset->query('select d.name, d.description, count(*) as runs, q.value as instances, q2.value as features, q3.value as missing, q4.value as classes from dataset d left join data_quality q on d.did=q.data left join data_quality q2 on d.did=q2.data left join data_quality q3 on d.did=q3.data left join data_quality q4 on d.did=q4.data, cvrun r where r.inputdata=d.did and q.quality=\'NumberOfInstances\' and q2.quality=\'NumberOfFeatures\' and q3.quality=\'NumberOfMissingValues\' and q4.quality=\'NumberOfClasses\' group by d.did ORDER BY runs DESC LIMIT 0,5');
  if( $dataset != false ) {
	  foreach( $dataset as $d ) {
		  $result = array(
			  'type' => 'dataset',
			  'name' => $d->name,
			  'icon' => $icons['dataset'],
			  'description' => $d->description,
			  'runs' => $d->runs,
			  'instances' => $d->instances,
			  'features' => $d->features,
			  'missing' => $d->missing,
			  'classes' => $d->classes
		  );
		  $this->results_all[] = $result;
		  $this->dataset_count++;
    }
	}
		
	$this->time = round(microtime(true) - $start_time,3);
}

/// DETAIL

$this->type = 'dataset';
$this->record = false;
$this->displayName = false;
$this->measures = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
$this->current_measure = 'predictive_accuracy';

if(false !== strpos($_SERVER['REQUEST_URI'],'name')) {
	$this->dataname = html_entity_decode(gu('name'));
	$this->record = $this->Dataset->getWhere('name = "' . $this->dataname . '"');
	$this->record = $this->record[0];
	$this->displayName = $this->record->name;
	
	$this->dt_main 						= array();
	$this->dt_main['columns'] 			= array('img_open','rid','sid','i.fullName','value');
	$this->dt_main['column_widths']		= array(10,0,0,30,30);
	$this->dt_main['column_content']	= array('<img src="img/datatables/details_open.png">',null,null,'<a href="f/name/[CONTENT]">[CONTENT]</a>',null);
	$this->dt_main['column_source']		= array('content','db','db','wrapper','db');
	$this->dt_main['group_by'] 			= 'l.implementation_id';
	
	$this->dt_main['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, `i`.`fullName`, max(`e`.`value`) AS `value` ' .
										'FROM algorithm_setup `l`, evaluation `e`, cvrun `r`, dataset `d`, implementation `i` ' .
										'WHERE `r`.`learner`=`l`.`sid` ' .
										'AND `l`.`implementation_id` = `i`.`id` ' . 
										'AND `r`.`inputdata`=`d`.`did` ' .
										'AND `e`.`source`=`r`.`rid` ' .
										'AND `d`.`name`="'.$this->record->name.'"';
										
	$this->dt_main_all = array();
	$this->dt_main_all['columns'] 		= array('img_open','rid','sid','i.fullName','value');
	$this->dt_main_all['column_content']= array('<img src="img/datatables/details_open.png">',null,null,'<a href="f/name/[CONTENT]">[CONTENT]</a>',null);
	$this->dt_main_all['column_source']	= array('content','db','db','wrapper','db');
	//$this->dt_main_all['group_by'] 	= 'l.implementation'; NONE
	
	$this->dt_main_all['base_sql'] 	= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, `i`.`fullName`, `e`.`value` AS `value` ' .
										'FROM algorithm_setup `l`, evaluation `e`, cvrun `r`, dataset `d`, implementation `i` ' .
										'WHERE `r`.`learner`=`l`.`sid` ' .
										'AND `r`.`inputdata`=`d`.`did` ' .
										'AND `l`.`implementation_id` = `i`.`id` ' . 
										'AND `e`.`source`=`r`.`rid` ' .
										'AND `d`.`name`="'.$this->record->name.'"';
	
	$this->dt_features = array();
	$this->dt_features['columns'] 		= array('index','name','data_type','NumberOfDistinctValues','NumberOfUniqueValues','NumberOfMissingValues','MaximumValue','MinimumValue','MeanValue','StandardDeviation');
	$this->dt_features['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_features['columns']) . '` FROM `data_feature` WHERE `did`="'.$this->record->did.'"';
	$this->dt_features['column_widths']	= array(0,15,15,10,10,10,10,10,10,10);
	
	$this->dt_qualities = array();
	$this->dt_qualities['columns'] 		= array('name','description','value');
	$this->dt_qualities['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_qualities['columns']) . '` FROM `data_quality`,`quality` WHERE `data_quality`.`quality` = `quality`.`name` AND `data_quality`.`data`="'.$this->record->did.'"';
	$this->dt_qualities['column_widths']	= array(25,50,25);	
}

?>
