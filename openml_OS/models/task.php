<?php
class Task extends Database_write {
  
  // An config array configuring all tasks types. The key is the task type id (counting 
  // from 1) and the value is an array with key value pairs of all important information
  // for task search. Note that not necessarily all fields are included. E.g., nr_of_samples
  // (learning curves) is implicit information, hence it is not used for searching. 
  private $sql_configuration = array(
    0 => array( 1 => 'did' ), // UNIFORM KEY TO OBTAIN ALL TASSKS
    1 => array( 1 => 'did', 2 => 'target_feature', 3 => 'type', 5 => 'repeats', 6 => 'folds', 7 => 'percentage', 8 => 'stratified_sampling', 9 => 'evaluation_measure' ),
    2 => array( 1 => 'did', 2 => 'target_feature', 3 => 'type', 5 => 'repeats', 6 => 'folds', 7 => 'percentage', 8 => 'stratified_sampling', 9 => 'evaluation_measure' ),
    3 => array( 1 => 'did', 2 => 'target_feature', 3 => 'type', 5 => 'repeats', 6 => 'folds', 7 => 'percentage', 8 => 'stratified_sampling', 9 => 'evaluation_measure' ),
    4 => array( 1 => 'did', 2 => 'target_feature', 3 => 'type', 4 => 'evaluation_measure' )
  );
  private $sql_configuration_evaluation = array(
    0 => array(),
    1 => array( 1 => 'did', 2 => 'target_feature', 3 => 'type', 4 => 'splits_url', 5 => 'repeats', 6 => 'folds' ),
    2 => array( 1 => 'did', 2 => 'target_feature', 3 => 'type', 4 => 'splits_url', 5 => 'repeats', 6 => 'folds' ),
    3 => array( 1 => 'did', 2 => 'target_feature', 3 => 'type', 4 => 'splits_url', 5 => 'repeats', 6 => 'folds' ),
    4 => array( 1 => 'did', 2 => 'target_feature', 3 => 'type' )
  );
  
  
  function __construct() {
    parent::__construct();
    $this->table = 'task';
    $this->id_column = 'task_id';
    
    $this->load->model('Estimation_procedure');
    $this->load->model('Task_inputs');
  }
  
  function search( $task_type_id, $keyValues ) {
    // function that searches through the tasks, based on the values in the task_inputs table.
    // source_data is automatically added, because every task has source data. 
    // source_data is searched by dataset name, other fields by the value of the task_inputs table
    $sql = 'SELECT `task`.`task_id`, `task`.`ttid`, CONCAT("Task ", `task`.`task_id`, ": ", `task_type`.`name`, " - ", `dataset`.`name`) AS `name`';
    foreach( $keyValues as $key => $value ) {
      $sql .= ', `'.$key.'`.`value` AS `'.$key.'`';
    }
    
    $sql .= ' FROM `task`, `task_type`, `dataset`, `task_inputs` AS `source_data` ';
    foreach( $keyValues as $key => $value ) {
      if($key == "source_data") continue; // already added hardcoded
      $sql .= ', `task_inputs` AS `'.$key.'`';
    }
    
    $sql .= ' WHERE `task`.`ttid` = `task_type`.`ttid`'.
            ' AND `task`.`ttid` = "' . $task_type_id . '"'.
            ' AND `dataset`.`did` = `source_data`.`value`'.
            ' AND `task`.`task_id` = `source_data`.`task_id`'.
            ' AND `source_data`.`input` = "source_data"';
    
    foreach( $keyValues as $key => $value ) {
      $possible_values = explode(',', $value);
      for( $i = 0; $i < count($possible_values); ++$i ) {
        if($key == 'source_data') {
          $possible_values[$i] = '`dataset`.`name` LIKE "%' . $possible_values[$i] . '%"';
          $sql .= ' AND (' . implode( ' OR ', $possible_values ) . ')';
        } else {
          $possible_values[$i] = '`' . $key . '`.`value` = "' . $possible_values[$i] . '"';
          $sql .= ' AND `task`.`task_id` = `' . $key . '`.`task_id` AND `'.$key.'`.`input` = "'.$key.'" AND (' . implode( ' OR ', $possible_values ) . ')'; 
        }
      }
    }
    
    return $this->query( $sql );
  }
  
  function getTasksWithDid( $did ) {
    $sql = $this->construct_sql( 0, false ) . ' AND `vtable_did`.`value` = "'.$did.'"';
    $tasks = $this->query( $sql );
    
    $res = array();
    if( is_array( $tasks ) ) {
      foreach( $tasks as $task ) {
        $res[] = $task->task_id;
      }
    }
    return $res;
  }
  
