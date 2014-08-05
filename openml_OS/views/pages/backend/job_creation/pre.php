<?php

$task_where_additional = array();
$setup_where_additional = '';

if( $this->input->post('filter') ) {
  $valid_data_filters = array( 
    'NumberOfInstances', 'NumberOfFeatures', 
    'NumberOfMissingValues', 'NumberOfClasses' );
  
  $filters = array();
  $hasConstraints = false;
  foreach( $valid_data_filters as $f ) {
    if( $this->input->post( $f ) ) { 
      $hasConstraints = true;
      $filters[$f] = $this->input->post( $f ); 
    }
  }
  
  if( $hasConstraints ) {
    $params = array( 'type' => 'data', 'filters' => $filters );
    // TODO: figure this out
    $params['size'] = 10000;
    $result = $this->elasticsearchlibrary->search( $params );
    
    $dids = array( '-1' );
    if( $result['hits']['total'] > 0 ) {
      foreach( $result['hits']['hits'] as $r ) { $dids[] = $r['_id']; }
    }
    $task_where_additional['source_data'] = $dids;
  }
  
  
  if( $this->input->post('Workbench') ) {
    $setup_where_additional .= ' AND i.dependencies LIKE "%'.$this->input->post('Workbench').'%"';
  }
  if( $this->input->post('DefaultOnly') ) {
    $setup_where_additional .= ' AND s.isDefault = "true"';
  }
}


$this->task_types = $this->Task_type->get( );
$this->setups = $this->Algorithm_setup->query( 'SELECT s.sid, i.name, i.version, s.setup_string FROM implementation i, algorithm_setup s WHERE s.implementation_id = i.id ' . $setup_where_additional . '; ' );
$this->datasets = $this->Dataset->getAssociativeArray( 'did', 'name', '`did` IS NOT NULL' );

foreach( $this->task_types as $key => $value ) {
  $this->task_types[$key]->tasks = $this->Task->tasks_crosstabulated( $value->ttid, true, $task_where_additional );
}

$this->active_tasks = array();
$this->active_setups = array();
$this->experiment = '';

if( gu('e') ) {
  $this->experiment = gu('e');
  $this->active_tasks = array_unique ( $this->Schedule->getColumnWhere( 'task_id', '`experiment` = "' . $this->experiment . '"' ) );
  $this->active_setups = array_unique ( $this->Schedule->getColumnWhere( 'sid', '`experiment` = "' . $this->experiment . '"' ) );
}

$this->data_filters = array();
$this->setup_filters = array();

?>
