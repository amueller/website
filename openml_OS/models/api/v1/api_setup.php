<?php
class Api_setup extends Api_model {
  
  protected $version = 'v1';
  
  function __construct() {
    parent::__construct();
    
    // load models
    $this->load->model('Algorithm_setup');
    $this->load->model('Setup_differences');
    $this->load->model('Input_setting');
    $this->load->model('Schedule');
    $this->load->model('Setup_tag');
  }

  function bootstrap($format, $segments, $request_type, $user_id) {
    $this->outputFormat = $format;
    
    $getpost = array('get','post');
    
    if (count($segments) == 1 && is_numeric($segments[0]) && in_array($request_type, $getpost)) {
      $this->setup($segments[0]);
      return;
    }
    
    if (count($segments) == 1 && is_numeric($segments[0]) && $request_type == 'delete') {
      $this->setup_delete($segments[0]);
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'tag' && $request_type == 'post') {
      $this->setup_tag($this->input->post('setup_id'),$this->input->post('tag'));
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'untag' && $request_type == 'post') {
      $this->setup_untag($this->input->post('setup_id'),$this->input->post('tag'));
      return;
    }
    
    if (count($segments) == 3 && $segments[0] == 'differences' && is_numeric($segments[1]) && is_numeric($segments[2]) && $request_type == 'post') {
    	$this->setup_differences($segments[1],$segments[2]);
    	return;
    }
    
    $this->returnError( 100, $this->version );
  }
  
  private function setup($setup_id) {
    if( $setup_id == false ) {
      $this->returnError( 280, $this->version );
      return;
    }
    $setup = $this->Algorithm_setup->getById( $setup_id );
    
    if ($setup == false) {
      $this->returnError( 281, $this->version );
      return;
    } else {
      // TODO: temp linking on concat of fields. should be done better
      $this->parameters = $this->Input_setting->query('SELECT * FROM `input_setting` LEFT JOIN `input` ON CONCAT( `input`.`implementation_id` , "_", `input`.`name` ) = `input_setting`.`input` WHERE setup = "'.$setup->sid.'"');

      $this->xmlContents( 'setup-parameters', $this->version, array( 'parameters' => $this->parameters ) );
    }
  }
  
  
  private function setup_delete($setup_id) {

    $setup = $this->Algorithm_setup->getById( $setup_id );
    if( $setup == false ) {
      $this->returnError( 402, $this->version );
      return;
    }

    $runs = $this->Run->getWhere( 'setup = "' . $setup->sid . '"' );
    $schedules = $this->Schedule->getWhere( 'sid = "' . $setup->sid . '"' );

    if( $runs || $schedules ) {
      $this->returnError( 404, $this->version );
      return;
    }


    $result = true;
    $result = $result && $this->Input_setting->deleteWhere('setup = ' . $setup->sid );

    if( $result ) {
      $result = $this->Algorithm_setup->delete( $setup->sid );
    }

    if( $result == false ) {
      $this->returnError( 405, $this->version );
      return;
    }

    $this->xmlContents( 'setup-delete', $this->version, array( 'setup' => $setup ) );
  }
  
  
  private function setup_tag($id,$tag) {

    $error = -1;
    $result = tag_item( 'algorithm_setup', $id, $tag, $this->user_id, $error );

    //update index
    $this->elasticsearch->index('setup', $id);

    if( $result == false ) {
      $this->returnError( $error, $this->version );
    } else {
      $this->xmlContents( 'entity-tag', $this->version, array( 'id' => $id, 'type' => 'setup' ) );
    }
  }
  
  private function setup_differences($setupA, $setupB) {
  	$task_id = $this->input->post('task_id');
  	$task_size = $this->input->post('task_size');
  	$differences = $this->input->post('differences');
  	
  	if( $this->ion_auth->is_admin($this->user_id) == false ) {
      $this->returnError( 104, $this->version );
      return;
    }
  	
  	$data = array(
  		'sidA' => min($setupA,$setupB),
  		'sidB' => max($setupA,$setupB),
  		'task_id' => $task_id,
  		'task_size' => $task_size,
  		'differences' => $differences
  	);
  	
  	$success = $this->Setup_differences->insert($data);
  	
  	// if ($success == false) {
  	//	$this->returnError( 520, $this->version );
  	//	return;
  	//} else {
  		$meta_array = array($data);
  		$this->xmlContents( 'setup-differences', $this->version, array( 'data' => $meta_array ) );
  	//}
  }

  private function setup_untag($id,$tag) {
    
    $error = -1;
    $result = untag_item( 'algorithm_setup', $id, $tag, $this->user_id, $error );

    //update index
    $this->elasticsearch->index('setup', $id);

    if( $result == false ) {
      $this->returnError( $error, $this->version );
    } else {
      $this->xmlContents( 'entity-untag', $this->version, array( 'id' => $id, 'type' => 'setup' ) );
    }
  }
}
?>
