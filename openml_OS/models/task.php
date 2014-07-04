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
  }
  
  function getAllTasks() {
    return $this->query( $this->construct_sql( 0 ) . ' ORDER BY `task_id`' );
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
  
  function getByIdWithValues( $id ) {
    if(is_numeric($id) === false)
      return false;
    $record = $this->Task->getById( $id );
    $ttid = $record->ttid;
    $task = $this->query( $this->construct_sql( $ttid ) . ' AND `task`.`task_id` = ' . $id );
    if($task)
      return end($task);
    else
      return false;
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
  
  function getByIdForEvaluation( $id ) {
    if(is_numeric($id) === false)
      return false;
    $record = $this->Task->getById( $id );
    $ttid = $record->ttid;
    $task = $this->query( $this->construct_sql( $ttid, true ) . ' AND `task`.`task_id` = ' . $id );
    if($task)
      return end($task);
    else
      return false;
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
