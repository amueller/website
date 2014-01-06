<?php
class Evaluation extends Database_write {
	
  function __construct() {
    parent::__construct();
    $this->table = 'evaluation';
    $this->id_column = array('did','function','label');
  }
}
?>
