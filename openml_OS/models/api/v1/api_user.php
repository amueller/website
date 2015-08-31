<?php
class Api_user extends Api_model {
  
  protected $version = 'v1';
  
  function __construct() {
    parent::__construct();
    
    // load models
    $this->load->model('User');
  }
  
  function bootstrap($segments, $request_type, $user_id) {
    $getpost = array('get','post');
    
    if (count($segments) == 1 && is_numeric($segments[0]) && $request_type == 'delete') {
      $this->user_delete($segments[0]);
      return;
    }
    
    $this->returnError( 100, $this->version );
  }

  
  private function user_delete() {

    if( $this->ion_auth->is_admin($this->user_id) == false ) {
      $this->returnError( 462, $this->version );
      return;
    }

    $user = $this->Author->getById( $this->input->post( 'user_id' ) );
    if( $user == false ) {
      $this->returnError( 463, $this->version );
      return;
    }

    $datasets = $this->Dataset->getWhereSingle( 'uploader = ' . $user->id );

    if( $datasets ) {
      $this->returnError( 464, $this->version );
      return;
    }

    $flows = $this->Implementation->getWhereSingle( 'uploader = ' . $user->id );
    if( $flows ) {
      $this->returnError( 464, $this->version );
      return;
    }
    $runs = $this->Run->getWhereSingle( 'uploader = ' . $user->id );
    if( $runs ) {
      $this->returnError( 464, $this->version );
      return;
    }

    $result = $this->ion_auth->delete_user( $user->id );
    if( !$result ) {
      $this->returnError( 465, $this->version );
      return;
    }

    $this->_xmlContents( 'user-delete', array( 'user' => $user ) );
  }
  
}
?>