  function create_batch( $ttid, $task_batch ) {
    $result = array();
    $to_insert = array();
    $existing_tasks = $this->tasks_crosstabulated( $ttid );
    if( $existing_tasks == false ) { $existing_tasks = array(); }
    foreach( $task_batch as $task ) {
      $current_task_obj = json_decode(json_encode($task), false); // convert array to obj, using json lib
      
      if( in_array( $current_task_obj, $existing_tasks ) == false ) {
        $task_id = $this->insert( array( 'ttid' => $ttid ) );
        foreach( $task as $key => $value ) {
          $to_insert[] = array( 'task_id' => $task_id, 'input' => $key, 'value' => $value );
        }
        // additional hidden inputs, specific for "official" OpenML inputs.
        // TODO: integrate?
        if( $ttid == 3 ) {
          // "number_samples"
          $numInstances = $this->Data_quality->getFeature( $task['source_data'], 'NumberOfInstances' );
          $estimation_procedure = $this->Estimation_procedure->getById( $task['estimation_procedure'] );
          $numSamples = $this->Estimation_procedure->number_of_samples(
            $this->Estimation_procedure->trainingset_size( $numInstances, $estimation_procedure->folds ) 
          );
          $to_insert[] = array( 'task_id' => $task_id, 'input' => 'number_samples', 'value' => $numSamples );
        }
        $result[] = $task_id;
      }
    }
    $this->Task_inputs->insert_batch( $to_insert );
    return $result;
  }

  function tasks_crosstabulated( $ttid, $include_task_id = false, $where_additional = array(), $order_by_values = false, $single_task_id = false ) {
    $inputs = $this->Task_type_inout->getWhere( '`io` = "input" AND `requirement` <> "hidden" AND `ttid` = "' . $ttid . '"' );
    $select = array();
    $left_join = array();
    $from = array();
    $where = array( '`t`.`ttid` = ' . $ttid );
    $order_by = array();
    if( $order_by_values == false ) { $order_by[] = '`t`.`task_id` ASC';}
    if( $single_task_id ) { $where[] = '`t`.`task_id` = "'.$single_task_id.'"'; }

    if( $include_task_id ) {
      $select[] = '`t`.`task_id`';
    }
    foreach( $inputs as $in ) {
      $select[] = '`' . $in->name . '`.`value` AS `' . $in->name . '`';
      
      // use a left join for the "optional" fields, since these might be missing. 
      if( $in->requirement == 'optional' ) {
        $left_join[] = ' LEFT JOIN `task_inputs` AS `' . $in->name . '` ON `' . $in->name . '`.`task_id` = `t`.`task_id` AND `' . $in->name . '`.`input` = "' . $in->name . '"';
      } elseif( $in->requirement == 'required' ) {
        $from[] = '`task_inputs` AS `' . $in->name . '`';
        $where[] = '`' . $in->name . '`.`task_id` = `t`.`task_id` AND `' . $in->name . '`.`input` = "' . $in->name . '"';
        // this might speed up the query
        if( $single_task_id ) { $where[] = '`'.$in->name.'`.`task_id` = "'.$single_task_id.'"'; }
      }
      
      // and order it by values
      if( $order_by_values ) { $order_by[] = '`' . $in->name . '`.`value` ASC';}
    }
    foreach( $where_additional as $key => $value ) {
      // we don't need to connect key.input to "key", since this is already done. 
      if( is_array( $value ) ) {
        // multiple possibilities, use WHERE ... IN
        $where[] = '`' . $key . '`.`value` IN ("' . implode( '", "', $value ) . '")';
      } else {
        // only one possibility, use WHERE ... IS
        $where[] = '`' . $key . '`.`value` = "'.$value.'"';
      }
    }
    $sql = 'SELECT ' . implode( ', ', $select ) . ' FROM `task` `t` ' . implode( ' ', $left_join ) . ', ' . implode( ', ', $from ) . ' WHERE ' . implode( ' AND ', $where ) . ' ORDER BY ' . implode( ', ', $order_by );
    $result = $this->query( $sql );
    
    // remove "NULL" values
    if( $result ) {
      for( $i = 0; $i < count($result); ++$i ) {
        foreach( $result[$i] as $key => $value ) {
          if( $value == NULL ) unset( $result[$i]->{$key} );
        }
      }
    }
    return $result;
  }
  
  // constructs a query, able to concatinate multiple entrees out of the task_values table
  // in one "crosstabulated" record. For this, an entry in the sql_configuration array
  // is needed. Due to the nature of the query, at least one field DID should be present.
  private function construct_sql( $task_type, $for_evaluation = false ) {
    $conf = $for_evaluation ? $this->sql_configuration_evaluation[$task_type] : $this->sql_configuration[$task_type];
    
    $base_sql = 
      'SELECT `task`.`task_id`,
      `task`.`task_id` AS `id`, 
      `task`.`ttid`, 
      `dataset`.`default_target_attribute` AS `dta`,
      CONCAT("Task ", `task`.`task_id`, ": ", `task_type`.`name`, " - ", `dataset`.`name`) AS `name`';
    foreach( $conf as $value ) {
      $base_sql .= ', `vtable_' . $value . '`.`value` AS `'.$value.'` ';
    }
    $base_sql .= 'FROM `task`, `task_type`, `dataset` ';
    foreach( $conf as $value )
      $base_sql .= ',`task_values` AS `vtable_' . $value . '` ';
    $base_sql .= 
      'WHERE `task`.`ttid` = `task_type`.`ttid` ' .
      'AND `dataset`.`did` = `vtable_did`.`value` ' .
    (($task_type != 0) ? 'AND `task`.`ttid` = ' . $task_type . ' ' : '');
      
    foreach( $conf as $key => $value ) {
      $base_sql .= "\n". 'AND `vtable_' . $value .'`.`input` = ' . $key . ' ';
      $base_sql .=       'AND `vtable_' . $value . '`.`task_id` = `task`.`task_id` ';
    }
    
    return $base_sql;
  }
  
}
?>
