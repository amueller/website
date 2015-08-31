<?php
class Api_run extends Api_model {
  
  protected $version = 'v1';
  
  function __construct() {
    parent::__construct();
    
    // load models
    $this->load->model('Run');
    $this->load->model('Run_tag');
    $this->load->model('Algorithm_setup');
    $this->load->model('Input_setting');
    
    $this->load->model('Evaluation');
    $this->load->model('Evaluation_fold');
    $this->load->model('Evaluation_sample');
    $this->load->model('Evaluation_interval');
    
    $this->load->model('File');
    
  }
  
  function bootstrap($segments, $request_type, $user_id) {
    $getpost = array('get','post');
    
    if (count($segments) == 1 && $segments[0] == 'list') {
      $this->run_list();
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'evaluate') {
      $this->run_evaluate();
      return;
    }
    
    if (count($segments) == 1 && is_numeric($segments[0]) && in_array($request_type, $getpost)) {
      $this->run($segments[0]);
      return;
    }
    
    if (count($segments) == 2 && is_numeric($segments[1]) && $segments[0] == 'reset' && in_array($request_type, $getpost)) {
      $this->run_reset($segments[1]);
      return;
    }
    
    if (count($segments) == 1 && is_numeric($segments[0]) && $request_type == 'delete') {
      $this->run_delete($segments[0]);
      return;
    }
    
    if (count($segments) == 0 && $request_type == 'post') {
      $this->run_upload();
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'tag' && $request_type == 'post') {
      $this->run_tag($this->input->post('run_id'),$this->input->post('tag'));
      return;
    }
    
    if (count($segments) == 1 && $segments[0] == 'untag' && $request_type == 'post') {
      $this->run_untag($this->input->post('run_id'),$this->input->post('tag'));
      return;
    }
    
    $this->returnError( 100, $this->version );
  }
  
  
  private function run_list() {
    $task_id = $this->input->get_post('task_id');
    $setup_id = $this->input->get_post('setup_id');
    $implementation_id = $this->input->get_post('implementation_id');

    if( $task_id == false && $setup_id == false && $implementation_id == false ) {
      $this->returnError( 510, $this->version );
      return;
    }

    if( is_safe( $task_id ) == false ||
        is_safe( $setup_id ) == false ||
        is_safe( $implementation_id ) == false ) {
      $this->returnError( 511, $this->version );
      return;
    }

    $where_task = $task_id == false ? '' : ' AND task_id IN (' . $task_id . ') ';
    $where_setup = $setup_id == false ? '' : ' AND setup IN (' . $setup_id . ') ';
    $where_impl = $implementation_id == false ? '' : ' AND implementation_id IN (' . $implementation_id . ') ';

    $sql =
      'SELECT r.rid, r.uploader, r.task_id, r.setup, s.implementation_id, s.setup_string ' .
      'FROM run r, algorithm_setup s WHERE r.setup = s.sid ' . $where_task . $where_setup . $where_impl;
    $res = $this->Run->query( $sql );

    if($res == false) {
      $this->returnError( 512, $this->version );
      return;
    }

    $this->xmlContents( 'runs', $this->version, array( 'runs' => $res ) );
  }
  
  
  private function run($run_id) {
    if( $run_id == false ) {
      $this->returnError( 220, $this->version );
      return;
    }
    $run = $this->Run->getById( $run_id );
    if( $run === false ) {
      $this->returnError( 221, $this->version );
      return;
    }

    $run->inputData = $this->Run->getInputData( $run->rid );
    $run->outputData = $this->Run->getOutputData( $run->rid );
    $run->setup = $this->Algorithm_setup->getById( $run->setup );
    $run->tags = $this->Run_tag->getColumnWhere( 'tag', 'id = ' . $run->rid );
    $run->inputSetting = $this->Input_setting->query('SELECT i.name, s.value from input i, input_setting s where i.id=s.input_id and setup = ' . $run->setup->sid );

    $this->xmlContents( 'run-get', $this->version, array( 'source' => $run ) );
  }
  
  private function run_delete($run_id) {

    $run = $this->Run->getById( $run_id );
    if( $run == false ) {
      $this->returnError( 392, $this->version );
      return;
    }

    if($run->uploader != $this->user_id && $this->ion_auth->is_admin($this->user_id) == false ) {
      $this->returnError( 393, $this->version );
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
      $this->returnError( 394, $this->version );
      return;
    }
    $this->xmlContents( 'run-delete', $this->version, array( 'run' => $run ) );
  }
  
  
  private function run_reset($run_id) {

    $run = $this->Run->getById( $run_id );
    if( $run == false ) {
      $this->returnError( 412, $this->version );
      return;
    }

    if($run->uploader != $this->user_id && $this->ion_auth->is_admin($this->user_id) == false ) {
      $this->returnError( 413, $this->version );
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
      $this->returnError( 394, $this->version );
      return;
    }
    $this->xmlContents( 'run-reset', $this->version, array( 'run' => $run ) );
  }
  
