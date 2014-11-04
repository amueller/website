<?php

$datasets= $this->input->post('datasets');
$flows   = $this->input->post('flows');
$setups  = $this->input->post('setups');
$tasks   = $this->input->post('tasks');

$dataset_ids = ($datasets)? $this->Dataset_tag->get_ids( explode( ',', $datasets ) ) : null;
$flow_ids    = ($flows)   ? $this->Implementation_tag->get_ids( explode( ',', $flows ) ) : null;
$task_ids    = ($tasks)   ? $this->Task_tag->get_ids( explode( ',', $tasks ) ) : null;
$setup_ids   = ($setups)  ? $this->Setup_tag->get_ids( explode( ',', $setups ) ) : null;

if( $dataset_ids === false || $flow_ids === false || $task_ids === false || $setup_ids === false ) {
  sm('Wrong input: Either of the input fields (datasets, implementations, setups, tasks) had no results. ' );
  su('frontend/page/meta_dataset');
}

if( $this->input->post('create') == true ) {
  $functions = $this->input->post('functions');

  $legal_functions = $this->Math_function->getColumnWhere( 'name', 'functionType = "EvaluationFunction"'  );

  $illegal_value = array();
  foreach( $functions as $f ) {
    if( in_array( $f, $legal_functions ) == false ) {
      $illegal_value[] = $f;
    }
  }
  if( $illegal_value ) {
    sm('Illegal value in function list: ' . implode( ', ', $illegal_value ) );
    su('frontend/page/meta_dataset');
  }

  if( $functions == false ) {
    sm('Please select at least one function. ' );
    su('frontend/page/meta_dataset');
  }



  $functions = '"' . implode( '", "', $functions ) . '"';
  
  $md = array(
    'request_date' => now(),
    'datasets' => $dataset_ids ? implode( ', ', $dataset_ids ) : null,
    'tasks' => $task_ids ? implode( ', ', $task_ids ) : null,
    'flows' => $flow_ids ? implode( ', ', $flow_ids ) : null,
    'setups' => $setup_ids ? implode( ', ', $setup_ids ) : null,
    'functions' => $functions ? $functions : null,
    'user_id' => $this->ion_auth->get_user_id() );

  $res = $this->Meta_dataset->insert( $md );

  sm('Meta dataset will be created. It can take several minutes to be generated.');
  su('frontend/page/meta_dataset#overview');
  
} elseif( $this->input->post('check') == true ) {
  $sql_setups = 
    'SELECT `s`.`sid`, `i`.`dependencies`, `s`.`setup_string` ' . 
    'FROM `algorithm_setup` `s`, `implementation` `i` '.
    'WHERE `s`.`implementation_id` = `i`.`id` ' . 
    (($setup_ids) ? ('AND `s`.`sid` IN (' . implode( ',', $setup_ids ) . ') ') : '' ) . 
    (($flow_ids) ? ('AND `i`.`id` IN (' . implode( ',', $flow_ids ) . ') ') : '' );
  $res_setups = $this->Algorithm_setup->query( $sql_setups );
  
  $sql_tasks = 
    'SELECT `t`.* FROM `task` `t`, `task_inputs` `d` ' .
    'WHERE `t`.`task_id` = `d`.`task_id` ' . 
    'AND `d`.`input` = "source_data" ' .
    (($dataset_ids) ? ('AND `d`.`value` IN (' . implode( ',', $dataset_ids ) . ') ') : '' ) . 
    (($task_ids) ? ('AND `t`.`task_id` IN (' . implode( ',', $task_ids ) . ') ') : '' );
  $res_tasks = $this->Task->query( $sql_tasks );
  
  // TODO: implementations
  $sql_runs = 
    'SELECT `r`.`task_id`,`r`.`setup` ' .
    'FROM `run` `r`, `task_inputs` `d` ' .
    'WHERE `r`.`task_id` = `d`.`task_id` ' . 
    'AND `d`.`input` = "source_data" ' .
    (($dataset_ids) ? ('AND `d`.`value` IN (' . implode( ',', $dataset_ids ) . ') ') : '' ) . 
    (($task_ids) ? ('AND `r`.`task_id` IN (' . implode( ',', $task_ids ) . ') ') : '' ) . 
    (($setup_ids) ? ('AND `r`.`setup` IN (' . implode( ',', $setup_ids ) . ') ') : '' ) . 
    'GROUP BY `r`.`task_id`, `r`.`setup`;';
  $res_runs = $this->Run->query( $sql_runs );
  $this->data = array();
  $this->check = true;
  
  if( $res_runs == false || $res_tasks == false || $res_setups == false ) {
    
    
  } else {
    $task_reference = array();
    $setup_reference = array();
    
    foreach( $res_setups as $setup ) {
      $setup_reference[$setup->sid] = array( 
        'dependencies' => $setup->dependencies, 
        'setup_string' => $setup->setup_string );
    }
    foreach( $res_tasks as $task ) {
      $task_reference[$task->task_id] = array(
        'ttid' => $task->ttid
      );
    }
    ksort($task_reference);
    ksort($setup_reference);
    
    foreach( array_keys( $setup_reference ) as $s ) {
      $this->data[$s] = array();
      foreach( array_keys( $task_reference ) as $t ) {
        $this->data[$s][$t] = false;
      }
    }
    
    foreach( $res_runs as $res ) {
      $this->data[$res->setup][$res->task_id] = true;
    }
    
    if( $this->input->post('schedule') && $this->ion_auth->is_admin() ) {
      $schedule = array();
      foreach( array_keys( $setup_reference ) as $s ) {
        foreach( array_keys( $task_reference ) as $t ) {
          if( $this->data[$s][$t] == false ) {
            $schedule[] = array( 
              'sid' => $s,
              'task_id' => $t,
              'experiment' => 'form_request',
              'active' => true,
              'ttid' => $task_reference[$t]['ttid'],
              'dependencies' => $setup_reference[$s]['dependencies'],
              'setup_string' => $setup_reference[$s]['setup_string'] 
            );
          }
        }
      }
      $this->Schedule->insert_batch( $schedule );
    }
  }
}
?>
