<?php
class Task extends Database_write {
	
	private $base_sql = 
			'SELECT `task`.`task_id`,
			`task`.`task_id` AS `id`, 
			`task`.`ttid`, 
			`input_data`.`value` AS `did`, 
			`target`.`value` AS `target_feature`, 
			`type`.`value` AS `type`, 
			`splits_url`.`value` AS `splits_url`, 
			`repeats`.`value` AS `repeats`, 
			`folds`.`value` AS `folds`,
			`percentage`.`value` AS `percentage`,
			`stratified`.`value` AS `stratified_sampling`,
			`evaluation_measure`.`value` AS `evaluation_measure`,
			`dataset`.`default_target_attribute` AS `dta`,
			CONCAT("Task ", `task`.`task_id`, ": ", `dataset`.`name`, " - ", `task_type`.`name`) AS `name`
			FROM `task`, 
			`task_type`,
			`task_values` AS `input_data`, 
			`task_values` AS `target`, 
			`task_values` AS `type`, 
			`task_values` AS `splits_url`, 
			`task_values` AS `repeats`, 
			`task_values` AS `folds`,
			`task_values` AS `percentage`,
			`task_values` AS `stratified`,
			`task_values` AS `evaluation_measure`,
			`dataset`
			WHERE `task`.`ttid` = `task_type`.`ttid` 
			AND `task`.`task_id` = `input_data`.`task_id` 
			AND `task`.`task_id` = `target`.`task_id` 
			AND `task`.`task_id` = `splits_url`.`task_id` 
			AND `task`.`task_id` = `type`.`task_id` 
			AND `task`.`task_id` = `repeats`.`task_id` 
			AND `task`.`task_id` = `folds`.`task_id` 
			AND `task`.`task_id` = `percentage`.`task_id` 
			AND `task`.`task_id` = `stratified`.`task_id` 
			AND `task`.`task_id` = `evaluation_measure`.`task_id` 
			AND `dataset`.`did` = `input_data`.`value` 
			AND `input_data`.`input` = 1 
			AND `target`.`input` = 2 
			AND `type`.`input` = 3 
			AND `splits_url`.`input` = 4 
			AND `repeats`.`input` = 5 
			AND `folds`.`input` = 6 
			AND `percentage`.`input` = 7 
			AND `stratified`.`input` = 8 
			AND `evaluation_measure`.`input` = 9 ';
  
  private $base_sql_learning = 'SELECT `task`.`task_id`,
			`task`.`task_id` AS `id`, 
			`task`.`ttid`, 
			`input_data`.`value` AS `did`, 
			`target`.`value` AS `target_feature`, 
			`type`.`value` AS `type`, 
			`splits_url`.`value` AS `splits_url`, 
			`repeats`.`value` AS `repeats`, 
			`evaluation_measure`.`value` AS `evaluation_measure`,
			`dataset`.`default_target_attribute` AS `dta`,
			CONCAT("Task ", `task`.`task_id`, ": ", `dataset`.`name`, " - ", `task_type`.`name`) AS `name`
			FROM `task`, 
			`task_type`,
			`task_values` AS `input_data`, 
			`task_values` AS `target`, 
			`task_values` AS `type`, 
			`task_values` AS `splits_url`, 
			`task_values` AS `repeats`, 
			`task_values` AS `samples`,
			`task_values` AS `evaluation_measure`,
			`dataset`
			WHERE `task`.`ttid` = `task_type`.`ttid` 
			AND `task`.`task_id` = `input_data`.`task_id` 
			AND `task`.`task_id` = `target`.`task_id` 
			AND `task`.`task_id` = `splits_url`.`task_id` 
			AND `task`.`task_id` = `type`.`task_id` 
			AND `task`.`task_id` = `repeats`.`task_id` 
			AND `task`.`task_id` = `folds`.`task_id` 
			AND `task`.`task_id` = `percentage`.`task_id` 
			AND `task`.`task_id` = `stratified`.`task_id` 
			AND `task`.`task_id` = `evaluation_measure`.`task_id` 
			AND `dataset`.`did` = `input_data`.`value` 
			AND `input_data`.`input` = 1 
			AND `target`.`input` = 2 
			AND `type`.`input` = 3 
			AND `splits_url`.`input` = 4 
			AND `repeats`.`input` = 5 
			AND `samples`.`input` = 6 
			AND `evaluation_measure`.`input` = 7 ';
	
	function __construct() {
		parent::__construct();
		$this->table = 'task';
		$this->id_column = 'task_id';
		
		$this->load->model('Task_type_function');
		$this->load->model('Estimation_procedure');
    }

	function getWithValues() {
		return $this->query( $this->base_sql );
	}
	
	function getByIdWithValues( $id ) {
		if(is_numeric($id) === false)
			return false;
    $task = $this->query( $this->base_sql . ' AND `task`.`task_id` = ' . $id );
    if($task)
      return end($task);
    else
      return false;
	}
	
