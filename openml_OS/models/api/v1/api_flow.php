<?php
class Api_flow extends Api_model {
  
  protected $version = 'v1';
  
  function __construct() {
    parent::__construct();
    
    // load models
    $this->load->model('Implementation');
    $this->load->model('Implementation_tag');
    $this->load->model('Implementation_component');
    
    $this->load->model('File');
  }
  
  function bootstrap($segments, $request_type, $user_id) {
    $getpost = array('get','post');
    
    if (count($segments) == 1 && $segments[0] == 'list') {
      $this->flow_list();
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'owned') {
      $this->flow_owned($user_id);
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'exists') {
      $this->flow_exists();
      return;
    }
    
    if (count($segments) == 1 && is_numeric($segments[0]) && in_array($request_type, $getpost)) {
      $this->flow($segments[0]);
      return;
    }
    
    if (count($segments) == 1 && is_numeric($segments[0]) && $request_type == 'delete') {
      $this->flow_delete($segments[0]);
      return;
    }
    
    if (count($segments) == 0 && $request_type == 'post') {
      $this->flow_upload();
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'tag' && $request_type == 'post') {
      $this->flow_tag($this->input->post('flow_id'),$this->input->post('tag'));
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'untag' && $request_type == 'post') {
      $this->flow_tag($this->input->post('flow_id'),$this->input->post('tag'));
      return;
    }
    
    $this->returnError( 100, $this->version );
  }
  
  
  private function flow_list() {

    $implementations = $this->Implementation->get();
    if( $implementations == false ) {
      $this->returnError( 500, $this->version );
      return;
    }
    $this->xmlContents( 'implementations', $this->version, array( 'implementations' => $implementations ) );
  }
  
  
  private function flow_owned() {

    $implementations = $this->Implementation->getColumnWhere( 'id', '`uploader` = "'.$this->user_id.'"' );
    if( $implementations == false ) {
      $this->returnError( 312, $this->version );
      return;
    }
    $this->xmlContents( 'implementation-owned', $this->version, array( 'implementations' => $implementations ) );
  }
  
  
  private function flow_exists() {
    $name = $this->input->post( 'name' );
    $external_version = $this->input->post( 'external_version' );

    $similar = false;
    if( $name !== false && $external_version !== false ) {
      $similar = $this->Implementation->getWhere( '`name` = "' . $name . '" AND `external_version` = "' . $external_version . '"' );
    } else {
      $this->returnError( 330, $this->version );
      return;
    }

    $result = array( 'exists' => 'false', 'id' => -1 );
    if( $similar ) {
      $result = array( 'exists' => 'true', 'id' => $similar[0]->id );
    }
    $this->xmlContents( 'implementation-exists', $this->version, $result );
  }
  
  private function flow($id) {
    if( $id == false ) {
      $this->returnError( 180, $this->version );
      return;
    }

    if(is_numeric($id) === false ) {
      $record = $this->Implementation->getWhere('`fullName` = "' . $id . '"');

      if( $record !== false ) {
        $id = $record[0]->id;
      } else {
        // maybe a file hash has been given.
        $files =  $this->File->getColumnWhere('id','`md5_hash` = "'.$id.'"');
        if( $files !== false ) {
          $record = $this->Implementation->getWhere('`binary_file_id` IN ('.implode(',', $files).') OR `source_file_id` IN ('.implode(',', $files).')');
          if( $record !== false ) {
            $id = $record[0]->id;
          } else {
            $id = -1;
          }
        } else {
          $id = -1;
        }
      }
    }

    $implementation = $this->Implementation->fullImplementation( $id );

    if( $implementation === false ) {
      $this->returnError( 181, $this->version );
      return;
    }

    $this->xmlContents( 'implementation-get', $this->version, array( 'source' => $implementation ) );
  }
  
