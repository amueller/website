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
  
  function getFeature( $did, $quality, $label = false ) {
    if( is_numeric( $did ) === false ) {
      return false;
    } else {
      $constraints = 'data = ' . $did . ' AND quality = "' . $quality . '"';
      if( $label !== false ) {
        $constraints .= ' AND label = "' . $label . '"';
      }
      $res = $this->getWhere( $constraints );
      if( $res === false ) {
        return false;
      } else {
        return $res[0]->value;
      }
    }
  }
}
?>
