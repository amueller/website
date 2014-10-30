<?php
class Rest_api extends CI_Controller {
  
  private $requested_function;
  
  function __construct() {
    parent::__construct();
    
    $this->controller = strtolower(get_class ($this));
    $this->active = 'learn';
    $this->message = $this->session->flashdata('message'); // can be overridden
    
    // for writing
    $this->load->model('Dataset');
    $this->load->model('Dataset_tag');
    $this->load->model('Data_feature');
    $this->load->model('Data_quality');
    $this->load->model('Data_quality_interval');
    $this->load->model('File');
    $this->load->model('Algorithm_setup');
    $this->load->model('Implementation');
    $this->load->model('Implementation_tag');
    $this->load->model('Implementation_component');
    $this->load->model('Run');
    $this->load->model('Evaluation');
    $this->load->model('Evaluation_interval');
    $this->load->model('Evaluation_fold');
    $this->load->model('Evaluation_sample');
    $this->load->model('Estimation_procedure');
    $this->load->model('Input');
    $this->load->model('Input_data');
    $this->load->model('Output_data');
    $this->load->model('Bibliographical_reference');
    $this->load->model('Input_setting');
    $this->load->model('Runfile');
    $this->load->model('Run_tag');
    $this->load->model('Task_tag');

    // only for reading
    $this->load->model('Algorithm');
    $this->load->model('Feature');
    $this->load->model('Math_function');
    $this->load->model('Quality');
    $this->load->model('Schedule');
    $this->load->model('Task');
    $this->load->model('Task_inputs');
    $this->load->model('Task_type');
    $this->load->model('Task_type_inout');
    $this->load->model('Workflow_setup');
    $this->load->model('Algorithm_setup');
    
    // community db
    $this->load->model('Api_session');
    $this->load->model('Log');
    
    // helper
    $this->load->helper('api');
    
    $this->load->library('elasticSearch');
    $this->load->library('wiki');
    
    // paths
    $this->data_folders = array(
      'dataset'       => 'dataset/api/',
      'implementation'   => 'implementation/',
      'run'        => 'run/'
    );
    
    $this->data_tables = $this->config->item('data_tables');
    
    // XML maintainance
    $this->xml_fields_dataset = $this->config->item('xml_fields_dataset');
    $this->xml_fields_dataset_update = $this->config->item('xml_fields_dataset_update');
    $this->xml_fields_implementation = $this->config->item('xml_fields_implementation');
    $this->xml_fields_run = $this->config->item('xml_fields_run');
    
    $this->data_controller = $this->config->item('data_controller');
    
    $this->supportedMetrics = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
    $this->supportedAlgorithms = $this->Algorithm->getColumn('name');
    
    // some user authentication things. 
    $this->provided_hash = $this->input->get_post('session_hash') != false;
    $this->provided_valid_hash = $this->Api_session->isValidHash( $this->input->get_post('session_hash') );
    $this->authenticated = $this->provided_valid_hash || $this->ion_auth->logged_in();
    $this->user_id = false;
    if($this->provided_valid_hash) {
      $this->user_id = $this->Api_session->getByHash( $this->input->post('session_hash') )->author_id;
    } elseif($this->ion_auth->logged_in()) {
      $this->user_id = $this->ion_auth->user()->row()->id;
    }
    $this->openmlGeneralErrorCode = 450;
  }
  
  public function index() {
    $this->requested_function = $this->input->get('f');
    
    if( $this->requested_function == false ) {
      $this->_show_webpage();
    } else {
      $this->page = 'xml';
      loadpage($this->page,false,'pre');
      
      $api_function = '_' . str_replace( '.', '_', $this->requested_function );
      
      if( method_exists( $this, $api_function ) ) {
        if( $this->authenticated || substr( $this->requested_function, 0, 19 ) == 'openml.authenticate' ) {
          $this->$api_function();
        } else {
          if( $this->provided_hash ) { // user authenticated, but failed
            $this->_returnError( 103, 401 );
            return;
          } else { // user should authenticate
            $this->_returnError( 102, 401 );
            return;
          }
        }
      } else {
        $this->_returnError( 100, 404 );
        return;
      }
    }
  }
  
  public function xsd($filename) {
    if(is_safe($filename) && file_exists(xsd($filename))) {
      header('Content-type: text/xml; charset=utf-8');
      echo file_get_contents(xsd($filename));
    } else {
      $this->error404();
    }
  }
  
  public function error404() {
    header("Status: 404 Not Found");
    $this->load->view('404');
  }
  
  /*************************************** API ***************************************/
  
  private function _openml_authenticate() {
    $username = $this->input->post( 'username' );
    $password = $this->input->post( 'password' );
    if( $username == false ) {
      $this->_returnError( 250 );
      return;
    }
    if( $password == false ) {
      $this->_returnError( 251 );
      return;
    }
    
    $hash = $this->Api_session->createByCredentials( $username, $password );
    
    if( $hash === false ) {
      $this->_returnError( 252 );
      return;
    }
    
    $record = $this->Api_session->getByHash( $hash );
    
    $source = new stdClass();
    $source->hash = $hash;
    $source->until = $this->Api_session->validUntil( $record->creation_date );
    $source->timezone = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $source->timezonename = $source->timezone->getTimezone()->getName();
    
    $this->_xmlContents( 'authenticate', $source );
  }
  
  private function _openml_authenticate_check() {
    $username     = $this->input->getpost( 'username' );
    $session_hash  = $this->input->getpost( 'session_hash' );
    
    if( $username == false ) {
      $this->_returnError( 290 );
      return;
    }
    if( $session_hash == false ) {
      $this->_returnError( 291 );
      return;
    }
    $author_db  = $this->Author->getWhere('`username` = "'.$username.'"');
    $hash_db   = $this->Api_session->getByHash( $session_hash );
    
    if(count($author_db) < 1 || $hash_db == false) { // hash or author not found
      $this->_returnError( 292 );
      return;
    }
    if($author_db[0]->id != $hash_db->author_id) { // hash does not match author
      $this->_returnError( 292 );
      return;
    }
    
    $this->_xmlContents( 'authenticate.check', array( 'until' => $this->Api_session->validUntil( $hash_db->creation_date ) ) );
  }
  
  private function _openml_authenticate_weblogin() {
    $this->_xmlContents( 'authenticate.weblogin', array( 'weblogin' => $this->authenticated ? 'true' : 'false' ) );
  }
  
  private function _openml_data() {
    $datasets = $this->Task->query( 'SELECT `did`, `name`, `status` FROM `dataset` `d` WHERE 1; ' );
    if( is_array( $datasets ) == false || count( $datasets ) == 0 ) {
      $this->_returnError( 370 );
    }
    $dids = array();
    foreach( $datasets as $d ) { $dids[] = $d->did; }
    
    $data_qualities = $this->Data_quality->query('SELECT data, quality, value FROM data_quality WHERE `data` IN (' . implode(',', $dids) . ') AND quality IN ("' .  implode('","', $this->config->item('basic_qualities') ) . '") ORDER BY `data`');
    
    // DIRTY HACK. CAN BE DONE FASTER???
    for( $i = 0; $i < count($datasets); ++$i ) {
      for( $j = 0; $j < count($data_qualities); ++$j ) {
        if($datasets[$i]->did == $data_qualities[$j]->data) {
          if( property_exists( $datasets[$i], 'qualities' ) == false ) {
            $datasets[$i]->qualities = array();
          }
          $datasets[$i]->qualities[$data_qualities[$j]->quality] = $data_qualities[$j]->value;
        }
      }
    }
    
    $this->_xmlContents( 'data', array( 'datasets' => $datasets ) );
  }
  
