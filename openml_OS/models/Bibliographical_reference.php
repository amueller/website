<?php
class Bibliographical_reference extends Database_write {
	
	function __construct() {
    parent::__construct();
    $this->table = 'bibliographical_reference';
    $this->id_column = 'id';
  }

  function compareToXML( $xml, $implementation_id ) {
    $relevant = array('citation' => 'citation','url' => 'url');
    $where = array('implementation_id' => $implementation_id);
    
    foreach( $relevant as $key => $item ) {
      if( property_exists( $xml->children('oml', true), $item ) ) {
        $where[$key] = trim($xml->children('oml', true)->$item);
      } else {
        $where[$key] = null;
      }
    }
    $result = $this->getWhere( $where );
    if( $result != false ) {
      return $result[0]->id;
    } else {
      return false;
    }
  }
}
?>
