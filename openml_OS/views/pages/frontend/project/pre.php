<?php

$with_tag = '';
$where_tag_task = '';
$where_tag_setup = '';
$where_tag_data = '';
if( $this->input->get('tag') ) {
  $where_tag_setup = 'AND st.tag = "' . $this->input->get('tag') . '" ';
  $where_tag_task = 'AND tt.tag = "' . $this->input->get('tag') . '" ';
  $where_tag_data = 'AND dt.tag = "' . $this->input->get('tag') . '" ';
  $with_tag = ' tagged with ' . $this->input->get('tag');
}


$setup_sql = 
  'SELECT s.sid AS id, i.name, s.setup_string ' .
  'FROM `implementation` i, `algorithm_setup` s, `setup_tag` st ' .
  'WHERE s.sid = st.id ' .
  $where_tag_setup . 
  'AND i.id = s.implementation_id ' .
  'GROUP BY s.sid;';
$this->setup_columns = array( 'id', 'name', 'setup_string' );
$this->setup_items = $this->Algorithm_setup->query( $setup_sql );
$this->setup_name = 'Setups' . $with_tag;

$task_sql = 
  'SELECT task.task_id AS id, t.name AS task_type, d.name, inst.value AS instances, attr.value AS features ' . 
  'FROM task, task_type t, task_tag `tt`, task_inputs `i`, dataset d ' . 
  'LEFT JOIN data_quality inst ON d.did = inst.data AND inst.quality = "NumberOfInstances" ' .
  'LEFT JOIN data_quality attr ON d.did = attr.data AND attr.quality = "NumberOfFeatures" ' .
  'WHERE task.task_id = tt.id ' .
  'AND task.ttid = t.ttid ' .
  'AND i.input = "source_data" AND i.task_id = task.task_id ' . 
  'AND i.value = d.did ' .
  $where_tag_task . ' ' .
  'GROUP BY task.task_id;';
$this->task_columns = array( 'id', 'task_type', 'name', 'instances', 'features' );
$this->task_items = $this->Algorithm_setup->query( $task_sql );
$this->task_name = 'Tasks' . $with_tag;

$data_sql = 
  'SELECT d.did AS id, d.name, inst.value AS instances, attr.value AS features ' . 
  'FROM dataset_tag `dt`, dataset d ' . 
  'LEFT JOIN data_quality inst ON d.did = inst.data AND inst.quality = "NumberOfInstances" ' .
  'LEFT JOIN data_quality attr ON d.did = attr.data AND attr.quality = "NumberOfFeatures" ' .
  'WHERE d.did = dt.id ' .
  $where_tag_data . ' ' .
  'GROUP BY d.did;';
$this->data_columns = array( 'id', 'name', 'instances', 'features' );
$this->data_items = $this->Dataset->query( $data_sql );
$this->data_name = 'Data' . $with_tag;

$run_sql = 
  'SELECT r.rid, i.id, i.name, r.task_id, r.error '.
  'FROM `run` `r`, `algorithm_setup` `s`, `setup_tag` `st`, task_tag `tt`, `implementation` `i` '.
  'WHERE `i`.`id` = `s`.`implementation_id` AND `r`.`task_id` = `tt`.`id` '.
  'AND `r`.`setup` = `s`.`sid` AND `s`.`sid` = `st`.`id` ' .
  'AND `r`.`error`  IS NOT NULL ' . 
  $where_tag_task . $where_tag_setup . ' ' .
  'GROUP BY r.rid;';
$this->run_columns = array( 'rid', 'task_id', 'id', 'name', 'error' );
$this->run_items = $this->Run->query( $run_sql );
$this->run_name = 'Runs (errors) ' . $with_tag;
?>
