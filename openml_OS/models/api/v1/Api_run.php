<?php
class Api_run extends Api_model {

  protected $version = 'v1';

  function __construct() {
    parent::__construct();

    // load models
    $this->load->model('Run');
    $this->load->model('Dataset');
    $this->load->model('Run_tag');
    $this->load->model('Runfile');
    $this->load->model('Algorithm_setup');
    $this->load->model('Input_setting');
    $this->load->model('Output_data');
    $this->load->model('Input_data');
    $this->load->model('Task');
    $this->load->model('Task_inputs');
    $this->load->model('Author');
    $this->load->model('Implementation');
    $this->load->model('Trace');

    $this->load->model('Evaluation');
    $this->load->model('Evaluation_fold');
    $this->load->model('Evaluation_sample');
    $this->load->model('Evaluation_interval');

    $this->load->helper('arff');

    $this->load->model('File');
  }

  function bootstrap($format, $segments, $request_type, $user_id) {
    $this->outputFormat = $format;

    $getpost = array('get','post');

    if (count($segments) >= 1 && $segments[0] == 'list') {
      array_shift($segments);
      $this->run_list($segments);
      return;
    }

    if (count($segments) == 1 && $segments[0] == 'evaluate' && $request_type == 'post') {
      $this->run_evaluate();
      return;
    }

    if (count($segments) == 1 && $segments[0] == 'trace' && $request_type == 'post') {
      $this->run_trace_upload();
      return;
    }

    if (count($segments) == 2 && $segments[0] == 'trace' && is_numeric($segments[1])) {
      $this->run_trace($segments[1]);
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


  private function run_list($segs) {
    $query_string = array();
    for ($i = 0; $i < count($segs); $i += 2)
      $query_string[$segs[$i]] = urldecode($segs[$i+1]);

    $task_id = element('task', $query_string);
    $setup_id = element('setup',$query_string);
    $implementation_id = element('flow',$query_string);
    $uploader_id = element('uploader',$query_string);
    $run_id = element('run',$query_string);
    $tag = element('tag',$query_string);
    $limit = element('limit',$query_string);
    $offset = element('offset',$query_string);

    if ($task_id == false && $setup_id == false && $implementation_id == false && $uploader_id == false && $run_id == false && $tag == false && $limit == false) {
      $this->returnError( 510, $this->version );
      return;
    }

    if (!(is_safe($task_id) && is_safe($setup_id) && is_safe($implementation_id) && is_safe($uploader_id) && is_safe($run_id) && is_safe($tag) && is_safe($limit) && is_safe($offset))) {
      $this->returnError(511, $this->version );
      return;
    }

    $where_task = $task_id == false ? '' : ' AND `r`.`task_id` IN (' . $task_id . ') ';
    $where_setup = $setup_id == false ? '' : ' AND `r`.`setup` IN (' . $setup_id . ') ';
    $where_uploader = $uploader_id == false ? '' : ' AND `r`.`uploader` IN (' . $uploader_id . ') ';
    $where_impl = $implementation_id == false ? '' : ' AND `i`.`id` IN (' . $implementation_id . ') ';
    $where_run = $run_id == false ? '' : ' AND `r`.`rid` IN (' . $run_id . ') ';
    $where_tag = $tag == false ? '' : ' AND `r`.`rid` IN (select id from run_tag where tag="' . $tag . '") ';
    $where_server_error = " AND (`r`.`status` <> 'error' and `r`.`error` is null or `r`.`error` like 'Inconsistent%' or `r`.`error_message` is not null) ";
    $where_limit = $limit == false ? '' : ' LIMIT ' . $limit;
    if($limit != false && $offset != false){
      $where_limit =  ' LIMIT ' . $offset . ',' . $limit;
    }

    $where_total = $where_task . $where_setup . $where_uploader . $where_impl . $where_run . $where_tag . $where_server_error;

    $sql =
      'SELECT r.rid, r.uploader, r.task_id, d.did AS dataset_id, d.name AS dataset_name, r.setup, i.id AS flow_id, i.name AS flow_name, r.error_message ' .
      'FROM run r LEFT JOIN task_inputs t ON r.task_id = t.task_id AND t.input = "source_data" LEFT JOIN dataset d ON t.value = d.did , algorithm_setup s, implementation i ' .
      'WHERE r.setup = s.sid AND i.id = s.implementation_id ' . $where_total . $where_limit;
    $res = $this->Run->query( $sql );

    if ($res == false) {
      $this->returnError(512, $this->version);
      return;
    }

    if (count($res) > 10000) {
      $this->returnError(513, $this->version, $this->openmlGeneralErrorCode, 'Size of result set: ' . count($res) . '; max size: 10000. ');
      return;
    }

    // make associative array
    $runs = array();
    foreach( $res as $r ) {
      $runs[$r->rid] = $r;
    }

    // attach tags
    $dt = $this->Run_tag->query('SELECT id, tag FROM run_tag WHERE `id` IN (' . implode(',', array_keys($runs)) . ') ORDER BY `id`');
    foreach( $dt as $tag ) {
      $runs[$tag->id]->tags[] = $tag->tag;
    }

    $this->xmlContents( 'runs', $this->version, array( 'runs' => $runs ) );
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
    $run->task_type = $this->Task->query('SELECT tt.name from task t, task_type tt where t.ttid=tt.ttid and t.task_id = ' . $run->task_id )[0]->name;
    $user = $this->Author->getById($run->uploader);
    $run->user_name = $user->first_name . ' ' . $user->last_name;
    $run->flow_name = $this->Implementation->getById($run->setup->implementation_id)->fullName;
    $run->task_evaluation = $this->Task_inputs->getWhere("task_id = " . $run->task_id . " and input = 'evaluation_measures'")[0];

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
      $additional_sql = ''; //' AND `did` NOT IN (SELECT `data` FROM `input_data` UNION SELECT `data` FROM `output_data`)';
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

    $this->elasticsearch->delete('run', $run_id);
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

    $result = $result && $this->Trace->deleteWhere('`run_id` = "' . $run->rid . '" ');
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

    // IMPORTANT! This function is sort of similar to "setup exists".
    // If changing something big, also test that function.

    $timestamps = array(microtime(true)); // profiling 0

    // check uploaded file
    $description = isset($_FILES['description']) ? $_FILES['description'] : false;
    $uploadError = '';
    if(!check_uploaded_file($description,false,$uploadError)) {
      $this->returnError(202, $this->version,$this->openmlGeneralErrorCode,$uploadError);
      return;
    }


    // validate xml
    $xmlErrors = '';
    if(validateXml($description['tmp_name'], xsd('openml.run.upload', $this->controller, $this->version), $xmlErrors) == false) {
      $this->returnError(203, $this->version, $this->openmlGeneralErrorCode, $xmlErrors);
      return;
    }

    if (!$this->ion_auth->in_group($this->groups_upload_rights, $this->user_id)) {
      $this->returnError(104, $this->version);
      return;
    }

    // fetch xml
    $xml = simplexml_load_file($description['tmp_name']);
    if($xml === false) {
      $this->returnError(219, $this->version);
      return;
    }

    $run_xml = all_tags_from_xml(
      $xml->children('oml', true),
      $this->xml_fields_run);

    $task_id = $run_xml['task_id'];
    $implementation_id = $run_xml['flow_id'];
    $setup_string = array_key_exists('setup_string', $run_xml) ? $run_xml['setup_string'] : null;
    $error_message = array_key_exists('error_message', $run_xml) ? $run_xml['error_message'] : false;
    $parameter_objects = array_key_exists('parameter_setting', $run_xml) ? $run_xml['parameter_setting'] : array();
    $output_data = array_key_exists('output_data', $run_xml) ? $run_xml['output_data'] : array();
    $tags = array_key_exists('tag', $run_xml) ? str_getcsv ($run_xml['tag']) : array();

    // the user can specify his own metrics. here we check whether these exists in the database.
    if($output_data != false && array_key_exists('evaluation', $output_data)) {
      foreach($output_data->children('oml',true)->{'evaluation'} as $eval) {
        $measure_id = $this->Implementation->getWhere('`fullName` = "'.$eval->flow.'" AND `implements` = "'.$eval->name.'"');
        if($measure_id == false) {
          $this->returnError(217, $this->version,$this->openmlGeneralErrorCode,'Measure: ' . $eval->name . '; flow: ' . $eval->flow);
          return;
        }
      }
    }
    $predictionsUrl   = false;

    // fetch implementation
    $implementation = $this->Implementation->getById($implementation_id);
    if($implementation === false) {
      $this->returnError(205, $this->version);
      return;
    }
    if(in_array($implementation->{'implements'}, $this->supportedMetrics)) {
      $this->returnError(218, $this->version);
      return;
    }

    // check whether uploaded files are present.

    foreach ($_FILES as $key => $value) {
      $message = '';
      $extension = getExtension($_FILES[$key]['name']);

      if (/*in_array($extension,$this->config->item('allowed_extensions')) == false ||*/ $extension == false) {
        $this->returnError(206, $this->version, $this->openmlGeneralErrorCode, 'Invalid extension for file "'.$key.'". Original filename: ' . $_FILES[$key]['name']);
        return;
      }

      if (!check_uploaded_file($_FILES[$key], false, $message)) {
        $this->returnError(207, $this->version, $this->openmlGeneralErrorCode, 'Upload problem with file "'.$key.'": ' . $message);
        return;
      }

      if ($extension == 'arff') {
        $arffCheck = ARFFcheck($_FILES[$key]['tmp_name'], 1000);
        if ($arffCheck !== true) {
          $this->returnError(209, $this->version, $this->openmlGeneralErrorCode, 'Arff error in predictions file: ' . $arffCheck);
          return;
        }
      }

      if ($extension == 'xml') {
        $xmlCheck = simplexml_load_file($_FILES[$key]['tmp_name']);
        if($xmlCheck === false) {
          $this->returnError(209, $this->version, $this->openmlGeneralErrorCode, 'XML error in predictions file: ' . $xmlCheck);
          return;
        }
      }
    }

    $timestamps[] = microtime(true); // profiling 1

    $parameters = array();
    foreach($parameter_objects as $p) {
      // since 'component' is an optional XML field, we add a default option
      $component = property_exists($p, 'component') ? $p->component : $implementation->id;

      // now find the input id
      $input_id = $this->Input->getWhereSingle('`implementation_id` = ' . $component . ' AND `name` = "' . $p->name . '"');
      if($input_id === false) {
        $this->returnError(213, $this->version, $this->openmlGeneralErrorCode, 'Name: ' . $p->name . ', flow id (component): ' . $component);
        return;
      }

      $parameters[$input_id->id] = $p->value . '';
    }
    // search setup ... // TODO: do something about the new parameters. Are still retrieved by ID, does not work with Weka plugin.
    $setupId = $this->Algorithm_setup->getSetupId($implementation, $parameters, true, $setup_string);
    if( $setupId === false ) {
      $this->returnError(214, $this->version);
      return;
    }

    $timestamps[] = microtime(true); // profiling 2

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
      'error_message' => ($error_message == false) ? null : $error_message,
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


    $timestamps[] = microtime(true); // profiling 3
    // add to elastic search index.
    $this->elasticsearch->index('run', $run->rid);

    $timestamps[] = microtime(true); // profiling 4
    if (DEBUG) {
      $this->Log->profiling(__FUNCTION__, $timestamps,
        array(
          'uploaded file handling',
          'setup searching / creation',
          'database insertions',
          'elastic search')
      );
    }


    // remove scheduled task
    $this->Schedule->deleteWhere( 'task_id = "' . $task->task_id . '" AND sid = "' . $setupId . '"' );

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Now the stuff that needs to be done for the special     *
     * supported tasks, like classification, regression        *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    // and present result, in effect only a run_id.
    $this->xmlContents( 'run-upload', $this->version, $result );
  }

  private function run_trace($run_id) {
    $trace = $this->Trace->getWhere('run_id = ' . $run_id, 'repeat ASC, fold ASC, iteration ASC');

    if ($trace === false) {
      $this->returnError(570,$this->version);
      return;
    }

    $this->xmlContents('run-trace-get', $this->version, array('run_id' => $run_id, 'trace' => $trace));
  }

  private function run_trace_upload() {
    // check uploaded file
    $trace = isset($_FILES['trace']) ? $_FILES['trace'] : false;
    if(!check_uploaded_file($trace)) {
      $this->returnError(561,$this->version);
      return;
    }

    $xsd = xsd('openml.run.trace', $this->controller, $this->version);

    // validate xml
    if(validateXml($trace['tmp_name'], $xsd, $xmlErrors) == false) {
      $this->returnError(562, $this->version, $this->openmlGeneralErrorCode, $xmlErrors);
      return;
    }

    // fetch xml
    $xml = simplexml_load_file($trace['tmp_name']);
    if($xml === false) {
      $this->returnError(563, $this->version);
      return;
    }

    $run_id = (string) $xml->children('oml', true)->{'run_id'};

    $this->db->trans_start();
    foreach($xml->children('oml', true)->{'trace_iteration'} as $t) {
      $iteration = xml2assoc($t, true);

      $iteration['run_id'] = $run_id;

      $this->Trace->insert($iteration);
    }
    $this->db->trans_complete();

    $this->xmlContents('run-trace', $this->version, array('run_id' => $run_id));
  }

  private function run_evaluate() {

    // check uploaded file
    $description = isset( $_FILES['description'] ) ? $_FILES['description'] : false;
    if( ! check_uploaded_file( $description ) ) {
      $this->returnError( 422, $this->version );
      return;
    }

    $xsd = xsd('openml.run.evaluate', $this->controller, $this->version);

    // validate xml
    if( validateXml( $description['tmp_name'], $xsd, $xmlErrors ) == false ) {
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
    if( isset( $xml->children('oml', true)->{'warning'}) ) {
      $data['warning'] = '' . $xml->children('oml', true)->{'warning'};
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
      if( array_key_exists( $evaluation['flow'], $implementation_ids ) ) {
        $evaluation['implementation_id'] = $implementation_ids[$evaluation['flow']];
        unset($evaluation['flow']);
      } else {
        $this->Log->mapping( __FILE__, __LINE__, 'Flow ' . $evaluation['flow'] . ' not found in database. ' );
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
  //    } elseif( array_key_exists( 'interval_start', $evaluation ) && array_key_exists( 'interval_end', $evaluation ) ) {
  //      // evaluation_interval
  //      $this->Evaluation_interval->insert( $evaluation );
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
    $error = -1;
    $result = tag_item( 'run', $id, $tag, $this->user_id, $error );

    //update index
    $this->elasticsearch->index('run', $id);
    //update studies
    if(startsWith($tag,'study_')){
      $this->elasticsearch->index('study', end(explode('_',$tag)));
    }

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