  private function run_upload() {

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Everything that needs to be done for EVERY task,        *
     * Including the unsupported tasks                         *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    // check uploaded file
    $description = isset( $_FILES['description'] ) ? $_FILES['description'] : false;
    if( ! check_uploaded_file( $description ) ) {
      $this->returnError( 202, $this->version );
      return;
    }
    // validate xml
    if( validateXml( $description['tmp_name'], xsd('openml.run.upload'), $xmlErrors ) == false ) {
      $this->returnError( 203, $this->version, $this->openmlGeneralErrorCode, $xmlErrors );
      return;
    }

    // fetch xml
    $xml = simplexml_load_file( $description['tmp_name'] );
    if( $xml === false ) {
      $this->returnError( 219, $this->version );
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
          $this->returnError( 217, $this->version );
          return;
        }
      }
    }
    $predictionsUrl   = false;

    // fetch implementation
    $implementation = $this->Implementation->getById( $implementation_id );
    if( $implementation === false ) {
      $this->returnError( 205, $this->version );
      return;
    }
    if( in_array( $implementation->{'implements'}, $this->supportedMetrics ) ) {
      $this->returnError( 218, $this->version );
      return;
    }

    // check whether uploaded files are present.
    if($error_message == false) {
      if( count( $_FILES ) < 2 ) {
        $this->returnError( 206, $this->version );
        return;
      }

      $message = '';
      if( ! check_uploaded_file( $_FILES['predictions'], false, $message ) ) {
        $this->returnError( 207, $this->version, $this->openmlGeneralErrorCode, 'File predictions: ' . $message );
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
        $this->returnError( 213, $this->version );
        return;
      }

      $parameters[$input_id->id] = $p->value . '';
    }
    // search setup ... // TODO: do something about the new parameters. Are still retrieved by ID, does not work with Weka plugin.
    $setupId = $this->Algorithm_setup->getSetupId( $implementation, $parameters, true, $setup_string );
    if( $setupId === false ) {
      $this->returnError( 214, $this->version );
      return;
    }

    // fetch task
    $taskRecord = $this->Task->getById( $task_id );
    if( $taskRecord === false ) {
      $this->returnError( 204, $this->version );
      return;
    }
    $task = end( $this->Task->tasks_crosstabulated( $taskRecord->ttid, true, array(), false, $task_id ) );

    // now create a run

    $runData = array(
      'uploader' => $this->user_id,
      'setup' => $setupId,
      'task_id' => $task->task_id,
      'start_time' => now(),
      'status' => ($error_message == false) ? 'OK' : 'error',
      'error' => ($error_message == false) ? null : $error_message,
      'experiment' => '-1',
    );
    $runId = $this->Run->insert( $runData );
    if( $runId === false ) {
      $this->returnError( 210, $this->version );
      return;
    }
    // and fetch the run record
    $run = $this->Run->getById( $runId );
    $result = new stdClass();
    $result->run_id = $runId; // for output

    // attach uploaded files as output to run
    foreach( $_FILES as $key => $value ) {
      $file_type = ($key == 'predictions') ? 'predictions' : 'run_uploaded_file';
      $file_id = $this->File->register_uploaded_file($value, $this->data_folders['run'], $this->user_id, $file_type);
      if(!$file_id) {
        $this->returnError( 212, $this->version );
        return;
      }
      $file_record = $this->File->getById($file_id);
      $filename = getAvailableName( DATA_PATH . $this->data_folders['run'], $value['name'] );

      $record = array(
        'source' => $run->rid,
        'field' => $key,
        'name' => $value['name'],
        'format' => $file_record->extension,
        'file_id' => $file_id );

      $did = $this->Runfile->insert( $record );
      if( $did == false ) {
        $this->returnError( 212, $this->version );
        return;
      }
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

    // remove scheduled task
    $this->Schedule->deleteWhere( 'task_id = "' . $task->task_id . '" AND sid = "' . $setupId . '"' );

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Now the stuff that needs to be done for the special     *
     * supported tasks, like classification, regression        *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    // and present result, in effect only a run_id.
    $this->xmlContents( 'run-upload', $this->version, $result );
  }
  
  
  private function run_evaluate() {

    // check uploaded file
    $description = isset( $_FILES['description'] ) ? $_FILES['description'] : false;
    if( ! check_uploaded_file( $description ) ) {
      $this->returnError( 422, $this->version );
      return;
    }

    // validate xml
    if( validateXml( $description['tmp_name'], xsd('openml.run.evaluate'), $xmlErrors ) == false ) {
      $this->returnError( 423, $this->version, $this->openmlGeneralErrorCode, $xmlErrors );
      return;
    }

    // fetch xml
    $xml = simplexml_load_file( $description['tmp_name'] );
    if( $xml === false ) {
      $this->returnError( 424, $this->version );
      return;
    }

    $run_id = (string) $xml->children('oml', true)->{'run_id'};


    $runRecord = $this->Run->getById( $run_id );
    if( $runRecord == false ) {
      $this->returnError( 425, $this->version );
      return;
    }

    if( $runRecord->processed != null ) {
      $this->returnError( 426, $this->version );
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

    $this->xmlContents( 'run-evaluate', $this->version, array( 'run_id' => $run_id ) );
  }
  
  
  private function run_tag($id,$tag) {
    $id = $this->input->get( 'run_id' );
    $tag = $this->input->get( 'tag' );

    $error = -1;
    $result = tag_item( 'run', $id, $tag, $this->user_id, $error );

    //update index
    $this->elasticsearch->index('run', $id);

    if( $result == false ) {
      $this->returnError( $error, $this->version );
    } else {
      $this->xmlContents( 'entity-tag', $this->version, array( 'id' => $id, 'type' => 'run' ) );
    }
  }

  private function run_untag($id,$tag) {
    $error = -1;
    $result = untag_item( 'run', $id, $tag, $this->user_id, $error );

    //update index
    $this->elasticsearch->index('run', $id);

    if( $result == false ) {
      $this->returnError( $error, $this->version );
    } else {
      $this->xmlContents( 'entity-untag', $this->version, array( 'id' => $id, 'type' => 'run' ) );
    }
  }
  
}
?>
