<?php
class Api_study extends Api_model {
  
  protected $version = 'v1';
  
  function __construct() {
    parent::__construct();
    
    $this->load->model('Study');
  }

  function bootstrap($format, $segments, $request_type, $user_id) {
    $this->outputFormat = $format;
    
    $getpost = array('get','post');

    if (count($segments) >= 1 && $segments[0] == 'list') {
      array_shift($segments);
      $this->study_list($segments);
      return;
    }
    
    $this->returnError( 100, $this->version );
  }
  
  
  private function study_list() {
    $studies = $this->Study->getWhere('visibility = "public" or creator = ' . $this->user_id);
    
    if (count($studies) == 0) {
      $this->returnError(591, $this->version );
      return;
    }

    $this->xmlContents('study-list', $this->version, array('studies' => $studies));
  }
}
?>
