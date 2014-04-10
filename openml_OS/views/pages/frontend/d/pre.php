<?php
$this->initialMsgClass = '';
$this->initialMsg = '';

if (!$this->ion_auth->logged_in()) {
	$this->initialMsgClass = 'alert alert-warning';
	$this->initialMsg = 'Before submitting content, please login first!';
}

/// SEARCH
$this->terms = safe($this->input->post('searchterms'));

// get max/min qualities
$this->dqrange = array();
$dqs = $this->Dataset->query('SELECT quality, floor(min(value*1)) as min , ceiling(max(value*1)) as max FROM data_quality where data in (select did from dataset where isOriginal=\'true\') group by quality');
if ($dqs != false){
      foreach( $dqs as $r ) {
        $q = array(
          'min' => $r->min,
          'max' => $r->max
        );
        $this->dqrange[$r->quality] = $q;
      }
}

// limit by user settings
$nri = safe($this->input->post('numberinstances'));
$nrf = safe($this->input->post('numberfeatures'));
$nrc = safe($this->input->post('numberclasses'));
$nrm = safe($this->input->post('numbermissing'));
$nrm = safe($this->input->post('numbermissing'));

if(!empty($nri)){
$array = explode(',',$nri);
$this->nrinstances_min = $array[0];
$this->nrinstances_max = $array[1];} else {
$this->nrinstances_min = $this->dqrange['NumberOfInstances']['min'];
$this->nrinstances_max = $this->dqrange['NumberOfInstances']['max']; 
}
if(!empty($nrf)){
$array = explode(',',$nrf);
$this->nrfeatures_min = $array[0];
$this->nrfeatures_max = $array[1];} else {
$this->nrfeatures_min = $this->dqrange['NumberOfFeatures']['min'];
$this->nrfeatures_max = $this->dqrange['NumberOfFeatures']['max']; 
}

if(!empty($nrc)){
$array = explode(',',$nrc);
$this->nrclasses_min = $array[0];
$this->nrclasses_max = $array[1];} else {
$this->nrclasses_min = $this->dqrange['NumberOfClasses']['min'];
$this->nrclasses_max = $this->dqrange['NumberOfClasses']['max']; 
}

if(!empty($nrm)){
$array = explode(',',$nrm);
$this->nrmissing_min = $array[0];
$this->nrmissing_max = $array[1];} else {
$this->nrmissing_min = $this->dqrange['NumberOfMissingValues']['min'];
$this->nrmissing_max = $this->dqrange['NumberOfMissingValues']['max']; 
}

if( $this->terms == false && (!empty($nri) || !empty($nrf) || !empty($nrc) || !empty($nrm))){
 $this->terms = 'all';
}


$this->dataset_count = 0;
$this->results_all = array();
$this->results_runcount = array();

