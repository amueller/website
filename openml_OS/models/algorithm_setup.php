<?php
class Algorithm_setup extends Database_write {
	
  function __construct() {
    parent::__construct();
    $this->table = 'algorithm_setup';
    $this->id_column = 'sid';
  }
	
	
	function getSetupId( $implementation, $parameters, $create = false ) {
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
			$legal_parameters = $this->Input->getAssociativeArray('fullName','defaultValue','implementation_id IN ("'.implode( '","', $components).'")');
			$isDefault = false;
			
			foreach( $parameters as $key => $value ) {
				if( array_key_exists( $key, $legal_parameters ) == false ) {
					// an illegal parameter was set. 
					return false;
				}
			}
			if(count(array_diff_assoc($legal_parameters, $parameters)) === 0) {
				$isDefault = true;
			}
			
			$setupData = array( 
				'sid' => $this->Algorithm_setup->getHighestIndex( array( 'algorithm_setup','function_setup','workflow_setup' ), 'sid' ),
	//			'parent' => '0',
				'algorithm' => $implementation->implements,
				'implementation_id' => $implementation->id,
				'isDefault' => $isDefault ? 'true' : 'false',
			); 
			
			$setupId = $this->Algorithm_setup->insert( $setupData );
			if(!$setupId) return false; // not going to happen :)
			
			// and register the parameters
			foreach( $parameters as $key => $value ) {
				$insert = array( 'setup' => $setupId, 'input' => $key, 'value' => $value );
				$this->Input_setting->insert( $insert );
				if(!$insert) return false;
			}
			return $setupId;
		}
	}
}
?>
