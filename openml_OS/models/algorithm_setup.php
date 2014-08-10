<?php
class Algorithm_setup extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'algorithm_setup';
    $this->id_column = 'sid';
  }
  
  
  function getSetupId( $implementation, $parameters, $create, $setup_string = null ) {
    $paramString = '';
    $valueString = '';
    
    ksort( $parameters );
    
    foreach( $parameters as $key => $value ) {
      $paramString .= ',' . $key;
      $valueString .= ',' . $value;
    }
    
    if(count($parameters)) {
      $sql = 'SELECT `sid`,`implementation_id`,`nr_parameters`,`parameters`,`values` FROM `algorithm_setup` AS `s` LEFT JOIN (SELECT `setup`, COUNT(*) AS `nr_parameters`, GROUP_CONCAT(`input_setting`.`input`) AS `parameters`, GROUP_CONCAT(`input_setting`.`value`) AS `values` FROM `input_setting` GROUP BY `setup` ORDER BY `input`) AS `p` ON `s`.`sid` = `p`.`setup` WHERE `implementation_id` = "'.$implementation->id.'" AND `p`.`parameters` = "'.substr( $paramString, 1 ).'" AND `p`.`values` = "'.substr( $valueString, 1 ).'" LIMIT 0,1;';
    } else {
      $sql = 'SELECT `sid`,`implementation_id`,`nr_parameters` FROM `algorithm_setup` AS `s` LEFT JOIN (SELECT `setup`, COUNT(*) AS `nr_parameters` FROM `input_setting` GROUP BY `setup`) AS `p` ON `s`.`sid` = `p`.`setup` WHERE `implementation_id` = "'.$implementation->id.'" AND `nr_parameters` IS NULL LIMIT 0,1';
    }
    
    $result = $this->db->query( $sql )->result();
    
    if( count( $result ) > 0 ) {
      return $result[0]->sid;
    } elseif( $create === false ) {
      return false;
    } else {
      // CREATE THE NEW SETUP
      $components = array_merge( array($implementation->id), $this->Implementation->getComponentIds( $implementation->id ) );
      $legal_parameters = $this->Input->getAssociativeArray('CONCAT(`implementation_id`,\'_\',`name`)','defaultValue','implementation_id IN ("'.implode( '","', $components).'")');
      $isDefault = false; 
      
      if( is_array( $legal_parameters ) === false ) {
        // no legal parameters found, make it an array anyway
        $legal_parameters = array();
      }
      
      foreach( $parameters as $key => $value ) {
        if( array_key_exists( $key, $legal_parameters ) == false ) {
          // an illegal parameter was set. 
          return false;
        }
      }
      
      foreach( $legal_parameters as $key => $value ) {
        if( $value == null ) unset($legal_parameters[$key]);
      }
      
      if(count(array_diff_assoc($legal_parameters, $parameters)) === 0 && 
         count(array_diff_assoc($parameters, $legal_parameters)) === 0) {
        $isDefault = true;
      }
      
      $setupData = array( 
        'sid' => $this->Algorithm_setup->getHighestIndex( array( 'algorithm_setup' ), 'sid' ),
  //      'parent' => '0',
        'algorithm' => $implementation->implements,
        'implementation_id' => $implementation->id,
        'setup_string' => $setup_string,
        'isDefault' => $isDefault ? 'true' : 'false',
      ); 
      
      $setupId = $this->Algorithm_setup->insert( $setupData );
      if(!$setupId) return false; // not going to happen :)
      
      // and register the parameters
      foreach( $parameters as $key => $value ) {
        $insert = array( 'setup' => $setupId, 'input' => $key, 'value' => $value );
        $this->Input_setting->insert( $insert );
        if(!$insert) return false;
      }// TODO: input setting was saved with key {implementation_id}_{name}. Make a better index for input_setting link
      return $setupId;
    }
  }
}
?>
