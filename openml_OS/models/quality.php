<?php
class Quality extends Database_read {
	
	function __construct() {
		parent::__construct();
		$this->table = 'quality';
		$this->id_column = 'id';
  }
}
?>