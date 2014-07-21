<?php
/* * * * *
 * This script transforms the input of the form into
 * a uniform format, as used by the model. 
 * It converts a dataset name into an id and filters
 * the datasets with the wrong target attribute. 
 * * * * */

$ttid = $this->input->post( 'ttid' );
$required_inputs = $this->Task_type_inout->getWhere( '`io` = "input" AND `requirement` <> "hidden" AND `ttid` = "'.$ttid.'"' );
$inputs = array();
foreach( $required_inputs as $i ) {
  if( $i->requirement == 'optional' && $this->input->post($i->name) == false ) { continue; }
  $inputs[$i->name] = $this->input->post($i->name);
}

$constraints = $this->Dataset->nameVersionConstraints( $this->input->post( 'source_data' ), 'd' );
$target_feature = '`d`.`default_target_attribute`';
if( trim( $this->input->post( 'target_feature' ) ) ) {
  $target_feature = '"'.trim( $this->input->post( 'target_feature' ) ).'"';
} else {
  unset( $inputs['target_feature'] );
}

$sql = 'SELECT `d`.`did`, `f`.`name` FROM `dataset` `d`,`data_feature` `f` WHERE `d`.`did` = `f`.`did` AND `f`.`name` = ' . $target_feature . ' AND ' . $constraints . ' ORDER BY `did`';

$datasets = $this->Dataset->query( $sql );

$results = array(); // resulting task configurations
$dids = array(); // used dataset ids
$new_tasks = array();
if( is_array( $datasets ) ) {
  foreach( $datasets as $dataset ) {
    $current = $inputs;
    $current['source_data'] = $dataset->did;
    $current['target_feature'] = $dataset->name;
    $results[] = $current;

    $dids[] = $dataset->did;
  }
  
  $new_tasks = $this->Task->create_batch( $ttid, $results );
}

$inputs['source_data'] = $dids;
$tasks = $this->Task->tasks_crosstabulated( $ttid, true, $inputs );

if( $tasks ) {
  foreach( $tasks as $task ) {
    $new = in_array( $task->task_id, $new_tasks ) ? '*' : '';
    $this->task_ids[] = '<a href="t/' . $task->task_id . '">' . $task->task_id . '</a>' . $new;
  }
}

if( $new_tasks ) { $this->new_text = '* new'; }

?>
