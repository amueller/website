<?php
class Evaluation_fold extends Database_write {
	
  function __construct() {
    parent::__construct();
    $this->table = 'evaluation_fold';
    $this->id_column = array('did','function','label','repeat','fold');
  }
}
?>
