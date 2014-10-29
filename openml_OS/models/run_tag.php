<?php
class Run_tag extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'run_tag';
    $this->id_column = array( 'id', 'tag' );
  }
}
?>
