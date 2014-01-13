<?php
class Task_type_io extends Database_read {
	
	function __construct() {
    parent::__construct();
    $this->table = 'task_type_io';
    $this->id_column = array('ttid','name');
  }
	
	public function getByTaskType( $ttid, $orderBy = null ) {
		return $this->getWhere( 'ttid = ' . $ttid, $orderBy );
	}
	
	public function getParsed( $ttid, $values ) {
		$io = $this->getWhere( 'ttid = ' . $ttid, 'io ASC, name ASC' );
		$needles = array();
		$haystacks = array();
		$subjects = array();
		foreach( $values as $key => $value ) {
			$needles[] = '[INPUT:'.$key.']';
			$haystacks[] = $value;
		}
		foreach( $io as $i ) {
			$subjects[] = '<oml:'.$i->io.' name="'.$i->name.'">' . $i->template . '</oml:'.$i->io.'>';
		}
		return str_replace( $needles, $haystacks, $subjects );
	}
}
?>
