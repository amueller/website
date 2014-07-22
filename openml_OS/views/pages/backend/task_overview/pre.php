<?php
$this->task_types = $this->Task_type->get( );
$this->task_ids = array();
$this->missingheader = array( 'task_id' => 'Task id', 'inputs' => 'inputs' );

foreach( $this->task_types as $key => $value ) {
  $this->task_types[$key]->inputs = array_merge(
    array( 'task_id' => 'task_id'),
    $this->Task_type_inout->getAssociativeArray( 'name', 'name', '`io` = "input" AND `requirement` <> "hidden" AND `ttid` = "' . $value->ttid . '"', 'order ASC' )
  );
  $this->task_types[$key]->tasks = $this->Task->tasks_crosstabulated( $value->ttid, true );
  if( $this->task_types[$key]->tasks ) { foreach( $this->task_types[$key]->tasks as $t ) { $this->task_ids[] = $t->task_id; } }
  
  $illegal_sql = 'SELECT `t`.`task_id`, `g`.`inputs` FROM `task_inputs` `i`, `task` `t` LEFT JOIN (SELECT `task_id`, GROUP_CONCAT(`input`) AS `inputs` FROM `task_inputs` GROUP BY `task_id`) AS `g` ON `t`.`task_id` = `g`.`task_id` WHERE `t`.`task_id` = `i`.`task_id` AND `i`.`input` NOT IN (SELECT `name` FROM `task_type_inout` `io` WHERE `io`.`ttid` = "' . $value->ttid . '") AND `t`.`ttid` = "' . $value->ttid . '"';
  
  $missing_sql = 'SELECT `t`.`task_id`, `g`.`inputs` FROM `task` `t` LEFT JOIN (SELECT `task_id`, GROUP_CONCAT(`input`) AS `inputs` FROM `task_inputs` GROUP BY `task_id`) AS `g` ON `t`.`task_id` = `g`.`task_id` WHERE `t`.`ttid` = "' . $value->ttid . '" AND `t`.`task_id` NOT IN (' . implode( ', ', $this->task_ids ) . ')'; // TODO
  
  $this->task_types[$key]->illegal = $this->Task->query( $illegal_sql ); 
  $this->task_types[$key]->missing = $this->Task->query( $missing_sql ); 
}
?>