  private function _openml_data_get() {
    $data_id = $this->input->get( 'data_id' );
    if( $data_id == false ) {
      $this->_returnError( 110 );
      return;
    }
    
    $dataset = $this->Dataset->getById( $data_id );
    if( $dataset === false ) {
      $this->_returnError( 111 );
      return;
    }
    $tags = $this->Dataset_tag->getColumnWhere( 'tag', 'id = ' . $dataset->did );
    $dataset->tag = $tags != false ? '"' . implode( '","', $tags ) . '"' : array();
    
    foreach( $this->xml_fields_dataset['csv'] as $field ) {
      $dataset->{$field} = getcsv( $dataset->{$field} );
    }
    
    $this->_xmlContents( 'data-description', $dataset );
  }
  
  private function _openml_data_features() {
    $data_id = $this->input->get( 'data_id' );
    if( $data_id == false ) {
      $this->_returnError( 270 );
      return;
    }
    $dataset = $this->Dataset->getById( $data_id );
    if( $dataset === false ) {
      $this->_returnError( 271 );
      return;
    }
    
    if( $dataset->processed == NULL) {
      $this->_returnError( 273 );
      return;
    }
    
    if( $dataset->error != "false") {
      $this->_returnError( 274 );
      return;
    }
    
    $dataset->features = $this->Feature->getWhere( 'did = "' . $dataset->did . '"' );
    
    if( $dataset->features === false ) {
      $this->_returnError( 272 );
      return;
    }
    if( is_array( $dataset->features ) === false ) {
      $this->_returnError( 272 );
      return;
    }
    if( count( $dataset->features ) === 0 ) {
      $this->_returnError( 272 );
      return;
    }
    
    $this->_xmlContents( 'data-features', $dataset );
  }
  
  private function _openml_data_features_upload() {
    // get correct description
    if( isset($_FILES['description']) == false || check_uploaded_file( $_FILES['description'] ) == false ) {
      $this->_returnError( 432 );
      return;
    }
    
    // get description from string upload
    $description = $_FILES['description'];
    if( validateXml( $description['tmp_name'], xsd('openml.data.features'), $xmlErrors ) == false ) {
      $this->_returnError( 433, $this->openmlGeneralErrorCode, $xmlErrors );
      return;
    }
    $xml = simplexml_load_file( $description['tmp_name'] );
    $did = ''. $xml->children('oml', true)->{'did'};
    
    $dataset = $this->Dataset->getById( $did );
    if( $dataset == false ) {
      $this->_returnError( 434 );
      return;
    }
    // prepare array for updating data object
    $data = array( 'processed' => now() );
    if( $xml->children('oml', true)->{'error'} ) {
      $data['error'] = "true";
      $data['error_message'] = htmlentities($xml->children('oml', true)->{'error'});
    }
    
    $this->db->trans_start();
    $success = true;
    //$current_index = -1;

    //copy special features into data_features
    $targets = array_map('trim',explode(",",$dataset->default_target_attribute));
    $rowids = array_map('trim',explode(",",$dataset->row_id_attribute));
    $ignores = getcsv($dataset->ignore_attribute);
    if(!$ignores) {
      $ignores = array();
    }
    
    foreach( $xml->children('oml', true)->{'feature'} as $q ) {
      $feature = xml2object( $q, true );
      $feature->did = $did;

      // add special features 
      if(in_array($feature->name,$targets))
        $feature->is_target = 'true';
      else //this is needed because the Java feature extractor still chooses a target when there isn't any
        $feature->is_target = 'false';
      if(in_array($feature->name,$rowids))
        $feature->is_row_identifier = 'true';
      if(in_array($feature->name,$ignores))
        $feature->is_ignore = 'true';

      //actual insert
      $this->Data_feature->insert_ignore( $feature );

      // NOTE: this is commented out because not all datasets have targets, or they can have multiple ones. Targets should also be set more carefully.
      // if no specified attribute is the target, select the last one:
      //if( $dataset->default_target_attribute == false && $feature->index > $current_index ) {
      //  $current_index = $feature->index;
      //  $data['default_target_attribute'] = $feature->name;
      //}
    }
    $this->db->trans_complete();
        
    $this->Dataset->update( $did, $data );
    
    if( $success ) {
      $this->_xmlContents( 'data-features-upload', array( 'did' => $dataset->did ) );
    } else {
      $this->_returnError( 435 );
      return;
    }
  }
  
  private function _openml_data_qualities() {
    $data_id = $this->input->get( 'data_id' );
    if( $data_id == false ) {
      $this->_returnError( 360 );
      return;
    }
    $dataset = $this->Dataset->getById( $data_id );
    if( $dataset === false ) {
      $this->_returnError( 361 );
      return;
    }
    
    if( $dataset->processed == NULL) {
      $this->_returnError( 363 );
      return;
    }
    
    if( $dataset->error != "false") {
      $this->_returnError( 364 );
      return;
    }
    
    $interval_start = $this->input->get( 'interval_start' );
    $interval_end = $this->input->get( 'interval_end' );
    $interval_size = $this->input->get( 'interval_size' );
    
    $evaluation_table_constraints = '';
    if( $interval_start !== false || $interval_end !== false || $interval_size !== false ) {
      $evaluation_table = 'evaluation_interval';
      $interval_constraints = '';
      if( $interval_start !== false && is_numeric( $interval_start ) ) {
        $interval_constraints .= ' AND `interval_start` >= ' . $interval_start;
      }
      if( $interval_end !== false && is_numeric( $interval_end ) ) {
        $interval_constraints .= ' AND `interval_end` <= ' . $interval_end;
      }
      if( $interval_size !== false && is_numeric( $interval_size ) ) {
        $interval_constraints .= ' AND `interval_end` - `interval_start` = ' . $interval_size;
      }
      $dataset->qualities = $this->Data_quality_interval->getWhere( 'data = "' . $dataset->did . '" ' . $interval_constraints );
    } else {
      $dataset->qualities = $this->Data_quality->getWhere( 'data = "' . $dataset->did . '"' );
    }
    
    if( $dataset->qualities === false ) {
      $this->_returnError( 362 );
      return;
    }
    if( is_array( $dataset->qualities ) === false ) {
      $this->_returnError( 362 );
      return;
    }
    if( count( $dataset->qualities ) === 0 ) {
      $this->_returnError( 362 );
      return;
    }
    
    $this->_xmlContents( 'data-qualities', $dataset );
  }
  
  private function _openml_data_qualities_list() {
    $result = $this->Quality->allUsed( );
    $qualities = array();
    foreach( $result as $r ) {
      $qualities[] = $r->name;
    }
    $this->_xmlContents( 'data-qualities-list', array( 'qualities' => $qualities ) );
  }
  
