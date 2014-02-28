<?php
/* TASK SEARCH */
$ttid = $this->input->post('task_type');
$this->att = 'results';

$evaluation_measures = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
$dataset_ids = $this->Dataset->getColumnWhere('did', 'format = "arff" AND ' . $this->Dataset->nameVersionConstraints( $this->input->post('datasets') ) );

switch($ttid) {
case 1:
case 2:
case 3:
  $this->found_tasks = $this->Task->getGeneralTask( 
    $ttid, 
    $this->input->post('estimation_procedure'), 
    $dataset_ids, 
    $this->input->post('target_feature'), 
    $this->input->post('evaluation_measure'),
    true );
  if($this->found_tasks === false) {
    $this->task_message = 'None of the tasks met the search criteria. Please try again. ';
  }
  break;
case 4: // TODO: build this functionality!
  $this->found_tasks = $this->Task->getGeneralTask( 
    $ttid, 
    $this->input->post('estimation_procedure'), 
    $dataset_ids, 
    $this->input->post('target_feature'), 
    $this->input->post('evaluation_measure'),
    true );
  if($this->found_tasks === false) {
    $this->task_message = 'None of the tasks met the search criteria. Please try again. ';
  }
  break;
default:
  $this->task_message = 'Illigal task type. ';
  break;
}
?>
