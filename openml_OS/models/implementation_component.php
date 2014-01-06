<?php
class Implementation_component extends Database_write {
	
  function __construct() {
    parent::__construct();
    $this->table = 'implementation_component';
    $this->id_column = array('parent','child');
  }
}
?>