  private function _openml_data_qualities_upload() {
    // get correct description
    if( isset($_FILES['description']) == false || check_uploaded_file( $_FILES['description'] ) == false ) {
      $this->_returnError( 382 );
      return;
    }
    
    // get description from string upload
    $description = $_FILES['description'];
    if( validateXml( $description['tmp_name'], xsd('openml.data.qualities'), $xmlErrors ) == false ) {
      $this->_returnError( 383, $this->openmlGeneralErrorCode, $xmlErrors );
      return;
    }
    $xml = simplexml_load_file( $description['tmp_name'] );
    $did = ''. $xml->children('oml', true)->{'did'};
    
    $dataset = $this->Dataset->getById( $did );
    if( $dataset == false ) {
      $this->_returnError( 384 );
      return;
    }
    
    // prepare array for updating data object
    $data = array( 'processed' => now() );
    if( $xml->children('oml', true)->{'error'} ) { 
      $data['error'] = "true";
    }
    $this->Dataset->update( $did, $data );

    
    $all_qualities = $this->Quality->getColumnWhere( 'name', '`type` = "DataQuality"' );
    
    $qualities = $this->Data_quality->getAssociativeArray( 'quality', 'value', '`data` = "' . $dataset->did . '"' );
    
    // check and collect the qualities
    $newQualities = array();
    foreach( $xml->children('oml', true)->{'quality'} as $q ) {
      $quality = xml2object( $q, true );
      
      /*if( array_key_exists( $quality->name, $newQualities ) ) { // quality calculated twice
        $this->_returnError( 385, $this->openmlGeneralErrorCode, $quality->name );
        return;
      } elseif( $qualities != false && array_key_exists( $quality->name, $qualities ) ) { // prior to this run, we already got this quality
        if( abs( $qualities[$quality->name] - $quality->value ) > $this->config->item('double_epsilon') ) {
          $this->_returnError( 386, $this->openmlGeneralErrorCode, $quality->name );
          return;
        }
      } else*/if( is_array( $all_qualities ) == false || in_array( $quality->name, $all_qualities ) == false ) {
        $this->_returnError( 387, $this->openmlGeneralErrorCode, $quality->name );
        return;
      } else {
        $newQualities[] = $quality;
      }
      
      if( property_exists( $quality, 'interval_start' ) ) {
      
      } else {
      
      }
    }
    
    if( count( $newQualities) == 0 ) {
      $this->_returnError( 388 );
      return;
    }
    
    $success = true;
    $this->db->trans_start();
    foreach( $newQualities as $index => $quality ) {
      if( property_exists( $quality, 'interval_start' ) ) {
        $data = array(
          'data' => $dataset->did,
          'quality' => $quality->name,
          'interval_start' => $quality->interval_start,
          'interval_end' => $quality->interval_end,
          'value' => $quality->value
        );
        $this->Data_quality_interval->insert_ignore( $data );
      } else {
        $data = array(
          'data' => $dataset->did,
          'quality' => $quality->name,
          'value' => $quality->value
        );
        $this->Data_quality->insert_ignore( $data );
      }
    }
    $this->db->trans_complete();
    
    // add to elastic search index. 
    $this->elasticsearch->index('data', $dataset->did); 
    
    if( $success ) {
      $this->_xmlContents( 'data-qualities-upload', array( 'did' => $dataset->did ) );
    } else {
      $this->_returnError( 389 );
      return;
    }
  }
  
  private function _openml_data_delete() {
    
    $dataset = $this->Dataset->getById( $this->input->post( 'data_id' ) );
    if( $dataset == false ) {
      $this->_returnError( 352 );
      return;
    }
    
    if($dataset->uploader != $this->user_id ) {
      $this->_returnError( 353 );
      return;
    }
    
    $tasks = $this->Task->getTasksWithValue( array( 'source_data' => $dataset->did ) );
    
    if( $tasks !== false ) { 
      $task_ids = array();
      foreach( $tasks as $t ) { $task_ids[] = $t->task_id; }

      $runs = $this->Run->getWhere( 'task_id IN ("'.implode('","', $task_ids).'")' );
      
      
      if( $runs ) {
        $this->_returnError( 354 );
        return;
      }
    }
    
    $result = $this->Dataset->delete( $dataset->did );
    $this->Data_feature->deleteWhere('did =' . $dataset->did);
    $this->Data_quality->deleteWhere('data =' . $dataset->did);

    if( $result == false ) {
      $this->_returnError( 355 );
      return;
    }
    $this->_xmlContents( 'data-delete', array( 'dataset' => $dataset ) );
  }
  
  private function _openml_data_licences() {
    $data->licences = $this->Dataset->getDistinct( 'licence' );
    $this->_xmlContents( 'data-licences', $data );
  }
  
  private function _openml_data_upload() {
    
    // get correct description
    if( $this->input->post('description') ) {
      // get description from string upload
      $description = $this->input->post('description', false);
      if( validateXml( $description, xsd('openml.data.upload'), $xmlErrors, false ) == false ) {
        $this->_returnError( 131, $this->openmlGeneralErrorCode, $xmlErrors );
        return;
      }
      $xml = simplexml_load_string( $description );
    } elseif(isset($_FILES['description']) && check_uploaded_file( $_FILES['description'] ) == true) {
      // get description from file upload
      $description = $_FILES['description'];
      
      if( validateXml( $description['tmp_name'], xsd('openml.data.upload'), $xmlErrors ) == false ) {
        $this->_returnError( 131, $this->openmlGeneralErrorCode, $xmlErrors );
        return;
      }
      $xml = simplexml_load_file( $description['tmp_name'] );
    } else {
      $this->_returnError( 135 );
      return;
    }

    //check if this is an update or a new dataset
    $update = false;
    if($xml->children('oml', true)->{'id'}) {
      $update = true;
    }
    
    //check and register the data files, return url
    $file_id = null;
    $datasetUrlProvided = property_exists( $xml->children('oml', true), 'url' );
    $datasetFileProvided = isset( $_FILES['dataset'] );
    if( $datasetUrlProvided && $datasetFileProvided ) {
      $this->_returnError( 140 );
      return;
    } elseif( $datasetFileProvided ) {
      $message = '';
      if( ! check_uploaded_file( $_FILES['dataset'], false, $message ) ) {
        $this->_returnError( 130, $this->openmlGeneralErrorCode, 'File dataset: ' . $message );
        return;
      }
      $access_control = 'public';
      $access_control_option = $xml->children('oml', true)->{'visibility'};
      if( $access_control_option != 'public' ) {
        $access_control = 'private';
      }
      
      $file_id = $this->File->register_uploaded_file($_FILES['dataset'], $this->data_folders['dataset'], $this->user_id, 'dataset', $access_control);
      if($file_id === false) {
        $this->_returnError( 132 );
        return;
      }
      $file_record = $this->File->getById($file_id);
      $destinationUrl = $this->data_controller . 'download/' . $file_id . '/' . $file_record->filename_original;
    } elseif( $datasetUrlProvided ) {
      $destinationUrl = '' . $xml->children('oml', true)->url;
    } elseif($update) {
      $destinationUrl = false;
    } else {
      $this->_returnError( 141 );
      return;
    } 
    
    //build dataset object with new fields to be stored
    if(!$update){
      // ***** NEW DATASET ***** 
      $name = '' . $xml->children('oml', true)->{'name'};
      $version = $this->Dataset->incrementVersionNumber( $name );
      
      $dataset = array(
        'name' => $name,
        'version' => $version,
        'url' => $destinationUrl,
        'upload_date' => now(),
        'last_update' => now(),
        'uploader' => $this->user_id,
        'isOriginal' => 'true',
        'file_id' => $file_id,
        'md5_checksum' => md5_file( $destinationUrl )
      );
      // extract all other necessary info from the XML description
      $dataset = all_tags_from_xml( 
        $xml->children('oml', true), 
        $this->xml_fields_dataset, $dataset );
    } else {
      // ***** UPDATED DATASET *****
      $id = $xml->children('oml', true)->{'id'};
      $dataset = $this->Dataset->getById( $id );
      if( $dataset === false ) {
        $this->_returnError( 144 );
        return;
      }
      
      if ($destinationUrl){
        $dataset = array(
          'last_update' => now(),
          'url' => $destinationUrl,
          'md5_checksum' => md5_file( $destinationUrl )
        );
      } else {
        $dataset = array(
          'last_update' => now()
        );
      }
      // extract all other necessary info from the XML description
      $dataset = all_tags_from_xml( 
        $xml->children('oml', true), 
        $this->xml_fields_dataset_update, $dataset );
    }
    
    // handle tags 
    $tags = array();
    if( array_key_exists( 'tag', $dataset ) ) {
      $tags = str_getcsv( $dataset['tag'] );
      unset( $dataset['tag'] );
    }
    
    /* * * * 
     * THE ACTUAL INSERTION
     * * * */
    if(!$update) {
      // ***** NEW DATASET *****
      
      $id = $this->Dataset->insert( $dataset );
      if( ! $id ) {
        $this->_returnError( 134 );
        return;
      }
      // insert tags.
      foreach( $tags as $tag ) {
        $error = -1;
        tag_item( 'dataset', $id, $tag, $this->user_id, $error );
      }
      // TODO: handle tags for updated data sets as well.
    } else {
      // ***** UPDATED DATASET *****
      $id =  '' . $xml->children('oml', true)->{'id'};

      // ignore id, description (should not be altered)
      unset($dataset['id']);
      unset($dataset['description']);

	    // remove ignore attributes if none specified
      if(!array_key_exists('ignore_attribute', $dataset)) {
        $dataset['ignore_attribute'] = NULL;
      }
      
      // reset data features so that they are recalculated
      $dataset['processed'] = NULL; 
      $dataset['error'] = 'false';
      $this->Data_feature->deleteWhere('`did` = "' . $id . '"');
      $this->Data_quality->deleteWhere('`data` = "' . $id . '"');

            // the actual update
      $response = $this->Dataset->update( $id, $dataset );
    }

    // update elastic search index. 
    $this->elasticsearch->index('data', $id);

    // create initial wiki page
    if(!$update) {
      $this->wiki->export_to_wiki($id);
    }
    
    // create 
    $this->_xmlContents( 'data-upload', array( 'id' => $id ) );
  }
  
