<?php
class Confusion_matrix extends Database_write {
	
  function __construct() {
    parent::__construct();
    $this->table = 'confusion_matrix';
    $this->id_column = array('did','actual','predicted');
  }
}
?>
