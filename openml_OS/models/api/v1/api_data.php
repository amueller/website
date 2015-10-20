<?php
class Api_data extends Api_model {

  protected $version = 'v1';

  function __construct() {
    parent::__construct();

    // load models
    $this->load->model('Dataset');
    $this->load->model('Dataset_tag');
    $this->load->model('Data_feature');
    $this->load->model('Data_quality');
    $this->load->model('Data_quality_interval');
    $this->load->model('Quality');
    $this->load->model('File');
  }

  function bootstrap($segments, $request_type, $user_id) {
    $getpost = array('get','post');

    if (count($segments) == 1 && $segments[0] == 'list') {
      $this->data_list();
      return;
    }

    if (count($segments) == 1 && is_numeric($segments[0]) && in_array($request_type, $getpost)) {
      $this->data($segments[0]);
      return;
    }

    if (count($segments) == 1 && is_numeric($segments[0]) && $request_type == 'delete') {
      $this->data_delete($segments[0]);
      return;
    }

    if (count($segments) == 0 && $request_type == 'post') {
      $this->data_upload();
      return;
    }

    if (count($segments) == 2 && $segments[0] == 'features' && is_numeric($segments[1]) && in_array($request_type, $getpost)) {
      $this->data_features($segments[1]);
      return;
    }

    if (count($segments) == 1 && $segments[0] == 'features' && $request_type == 'post') {
      $this->data_features_upload($segments[0]);
      return;
    }

    if (count($segments) == 2 && $segments[0] == 'qualities' && $segments[1] == 'list' && in_array($request_type, $getpost)) {
      $this->data_qualities_list($segments[1]);
      return;
    }

    if (count($segments) == 2 && $segments[0] == 'qualities' && is_numeric($segments[1]) && in_array($request_type, $getpost)) {
      $this->data_qualities($segments[1]);
      return;
    }

    if (count($segments) == 1 && $segments[0] == 'qualities' && $request_type == 'post') {
      $this->data_qualities_upload($segments[0]);
      return;
    }

    if (count($segments) == 1 && $segments[0] == 'tag' && $request_type == 'post') {
      $this->data_tag($this->input->post('data_id'),$this->input->post('tag'));
      return;
    }

    if (count($segments) == 1 && $segments[0] == 'untag' && $request_type == 'post') {
      $this->data_untag($this->input->post('data_id'),$this->input->post('tag'));
      return;
    }

    $this->returnError( 100, $this->version );
  }

  private function data_list() {
    $active = 'visibility = "public"'; // no constraints
    $datasets_res = $this->Dataset->getWhere( $active, 'did' );
    if( is_array( $datasets_res ) == false || count( $datasets_res ) == 0 ) {
      $this->returnError( 370, $this->version );
      return;
    }

    // make associative
    $datasets = array();
    foreach( $datasets_res as $dataset ) {
      $datasets[$dataset->did] = $dataset;
      $datasets->qualities = array();
    }

    $dq = $this->Data_quality->query('SELECT data, quality, value FROM data_quality WHERE `data` IN (' . implode(',', array_keys( $datasets) ) . ') AND quality IN ("' .  implode('","', $this->config->item('basic_qualities') ) . '") ORDER BY `data`');

    foreach( $dq as $quality ) {
      $datasets[$quality->data]->qualities[$quality->quality] = $quality->value;
    }

    $this->xmlContents( 'data', $this->version, array( 'datasets' => $datasets ) );
  }

  private function data($data_id) {
    if( $data_id == false ) {
      $this->returnError( 110, $this->version );
      return;
    }

    $dataset = $this->Dataset->getById( $data_id );
    if( $dataset === false ) {
      $this->returnError( 111, $this->version );
      return;
    }
    $file = $this->File->getById( $dataset->file_id );
    $tags = $this->Dataset_tag->getColumnWhere( 'tag', 'id = ' . $dataset->did );
    $dataset->tag = $tags != false ? '"' . implode( '","', $tags ) . '"' : array();
    $dataset->md5_checksum = $file->md5_hash;

    foreach( $this->xml_fields_dataset['csv'] as $field ) {
      $dataset->{$field} = getcsv( $dataset->{$field} );
    }

    $this->xmlContents( 'data-get', $this->version, $dataset );
  }

  private function data_delete($data_id) {

    $dataset = $this->Dataset->getById( $data_id );
    if( $dataset == false ) {
      $this->returnError( 352, $this->version );
      return;
    }

    if($dataset->uploader != $this->user_id ) {
      $this->returnError( 353, $this->version );
      return;
    }

    $tasks = $this->Task->getTasksWithValue( array( 'source_data' => $dataset->did ) );

    if( $tasks !== false ) {
      $task_ids = array();
      foreach( $tasks as $t ) { $task_ids[] = $t->task_id; }

      $runs = $this->Run->getWhere( 'task_id IN ("'.implode('","', $task_ids).'")' );


      if( $runs ) {
        $this->returnError( 354, $this->version );
        return;
      }
    }

    $result = $this->Dataset->delete( $dataset->did );
    $this->Data_feature->deleteWhere('did =' . $dataset->did);
    $this->Data_quality->deleteWhere('data =' . $dataset->did);

    if( $result == false ) {
      $this->returnError( 355, $this->version );
      return;
    }

    $this->elasticsearch->delete('data', $data_id);
    $this->xmlContents( 'data-delete', $this->version, array( 'dataset' => $dataset ) );
  }


