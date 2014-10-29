<?php
class Dataset_tag extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'dataset_tag';
    $this->id_column = array( 'did', 'tag' );
  }
}
?>