  private function _openml_data_tag() {
    $id = $this->input->get( 'data_id' );
    $tag = $this->input->get( 'tag' );
    
    $error = -1;
    $result = tag_item( 'dataset', $id, $tag, $this->user_id, $error );
    
    if( $result == false ) {
      $this->_returnError( $error );
    } else {
      $this->_xmlContents( 'entity-tag', array( 'id' => $id, 'type' => 'data' ) ); 
    }
  }
  
  private function _openml_data_untag() {
    $id = $this->input->get( 'data_id' );
    $tag = $this->input->get( 'tag' );
    
    $error = -1;
    $result = untag_item( 'dataset', $id, $tag, $this->user_id, $error );
    
    if( $result == false ) {
      $this->_returnError( $error );
    } else {
      $this->_xmlContents( 'entity-untag', array( 'id' => $id, 'type' => 'data' ) ); 
    }
  }
  
  private function _openml_tasks() {
    $task_type_id = $this->input->get( 'task_type_id' );
    if( $task_type_id == false ) {
      $this->_returnError( 480 );
      return;
    }
    
    $tasks = $this->Task->query( 'SELECT t.task_id, tt.name, source.value as did, d.status, d.name AS dataset_name FROM `task` `t`, `task_inputs` `source`, `dataset` `d`, `task_type` `tt` WHERE `source`.`input` = "source_data" AND `source`.`task_id` = `t`.`task_id` AND `source`.`value` = `d`.`did` AND `tt`.`ttid` = `t`.`ttid` AND `t`.`ttid` = "'.$task_type_id.'"; ' );
    if( is_array( $tasks ) == false || count( $tasks ) == 0 ) {
      $this->_returnError( 481 );
    }
    $dids = array();
    foreach( $tasks as $task ) { $dids[] = $task->did; }
    
    $data_qualities = $this->Data_quality->query('SELECT data, quality, value FROM data_quality WHERE data IN (' . implode(',', $dids) . ') AND quality IN ("' .  implode('","', $this->config->item('basic_qualities') ) . '") ORDER BY data');
    
    // DIRTY HACK. CAN BE DONE FASTER???
    for( $i = 0; $i < count($tasks); ++$i ) {
      for( $j = 0; $j < count($data_qualities); ++$j ) {
        if($tasks[$i]->did == $data_qualities[$j]->data) {
          if( property_exists( $tasks[$i], 'qualities' ) == false ) {
            $tasks[$i]->qualities = array();
          }
          $tasks[$i]->qualities[$data_qualities[$j]->quality] = $data_qualities[$j]->value;
        }
      }
    }
    
    $this->_xmlContents( 'tasks', array( 'tasks' => $tasks ) );
  }
  
  private function _openml_task_type() {
    $data = new stdClass();
    $data->task_types = $this->Task_type->get();
    $this->_xmlContents( 'task-types', $data );
  }
  
  private function _openml_task_type_get() {
    $task_type_id = $this->input->get( 'task_type_id' );
    if( $task_type_id == false ) {
      $this->_returnError( 240 );
      return;
    }
    
    $taskType = $this->Task_type->getById( $_GET['task_type_id'] );
    $taskTypeIos = $this->Task_type_inout->getByTaskType( $_GET['task_type_id'], 'order ASC' );
    
    if( $taskType === false ) {
      $this->_returnError( 241 );
      return;
    }
    
    $this->_xmlContents( 'task-types-search', array( 'task_type' => $taskType, 'io' => $taskTypeIos ) );
  }
  
  private function _openml_task_get() {
    $task_id = $this->input->get( 'task_id' );
    if( $task_id == false ) {
      $this->_returnError( 150 );
      return;
    }
    
    $task = $this->Task->getById( $task_id );
    if( $task === false ) {
      $this->_returnError( 151 );
      return;
    }
    
    $task_type = $this->Task_type->getById( $task->ttid );
    if( $task_type === false ) {
      $this->_returnError( 151 );
      return;
    }
    
    $parsed_io = $this->Task_type_inout->getParsed( $task_id );
    $tags = $this->Task_tag->getColumnWhere( 'tag', 'id = ' . $task_id );
    $this->_xmlContents( 'task-get', array( 'task' => $task, 'task_type' => $task_type, 'parsed_io' => $parsed_io, 'tags' => $tags ) );
  }
  
  private function _openml_task_tag() {
    $id = $this->input->get( 'task_id' );
    $tag = $this->input->get( 'tag' );
    
    $error = -1;
    $result = tag_item( 'task', $id, $tag, $this->user_id, $error );
    
    if( $result == false ) {
      $this->_returnError( $error );
    } else {
      $this->_xmlContents( 'entity-tag', array( 'id' => $id, 'type' => 'task' ) ); 
    }
  }
  
  private function _openml_task_untag() {
    $id = $this->input->get( 'task_id' );
    $tag = $this->input->get( 'tag' );
    
    $error = -1;
    $result = untag_item( 'task', $id, $tag, $this->user_id, $error );
    
    if( $result == false ) {
      $this->_returnError( $error );
    } else {
      $this->_xmlContents( 'entity-untag', array( 'id' => $id, 'type' => 'task' ) ); 
    }
  }
  
  private function _openml_task_delete() {
    
    $task = $this->Task->getById( $this->input->post( 'task_id' ) );
    if( $task == false ) {
      $this->_returnError( 452 );
      return;
    }
    
    $runs = $this->Run->getWhere( 'task_id = "' . $task->task_id . '"' );
    
    if( $runs ) {
      $this->_returnError( 454 );
      return;
    }
    
    
    $result = true;
    $result = $result && $this->Task_inputs->deleteWhere('task_id = ' . $task->task_id );
    
    if( $result ) {
      $result = $this->Task->delete( $task->task_id );
    }
    
    if( $result == false ) {
      $this->_returnError( 455 );
      return;
    }
    
    $this->_xmlContents( 'task-delete', array( 'task' => $task ) );
  }
    
  private function _openml_estimationprocedure_get() {
    $id = $this->input->get( 'estimationprocedure_id' );
    if( $id == false ) {
      $this->_returnError( 440 );
      return;
    }
    
    $ep = $this->Estimation_procedure->getById( $id );
    if( $ep == false ) {
      $this->_returnError( 441 );
      return;
    }
    $this->_xmlContents( 'estimationprocedure-get', array( 'ep' => $ep ) );
  }
  
