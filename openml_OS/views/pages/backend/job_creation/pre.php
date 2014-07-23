<?php

$this->task_types = $this->Task_type->get( );
$this->setups = $this->Algorithm_setup->query( 'SELECT s.sid, i.name, i.version, s.setup_string FROM implementation i, algorithm_setup s WHERE s.implementation_id = i.id; ' );
$this->datasets = $this->Dataset->getAssociativeArray( 'did', 'name', '`did` IS NOT NULL' );

foreach( $this->task_types as $key => $value ) {
  $this->task_types[$key]->tasks = $this->Task->tasks_crosstabulated( $value->ttid, true );
}

$this->active_tasks = array();
$this->active_setups = array();
$this->experiment = '';

if( gu('e') ) {
  $this->experiment = gu('e');
  $this->active_tasks = array_unique ( $this->Schedule->getColumnWhere( 'task_id', '`experiment` = "' . $this->experiment . '"' ) );
  $this->active_setups = array_unique ( $this->Schedule->getColumnWhere( 'sid', '`experiment` = "' . $this->experiment . '"' ) );
}
?>
