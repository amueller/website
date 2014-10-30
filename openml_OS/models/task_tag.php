<?php
class Task_tag extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'task_tag';
    $this->id_column = array( 'id', 'tag' );
  }
}
?>