  private function _openml_task_evaluations() {
    $task_id = $this->input->get( 'task_id' );
    $interval_start = $this->input->get( 'interval_start' );
    $interval_end   = $this->input->get( 'interval_end' );
    $interval_size   = $this->input->get( 'interval_size' );
    
    if( $task_id == false ) {
      $this->_returnError( 300 );
      return;
    }
    
    $task = false;
    $taskRecord = $this->Task->getById( $task_id );
    if( $taskRecord ) { // task actually exists
      $task = end( $this->Task->tasks_crosstabulated( $taskRecord->ttid, true, array(), false, $task_id ) );
    }
    
    if( $task === false ) {
      $this->_returnError( 301 );
      return;
    }
    
    $estimation_procedure = $this->Estimation_procedure->getById( $task->estimation_procedure );
    
    $evaluation_table = 'evaluation';
    $evaluation_table_constraints = '';
    if( $interval_start !== false || $interval_end !== false || $interval_size !== false ) {
      $evaluation_table = 'evaluation_interval';
      if( $interval_start !== false && is_numeric( $interval_start ) ) {
        $evaluation_table_constraints .= ' AND `e`.`interval_start` >= ' . $interval_start;
      }
      if( $interval_end !== false && is_numeric( $interval_end ) ) {
        $evaluation_table_constraints .= ' AND `e`.`interval_end` <= ' . $interval_end;
      }
      if( $interval_size !== false && is_numeric( $interval_size ) ) {
        $evaluation_table_constraints .= ' AND `e`.`interval_end` - `e`.`interval_start` = ' . $interval_size;
      }
    }
    
    $sql = '
      SELECT `r`.`task_id`, `r`.`rid`, `s`.`sid`, `s`.`implementation_id` AS `algorithm_implementation_id`, `i`.`fullName`, `e`.* 
      FROM `run` `r`, `algorithm_setup` `s`, `' . $evaluation_table . '` `e`, `implementation` `i`  
      WHERE `s`.`sid` = `r`.`setup` AND `r`.`task_id` = "'.$task_id.'" 
      AND `e`.`source` = `r`.`rid` AND `s`.`implementation_id` = `i`.`id` ' .
      $evaluation_table_constraints. '
      ORDER BY `rid`, `s`.`implementation_id` ASC;';
    $runs = $this->Run->query( $sql );
    
    $results = array();
    $previous = -1;
    if($runs != false ) { //TODO: sort on value ..x.. ?
      foreach( $runs as $r ) {
        $key = $r->rid;
        if(property_exists( $r, 'interval_start')) $key .= '_' . $r->interval_start;
        if(property_exists( $r, 'interval_end'  )) $key .= '_' . $r->interval_end;
        if( $key == $previous ) {
          $results[$key]['measures'][$r->{'function'}] = $r->{'value'} != null ? $r->{'value'} : $r->{'array_data'};
        } else {
          $results[$key] = array();
          $results[$key]['measures'] = array();
          $results[$key]['measures'][$r->{'function'}] = $r->{'value'} != null ? $r->{'value'} : $r->{'array_data'};
          $results[$key]['rid'] = $r->rid;
          $results[$key]['setup_id'] = $r->sid;
          $results[$key]['implementation_id'] = $r->algorithm_implementation_id;
          $results[$key]['implementation'] = $r->fullName;
          if(property_exists( $r, 'interval_start' ) ) { $results[$key]['interval_start'] = $r->interval_start; }
          if(property_exists( $r, 'interval_end' ) )   { $results[$key]['interval_end']   = $r->interval_end; }
        }
        $previous = $key;
      }
    }
    $this->_xmlContents( 'task-evaluations', array( 'task' => $task, 'estimation_procedure' => $estimation_procedure, 'results' => $results ) );
  }
  
  private function _openml_implementation_licences() {
    $data->licences = $this->Implementation->getDistinct( 'licence' );
    $this->_xmlContents( 'implementation-licences', $data );
  }
  
  private function _openml_implementation_upload() {
    
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
      $this->_returnError( 162 );
      return;
    }
    
    foreach( $_FILES as $key => $file ) {
      if( check_uploaded_file( $file ) == false ) {
        $this->_returnError( 160 );
        return;
      }
    }
    
    // get correct description
    if( $this->input->post('description') ) {
      // get description from string upload
      $description = $this->input->post('description');
      $xmlErrors = "";
      if( validateXml( $description, xsd('openml.implementation.upload'), $xmlErrors, false ) == false ) {
        $this->_returnError( 163, $this->openmlGeneralErrorCode, $xmlErrors );
        return;
      }
      $xml = simplexml_load_string( $description );
    } elseif(isset($_FILES['description'])) {
      // get description from file upload
      $description = $_FILES['description'];
      
      if( validateXml( $description['tmp_name'], xsd('openml.implementation.upload'), $xmlErrors ) == false ) {
        $this->_returnError( 163, $this->openmlGeneralErrorCode, $xmlErrors );
        return;
      }
      $xml = simplexml_load_file( $description['tmp_name'] );
      $similar = $this->Implementation->compareToXML( $xml );
      if( $similar ) {
        $this->_returnError( 171, $this->openmlGeneralErrorCode, 'implementation_id:' . $similar );
        return;
      }
    } else {
      $this->_returnError( 161 );
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
        $this->_returnError( 167 );
        return;
      }
      
      $file_id = $this->File->register_uploaded_file($_FILES[$key], $this->data_folders['implementation'] . $key . '/', $this->user_id, 'implementation');
      if($file_id === false) {
        $this->_returnError( 165 );
        return;
      }
      $file_record = $this->File->getById($file_id);
      
      //$implementation[$key.'Url'] = $this->data_controller . 'download/' . $file_id . '/' . $file_record->filename_original;
      $implementation[$key.'_md5'] = $file_record->md5_hash;
      $implementation[$key.'_file_id'] = $file_id;
      //$implementation[$key.'Format'] = $file_record->md5_hash;
      
