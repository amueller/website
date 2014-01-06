<?php
class Data_quality extends Database_write {
	
	function __construct() {
		parent::__construct();
		$this->table = 'data_quality';
		$this->id_column = array( 'data', 'quality', 'label' );
    }

	function getByDid( $did ) {
		if( is_numeric( $did ) === false ) {
			return false;
		} else {
			return $this->getWhere( 'data = ' . $did );
		}
	}
	
}
?>
