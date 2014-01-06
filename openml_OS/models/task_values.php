<?php
class Task_values extends Database_write {
	
	function __construct() {
		parent::__construct();
		$this->table = 'task_values';
		$this->id_column = array( 'task_id', 'input' );
    }

	function getTaskValuesAssoc( $task_id ) {
		$values = $this->getWhere( 'task_id = ' . $task_id );
		$res = array();
		foreach( $values as $value ) {
			$res[$value->input] = $value->value;
		}
		return $res;
	}
}
?>