      if( property_exists( $xml->children('oml', true), $key.'_md5' ) ) {
        if( $xml->children('oml', true)->{$key.'_md5'} != $file_record->md5_hash ) {
          $this->_returnError( 168 );
          return;
        }
      }
    }
    
    $impl = insertImplementationFromXML( $xml->children('oml', true), $this->xml_fields_implementation, $implementation );
    if( $impl == false ) {
      $this->_returnError( 165 );
      return;
    }
    $implementation = $this->Implementation->getById( $impl );
    
    $this->_xmlContents( 'implementation-upload', $implementation );
  }


  
  private function _openml_implementation_tag() {
    $id = $this->input->get( 'implementation_id' );
    $tag = $this->input->get( 'tag' );
    
    $error = -1;
    $result = tag_item( 'implementation', $id, $tag, $this->user_id, $error );
    
    if( $result == false ) {
      $this->_returnError( $error );
    } else {
      $this->_xmlContents( 'entity-tag', array( 'id' => $id, 'type' => 'implementation' ) ); 
    }
  }
  
  private function _openml_implementation_untag() {
    $id = $this->input->get( 'implementation_id' );
    $tag = $this->input->get( 'tag' );
    
    $error = -1;
    $result = untag_item( 'implementation', $id, $tag, $this->user_id, $error );
    
    if( $result == false ) {
      $this->_returnError( $error );
    } else {
      $this->_xmlContents( 'entity-untag', array( 'id' => $id, 'type' => 'implementation' ) ); 
    }
  }
  
  private function _openml_implementation_exists() {
    $name = $this->input->get( 'name' );
    $external_version = $this->input->get( 'external_version' );
    
    $similar = false;
    if( $name !== false && $external_version !== false ) {
      $similar = $this->Implementation->getWhere( '`name` = "' . $name . '" AND `external_version` = "' . $external_version . '"' );
    } else {
      $this->_returnError( 330 );
      return;
    }
    
    $result = array( 'exists' => 'false', 'id' => -1 );
    if( $similar ) {
      $result = array( 'exists' => 'true', 'id' => $similar[0]->id );
    }
    $this->_xmlContents( 'implementation-exists', $result );
  }

  private function _openml_implementation_delete() {
    
    $implementation = $this->Implementation->getById( $this->input->post( 'implementation_id' ) );
    if( $implementation == false ) {
      $this->_returnError( 322 );
      return;
    }
    
    if($implementation->uploader != $this->user_id ) {
      $this->_returnError( 323 );
      return;
    }
    
    $runs = $this->Implementation->query('SELECT rid FROM `algorithm_setup`, `run` WHERE `algorithm_setup`.`sid` = `run`.`setup` AND `algorithm_setup`.`implementation_id` = "'.$implementation->id.'" LIMIT 0,1;');
    $evaluations = $this->Evaluation->getWhereSingle('implementation_id = "' . $implementation->id . '"');
    
    if($runs || $evaluations || $this->Implementation->isComponent($implementation->id) ) {
      $this->_returnError( 324 );
      return;
    }
    
    $result = $this->Implementation->delete( $implementation->id );
    if( $implementation->binary_file_id != false ) { $this->File->delete_file($implementation->binary_file_id); }
    if( $implementation->source_file_id != false ) { $this->File->delete_file($implementation->source_file_id); }
    $this->Input->deleteWhere('implementation_id =' . $implementation->id);
    $this->Implementation_component->deleteWhere('parent =' . $implementation->id);
    $this->Bibliographical_reference->deleteWhere('implementation_id =' . $implementation->id);
    // TODO: also check component parts. 

    if( $result == false ) {
      $this->_returnError( 325 );
      return;
    }
    $this->_xmlContents( 'implementation-delete', array( 'implementation' => $implementation ) );
  }
  
  private function _openml_implementation_get() {
    $id = $this->input->get( 'implementation_id' );
    if( $id == false ) {
      $this->_returnError( 180 );
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
      $this->_returnError( 181 );
      return;
    }
    
    $this->_xmlContents( 'implementation-get', array( 'source' => $implementation ) );
  }

  private function _openml_implementation_owned() {
    
    $implementations = $this->Implementation->getColumnWhere( 'id', '`uploader` = "'.$this->user_id.'"' );
    if( $implementations == false ) {
      $this->_returnError( 312 );
      return;
    }
    $this->_xmlContents( 'implementation-owned', array( 'implementations' => $implementations ) );
  }
  
  private function _openml_evaluation_measures() {
    $data->measures = $this->Math_function->getWhere( 'functionType = "EvaluationFunction"' );
    $this->_xmlContents( 'evaluation-measures', $data );
  }
  
  private function _openml_evaluation_methods() {
    $this->_returnError( 101 );
  }
  
  private function _openml_run_upload() {
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Everything that needs to be done for EVERY task,        *
     * Including the unsupported tasks                         *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    // check uploaded file
    $description = isset( $_FILES['description'] ) ? $_FILES['description'] : false;
    if( ! check_uploaded_file( $description ) ) {
      $this->_returnError( 202 );
      return;
    }
    // validate xml
    if( validateXml( $description['tmp_name'], xsd('openml.run.upload'), $xmlErrors ) == false ) {
      $this->_returnError( 203, $this->openmlGeneralErrorCode, $xmlErrors );
      return;
    }
    
    // fetch xml
    $xml = simplexml_load_file( $description['tmp_name'] );
    if( $xml === false ) {
      $this->_returnError( 219 );
      return;
    }
    
    $run_xml = all_tags_from_xml( 
      $xml->children('oml', true), 
      $this->xml_fields_run );

    $task_id = $run_xml['task_id'];
    $implementation_id = $run_xml['implementation_id'];
    $setup_string = array_key_exists( 'setup_string', $run_xml ) ? $run_xml['setup_string'] : null;
    $error_message = array_key_exists( 'error_message', $run_xml ) ? $run_xml['error_message'] : false;
    $parameter_objects = array_key_exists( 'parameter_setting', $run_xml ) ? $run_xml['parameter_setting'] : array();
    $output_data = array_key_exists( 'output_data', $run_xml ) ? $run_xml['output_data'] : array();
    $tags = array_key_exists( 'tag', $run_xml ) ? str_getcsv ( $run_xml['tag'] ) : array();
    
    // the user can specify his own metrics. here we check whether these exists in the database. 
    if( $output_data != false && array_key_exists('evaluation', $output_data ) ) {
      foreach( $output_data->children('oml',true)->{'evaluation'} as $eval ) {
        $measure_id = $this->Implementation->getWhere('`fullName` = "'.$eval->implementation.'" AND `implements` = "'.$eval->name.'"');
        if( $measure_id == false ) {
          $this->_returnError( 217 );
          return;
        }
      }
    }
    $predictionsUrl   = false;
    
    // fetch implementation
    $implementation = $this->Implementation->getById( $implementation_id );
    if( $implementation === false ) {
      $this->_returnError( 205 );
      return;
    }
    if( in_array( $implementation->{'implements'}, $this->supportedMetrics ) ) {
      $this->_returnError( 218 );
      return;
    }
    
    // check whether uploaded files are present.
    if($error_message == false) {
      if( count( $_FILES ) < 2 ) { 
        $this->_returnError( 206 );
        return;
      }
      
      $message = '';
      if( ! check_uploaded_file( $_FILES['predictions'], false, $message ) ) {
        $this->_returnError( 207, $this->openmlGeneralErrorCode, 'File predictions: ' . $message );
        return;
      }
    }
    
    $parameters = array();
    foreach( $parameter_objects as $p ) {
      // since 'component' is an optional XML field, we add a default option
      $component = property_exists($p, 'component') ? $p->component : $implementation->id;
      
      // now find the input id
      $input_id = $this->Input->getWhereSingle( '`implementation_id` = ' . $component . ' AND `name` = "' . $p->name . '"' );
      if( $input_id === false ) {
        $this->_returnError( 213 );
        return;
      }
      
      $parameters[$input_id->id] = $p->value . '';
    }
    // search setup ... // TODO: do something about the new parameters. Are still retrieved by ID, does not work with Weka plugin. 
    $setupId = $this->Algorithm_setup->getSetupId( $implementation, $parameters, true, $setup_string );
    if( $setupId === false ) {
      $this->_returnError( 214 );
      return;
    }
    
    // fetch task
    $taskRecord = $this->Task->getById( $task_id );
    if( $taskRecord === false ) { 
      $this->_returnError( 204 );
      return;
    }
    $task = end( $this->Task->tasks_crosstabulated( $taskRecord->ttid, true, array(), false, $task_id ) );
    
    // now create a run
    $runId = $this->Run->getHighestIndex( array('run'), 'rid' );
    
    $runData = array(
      'rid' => $runId,
      'uploader' => $this->user_id,
      'setup' => $setupId,
      'task_id' => $task->task_id,
      'start_time' => now(),
      'status' => ($error_message == false) ? 'OK' : 'error',
      'error' => ($error_message == false) ? null : $error_message,
      'experiment' => '-1',
    );
    if( $this->Run->insert( $runData ) === false ) {
      $this->_returnError( 210 );
      return;
    }
    // and fetch the run record
    $run = $this->Run->getById( $runId );
    $result = new stdClass();
    $result->run_id = $runId; // for output
    
    // attach uploaded files as output to run
    foreach( $_FILES as $key => $value ) {
      $file_type = ($value == 'predictions') ? 'predictions' : 'run_uploaded_file';
      $file_id = $this->File->register_uploaded_file($value, $this->data_folders['run'], $this->user_id, $file_type);
      if(!$file_id) {
        $this->_returnError( 212 );
        return;
      }
      $file_record = $this->File->getById($file_id);
      $filename = getAvailableName( DATA_PATH . $this->data_folders['run'], $value['name'] );
      
      $did = $this->Runfile->getHighestIndex( $this->data_tables, 'did' );
      $record = array(
        'did' => $did,
        'source' => $run->rid,
        'field' => $key,
        'name' => $value['name'],
        'format' => $file_record->extension,
        'file_id' => $file_id );
      
      $this->Runfile->insert( $record ); 
      
      $this->Run->outputData( $run->rid, $did, 'runfile', $key );
    }
    
    // attach input data
    $inputData = $this->Run->inputData( $runId, $task->source_data, 'dataset' ); // Based on the query, it has been garantueed that the dataset id exists.
    if( $inputData === false ) {
      $errorCode = 211;
      return false;
    }
    
    // tag it, if neccessary
    foreach( $tags as $tag ) {
      $error = -1;
      tag_item( 'run', $runId, $tag, $this->user_id, $error );
    }
    
    // add to elastic search index. 
    $this->elasticsearch->index('run', $run->rid); 
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Now the stuff that needs to be done for the special     *
     * supported tasks, like classification, regression        *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    // and present result, in effect only a run_id. 
    $this->_xmlContents( 'run-upload', $result );
  }
  
  private function _openml_run_tag() {
    $id = $this->input->get( 'run_id' );
    $tag = $this->input->get( 'tag' );
    
    $error = -1;
    $result = tag_item( 'run', $id, $tag, $this->user_id, $error );
    
    if( $result == false ) {
      $this->_returnError( $error );
    } else {
      $this->_xmlContents( 'entity-tag', array( 'id' => $id, 'type' => 'run' ) ); 
    }
  }
  
  private function _openml_run_untag() {
    $id = $this->input->get( 'run_id' );
    $tag = $this->input->get( 'tag' );
    
    $error = -1;
    $result = untag_item( 'run', $id, $tag, $this->user_id, $error );
    
    if( $result == false ) {
      $this->_returnError( $error );
    } else {
      $this->_xmlContents( 'entity-untag', array( 'id' => $id, 'type' => 'run' ) ); 
    }
  }
  
  private function _openml_run_evaluate() {
    
    // check uploaded file
    $description = isset( $_FILES['description'] ) ? $_FILES['description'] : false;
    if( ! check_uploaded_file( $description ) ) {
      $this->_returnError( 422 );
      return;
    }
    
    // validate xml
    if( validateXml( $description['tmp_name'], xsd('openml.run.evaluate'), $xmlErrors ) == false ) {
      $this->_returnError( 423, $this->openmlGeneralErrorCode, $xmlErrors );
      return;
    }
    
    // fetch xml
    $xml = simplexml_load_file( $description['tmp_name'] );
    if( $xml === false ) {
      $this->_returnError( 424 );
      return;
    }
    
    $run_id = (string) $xml->children('oml', true)->{'run_id'};
    
    
    $runRecord = $this->Run->getById( $run_id );
    if( $runRecord == false ) {
      $this->_returnError( 425 );
      return;
    }
    
    if( $runRecord->processed != null ) {
      $this->_returnError( 426 );
      return;
    }
    
    $data = array( 'processed' => now() );
    if( isset( $xml->children('oml', true)->{'error'}) ) {
      $data['error'] = '' . $xml->children('oml', true)->{'error'};
    }
    
    $this->Run->update( $run_id, $data );
    
    $implementation_ids = $this->Implementation->getAssociativeArray( 'fullName', 'id', '`name` = `name`' );
    
    $this->db->trans_start();
    foreach(  $xml->children('oml', true)->{'evaluation'} as $e ) {
      $evaluation = xml2assoc($e, true);
      
      // naming convention
      $evaluation['function'] = $evaluation['name']; 
      unset($evaluation['name']); 
      
      // more naming convention
      if( array_key_exists( $evaluation['implementation'], $implementation_ids ) ) {
        $evaluation['implementation_id'] = $implementation_ids[$evaluation['implementation']];
        unset($evaluation['implementation']);
      } else {
        $this->Log->mapping( __FILE__, __LINE__, 'Implementation ' . $evaluation['implementation'] . ' not found in database. ' );
        continue;
      }
      
      // adding rid
      $evaluation['source'] = $run_id;
      
      if( array_key_exists( 'fold', $evaluation ) && array_key_exists( 'repeat', $evaluation ) &&  array_key_exists( 'sample', $evaluation ) ) {
        // evaluation_sample 
        $this->Evaluation_sample->insert( $evaluation );
      } elseif( array_key_exists( 'fold', $evaluation ) && array_key_exists( 'repeat', $evaluation ) ) {
        // evaluation_fold
        $this->Evaluation_fold->insert( $evaluation );
      } elseif( array_key_exists( 'interval_start', $evaluation ) && array_key_exists( 'interval_end', $evaluation ) ) {
        // evaluation_interval
        $this->Evaluation_interval->insert( $evaluation );
      } else {
        // global
        $this->Evaluation->insert( $evaluation );
      }
    }
    $this->db->trans_complete();
    
    // update elastic search index. 
    $this->elasticsearch->index('run', $run_id ); 
    
    $this->_xmlContents( 'run-evaluate', array( 'run_id' => $run_id ) );
  }
  
  private function _openml_run_delete() {
    
    $run = $this->Run->getById( $this->input->post( 'run_id' ) );
    if( $run == false ) {
      $this->_returnError( 392 );
      return;
    }
    
    if($run->uploader != $this->user_id ) {
      $this->_returnError( 393 );
      return;
    }
    
    $result = true;
    $result = $result && $this->Input_data->deleteWhere( 'run =' . $run->rid );
    $result = $result && $this->Output_data->deleteWhere( 'run =' . $run->rid );
    
    if( $result ) {
      $additional_sql = ' AND `did` NOT IN (SELECT `data` FROM `input_data` UNION SELECT `data` FROM `output_data`)';
      $result = $result && $this->Runfile->deleteWhere('`source` = "' . $run->rid . '" ' . $additional_sql);
      $result = $result && $this->Evaluation->deleteWhere('`source` = "' .  $run->rid. '" ' . $additional_sql);
      $result = $result && $this->Evaluation_fold->deleteWhere('`source` = "' . $run->rid . '" ' . $additional_sql);
      $result = $result && $this->Evaluation_sample->deleteWhere('`source` = "' . $run->rid . '" ' . $additional_sql);
      // Not needed
      //$this->Dataset->deleteWhere('`source` = "' . $run->rid . '" ' . $additional_sql);
    }
    
    if( $result ) {
      $result = $result && $this->Run->delete( $run->rid );
    }
    
    if( $result == false ) {
      $this->_returnError( 394 );
      return;
    }
    $this->_xmlContents( 'run-delete', array( 'run' => $run ) );
  }
  
  private function _openml_run_reset() {

    $run = $this->Run->getById( $this->input->post( 'run_id' ) );
    if( $run == false ) {
      $this->_returnError( 412 );
      return;
    }
    
    if($run->uploader != $this->user_id && $this->ion_auth->is_admin($this->user_id) == false ) {
      $this->_returnError( 413 );
      return;
    }
    
    $result = true;
    
    $evalPlain    = $this->Evaluation->getColumnWhere('did', '`source` = "' .  $run->rid. '" ');
    $evalFold     = $this->Evaluation_fold->getColumnWhere('did', '`source` = "' .  $run->rid. '" ');
    $evalSample   = $this->Evaluation_sample->getColumnWhere('did', '`source` = "' .  $run->rid. '" ');
    $evalInterval = $this->Evaluation_interval->getColumnWhere('did', '`source` = "' .  $run->rid. '" ');
    if( is_array($evalPlain) == false ) $evalPlain = array();
    if( is_array($evalFold) == false ) $evalFold = array();
    if( is_array($evalSample) == false ) $evalSample = array();
    if( is_array($evalInterval) == false ) $evalInterval = array();
    
    $evaluation_ids = array_unique ( array_merge( $evalPlain, $evalFold, $evalSample ) );
    
    if( is_array($evaluation_ids) && count($evaluation_ids) )
      $result = $result && $this->Output_data->deleteWhere( '`run` = "' . $run->rid  . '" AND `data` IN (' . implode( ',', $evaluation_ids ) . ')' );
    
    $result = $result && $this->Evaluation->deleteWhere('`source` = "' .  $run->rid. '" ');
    $result = $result && $this->Evaluation_fold->deleteWhere('`source` = "' . $run->rid . '" ');
    $result = $result && $this->Evaluation_sample->deleteWhere('`source` = "' . $run->rid . '" ');
    $result = $result && $this->Evaluation_interval->deleteWhere('`source` = "' . $run->rid . '" ');
    
    $update = array( 'error' => null, 'processed' => null );
    $this->Run->update( $run->rid, $update );
    
    if( $result == false ) {
      $this->_returnError( 394 );
      return;
    }
    $this->_xmlContents( 'run-reset', array( 'run' => $run ) );
  }
  
  private function _openml_job_get() {
    $workbench = $this->input->get('workbench');
    $task_type_id = $this->input->get('task_type_id');
    
    if( $workbench == false || $task_type_id == false ) {
      $this->_returnError( 340 );
      return;
    }
    
    $job = $this->Schedule->getJob( $workbench, $task_type_id );
    
    if( $job == false ) {
      $this->_returnError( 341 );
      return;
    }
    
    $this->_xmlContents( 'run-getjob', array( 'source' => $job ) );
  }
  
  private function _openml_run_get() {
    $run_id = $this->input->get('run_id');
    if( $run_id == false ) {
      $this->_returnError( 220 );
      return;
    }
    $run = $this->Run->getById( $run_id );
    if( $run === false ) {
      $this->_returnError( 221 );
      return;
    }
    
    $run->inputData = $this->Run->getInputData( $run->rid ); 
    $run->outputData = $this->Run->getOutputData( $run->rid ); 
    $run->setup = $this->Algorithm_setup->getById( $run->setup );
    $run->tags = $this->Run_tag->getColumnWhere( 'tag', 'id = ' . $run->rid );
    $run->inputSetting = $this->Input_setting->query('SELECT i.name, s.value from input i, input_setting s where i.id=s.input_id and setup = ' . $run->setup->sid );
    
    $this->_xmlContents( 'run-get', array( 'source' => $run ) );
  }
  
  private function _openml_setup_parameters() {
    $setup_id = $this->input->get('setup_id');
    if( $setup_id == false ) {
      $this->_returnError( 280 );
      return;
    }
    $setup = $this->Algorithm_setup->getById( $setup_id );
    if( $setup === false ) {
      $setup = $this->Workflow_setup->getById( $setup_id );
      if( $setup === false ) {
        $this->_returnError( 281 );
        return;
      }
    }
    // TODO: temp linking on concat of fields. should be done better
    $this->parameters = $this->Input_setting->query('SELECT * FROM `input_setting` LEFT JOIN `input` ON CONCAT( `input`.`implementation_id` , "_", `input`.`name` ) = `input_setting`.`input` WHERE setup = "'.$setup->sid.'"');
    
    $this->_xmlContents( 'setup-parameters', array( 'parameters' => $this->parameters ) );
  }
  
  private function _openml_setup_delete() {
    
    $setup = $this->Algorithm_setup->getById( $this->input->post( 'setup_id' ) );
    if( $setup == false ) {
      $this->_returnError( 402 );
      return;
    }
    
    $runs = $this->Run->getWhere( 'setup = "' . $setup->sid . '"' );
    $schedules = $this->Schedule->getWhere( 'sid = "' . $setup->sid . '"' );
    
    if( $runs || $schedules ) {
      $this->_returnError( 404 );
      return;
    }
    
    
    $result = true;
    $result = $result && $this->Input_setting->deleteWhere('setup = ' . $setup->sid );
    
    if( $result ) {
      $result = $this->Algorithm_setup->delete( $setup->sid );
    }
    
    if( $result == false ) {
      $this->_returnError( 405 );
      return;
    }
    
    $this->_xmlContents( 'setup-delete', array( 'setup' => $setup ) );
  }
  
  private function _openml_user_delete() {
    
    if( $this->ion_auth->is_admin($this->user_id) == false ) {
      $this->_returnError( 462 );
      return;
    }
    
    $user = $this->Author->getById( $this->input->post( 'user_id' ) );
    if( $user == false ) {
      $this->_returnError( 463 );
      return;
    } 

    $datasets = $this->Dataset->getWhereSingle( 'uploader = ' . $user->id );
    
    if( $datasets ) {
      $this->_returnError( 464 );
      return;
    }

    $flows = $this->Implementation->getWhereSingle( 'uploader = ' . $user->id );
    if( $flows ) {
      $this->_returnError( 464 );
      return;
    }
    $runs = $this->Run->getWhereSingle( 'uploader = ' . $user->id );
    if( $runs ) {
      $this->_returnError( 464 );
      return;
    }
    
    $result = $this->ion_auth->delete_user( $user->id );
    if( !$result ) {
      $this->_returnError( 465 );
      return;
    }
    
    $this->_xmlContents( 'user-delete', array( 'user' => $user ) );
  }
  
  /********************************* ALIAS FUNCTIONS *********************************/
  
  private function _openml_run_getjob() {
    $this->_openml_job_get();
  }
  
  private function _openml_data_description() {
    $this->_openml_data_get();
  }
  
  private function _openml_task_search() {
    $this->_openml_task_get();
  }
  
  /************************************* DISPLAY *************************************/
  
  private function _show_webpage() {
    $this->page = 'api_docs';
    if(!loadpage($this->page,true,'pre'))
      $this->page_body = '<div class="baseNormalContent">Pagina niet gevonden. 
                <a href="'.home().'">Klik hier</a> om terug te keren naar de hoofdpagina.</div>';
    $this->load->view('frontend_main');
  }
  
  private function _returnError( $code, $httpErrorCode = 450, $additionalInfo = null ) {
    $this->Log->api_error( 'error', $_SERVER['REMOTE_ADDR'], $code, $this->requested_function, $this->load->apiErrors[$code][0] . (($additionalInfo == null)?'':$additionalInfo) );
    $error['code'] = $code;
    $error['message'] = htmlentities( $this->load->apiErrors[$code][0] );
    $error['additional'] = htmlentities( $additionalInfo );
    
    $httpHeaders = array( 'HTTP/1.0 ' . $httpErrorCode );
    $this->_xmlContents( 'error-message', $error, $httpHeaders );
  }
  
  private function _xmlContents( $xmlFile, $source, $httpHeaders = array() ) {
    $view = 'pages/'.$this->controller.'/'.$this->page.'/'.$xmlFile.'.tpl.php';
    $data = $this->load->view( $view, $source, true );
    header('Content-length: ' . strlen($data) );
    header('Content-type: text/xml; charset=utf-8');
    foreach( $httpHeaders as $header ) {
      header( $header );
    }
    echo $data;
  }
}
?>
