<?php

$this->task_types = $this->Task_type->get( );
$this->setups = $this->Algorithm_setup->query( 'SELECT s.sid, i.name, i.version, s.setup_string FROM implementation i, algorithm_setup s WHERE s.implementation_id = i.id; ' );
$this->datasets = $this->Dataset->getAssociativeArray( 'did', 'name', '`did` IS NOT NULL' );

foreach( $this->task_types as $key => $value ) {
  $this->task_types[$key]->tasks = $this->Task->tasks_crosstabulated( $value->ttid, true );
}
?>