	// task_type = 1, 2
	function getSupervisedClassificationRegression( $task_type, $estimation_procedure_id, $dataset_ids, $target, $evaluation_measure, $create ) {
		$constr_estimation_procesure = ' AND ' . $this->Estimation_procedure->sql_constraints( $estimation_procedure_id, $task_type, 
			array('`type`.`value`','`repeats`.`value`','`folds`.`value`','`percentage`.`value`','`stratified_sampling`.`value`') );
		$constr_task_type = 'AND `task`.`ttid` = "'.$task_type.'" ';
		$constr_target = 'AND `target`.`value` = ' . ( $target ? '"'.safe($target).'" ' : '`dataset`.`default_target_attribute` ');
		$constr_dataset = (!$dataset_ids ? '' : 'AND `input_data`.`value` IN ('.implode(',',$dataset_ids).') ');
		$constr_eval_measures = 'AND `evaluation_measure`.`value` = "'.safe($evaluation_measure).'" ';
		
		if( in_array($task_type,array(1,2)) === false ) 
			return false;
		if( $constr_estimation_procesure == false )
			return false;
		$clause = '`ttid` = ' . $task_type . ' AND `math_function` = "' . safe($evaluation_measure) . '"';
		if( $this->Task_type_function->getWhere( $clause ) == false )
			return false;
		if( $dataset_ids == false ) {
			return false;
		}

		$sql = $this->base_sql . $constr_estimation_procesure . $constr_task_type . $constr_target . $constr_dataset . $constr_eval_measures;
		
		$tasks = $this->query( $sql );
		if($create) {
			$this->createSupervisedClassificationRegression( $task_type, $estimation_procedure_id, $dataset_ids, $target, $evaluation_measure, $tasks );
			return $this->query( $sql );
		} else {
			return $tasks;
		}
	}

  // task_type = 3
	function getLearningCurve( $task_type, $estimation_procedure_id, $dataset_ids, $target, $evaluation_measure, $create ) {
		$constr_estimation_procesure = ' AND ' . $this->Estimation_procedure->sql_constraints( $estimation_procedure_id, $task_type, 
			array('`type`.`value`','`repeats`.`value`') );
		$constr_task_type = 'AND `task`.`ttid` = "'.$task_type.'" ';
		$constr_target = 'AND `target`.`value` = ' . ( $target ? '"'.safe($target).'" ' : '`dataset`.`default_target_attribute` ');
		$constr_dataset = (!$dataset_ids ? '' : 'AND `input_data`.`value` IN ('.implode(',',$dataset_ids).') ');
		$constr_eval_measures = 'AND `evaluation_measure`.`value` = "'.safe($evaluation_measure).'" ';
		
		if( in_array($task_type,array(3)) === false ) 
			return false;
		if( $constr_estimation_procesure == false )
			return false;
		$clause = '`ttid` = ' . $task_type . ' AND `math_function` = "' . safe($evaluation_measure) . '"';
		if( $this->Task_type_function->getWhere( $clause ) == false )
			return false;
		if( $dataset_ids == false ) {
			return false;
		}

		$sql = $this->base_sql . $constr_estimation_procesure . $constr_task_type . $constr_target . $constr_dataset . $constr_eval_measures;
		
		$tasks = $this->query( $sql );
		if($create) {
			$this->createSupervisedClassificationRegression( $task_type, $estimation_procedure_id, $dataset_ids, $target, $evaluation_measure, $tasks );
			return $this->query( $sql );
		} else {
			return $tasks;
		}
	}

	// task_type = 1, 2
	private function createSupervisedClassificationRegression( $task_type, $estimation_procedure_id, $dataset_ids, $target, $evaluation_measure, $tasks ) {
		$task_dids = object_array_get_property( $tasks, 'did' );
		$ep = $this->Estimation_procedure->getById( $estimation_procedure_id );
		$datasets = $this->Dataset->getDatasetsWithFeature( $dataset_ids, $target, ($task_type == 1 ? array('nominal') : array('numeric','real')), true );
		
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
				$data = array( 
					'1' => $d->did, 
					'2' => $d->feature, 
					'3' => $ep->type, 
					'4' => BASE_URL . 'api_splits/get/' . $task_id . '/Task_' . $task_id . '_' . $d->name . '_splits.arff', 
					'5' => $ep->repeats, 
					'6' => $ep->folds,
					'7' => $ep->percentage,
					'8' => $ep->stratified_sampling,
					'9' => $evaluation_measure 
				);
			
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

  // task_type = 3
	private function createLearningCurve( $task_type, $estimation_procedure_id, $dataset_ids, $target, $evaluation_measure, $tasks ) {
		$task_dids = object_array_get_property( $tasks, 'did' );
		$ep = $this->Estimation_procedure->getById( $estimation_procedure_id );
		$datasets = $this->Dataset->getDatasetsWithFeature( $dataset_ids, $target, array('nominal') , true );
		
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
				$data = array( 
					'1' => $d->did, 
					'2' => $d->feature, 
					'3' => $ep->type, 
					'4' => BASE_URL . 'api_splits/get/' . $task_id . '/Task_' . $task_id . '_' . $d->name . '_splits.arff', 
					'5' => $ep->repeats, 
					'6' => $evaluation_measure
				);
			
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
}
?>
