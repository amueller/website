<?php
$flows = $this->input->post('flows');
$datasets = $this->input->post('datasets');
$tasks = $this->input->post('tasks');
$setups = $this->input->post('setups');
$functions = $this->input->post('functions');

$legal_functions = $this->Math_function->getColumnWhere( 'name', 'functionType = "EvaluationFunction"'  );

if( $flows && is_cs_natural_numbers( $flows ) == false ) {
  sm('Illegal value for flow list');
  su('frontend/page/meta_dataset');
}

if( $datasets && is_cs_natural_numbers( $datasets ) == false ) {
  sm('Illegal value for dataset list');
  su('frontend/page/meta_dataset');
}

if( $tasks && is_cs_natural_numbers( $tasks ) == false ) {
  sm('Illegal value for task list');
  su('frontend/page/meta_dataset');
}

if( $setups && is_cs_natural_numbers( $setups ) == false ) {
  sm('Illegal value for setup list');
  su('frontend/page/meta_dataset');
}

$illegal_value = array();
foreach( $functions as $f ) {
  if( in_array( $f, $legal_functions ) == false ) {
    $illegal_value[] = $f;
  }
}
if( $illegal_value ) {
  sm('Illegal value in function list: ' . implode( ', ', $illegal_value ) );
  su('frontend/page/meta_dataset');
}

if( $functions == false ) {
  sm('Please select at least one function. ' );
  su('frontend/page/meta_dataset');
}

$functions = '"' . implode( '", "', $functions ) . '"';

$md = array(
  'request_date' => now(),
  'datasets' => $datasets ? clean_cs_natural_numbers($datasets) : null,
  'tasks' => $tasks ? clean_cs_natural_numbers($tasks) : null,
  'flows' => $flows ? clean_cs_natural_numbers($flows) : null,
  'setups' => $setups ? clean_cs_natural_numbers($setups) : null,
  'functions' => $functions ? $functions : null,
  'user_id' => $this->ion_auth->get_user_id() );

$res = $this->Meta_dataset->insert( $md );

sm('Meta dataset will be created. It can take several minutes to be generated.');
su('frontend/page/meta_dataset#overview');

?>
