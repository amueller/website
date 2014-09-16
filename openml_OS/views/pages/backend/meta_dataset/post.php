<?php
$flows = $this->input->post('flows');
$datasets = $this->input->post('datasets');
$functions = $this->input->post('functions');

$legal_functions = $this->Math_function->getColumnWhere( 'name', 'functionType = "EvaluationFunction"'  );
var_dump( $legal_functions );

if( $flows && is_cs_natural_numbers( $flows ) == false ) {
  sm('Illegal value for flow list');
  su('backend/page/meta_dataset');
}

if( $datasets && is_cs_natural_numbers( $datasets ) == false ) {
  sm('Illegal value for dataset list');
  su('backend/page/meta_dataset');
}

foreach( $functions as $f ) {
  if( in_array( $f, $legal_functions ) == false ) {
    sm('Illegal value in function list');
    su('backend/page/meta_dataset');
  }
}

$functions = implode( ',', $functions );

$md = array( 
  'datasets' => $datasets ? $datasets : null,
  'flows' => $flows ? $flows : null,
  'functions' => $functions ? $functions : null,
  'user_id' => $this->ion_auth->get_user_id() );

$res = $this->Meta_dataset->insert( $md );

sm('Meta dataset will be created. It can take several minutes to be generated.');
su('backend/page/meta_dataset');

/*$sql = 
  'SELECT r.rid, t.task_id, d.name, i.fullName, e.function, e.repeat, e.fold, e.sample_size ' .
  'FROM run r, task t, dataset d, task_inputs v, algorithm_setup s, implementation i, evaluation_sample e ' .
  'WHERE r.task_id = t.task_id AND t.task_id = v.task_id ' .
  'AND v.input = "source_data" AND v.value = d.did ' .
  'AND r.rid = e.source AND e.function IN ("predictive_accuracy", "build_cpu_time", "area_under_roc_curve") ' .
  'AND r.setup = s.sid AND s.implementation_id = i.id ' .
   $dids_constraint . 
   $flows_constraint . 
  'GROUP BY t.task_id, d.did, e.repeat, e.fold, e.sample;';

die($sql);*/
?>
