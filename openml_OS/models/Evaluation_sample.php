<?php
class Evaluation_sample extends Database_write {
	
  function __construct() {
    parent::__construct();
    $this->table = 'evaluation_sample';
    $this->id_column = array('did','function_id','label');
  }
}
?>
