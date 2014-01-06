<?php
class Implementation extends Database_write {
	
	function __construct() {
		parent::__construct();
		$this->table = 'implementation';
		$this->id_column = 'id';
    
    $this->load->model('File');
  }
	
	function addComponent( $parent, $child ) {
		return $this->db->insert( 'implementation_component', array( 'parent' => $parent, 'child' => $child ) );
	}
  
  function isComponent( $id ) {
    $parents = $this->query('SELECT * FROM implementation_component WHERE child = "'.$id.'"');
    return $parents == true;
  }
	
	function getByFullName( $fullName ) {
		$implementation = $this->getWhere('fullName = "'.$fullName.'"');
		if($implementation == false) return false;
		return $implementation[0];
	}
	
	function fullImplementation( $id ) {
	  $impls = $this->getWhere( 'id = ' . $id );
    if(count($impls) == 0) return false;
    $implementation = $impls[0];
    
		return ( $implementation == false ) ? false : $this->_extendImplementation($implementation);
	}
	
	
	function getComponents( $included, $iterative = false ) {
		//$components = $this->db->select( 'implementation.*' )->where( '`implementation_component`.`parent` = "'.$fullName.'" AND `implementation_component`.`child` = `implementation`.`fullName`' )->get( '`implementation`, `implementation_component`' )->result();
		$components = $this->db->distinct()->where('`parent` IN ("'.implode('","',$included).'")')->get('implementation_component')->result();
		$results = object_array_get_property( $components, 'child' );
		//echo 'function called, params: ' .implode(',',$included). ', returned ' . implode(',',$results) . '<br/>';
		if( $iterative ) {
			$previous_size = count($results);
			$current_size  = count($results);
			do {
				$components = $this->getComponents( $results );
				//var_dump($components);
				$results = array_unique( array_merge( $results, $components ) );
				$previous_size = $current_size;
				$current_size = count($results);
			} while( $current_size > $previous_size );
		}
		return $results;
	}
  
  public function compareToXML( $xml ) {
    $relevant = array('name','creator','contributor','description','fullDescription','installationNotes','dependencies','implements');
    $sql = '';
    
    foreach( $relevant as $item ) {
      if( property_exists( $xml->children('oml', true), $item ) ) {
        if(in_array($item, array('creator','contributor') ) ) {
          $sql .= ' AND `'.$item.'` = \''.putcsv(xml_array_to_plain_array($xml, $item)).'\' ';
        } else {
          $sql .= ' AND `'.$item.'` = "'.$xml->children('oml', true)->$item.'" ';
        }
      } else {
        $sql .= ' AND `'.$item.'` IS NULL ';
      }
    }
    
    $candidates = $this->Implementation->getWhere(substr($sql, 5 ));
    if(is_array($candidates)) {
      foreach( $candidates as $candidate ) {
        // check parameters
        $params = $this->Input->getColumnFunctionWhere( 'count(*)', 'implementation_id = "'.$candidate->id.'"' );
        
        if( $params[0] != xml_size( $xml, 'parameter' ) ) continue;
        foreach( $xml->children('oml', true)->parameter as $p ) {
          if( $this->Input->compareToXML( $candidate->id, $p ) === false ) continue;
        }
        // check bibrefs
        $bibrefs = $this->Bibliographical_reference->getColumnFunctionWhere( 'count(*)', 'implementation_id = "'.$candidate->id.'"' );
        
        if( $bibrefs[0] != xml_size( $xml, 'bibliographical_reference' ) ) continue;
        foreach( $xml->children('oml', true)->bibliographical_reference as $b ) {
          if( $this->Bibliographical_reference->compareToXML( $candidate->id, $b ) === false ) continue;
        }
        // check components
        $components = $this->getComponents( array( $candidate->id ) );
        if( count($components) != xml_subsize( $xml, 'components', 'implementation' ) ) { continue; }
        if( count( $components ) ) {
          foreach( $xml->children('oml', true)->components->implementation as $i ) {
            if( $this->compareToXML( $i ) === false ) continue;
          }
        }

        // passed all checks :)
        return $candidate->id;
      }
    }
    // none of the implementations matched
    return false;
  }
	
	private function _extendImplementation( $implementation ) {
		$implementation->creator = getcsv( $implementation->creator );
		$implementation->contributor = getcsv( $implementation->contributor );
		$implementation->parameterSetting = $this->Input->getWhere( 'implementation_id = "' . $implementation->id . '"' );
		$implementation->bibliographicalReference = $this->Bibliographical_reference->getWhere( 'implementation_id = "' . $implementation->id . '"' );
		$implementation->components = $this->getComponents( array( $implementation->id ) );
		for( $i = 0; $i < count( $implementation->components ); $i++ ) {
			$implementation->components[$i] = $this->_extendImplementation( $this->Implementation->getById( $implementation->components[$i] ) );
		}
    
    foreach( array('binary','source') as $type ) {
      if( $implementation->{$type.'_file_id'} != false ) {
        $file = $this->File->getById( $implementation->{$type.'_file_id'} );
        if( $file != false ) {
          $implementation->{$type.'Url'} = BASE_URL . 'data/download/' . $file->id . '/' . $file->filename_original;
          $implementation->{$type.'Format'} = $file->extension;
          $implementation->{$type.'Md5'} = $file->md5_hash;
        }
      }
    }


		return $implementation;
	}
}
?>