$this->dataset_total = $this->Dataset->numberOfRecords();
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
        $nbruns = 0;
 	$id = 0;
        $description = '';
        $nbruns = 0;
	$nbinstances = 0;
	$nbfeatures = 0;
	$nbmissing = 0;
	$nbclasses = 0;

        if ($type == 'dataset'){
	  $d = $this->Dataset->query('select d.did, d.name, d.description, count(rid) as nbruns, q.value as instances, q2.value as features, q3.value as missing, q4.value as classes from dataset d left join data_quality q on d.did=q.data left join data_quality q2 on d.did=q2.data left join data_quality q3 on d.did=q3.data left join data_quality q4 on d.did=q4.data, cvrun r where r.inputdata=d.did and q.quality=\'NumberOfInstances\' and q2.quality=\'NumberOfFeatures\' and q3.quality=\'NumberOfMissingValues\' and q4.quality=\'NumberOfClasses\' and r.inputData=d.did and q.value >= '.$this->nrinstances_min .' and q.value <= '.$this->nrinstances_max .' and q2.value >= '.$this->nrfeatures_min .' and q2.value <= '.$this->nrfeatures_max .' and q3.value >= '.$this->nrmissing_min .' and q3.value <= '.$this->nrmissing_max .' and q4.value >= '.$this->nrclasses_min .' and q4.value <= '.$this->nrclasses_max .' and d.name="'.$name.'" group by d.did');
          if( $d != false ) {
           $nbruns = $d[0]->nbruns;
           $id = $d[0]->did;
	   $nbinstances = $d[0]->instances;
	   $nbfeatures = $d[0]->features;
	   $nbmissing = $d[0]->missing;
	   $nbclasses = $d[0]->classes;
           $description = $d[0]->description;
	  }
          $this->dataset_count++;
        }
        
        $result = array(
          'type' => $type,
          'id' => $id,
          'name' => $name,
          'icon' => $icon,
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
      array_multisort($this->results_runcount, SORT_DESC, $this->results_all);
    }
  }
} else if ($this->terms != false and $this->terms == 'all'){ // all dataset
	$start_time = microtime(true);
	
	$dataset = $this->Dataset->query('select d.did, d.name, d.description, count(*) as runs, q.value as instances, q2.value as features, q3.value as missing, q4.value as classes from dataset d left join data_quality q on d.did=q.data left join data_quality q2 on d.did=q2.data left join data_quality q3 on d.did=q3.data left join data_quality q4 on d.did=q4.data, cvrun r where r.inputdata=d.did and q.quality=\'NumberOfInstances\' and q2.quality=\'NumberOfFeatures\' and q3.quality=\'NumberOfMissingValues\' and q4.quality=\'NumberOfClasses\'  and r.inputData=d.did and q.value >= '.$this->nrinstances_min .' and q.value <= '.$this->nrinstances_max .' and q2.value >= '.$this->nrfeatures_min .' and q2.value <= '.$this->nrfeatures_max .' and q3.value >= '.$this->nrmissing_min .' and q3.value <= '.$this->nrmissing_max .' and q4.value >= '.$this->nrclasses_min .' and q4.value <= '.$this->nrclasses_max .' group by d.did');  if( $dataset != false ) {
	  foreach( $dataset as $d ) {
		  $result = array(
			  'type' => 'dataset',
			  'id' => $d->did,
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
	
	$dataset = $this->Dataset->query('select d.did, d.name, d.description, count(*) as runs, q.value as instances, q2.value as features, q3.value as missing, q4.value as classes from dataset d left join data_quality q on d.did=q.data left join data_quality q2 on d.did=q2.data left join data_quality q3 on d.did=q3.data left join data_quality q4 on d.did=q4.data, cvrun r where r.inputdata=d.did and q.quality=\'NumberOfInstances\' and q2.quality=\'NumberOfFeatures\' and q3.quality=\'NumberOfMissingValues\' and q4.quality=\'NumberOfClasses\' group by d.did ORDER BY runs DESC LIMIT 0,5');
  if( $dataset != false ) {
	  foreach( $dataset as $d ) {
		  $result = array(
			  'type' => 'dataset',
			  'id' => $d->did,
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

if(false !== strpos($_SERVER['REQUEST_URI'],'/d/')) {
	$this->id = end(explode('/', $_SERVER['REQUEST_URI']));
	$this->record = $this->Dataset->getWhere('did = "' . $this->id . '"');
	$this->record = $this->record[0];
	$this->displayName = $this->record->name;
	
	$this->dt_main 						= array();
	$this->dt_main['columns'] 			= array('r.rid','rid','sid','fullName','value');
	$this->dt_main['column_widths']		= array(1,1,0,30,30);
	$this->dt_main['column_content']	= array('<a data-toggle="modal" data-id="[CONTENT]" data-target="#runModal" class="openRunModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="f/[CONTENT1]">[CONTENT2]</a>',null,null);
	$this->dt_main['column_source']		= array('wrapper','db','db','doublewrapper','db','db');
	$this->dt_main['group_by'] 		= 'l.implementation_id';
	
	$this->dt_main['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(`i`.`id`, "~", `i`.`fullName`) as fullName, round(max(`e`.`value`),4) AS `value` ' .
										'FROM algorithm_setup `l`, evaluation `e`, cvrun `r`, dataset `d`, implementation `i` ' .
										'WHERE `r`.`learner`=`l`.`sid` ' .
										'AND `l`.`implementation_id` = `i`.`id` ' . 
										'AND `r`.`inputdata`=`d`.`did` ' .
										'AND `e`.`source`=`r`.`rid` ' .
										'AND `d`.`did`="'.$this->record->did.'"';
										
	$this->dt_main_all = array();
	$this->dt_main_all['columns'] 		= array('r.rid','rid','sid','fullName','value');
	$this->dt_main_all['column_content']= array('<a data-toggle="modal" data-id="[CONTENT]" data-target="#runModal" class="openRunModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="f/[CONTENT1]">[CONTENT2]</a>',null,null);
	$this->dt_main_all['column_source']	= array('wrapper','db','db','doublewrapper','db','db');
	//$this->dt_main_all['group_by'] 	= 'l.implementation'; NONE
	
	$this->dt_main_all['base_sql'] 	= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(`i`.`id`, "~", `i`.`fullName`) as fullName, round(`e`.`value`,4) AS `value` ' .
										'FROM algorithm_setup `l`, evaluation `e`, cvrun `r`, dataset `d`, implementation `i` ' .
										'WHERE `r`.`learner`=`l`.`sid` ' .
										'AND `r`.`inputdata`=`d`.`did` ' .
										'AND `l`.`implementation_id` = `i`.`id` ' . 
										'AND `e`.`source`=`r`.`rid` ' .
										'AND `d`.`did`="'.$this->record->did.'"';
	
	$this->dt_features = array();
	$this->dt_features['columns'] 		= array('index','name','data_type','NumberOfDistinctValues','NumberOfUniqueValues','NumberOfMissingValues','MaximumValue','MinimumValue','MeanValue','StandardDeviation');
	$this->dt_features['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_features['columns']) . '` FROM `data_feature` WHERE `did`="'.$this->record->did.'"';
	$this->dt_features['column_widths']	= array(0,15,15,10,10,10,10,10,10,10);
	
	$this->dt_qualities = array();
	$this->dt_qualities['columns'] 		= array('name','description','value');
	$this->dt_qualities['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_qualities['columns']) . '` FROM `data_quality`,`quality` WHERE `data_quality`.`quality` = `quality`.`name` AND `data_quality`.`data`="'.$this->record->did.'"';
	$this->dt_qualities['column_widths']	= array(25,50,25);	
}

function cleanName($string){
	return $safe = preg_replace('/^-+|-+$/', '', strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $string)));
}

?>
