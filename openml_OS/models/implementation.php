<?php
class Implementation extends Database_write {
	
	function __construct() {
		parent::__construct();
		$this->table = 'implementation';
		$this->id_column = 'id';
    
    $this->load->model('File');
  }
	
	function addComponent( $parent, $child, $identifier ) {
    $insert = array( 'parent' => $parent, 'child' => $child, 'identifier' => $identifier );
		return $this->db->insert( 'implementation_component', $insert );
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
	
	
	function getComponents( $parent ) {
    $sql = 'SELECT implementation.* FROM implementation, implementation_component 
       WHERE implementation.id = implementation_component.child 
       AND implementation_component.parent = ' . $parent->id;
		$results = $this->query( $sql );
    if( is_array( $results ) ) {
      for( $i = 0; $i < count($results); $i++ ) {
        $results[$i] = $this->_extendImplementation( $results[$i] );
      }
      return $results;
    } else {
      return array();
    }
	}
  
  public function compareToXML( $xml ) {
    $relevant = array('name','creator','contributor','description','fullDescription','installationNotes','dependencies','implements');
    $where = array();
    
    foreach( $relevant as $item ) {
      if( property_exists( $xml->children('oml', true), $item ) ) {
        if(in_array($item, array('creator','contributor') ) ) {
          $where[$item] = putcsv(xml_array_to_plain_array($xml, $item));
        } else {
          $where[$item] = trim($xml->children('oml', true)->$item);
        }
      } else {
        $where[$item] = null;
      }
    }
    $candidates = $this->Implementation->getWhere($where);
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
        $components = $this->getComponents( $candidate );
        if( count($components) != xml_size( $xml, 'component' ) ) { continue; }
        if( count( $components ) ) {
          foreach( $xml->children('oml', true)->component as $i ) {
            if( $this->compareToXML( $i->children('oml', true)->implementation ) === false ) continue;
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
		$implementation->components = $this->getComponents( $implementation );
    
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
