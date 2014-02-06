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
		$this->load->model('Data_features');
		$this->load->model('Data_quality');
		$this->load->model('File');
		$this->load->model('Algorithm_setup');
		$this->load->model('Implementation');
		$this->load->model('Implementation_component');
		$this->load->model('Run');
		$this->load->model('Evaluation');
		$this->load->model('Evaluation_fold');
		$this->load->model('Evaluation_sample');
		$this->load->model('Input');
		$this->load->model('Bibliographical_reference');
		$this->load->model('Input_setting');

		// only for reading
		$this->load->model('Algorithm');
		$this->load->model('Feature');
		$this->load->model('Math_function');
		$this->load->model('Task');
		$this->load->model('Task_type');
		$this->load->model('Task_values');
		$this->load->model('Task_type_io');
		$this->load->model('Workflow_setup');
		
		// community db
		$this->load->model('Api_session');
		$this->load->model('Log');
		
		// helper
		$this->load->helper('api');
		
		// paths
		$this->data_folders = array(
			'dataset' 			=> 'dataset/api/',
			'implementation' 	=> 'implementation/',
			'run'				=> 'run/'
		);
		
    $this->data_tables = array( 'dataset','evaluation','evaluation_fold', 'evaluation_sample');
    
    // XML maintainance
    $this->xml_fields_dataset = array(
      'string' => array('description','format','collection_date','language','licence','default_target_attribute','row_id_attribute','md5_checksum'),
      'csv' => array('creator','contributor',)
    );
    $this->xml_fields_implementation = array(
      'string' => array('name','external_version','description','licence','language','fullDescription','installationNotes','dependencies',),
      'csv' => array('creator','contributor',),
      'array' => array('bibliographical_reference','parameter','component'),
      'plain' => array()
    );

		$this->data_controller = BASE_URL . 'files/';
		
		$this->supportedMetrics = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
    $this->supportedAlgorithms = $this->Algorithm->getColumn('name');
    
		// some user authentication things. 
		$this->provided_hash = $this->input->post('session_hash') != false;
		$this->provided_valid_hash = $this->Api_session->isValidHash( $this->input->post('session_hash') );
		$this->authenticated = $this->provided_valid_hash || $this->ion_auth->logged_in();
		$this->user_id = false;
		if($this->provided_valid_hash) {
			$this->user_id = $this->Api_session->getByHash( $this->input->post('session_hash') )->author_id;
		} elseif($this->ion_auth->logged_in()) {
			$this->user_id = $this->ion_auth->user()->row()->id;
		}
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
				$this->$api_function();
			} else {
				$this->_returnError( 100 );
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
		
		$hash = $this->Api_session->create( $username, $password );
		
		if( $hash === false ) {
			$this->_returnError( 252 );
			return;
		}
		
		$record = $this->Api_session->getByHash( $hash );
		
		$source = new stdClass();
		$source->hash = $hash;
		$source->until = $this->Api_session->validUntil( $record->creation_date );
		
		$this->_xmlContents( 'authenticate', $source );
	}
	
	private function _openml_authenticate_check() {
		$username 		= $this->input->post( 'username' );
		$session_hash	= $this->input->post( 'session_hash' );
		
		if( $username == false ) {
			$this->_returnError( 290 );
			return;
		}
		if( $session_hash == false ) {
			$this->_returnError( 291 );
			return;
		}
		$author_db	= $this->Author->getWhere('`username` = "'.$username.'"');
		$hash_db 	= $this->Api_session->getByHash( $session_hash );
		
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
	
	private function _openml_data_description() {
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
		$dataset->creator = getcsv( $dataset->creator );
		$dataset->contributor = getcsv( $dataset->contributor );
		
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
		
		$this->_xmlContents( 'data-set-features', $dataset );
	}
	
	private function _openml_data_licences() {
		$data->licences = $this->Dataset->getDistinct( 'licence' );
		$this->_xmlContents( 'data-licences', $data );
	}
	
	private function _openml_data_upload() {
		// authentication check. Real check is done in the constructor.
		if(!$this->authenticated) {
			if(!$this->provided_hash) {
				$this->_returnError( 137 );
				return;
			} else { // not provided valid hash
				$this->_returnError( 138 );
				return;
			}
		}
		
		// get correct description
		if( $this->input->post('description') ) {
			// get description from string upload
			$description = $this->input->post('description');
			if( validateXml( $description, xsd('openml.data.upload'), $xmlErrors, false ) == false ) {
				$this->_returnError( 131, $xmlErrors );
				return;
			}
			$xml = simplexml_load_string( $description );
		} elseif(isset($_FILES['description']) && check_uploaded_file( $_FILES['description'] ) == true) {
			// get description from file upload
			$description = $_FILES['description'];
			
			if( validateXml( $description['tmp_name'], xsd('openml.data.upload'), $xmlErrors ) == false ) {
				$this->_returnError( 131, $xmlErrors );
				return;
			}
			$xml = simplexml_load_file( $description['tmp_name'] );
		} else {
			$this->_returnError( 135 );
			return;
		}
		
		$name = '' . $xml->children('oml', true)->{'name'};
		
		$version = $this->Dataset->incrementVersionNumber( $name );
		
		$datasetUrlProvided = property_exists( $xml->children('oml', true), 'url' );
		$datasetFileProvided = isset( $_FILES['dataset'] );
		if( $datasetUrlProvided && $datasetFileProvided ) {
			$this->_returnError( 140 );
			return;
		} elseif( $datasetFileProvided ) {
      		$message = '';
			if( ! check_uploaded_file( $_FILES['dataset'], false, $message ) ) {
			  $this->_returnError( 130, 'File dataset: ' . $message );
			  return;
			}
			$file_id = $this->File->register_uploaded_file($_FILES['dataset'], $this->data_folders['dataset'], $this->user_id, 'dataset');
			if($file_id === false) {
				$this->_returnError( 132 );
				return;
			}
			$file_record = $this->File->getById($file_id);
			$destinationUrl = $this->data_controller . 'download/' . $file_id . '/' . $file_record->filename_original;
			
		} elseif( $datasetUrlProvided ) {
			$destinationUrl = '' . $xml->children('oml', true)->url;
		} else {
			$this->_returnError( 141 );
			return;
		}
		
		$dataset = array(
			'name' => $name,
			'version' => $version,
			'url' => $destinationUrl,
			'upload_date' => now(),
			'uploader' => $this->user_id,
			'isOriginal' => 'true',
		);
		
		if( isset( $md5_checksum ) ) $dataset['md5_checksum'] = $md5_checksum;
		
		$dataset = all_tags_from_xml( 
      $xml->children('oml', true), 
      $this->xml_fields_dataset, $dataset );
		
		$features = false;
		if(strtolower($dataset['format']) == 'arff') {
			// check whether the format is correct. For now we only check on ARFF
			// obtain data features.
      $class = array_key_exists( 'default_target_attribute', $dataset ) ? $dataset['default_target_attribute'] : false;
			$features = get_arff_features( $destinationUrl, $class );
      
			if(property_exists( $features, 'error' ) || $features == false) {
				$this->_returnError( 142 );
				return;
			}
		}

		/* * * * 
		 * THE ACTUAL INSERTION
		 * * * */
		$id = $this->Dataset->insert( $dataset );
		if( ! $id ) {
			$this->_returnError( 134 );
			return;
		} else {
			// fill table features. 
			insert_arff_features ( $id, $features->data_features );
			insert_arff_qualities( $id, $features->data_qualities );
		}

		$this->_xmlContents( 'data-set-upload', array( 'id' => $id ) );
	}
	
	private function _openml_tasks_types() {
		$data = new stdClass();
		$data->task_types = $this->Task_type->get();
		$this->_xmlContents( 'task-types', $data );
	}
	
	private function _openml_tasks_types_search() {
		$task_type_id = $this->input->get( 'task_type_id' );
		if( $task_type_id == false ) {
			$this->_returnError( 240 );
			return;
		}
		
		$taskType = $this->Task_type->getById( $_GET['task_type_id'] );
		$taskTypeIos = $this->Task_type_io->getByTaskType( $_GET['task_type_id'], 'io ASC, name ASC' );
		
		if( $taskType === false ) {
			$this->_returnError( 241 );
			return;
		}
		
		$this->_xmlContents( 'task-types-search', array( 'task_type' => $taskType, 'io' => $taskTypeIos ) );
	}
	
	private function _openml_tasks_search() {
		$task_id = $this->input->get( 'task_id' );
		if( $task_id == false ) {
			$this->_returnError( 150 );
			return;
		}
		
		$task = $this->Task->getById( $task_id );
		$task_type = $this->Task_type->getById( $task->ttid );

		if( $task === false || $task_type === false ) {
			$this->_returnError( 151 );
			return;
		}
		$task_values = $this->Task_values->getTaskValuesAssoc( $task_id );
		$parsed_io = $this->Task_type_io->getParsed( $task->ttid, $task_values );
		$this->_xmlContents( 'task', array( 'task' => $task, 'task_type' => $task_type, 'parsed_io' => $parsed_io ) );
	}

	private function _openml_task_evaluations() {
		$task_id = $this->input->get( 'task_id' );
		if( $task_id == false ) {
			$this->_returnError( 300 );
			return;
		}
		$task = $this->Task->getByIdWithValues( $task_id );
		
		if( $task === false ) {
			$this->_returnError( 301 );
			return;
		}
		$estimation_procedure = $this->Estimation_procedure->get_by_parameters( $task->ttid, $task->type, $task->repeats, $task->folds, $task->percentage, $task->stratified_sampling );
		
		$results = array();
		$implementations = array();
    $implementation_ids = array();

		$runs = $this->Run->query('SELECT r.task_id, r.rid, s.implementation_id, i.fullName, e.function, e.value FROM run r, output_data od, algorithm_setup s, evaluation e, implementation i  WHERE s.sid = r.setup AND r.task_id = '.$task_id.' AND od.run = r.rid AND e.did = od.data AND s.implementation_id = i.id ORDER BY rid, s.implementation_id ASC');
		$previous = -1;
		if($runs != false ) { //TODO: sort on value ..x.. ?
			foreach( $runs as $r ) {
				if( $r->rid == $previous ) {
					$results[$r->rid][$r->{'function'}] = $r->value; 
				} else {
					$results[$r->rid] = array();
					$results[$r->rid][$r->{'function'}] = $r->value; 
					$implementations[$r->rid] = $r->implementation_id;
					$implementation_ids[$r->rid] = $r->fullName;
				}
				$previous = $r->rid;
			}
		}
		$this->_xmlContents( 'task-evaluations', array( 'task' => $task, 'estimation_procedure' => $estimation_procedure, 'results' => $results, 'implementations' => $implementations, 'implementation_ids' => $implementation_ids ) );
	}
	
	private function _openml_tasks_search_supervised_classification() {
		$datasets = $this->input->get( 'datasets' );
		$classes = $this->input->get( 'class' );
	}
	
	private function _openml_implementation_licences() {
		$data->licences = $this->Implementation->getDistinct( 'licence' );
		$this->_xmlContents( 'implementation-licences', $data );
	}
	
	private function _openml_implementation_upload() {
		// authentication check. Real check is done in the constructor.
		if(!$this->authenticated) {
			if(!$this->provided_hash) {
				$this->_returnError( 169 );
				return;
			} else { // not provided valid hash
				$this->_returnError( 170 );
				return;
			}
		}
		
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
				$this->_returnError( 163, $xmlErrors );
				return;
			}
			$xml = simplexml_load_string( $description );
		} elseif(isset($_FILES['description'])) {
			// get description from file upload
			$description = $_FILES['description'];
			
			if( validateXml( $description['tmp_name'], xsd('openml.implementation.upload'), $xmlErrors ) == false ) {
				$this->_returnError( 163, $xmlErrors );
				return;
			}
			$xml = simplexml_load_file( $description['tmp_name'] );
      $similar = $this->Implementation->compareToXML( $xml );
      if( $similar ) {
        $this->_returnError( 171, 'implementation_id:' . $similar );
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
    if(!$this->authenticated) {
			if(!$this->provided_hash) {
				$this->_returnError( 320 );
				return;
			} else { // not provided valid hash
				$this->_returnError( 321 );
				return;
			}
		}
    
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
    if(!$this->authenticated) {
			if(!$this->provided_hash) {
				$this->_returnError( 310 );
				return;
			} else { // not provided valid hash
				$this->_returnError( 311 );
				return;
			}
		}
    
    $implementations = $this->Implementation->getColumnWhere( 'id', '`uploader` = "'.$this->user_id.'"' );
    if( $implementations == false ) {
      $this->_returnError( 312 );
		  return;
    }
    $this->_xmlContents( 'implementation-owned', array( 'implementations' => $implementations ) );
  }
	
	private function _openml_evaluation_measures() {
		$data->measures = $this->Math_function->getWhere( 'taskType = "EvaluationFunction"' );
		$this->_xmlContents( 'evaluation-measures', $data );
	}
	
	private function _openml_evaluation_methods() {
		$this->_returnError( 101 );
	}
	
	private function _openml_run_upload() {
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * authentication check. Real check is done in the         *
     * constructor.                                            *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
		if(!$this->authenticated) {
			if(!$this->provided_hash) {
				$this->_returnError( 200 );
				return;
			} else { // not provided valid hash
				$this->_returnError( 201 );
				return;
			}
		}
		
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
			$this->_returnError( 203, $xmlErrors );
			return;
		}
		
		// fetch xml
		$xml = simplexml_load_file( $description['tmp_name'] );
		
		$task_id 	 		= (string) $xml->children('oml', true)->{'task_id'}->{0};
		$implementation_id  = (string) $xml->children('oml', true)->{'implementation_id'}->{0};
		$parameter_objects	= $xml->children('oml', true)->{'parameter_setting'};
    $output_data = array();
    if( $xml->children('oml', true)->{'output_data'} != false ) {
      foreach( $xml->children('oml', true)->{'output_data'}->children('oml', true) as $out ) {
        $output_data[] = $out;
        $measure_id = $this->Implementation->getWhere('`fullName` = "'.$out->implementation.'" AND `implements` = "'.$out->name.'"');
        if( $measure_id == false ) {
          $this->_returnError( 217 );
			    return;
        }
      }
    }
		$error_message 		= false;
		$predictionsUrl 	= false;
    
		if( property_exists( $xml->children('oml', true), 'error_message' ) ) {
			$error_message	= (string) $xml->children('oml', true)->{'error_message'}->{0};
		}
		
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
		if($error_message === false) {
			if( count( $_FILES ) != 2 ) { // TODO: task type specific to task type 1, 2 and 3
				$this->_returnError( 206 );
				return;
			}
			
      $message = '';
			if( ! check_uploaded_file( $_FILES['predictions'], false, $message ) ) {
				$this->_returnError( 207, 'File predictions: ' . $message );
				return;
			}
		}
		
		$parameters = array();
		foreach( $parameter_objects as $p ) {
			$component = property_exists($p, 'component') ? $p->component : $implementation->fullName;
			$parameters[$component . '_' . $p->name] = $p->value . '';
			
		}
		// search setup ... // TODO: do something about the new parameters. Are still retrieved by ID, does not work with Weka plugin. 
		$setupId = $this->Algorithm_setup->getSetupId( $implementation, $parameters, true );
		if( $setupId === false ) {
			$this->_returnError( 213 );
			return;
		}
		
		// fetch task
		$task = $this->Task->getByIdWithValues( $task_id );
		if( $task === false ) { 
			$this->_returnError( 204 );
			return;
		}
		
		// now create a run
		$runId = $this->Run->getHighestIndex( array('run'), 'rid' );
		
		$runData = array(
			'rid' => $runId,
			'uploader' => $this->user_id,
			'setup' => $setupId,
			'task_id' => $task_id,
			'start_time' => now(),
			'status' => ($error_message === false) ? 'OK' : 'error',
			'error' => ($error_message === false) ? null : $error_message,
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
			if( $key == 'description' ) continue;
			
			$file_id = $this->File->register_uploaded_file($value, $this->data_folders['run'], $this->user_id, 'predictions');
			if(!$file_id) {
				$this->_returnError( 212 );
				return;
			}
			$file_record = $this->File->getById($file_id);
			$filename = getAvailableName( DATA_PATH . $this->data_folders['run'], $value['name'] );
			
			$dbName = 'run-' . $run->rid . '-' . $value['name'];
			$record = array(
				'did' => $this->Dataset->getHighestIndex( $this->data_tables, 'did' ),
				'source' => $run->rid,
				'name' => $dbName,
				'version' => $this->Dataset->incrementVersionNumber( $dbName ),
				'description' => 'uploaded content, attached to run ' . $run->rid,
				'format' => $file_record->extension,
				'upload_date' => now(),
				'licence' => 'public domain',
				'url' => $this->data_controller . 'download/' . $file_id . '/' . $file_record->filename_original, 
				'isOriginal' => 'false',
				'md5_checksum' => $file_record->md5_hash,
				'uploader' => $this->user_id );
			
			$data_id = $this->Dataset->insert( $record ); 
			if( $key === 'predictions' ) 
				$predictionsUrl = $record['url'];
			
			$this->Run->outputData( $run->rid, $data_id, 'dataset' );
		}
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Now the stuff that needs to be done for the special     *
     * supported tasks, like classification, regression        *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
		
		$errorCode = -1;
		$errorMessage = false;
		if( $task->ttid == 1 || $task->ttid == 2 || $task->ttid == 3 ) {
			if( $this->Run->insertSupervisedClassificationRun( $this->user_id, $run, $task, $setupId, $predictionsUrl, $output_data, $errorCode, $errorMessage ) == false ) {
				$this->_returnError( $errorCode, $errorMessage );
				return;
			}
		}
		
		// and present result, in effect only a run_id. 
		$this->_xmlContents( 'run-upload', $result );
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
		$run->inputSetting = $this->Input_setting->getWhere( 'setup = ' . $run->setup->sid );
		
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

	private function _test() {
		$this->Algorithm_setup->getSetupId( 'openML.janvanrijn.testRun(1.0)', array(), true );
	}
	
	/********************************* ALIAS FUNCTIONS *********************************/
	
	private function _openml_task_types() {
		$this->_openml_tasks_types();
	}
	
	private function _openml_task_types_search() {
		$this->_openml_tasks_types_search();
	}
	
	private function _openml_task_search() {
		$this->_openml_tasks_search();
	}
	
	/************************************* DISPLAY *************************************/
	
	private function _show_webpage() {
		$this->page = 'api_docs';
		if(!loadpage($this->page,true,'pre'))
			$this->page_body = '<div class="baseNormalContent">Pagina niet gevonden. 
								<a href="'.home().'">Klik hier</a> om terug te keren naar de hoofdpagina.</div>';
		$this->load->view('frontend_main');
	}
	
	private function _returnError( $code, $additionalInfo = null ) {
		$this->Log->api_error( 'error', $_SERVER['REMOTE_ADDR'], $code, $this->requested_function, $this->load->apiErrors[$code][0] . (($additionalInfo == null)?'':$additionalInfo) );
		$error['code'] = $code;
		$error['message'] = htmlentities( $this->load->apiErrors[$code][0] );
		$error['additional'] = htmlentities( $additionalInfo );
		$this->_xmlContents( 'error-message', $error );
	}
  
  private function _xmlContents( $xmlFile, $source ) {
    header('Content-type: text/xml; charset=utf-8');
    $view = 'pages/'.$this->controller.'/'.$this->page.'/'.$xmlFile.'.tpl.php';
    $data = $this->load->view( $view, $source, true );
    header('Content-length: ' . strlen($data) );
    echo $data;
  }
}
?>
