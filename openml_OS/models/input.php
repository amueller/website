<?php
class Input extends Database_write {
	
	function __construct() {
    parent::__construct();
    $this->table = 'input';
    $this->id_column = 'fullName';
  }

  function compareToXML( $implementation, $xml ) {
    $relevant = array('name','description','dataType','defaultValue');
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