  private function data_upload() {
    // get correct description
    if( $this->input->post('description') ) {
      // get description from string upload
      $description = $this->input->post('description', false);
      if( validateXml( $description, xsd('openml.data.upload', $this->controller, $this->version), $xmlErrors, false ) == false ) {
        $this->returnError( 131, $this->version, $this->openmlGeneralErrorCode, $xmlErrors );
        return;
      }
      $xml = simplexml_load_string( $description );
    } elseif(isset($_FILES['description']) && check_uploaded_file( $_FILES['description'] ) == true) {
      // get description from file upload
      $description = $_FILES['description'];

      if( validateXml( $description['tmp_name'], xsd('openml.data.upload', $this->controller, $this->version), $xmlErrors ) == false ) {
        $this->returnError( 131, $this->version, $this->openmlGeneralErrorCode, $xmlErrors );
        return;
      }
      $xml = simplexml_load_file( $description['tmp_name'] );
    } else {
      $this->returnError( 135, $this->version );
      return;
    }

    //check if this is an update or a new dataset
    $update = false;
    if($xml->children('oml', true)->{'id'}) {
      $update = true;
    }

    if (!$this->ion_auth->in_group($this->groups_upload_rights, $this->user_id)) {
      $this->returnError( 104, $this->version );
      return;
    }

    //check and register the data files, return url
    $file_id = null;
    $datasetUrlProvided = property_exists( $xml->children('oml', true), 'url' );
    $datasetFileProvided = isset( $_FILES['dataset'] );
    if( $datasetUrlProvided && $datasetFileProvided ) {
      $this->returnError( 140, $this->version );
      return;
    } elseif( $datasetFileProvided ) {
      $message = '';
      if( ! check_uploaded_file( $_FILES['dataset'], false, $message ) ) {
        $this->returnError( 130, $this->version, $this->openmlGeneralErrorCode, 'File dataset: ' . $message );
        return;
      }
      $access_control = 'public';
      $access_control_option = $xml->children('oml', true)->{'visibility'};
      if( $access_control_option != 'public' ) {
        $access_control = 'private';
      }

      $file_id = $this->File->register_uploaded_file($_FILES['dataset'], $this->data_folders['dataset'], $this->user_id, 'dataset', $access_control);
      if($file_id === false) {
        $this->returnError( 132, $this->version );
        return;
      }
      $file_record = $this->File->getById($file_id);
      $destinationUrl = $this->data_controller . 'download/' . $file_id . '/' . $file_record->filename_original;
    } elseif( $datasetUrlProvided ) {
      $destinationUrl = '' . $xml->children('oml', true)->url;
    } elseif($update) {
      $destinationUrl = false;
    } else {
      $this->returnError( 141, $this->version );
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
        'file_id' => $file_id
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
        $this->returnError( 144, $this->version );
        return;
      }

      if ($destinationUrl){
        $dataset = array(
          'last_update' => now(),
          'url' => $destinationUrl,
          'file_id' => $file_id
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
        $this->returnError( 134, $this->version );
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
    $this->xmlContents( 'data-upload', $this->version, array( 'id' => $id ) );
  }


  private function data_features($data_id) {
    if( $data_id == false ) {
      $this->returnError( 270, $this->version );
      return;
    }
    $dataset = $this->Dataset->getById( $data_id );
    if( $dataset === false ) {
      $this->returnError( 271, $this->version );
      return;
    }

    if( $dataset->processed == NULL) {
      $this->returnError( 273, $this->version );
      return;
    }

    if( $dataset->error != "false") {
      $this->returnError( 274, $this->version );
      return;
    }

    $dataset->features = $this->Data_feature->getWhere( 'did = "' . $dataset->did . '"' );

    if( $dataset->features === false ) {
      $this->returnError( 272, $this->version );
      return;
    }
    if( is_array( $dataset->features ) === false ) {
      $this->returnError( 272, $this->version );
      return;
    }
    if( count( $dataset->features ) === 0 ) {
      $this->returnError( 272, $this->version );
      return;
    }

    $this->xmlContents( 'data-features', $this->version, $dataset );
  }

  private function data_features_upload() {
    // get correct description
    if( isset($_FILES['description']) == false || check_uploaded_file( $_FILES['description'] ) == false ) {
      $this->returnError( 432, $this->version );
      return;
    }

    // get description from string upload
    $description = $_FILES['description'];
    if( validateXml( $description['tmp_name'], xsd('openml.data.features', $this->controller, $this->version), $xmlErrors ) == false ) {
      $this->returnError( 433, $this->version, $this->openmlGeneralErrorCode, $xmlErrors );
      return;
    }

    if (!$this->ion_auth->in_group($this->groups_upload_rights, $this->user_id)) {
      $this->returnError( 104, $this->version );
      return;
    }

    $xml = simplexml_load_file( $description['tmp_name'] );
    $did = ''. $xml->children('oml', true)->{'did'};

    $dataset = $this->Dataset->getById( $did );
    if( $dataset == false ) {
      $this->returnError( 434, $this->version );
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
      $this->xmlContents( 'data-features-upload', $this->version, array( 'did' => $dataset->did ) );
    } else {
      $this->returnError( 435, $this->version );
      return;
    }
  }

  private function data_qualities_list() {
    $result = $this->Quality->allUsed( );
    $qualities = array();
    if($result != false) {
      foreach( $result as $r ) {
        $qualities[] = $r->name;
      }
    } else {
      $this->returnError( 520, $this->version );
      return;
    }
    $this->xmlContents( 'data-qualities-list', $this->version, array( 'qualities' => $qualities ) );
  }


  private function data_qualities($data_id) {
    if( $data_id == false ) {
      $this->returnError( 360, $this->version );
      return;
    }
    $dataset = $this->Dataset->getById( $data_id );
    if( $dataset === false ) {
      $this->returnError( 361, $this->version );
      return;
    }

    if( $dataset->processed == NULL) {
      $this->returnError( 363, $this->version );
      return;
    }

    if( $dataset->error != "false") {
      $this->returnError( 364, $this->version );
      return;
    }

    $interval_start = false; // $this->input->get( 'interval_start' );
    $interval_end   = false; // $this->input->get( 'interval_end' );
    $interval_size  = false; // $this->input->get( 'interval_size' );

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
      $this->returnError( 362, $this->version );
      return;
    }
    if( is_array( $dataset->qualities ) === false ) {
      $this->returnError( 362, $this->version );
      return;
    }
    if( count( $dataset->qualities ) === 0 ) {
      $this->returnError( 362, $this->version );
      return;
    }

    $this->xmlContents( 'data-qualities', $this->version, $dataset );
  }

  private function data_qualities_upload() {
    // get correct description
    if( isset($_FILES['description']) == false || check_uploaded_file( $_FILES['description'] ) == false ) {
      $this->returnError( 382, $this->version );
      return;
    }

    // get description from string upload
    $description = $_FILES['description'];
    if( validateXml( $description['tmp_name'], xsd('openml.data.qualities', $this->controller, $this->version), $xmlErrors ) == false ) {
      $this->returnError( 383, $this->version, $this->openmlGeneralErrorCode, $xmlErrors );
      return;
    }

    if (!$this->ion_auth->in_group($this->groups_upload_rights, $this->user_id)) {
      $this->returnError( 104, $this->version );
      return;
    }

    $xml = simplexml_load_file( $description['tmp_name'] );
    $did = ''. $xml->children('oml', true)->{'did'};

    $dataset = $this->Dataset->getById( $did );
    if( $dataset == false ) {
      $this->returnError( 384, $this->version );
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
        $this->returnError( 385, $this->openmlGeneralErrorCode, $quality->name );
        return;
      } elseif( $qualities != false && array_key_exists( $quality->name, $qualities ) ) { // prior to this run, we already got this quality
        if( abs( $qualities[$quality->name] - $quality->value ) > $this->config->item('double_epsilon') ) {
          $this->returnError( 386, $this->openmlGeneralErrorCode, $quality->name );
          return;
        }
      } else*/if( is_array( $all_qualities ) == false || in_array( $quality->name, $all_qualities ) == false ) {
        $this->returnError( 387, $this->version, $this->openmlGeneralErrorCode, $quality->name );
        return;
      } else {
        $newQualities[] = $quality;
      }

      if( property_exists( $quality, 'interval_start' ) ) {

      } else {

      }
    }

    if( count( $newQualities) == 0 ) {
      $this->returnError( 388, $this->version );
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
      $this->xmlContents( 'data-qualities-upload', $this->version, array( 'did' => $dataset->did ) );
    } else {
      $this->returnError( 389, $this->version );
      return;
    }
  }


  private function data_tag($data_id, $tag) {
    $error = -1;
    $result = tag_item( 'dataset', $data_id, $tag, $this->user_id, $error );

    //update index
    $this->elasticsearch->index('data', $data_id);
    //update studies
    if(startsWith($tag,'study_')){
      $this->elasticsearch->index('study', end(explode('_',$tag)));
    }

    if( $result == false ) {
      $this->returnError( $error, $this->version );
    } else {
      $this->xmlContents( 'entity-tag', $this->version, array( 'id' => $data_id, 'type' => 'data' ) );
    }
  }

  private function data_untag($data_id, $tag) {
    $error = -1;
    $result = untag_item( 'dataset', $data_id, $tag, $this->user_id, $error );


    //update index
    $this->elasticsearch->index('data', $data_id);

    if( $result == false ) {
      $this->returnError( $error, $this->version );
    } else {
      $this->xmlContents( 'entity-untag', $this->version, array( 'id' => $data_id, 'type' => 'data' ) );
    }
  }
}
?>
