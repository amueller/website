<?php
$flows = $this->input->post('flows');
$datasets = $this->input->post('datasets');
$functions = $this->input->post('functions');

$legal_functions = $this->Math_function->getColumnWhere( 'name', 'functionType = "EvaluationFunction"'  );

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

$functions = '"' . implode( '", "', $functions ) . '"';

$md = array( 
  'datasets' => $datasets ? $datasets : null,
  'flows' => $flows ? $flows : null,
  'functions' => $functions ? $functions : null,
  'user_id' => $this->ion_auth->get_user_id() );

$res = $this->Meta_dataset->insert( $md );

sm('Meta dataset will be created. It can take several minutes to be generated.');
su('backend/page/meta_dataset');

?>
