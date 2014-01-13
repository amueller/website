<?php
class Task_type_function extends Database_read {
	
	function __construct() {
    parent::__construct();
    $this->table = 'task_type_function';
    $this->id_column = array('ttid','math_function');
  }

	function getByTtid( $ttid ) {
		if( is_numeric($ttid) === false )
			return false;
		return $this->getWhere('ttid = ' . $ttid);
	}
}
?>
