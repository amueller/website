<?php
class Data_quality extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'feature_quality';
    $this->id_column = array( 'data', 'feature_index', 'quality' );
  }
  
}
?>
