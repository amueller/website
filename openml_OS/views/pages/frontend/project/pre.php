<?php

$with_tag = '';
$where_tag = '';
if( $this->input->get('tag') ) {
  $where_tag = 'AND t.tag = "' . $this->input->get('tag') . '" ';
  $with_tag = ' tagged with ' . $this->input->get('tag');
}


$setup_sql = 
  'SELECT s.sid AS id, i.name, s.setup_string ' .
  'FROM `implementation` i, `algorithm_setup` s, `setup_tag` t ' .
  'WHERE s.sid = t.id ' .
  $where_tag . 
  'AND i.id = s.implementation_id;';
$this->setup_columns = array( 'id', 'name', 'setup_string' );
$this->setup_items = $this->Algorithm_setup->query( $setup_sql );
$this->setup_name = 'Setups' . $with_tag;

$task_sql = 
  'SELECT task.task_id AS id, tt.name AS task_type, d.name, inst.value AS instances, attr.value AS features ' . 
  'FROM task, task_type tt, task_tag `t`, task_inputs `i`, dataset d ' . 
  'LEFT JOIN data_quality inst ON d.did = inst.data AND inst.quality = "NumberOfInstances" ' .
  'LEFT JOIN data_quality attr ON d.did = attr.data AND attr.quality = "NumberOfFeatures" ' .
  'WHERE task.task_id = t.id ' .
  'AND task.ttid = tt.ttid ' .
  'AND i.input = "source_data" AND i.task_id = task.task_id ' . 
  'AND i.value = d.did ' .
  $where_tag;
$this->task_columns = array( 'id', 'task_type', 'name', 'instances', 'features' );
$this->task_items = $this->Algorithm_setup->query( $task_sql );
$this->task_name = 'Tasks' . $with_tag;
?>
