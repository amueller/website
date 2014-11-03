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
  
  // TODO: implementations
  $sql = 'SELECT `r`.`task_id`,`r`.`setup`, `s`.`setup_string`, `i`.`dependencies`, `t`.`ttid` ' .
         'FROM `run` `r`, `task` `t`, `task_inputs` `d`, `algorithm_setup` `s`, `implementation` `i` ' .
         'WHERE `r`.`task_id` = `d`.`task_id` ' . 
         'AND `t`.`task_id` = `r`.`task_id` ' . 
         'AND `r`.`setup` = `s`.`sid` ' . 
         'AND `s`.`implementation_id` = `i`.`id` ' .
         'AND `d`.`input` = "source_data" ' .
         (($dataset_ids) ? ('AND `d`.`value` IN (' . implode( ',', $dataset_ids ) . ') ') : '' ) . 
         (($task_ids) ? ('AND `r`.`task_id` IN (' . implode( ',', $task_ids ) . ') ') : '' ) . 
         (($setup_ids) ? ('AND `r`.`setup` IN (' . implode( ',', $setup_ids ) . ') ') : '' ) . 
         (($flow_ids) ? ('AND `i`.`id` IN (' . implode( ',', $flow_ids ) . ') ') : '' ) . 
         'GROUP BY `r`.`task_id`, `r`.`setup`;';
  $result = $this->Dataset->query( $sql );
  $this->data = array();
  $this->check = true;
  
  if( $result == false ) {
    
    
  } else {
    $setups = array();
    $tasks = array();
    
    $tasks_reference = array();
    $setup_reference = array();
    
    foreach( $result as $res ) {
      if( in_array( $res->setup, $setups ) == false ) { 
        $setups[] = $res->setup; 
        $setup_reference[$res->setup] = array( 
          'dependencies' => $res->dependencies, 
          'setup_string' => $res->setup_string );
      }
      if( in_array( $res->task_id, $tasks ) == false ) { 
        $tasks[] = $res->task_id; 
        $tasks_reference[$res->task_id] = array(
          'ttid' => $res->ttid
        );
      }
    }
    asort($tasks);
    asort($setups);
    
    foreach( $setups as $s ) {
      $this->data[$s] = array();
      foreach( $tasks as $t ) {
        $this->data[$s][$t] = false;
      }
    }
    
    foreach( $result as $res ) {
      $this->data[$res->setup][$res->task_id] = true;
    }
    
    if( $this->input->post('schedule') && $this->ion_auth->is_admin() ) {
      $schedule = array();
      foreach( $setups as $s ) {
        foreach( $tasks as $t ) {
          if( $this->data[$s][$t] == false ) {
            $schedule[] = array( 
              'sid' => $s,
              'task_id' => $t,
              'experiment' => 'form_request',
              'active' => true,
              'ttid' => $tasks_reference[$t]['ttid'],
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
