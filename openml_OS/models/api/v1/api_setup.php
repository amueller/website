<?php
class Api_setup extends Api_model {
  
  protected $version = 'v1';
  
  function __construct() {
    parent::__construct();
    
    // load models
    $this->load->model('Algorithm_setup');
    $this->load->model('Implementation');
    $this->load->model('Input');
    $this->load->model('Input_setting');
    $this->load->model('Schedule');
    $this->load->model('Setup_differences');
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
    
    if (count($segments) == 1 && $segments[0] == 'exists' && $request_type == 'post') {
      $this->setup_exists();
      return;
    }
    
    if (count($segments) == 3 && $segments[0] == 'differences' && 
        is_numeric($segments[1]) && is_numeric($segments[2]) && 
        $request_type == 'post' && $this->input->post('task_id') != false) { // TODO: fix $this->inpout->post('task_id') requirement
    	$this->setup_differences_upload($segments[1],$segments[2]);
    	return;
    }
    
    if (count($segments) >= 3 && $segments[0] == 'differences' && is_numeric($segments[1]) && is_numeric($segments[2])) {
    	$task_id = null;
    	if (count($segments) > 3) {
    		$task_id = $segments[3];
    	}
    	$this->setup_differences($segments[1],$segments[2],$task_id);
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
      $this->parameters = $this->Input_setting->query('SELECT * FROM `input_setting` `s` , `input` `i` WHERE `s`.`input_id` = `i`.`id` AND setup = "'.$setup->sid.'"');

      $this->xmlContents( 'setup-parameters', $this->version, array( 'parameters' => $this->parameters ) );
    }
  }
  
  private function setup_exists() {
    $description = isset($_FILES['description']) ? $_FILES['description'] : false;
    $uploadError = '';
    if(!check_uploaded_file($description,false,$uploadError)) {
      $this->returnError(581, $this->version,$this->openmlGeneralErrorCode,$uploadError);
      return;
    }
    
    // validate xml
    $xmlErrors = '';
    if(validateXml($description['tmp_name'], xsd('openml.run.upload', $this->controller, $this->version), $xmlErrors) == false) {
      $this->returnError(582, $this->version, $this->openmlGeneralErrorCode, $xmlErrors);
      return;
    }
    
    
    // fetch xml
    $xml = simplexml_load_file($description['tmp_name']);
    if($xml === false) {
      $this->returnError(583, $this->version);
      return;
    }
    
    $run_xml = all_tags_from_xml(
      $xml->children('oml', true),
      $this->xml_fields_run);
    
    $implementation_id = $run_xml['flow_id'];
    $parameter_objects = array_key_exists('parameter_setting', $run_xml) ? $run_xml['parameter_setting'] : array();
    
    // fetch implementation
    $implementation = $this->Implementation->getById($implementation_id);
    if($implementation === false) {
      $this->returnError(584, $this->version);
      return;
    }
    if(in_array($implementation->{'implements'}, $this->supportedMetrics)) {
      $this->returnError(585, $this->version);
      return;
    }
    
    $parameters = array();
    foreach( $parameter_objects as $p ) {
      // since 'component' is an optional XML field, we add a default option
      $component = property_exists($p, 'component') ? $p->component : $implementation->id;

      // now find the input id
      $input_id = $this->Input->getWhereSingle('`implementation_id` = ' . $component . ' AND `name` = "' . $p->name . '"');
      if($input_id === false) {
        $this->returnError(586, $this->version, $this->openmlGeneralErrorCode, 'Name: ' . $p->name . ', flow id (component): ' . $component);
        return;
      }

      $parameters[$input_id->id] = $p->value . '';
    }
    // search setup ... // TODO: do something about the new parameters. Are still retrieved by ID, does not work with Weka plugin.
    $setupId = $this->Algorithm_setup->getSetupId($implementation, $parameters, false);
    
    $result = array('exists' => 'false', 'id' => -1);
    if($setupId) {
      $result = array('exists' => 'true', 'id' => $setupId);
    }
    $this->xmlContents('setup-exists', $this->version, $result);
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
  
  private function setup_differences($setupA, $setupB, $task_id) {
  	$sidA = min($setupA, $setupB);
  	$sidB = max($setupA, $setupB);
  	$taskWhere = '';
  	
  	if ($task_id != null) {
  		$taskWhere = ' AND `task_id` = ' . $task_id;
  	}
  	
  	$meta_array = $this->Setup_differences->getWhere(
  		  '`sidA` = ' . $sidA . ' AND `sidB` = ' . $sidB . $taskWhere);
  	if ($meta_array != false) {
  		$this->xmlContents(
  			'setup-differences', $this->version, 
  			array('data' => $meta_array)
  		);
  	} else {
  		$this->returnError(520, $this->version);
  	}
  }
  
  private function setup_differences_upload($setupA, $setupB) {
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
  		$meta_array = $this->Setup_differences->getWhere(
  		  '`sidA` = ' . $data['sidA'] . ' AND `sidB` = ' . $data['sidB'] . ' AND `task_id` = ' . $data['task_id']);
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
