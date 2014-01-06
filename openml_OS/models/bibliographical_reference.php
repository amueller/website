<?php
class Bibliographical_reference extends Database_write {
	
	function __construct() {
    parent::__construct();
    $this->table = 'bibliographical_reference';
    $this->id_column = 'id';
  }

  function compareToXML( $implementation, $xml ) {
    $relevant = array('citation','url');
    $sql = '`implementation_id` = "'.$implementation.'"';
    foreach( $relevant as $item ) {
      if( property_exists( $xml->children('oml', true), $item ) ) {
        $sql .= ' AND `'.$item.'` = "'.$xml->children('oml', true)->$item.'" ';
      } else {
        $sql .= ' AND `'.$item.'` IS NULL ';
      }
    }
    $result = $this->getWhere( $sql );
    if( $result != false ) {
      return $result[0]->id;
    } else {
      return false;
    }
  }
}
?>
