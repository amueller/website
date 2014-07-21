<?php
$this->task_types = $this->Task_type->get( );

foreach( $this->task_types as $key => $value ) {
  $this->task_types[$key]->inputs = array_merge(
    array( 'task_id' => 'task_id'),
    $this->Task_type_inout->getAssociativeArray( 'name', 'name', '`io` = "input" AND `requirement` <> "hidden" AND `ttid` = "' . $value->ttid . '"', 'order ASC' )
  );
  $this->task_types[$key]->tasks = $this->Task->tasks_crosstabulated( $value->ttid, true );
  
  $missing_sql = ''; // TODO
  $this->missing = $this->Task->query( $missing_sql ); 

  $illegal_sql = ''; // TODO
  $this->illegal = $this->Task->query( $illegal_sql ); 
}

?>
