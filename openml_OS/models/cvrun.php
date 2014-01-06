<?php
class CVRun extends Database_write {
	
	function __construct()
    {
		parent::__construct();
		$this->table = 'cvrun';
		$this->id_column = 'rid';
    }
}
?>
