<?php
class Implementation_tag extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'implementation_tag';
    $this->id_column = array( 'id', 'tag' );
  }
}
?>
