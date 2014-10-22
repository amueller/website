<?php
/* * * * *
 * This script transforms the input of the form into
 * a uniform format, as used by the model. 
 * It converts a dataset name into an id and filters
 * the datasets with the wrong target attribute. 
 * * * * */
 
if($this->subpage == 'task') {
  $ttid = $this->input->post( 'ttid' );
  $datatype = array( 'nominal' );
  $required_inputs = $this->Task_type_inout->getWhere( '`io` = "input" AND `ttid` = "'.$ttid.'"' );
  $inputs = array();
  // retrieve all inputs
  foreach( $required_inputs as $i ) {
    if($this->input->post($i->name) == false ) { continue; }
    $inputs[$i->name] = $this->input->post($i->name);
  }
  
  // special retrieve datasets and target feature
  $constraints = $this->Dataset->nameVersionConstraints( $this->input->post( 'source_data' ), 'd' );
  $target_feature = '`d`.`default_target_attribute`';
  if( trim( $this->input->post( 'target_feature' ) ) ) {
    $target_feature = '"'.trim( $this->input->post( 'target_feature' ) ).'"';
  } else {
    unset( $inputs['target_feature'] );
  }
  
  // TODO: remove mapping, add logic in DB instead of here. 
  if( $ttid == 2 ) { // exception. 
    $datatype = array( 'numeric' );
  }

  $sql = 
    'SELECT `d`.`did`, `f`.`name` ' . 
    'FROM `dataset` `d`,`data_feature` `f` ' . 
    'WHERE `d`.`did` = `f`.`did` ' .
    'AND `f`.`name` = ' . $target_feature . ' ' .
    'AND `f`.`NumberOfMissingValues` = 0 ' . // MAKE TASKS WITH NO MISSING VALUES IN TARGET, FOR NOW
    'AND `f`.`data_type` IN ("' . implode( '","', $datatype ) . '") ' . 
    'AND ' . $constraints . ' ' .
    'ORDER BY `did`;';

  $datasets = $this->Dataset->query( $sql );
  
  // sanity check input
  $input_safe = true;
  // first sanitize custom testset
  if( $this->input->post('custom_testset') ) {
    if( is_cs_natural_numbers( $inputs['custom_testset'] ) ) {
      $inputs['custom_testset'] = implode( ',', range_string_to_array( $inputs['custom_testset'] ) );
    } else {
      unset( $inputs['custom_testset'] );
      $input_safe = false;
      echo "Warning: Illegal custom test set!";
    }
  }
  
  $results = array(); // resulting task configurations
  $dids = array(); // used dataset ids
  $new_tasks = array();
  if( is_array( $datasets ) ) {
    foreach( $datasets as $dataset ) {
      $current = $inputs;
      $current['source_data'] = $dataset->did;
      $current['target_feature'] = $dataset->name;
      $results[] = $current;

      $dids[] = $dataset->did;
    }
    if( count( $datasets ) > 1 && $this->input->post('custom_testset') ) {
      // against the rules
      echo "Error: this task creation is not allowed.";
    } elseif( $input_safe ) {
      $new_tasks = $this->Task->create_batch( $ttid, $results );
    } else {
      echo "This task creation setup is not defined.";	
    }
  }
  $inputs['source_data'] = $dids;

  $tasks = $this->Task->tasks_crosstabulated( $ttid, true, $inputs );

  if( $tasks ) {
    foreach( $tasks as $task ) {
      $new = in_array( $task->task_id, $new_tasks ) ? '*' : '';
      $this->task_ids[] = '<a href="t/' . $task->task_id . '">' . $task->task_id . '</a>' . $new;
    }
  }

  if( $new_tasks ) { $this->new_text = '* new'; }
  
} elseif($this->subpage == 'data') {

  $session_hash = $this->Api_session->createByUserId( $this->ion_auth->user()->row()->id );

  $description = $this->dataoverview->generate_xml(
    'data_set_description',
    $this->config->item('xml_fields_dataset')
  );

  $post_data = array(
      'description' => $description,
      'session_hash' => $session_hash
  );
  if( $_FILES['dataset']['error'] == 0 ) {
      $post_data['dataset'] = '@' . $_FILES['dataset']['tmp_name'];
  }

  $url = BASE_URL.'/api/?f=openml.data.upload';
  // Send the request & save response to $resp
  $api_response = $this->curlhandler->post_multipart_helper( $url, $post_data );
  if($api_response !== false) {
    $xml = simplexml_load_string( $api_response );
    $this->responsetype = 'alert alert-success';
    $this->responsecode = -1;
    $this->response = 'Data was uploaded with id: ';
    if( property_exists( $xml->children('oml', true), 'code' ) ) {
      $this->responsetype = 'alert alert-danger';
      $this->responsecode = $xml->children('oml', true)->code;
      $this->response = 'Error '.$this->responsecode.': '.$xml->children('oml', true)->message;
      if($this->responsecode=='131') $this->response .= ' Please fill in all required (red) fields, upload a file or give a URL (not both), and avoid spaces in the dataset name.';
    } else if($xml->children('oml', true)->id){
      $this->response = '<h2><i class="fa fa-thumbs-o-up"></i> Thanks!</h2>Data was uploaded successfully.<br>You can now <a href="d/'. $xml->children('oml', true)->id . '"> follow your dataset on OpenML</a>, track its impact and see all ensuing results.<br><br>You can also continue to add datasets below.';
      sm($this->response);  
      su('new/data');
    } else {
      print "Something went wrong. Server says:<br>";
      print $api_response;
    }
  } else{
    $this->responsetype = 'alert alert-danger';
    $this->response = 'Could not upload data. Please fill in all required (red) fields.';
  }
}

?>
