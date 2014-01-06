<?php
class Author extends Community {
	
	function __construct()
    {
		parent::__construct();
		$this->table = 'users';
		$this->deleted_activated = 'id IS NOT NULL ';
    }
}
?>
