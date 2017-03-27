<?php
class Algorithm_setup extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'algorithm_setup';
    $this->id_column = 'sid';
  }
  
  function setup_runs() {
    // select sid, implementation_id, count(*) as num_runs from algorithm_setup s LEFT JOIN run r ON s.sid = r.setup GROUP BY sid ORDER BY num_runs ASC 
    $query = $this->db->select('sid, implementation_id, count(*) as num_runs')->from($this->table)->join('run', 'run.setup = algorithm_setup.sid', 'left')->group_by('sid')->order_by('num_runs ASC');
    $data = $this->db->get();
    return ($data && $data->num_rows() > 0) ? $data->result() : false;
  }
  
  //inputs: complete implementation record, mapping parameter_id->value, flag (typically true), setup string
  function getSetupId( $implementation, $parameters, $create, $setup_string = null ) {
    $paramString = '';
    $valueString = '';
    
    // the OLD way of finding a parameter setup. 
    /*ksort( $parameters );
    
    foreach( $parameters as $key => $value ) {
      $paramString .= ',' . $this->db->escape_str( $key );
      $valueString .= ',' . $this->db->escape_str( $value );
    }
    
    if(count($parameters)) {
      $sql = 'SELECT `sid`,`implementation_id`,`nr_parameters`,`parameters`,`values` FROM `algorithm_setup` AS `s` LEFT JOIN (SELECT `setup`, COUNT(*) AS `nr_parameters`, GROUP_CONCAT(`input_setting`.`input_id`) AS `parameters`, GROUP_CONCAT(`input_setting`.`value`) AS `values` FROM `input_setting` GROUP BY `setup` ORDER BY `input`) AS `p` ON `s`.`sid` = `p`.`setup` WHERE `implementation_id` = "'.$implementation->id.'" AND `p`.`parameters` = "'.substr( $paramString, 1 ).'" AND `p`.`values` = "'.substr( $valueString, 1 ).'" LIMIT 0,1;';
    } else {
      $sql = 'SELECT `sid`,`implementation_id`,`nr_parameters` FROM `algorithm_setup` AS `s` LEFT JOIN (SELECT `setup`, COUNT(*) AS `nr_parameters` FROM `input_setting` GROUP BY `setup`) AS `p` ON `s`.`sid` = `p`.`setup` WHERE `implementation_id` = "'.$implementation->id.'" AND `nr_parameters` IS NULL LIMIT 0,1';
    }
    */
    
    // the new way
    $select = '';
    $leftJoin = '';
    $where = '';
    foreach($parameters as $key => $value) {
      // key = the input_id, value = the value
      $select .= ', `i'.$key.'`.`value` AS `i'.$key.'`';
      $leftJoin .= 'LEFT JOIN `input_setting` `i'.$key.'` ON `i'.$key.'`.`setup` = `s`.`sid` AND `i'.$key.'`.`input_id` = "'.$key.'" ';
      $where .= ' AND `i'.$key.'`.`value` = '.$this->db->escape($value).' ';
    }
    $sql = 'SELECT `sid`,`implementation_id`,`nr_parameters`' . $select . 
           'FROM `algorithm_setup` AS `s` ' .
           'LEFT JOIN (SELECT `setup`, COUNT(*) AS `nr_parameters` FROM `input_setting` GROUP BY `setup`) AS `p` ON `s`.`sid` = `p`.`setup` ' . 
           $leftJoin . 
           ' WHERE `implementation_id` = "' . $implementation->id . '" ' .
           ' AND IFNULL(`nr_parameters`,0) = ' . count($parameters) . $where .
           ' LIMIT 0,1;';
    
    $result = $this->db->query( $sql )->result();
    
    if( count( $result ) > 0 ) {
      return $result[0]->sid;
    } elseif( $create === false ) {
      return false;
    } else {
      // CREATE THE NEW SETUP
      $components = array_merge( array($implementation->id), $this->Implementation->getComponentIds( $implementation->id ) );
      $legal_parameters = $this->Input->getAssociativeArray('id','defaultValue','implementation_id IN ("'.implode( '","', $components).'")');
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
  //      'algorithm' => $implementation->implements,
        'implementation_id' => $implementation->id,
        'setup_string' => $setup_string,
        'isDefault' => $isDefault ? 'true' : 'false',
      ); 
      
      $setupId = $this->Algorithm_setup->insert( $setupData );
      if(!$setupId) return false; // not going to happen :)
      
      // and register the parameters
      foreach( $parameters as $key => $value ) {
        $insert = array( 'setup' => $setupId, 'input_id' => $key, 'value' => $value );
        $this->Input_setting->insert( $insert );
        if(!$insert) return false;
      }      return $setupId;
    }
  }
}
?>