  private function flow_upload() {

    if(isset($_FILES['source']) && $_FILES['source']['error'] == 0) {
      $source = true;
    } else {
      $source = false;
      unset($_FILES['source']);
    }

    if(isset($_FILES['binary']) && $_FILES['binary']['error'] == 0) {
      $binary = true;
    } else {
      $binary = false;
      unset($_FILES['binary']);
    }

    if( $source == false && $binary == false ) {
      $this->returnError( 162, $this->version );
      return;
    }

    foreach( $_FILES as $key => $file ) {
      if( check_uploaded_file( $file ) == false ) {
        $this->returnError( 160, $this->version );
        return;
      }
    }

    // get correct description
    if( $this->input->post('description') ) {
      // get description from string upload
      $description = $this->input->post('description');
      $xmlErrors = "";
      if( validateXml( $description, xsd('openml.implementation.upload'), $xmlErrors, false ) == false ) {
        $this->returnError( 163, $this->version, $this->openmlGeneralErrorCode, $xmlErrors );
        return;
      }
      $xml = simplexml_load_string( $description );
    } elseif(isset($_FILES['description'])) {
      // get description from file upload
      $description = $_FILES['description'];

      if( validateXml( $description['tmp_name'], xsd('openml.implementation.upload'), $xmlErrors ) == false ) {
        $this->returnError( 163, $this->version, $this->openmlGeneralErrorCode, $xmlErrors );
        return;
      }
      $xml = simplexml_load_file( $description['tmp_name'] );
      $similar = $this->Implementation->compareToXML( $xml );
      if( $similar ) {
        $this->returnError( 171, $this->version, $this->openmlGeneralErrorCode, 'implementation_id:' . $similar );
        return;
      }
    } else {
      $this->returnError( 161, $this->version );
      return;
    }

    $name = ''.$xml->children('oml', true)->{'name'};

    $implementation = array(
      'uploadDate' => now(),
      'uploader' => $this->user_id
    );

    foreach( $_FILES as $key => $file ) {
      if( $key == 'description' ) { continue; }
      if( ! in_array( $key, array( 'description', 'source', 'binary' ) ) ) {
        $this->returnError( 167, $this->version );
        return;
      }

      $file_id = $this->File->register_uploaded_file($_FILES[$key], $this->data_folders['implementation'] . $key . '/', $this->user_id, 'implementation');
      if($file_id === false) {
        $this->returnError( 165, $this->version );
        return;
      }
      $file_record = $this->File->getById($file_id);

      //$implementation[$key.'Url'] = $this->data_controller . 'download/' . $file_id . '/' . $file_record->filename_original;
      $implementation[$key.'_md5'] = $file_record->md5_hash;
      $implementation[$key.'_file_id'] = $file_id;
      //$implementation[$key.'Format'] = $file_record->md5_hash;

      if( property_exists( $xml->children('oml', true), $key.'_md5' ) ) {
        if( $xml->children('oml', true)->{$key.'_md5'} != $file_record->md5_hash ) {
          $this->returnError( 168, $this->version );
          return;
        }
      }
    }

    $impl = insertImplementationFromXML( $xml->children('oml', true), $this->xml_fields_implementation, $implementation );
    if( $impl == false ) {
      $this->returnError( 165, $this->version );
      return;
    }
    $implementation = $this->Implementation->getById( $impl );

    $this->xmlContents( 'implementation-upload', $this->version, $implementation );
  }
  
  
  private function flow_tag() {
    $id = $this->input->post( 'flow_id' );
    $tag = $this->input->post( 'tag' );

    $error = -1;
    $result = tag_item( 'implementation', $id, $tag, $this->user_id, $error );

    //update index
    $this->elasticsearch->index('flow', $id);

    if( $result == false ) {
      $this->returnError( $error, $this->version );
    } else {
      $this->xmlContents( 'entity-tag', $this->version, array( 'id' => $id, 'type' => 'implementation' ) );
    }
  }

  private function flow_untag() {
    $id = $this->input->post( 'flow_id' );
    $tag = $this->input->post( 'tag' );

    $error = -1;
    $result = untag_item( 'implementation', $id, $tag, $this->user_id, $error );

    //update index
    $this->elasticsearch->index('flow', $id);

    if( $result == false ) {
      $this->returnError( $error, $this->version );
    } else {
      $this->xmlContents( 'entity-untag', $this->version, array( 'id' => $id, 'type' => 'implementation' ) );
    }
  }
  
}
?>
