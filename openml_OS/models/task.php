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
    
    $this->load->model('Task_type_function');
    $this->load->model('Estimation_procedure');
  }
  
  function getAllTasks() {
    return $this->query( $this->construct_sql( 0 ) . ' ORDER BY `task_id`' );
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
  
  // task_type = 1, 2, 3, 4
  function getGeneralTask( $task_type, $estimation_procedure_id, $dataset_ids, $target, $evaluation_measure, $create ) {
    $constr_estimation_procesure = ' AND ' . $this->Estimation_procedure->sql_constraints( $estimation_procedure_id, $task_type,
      array('type','repeats','folds','percentage','stratified_sampling'), 
      array('`vtable_type`.`value`','`vtable_repeats`.`value`','`vtable_folds`.`value`','`vtable_percentage`.`value`','`vtable_stratified_sampling`.`value`') );
    
    $constr_target = 'AND `vtable_target_feature`.`value` = ' . ( $target ? '"'.safe($target).'" ' : '`dataset`.`default_target_attribute` ');
    $constr_dataset = (!$dataset_ids ? '' : 'AND `vtable_did`.`value` IN ('.implode(',',$dataset_ids).') ');
    $constr_eval_measures = 'AND `vtable_evaluation_measure`.`value` = "'.safe($evaluation_measure).'" ';
    
    if( in_array($task_type,array(1, 2, 3, 4)) === false ) 
      return false;
    if( $constr_estimation_procesure == false )
      return false;
    $clause = '`ttid` = ' . $task_type . ' AND `math_function` = "' . safe($evaluation_measure) . '"';
    if( $this->Task_type_function->getWhere( $clause ) == false )
      return false;
    if( $dataset_ids == false ) {
      return false;
    }

    $sql = $this->construct_sql( $task_type ) . $constr_estimation_procesure . $constr_target . $constr_dataset . $constr_eval_measures;
    
    $tasks = $this->query( $sql );
    
    if($create) {
      $this->createGeneralTask( $task_type, $estimation_procedure_id, $dataset_ids, $target, $evaluation_measure, $tasks );
      return $this->query( $sql );
    } else {
      return $tasks;
    }
  }
  
  // task_type = 1, 2, 3, 4
  private function createGeneralTask( $task_type, $estimation_procedure_id, $dataset_ids, $target, $evaluation_measure, $tasks ) {
    $task_dids = object_array_get_property( $tasks, 'did' );
    $ep = $this->Estimation_procedure->getById( $estimation_procedure_id );
    $target_type = array('nominal');
    if( $task_type == 2 ) $target_type = array('numeric','real');
    $datasets = $this->Dataset->getDatasetsWithFeature( $dataset_ids, $target, $target_type );
    
    if($datasets == false) 
      return;
    
    $this->db->trans_begin();
    
    foreach( $datasets as $d ) {
      // For each dataset, we are going to check whether it occurs in 
      // the already found tasks. Otherwise we'll create it.
      if( in_array( $d->did, $task_dids ) === false ) {
        // clearly, the task on the current dataset was not found. 
        // create it if it does not violate any constraints on arff size
        
        if( $this->Estimation_procedure->splits_arff_size( $ep, $d->instances ) > $this->config->item('max_split_arff_size') )
          continue;
        $task_id = $this->Task->insert( array('ttid' => $task_type) );
        $data = $this->prepare_insertion_array( $task_id, $task_type, $d, $ep, $evaluation_measure );
        
        foreach( $data as $key => $value ){
          $this->Task_values->insert( array( 'task_id' => $task_id, 'input' => $key, 'value' => $value ) );
        }
      }
    }

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();
    }
    else
    {
      $this->db->trans_commit();
    }
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
      CONCAT("Task ", `task`.`task_id`, ": ", `dataset`.`name`, " - ", `task_type`.`name`) AS `name`';
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
  
  private function prepare_insertion_array( $task_id, $ttid, $dataset, $estimation_procedure, $evaluation_measure ) {
    $insertion_array = array(
      '1' => $dataset->did, 
      '2' => $dataset->feature, 
      '3' => $estimation_procedure->type
    );
    
    switch( $ttid ) {
      case 1: // supervised classification [EQUALS]
      case 2: // supervised regression 
        $insertion_array = array(
          '1' => $dataset->did, 
          '2' => $dataset->feature, 
          '3' => $estimation_procedure->type, 
          '4' => BASE_URL . 'api_splits/get/' . $task_id . '/' . $estimation_procedure->id . '/Task_' . $task_id . '_' . $dataset->name . '_splits.arff', 
          '5' => $estimation_procedure->repeats, 
          '6' => $estimation_procedure->folds,
          '7' => $estimation_procedure->percentage,
          '8' => $estimation_procedure->stratified_sampling,
          '9' => $evaluation_measure );
        break;
      case 3: // Learning Curves
        $numInstances = $this->Data_quality->getFeature( $dataset->did, 'NumberOfInstances' );
        $numSamples = $this->Estimation_procedure->number_of_samples(
          $this->Estimation_procedure->trainingset_size( $numInstances, $estimation_procedure->folds ) 
        );
        $insertion_array = array(
          '1' => $dataset->did, 
          '2' => $dataset->feature, 
          '3' => $estimation_procedure->type, 
          '4' => BASE_URL . 'api_splits/get/' . $task_id . '/' . $estimation_procedure->id . '/Task_' . $task_id . '_' . $dataset->name . '_splits.arff', 
          '5' => $estimation_procedure->repeats, 
          '6' => $estimation_procedure->folds,
          '7' => $estimation_procedure->percentage,
          '8' => $estimation_procedure->stratified_sampling,
          '9' => $evaluation_measure,
          '10'=> $numSamples );
        
        break;
      case 4: // Supervised Data Stream Classification
        $insertion_array = array(
          '1' => $dataset->did, 
          '2' => $dataset->feature, 
          '3' => $estimation_procedure->type, 
          '4' => $evaluation_measure );
        break;
      default:
        break;
    }
    
    return $insertion_array;
  }
}
?>