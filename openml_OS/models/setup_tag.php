<?php
class Setup_tag extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'setup_tag';
    $this->id_column = array( 'id', 'tag' );
  }
}
?>
