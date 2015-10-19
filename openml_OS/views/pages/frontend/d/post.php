<?php

//Add and remove tags
if(isset($_POST["newtags"]) and !empty($_POST["newtags"])){
  $post_data = array('session_hash' => $this->Api_session->createByUserId( $this->ion_auth->user()->row()->id ));
  $url = BASE_URL.'/api/?f=openml.data.tag&data_id='.$this->id.'&tag='.$_POST["newtags"];
  $api_response = $this->curlhandler->post_helper($url,$post_data);
  redirect('d/'.$this->id);
}
elseif(isset($_POST["deletetag"]) and !empty($_POST["deletetag"])){
  $post_data = array('session_hash' => $this->Api_session->createByUserId( $this->ion_auth->user()->row()->id ));
  $url = BASE_URL.'/api/?f=openml.data.untag&data_id='.$this->id.'&tag='.$_POST["deletetag"];
  $api_response = $this->curlhandler->post_helper($url,$post_data);
  redirect('d/'.$this->id);
}
// Description edit
elseif($this->input->post('page') or $this->input->post('versions')){
// prepare to send data to gollum
  //$session_hash = $this->Api_session->createByUserId( $this->ion_auth->user()->row()->id );

  $message = ($this->input->post('message') != 'Write a small message explaining the change.' ? $this->input->post('message') : '[no message]');

  $post_data = array(
      'page' => $this->input->post('page'),
      'path' => $this->input->post('path'),
      'content' => $this->input->post('content'),
      'message' => $this->editor.': '.$message );

if($this->input->post('versions')){
  foreach($this->input->post('versions') as $k => $v){
	$post_data['versions['.$k.']'] = $v;
  }
}

// check whether we are sending new data or requesting comparison
  if($this->input->post('content'))
	$url = 'http://wiki.openml.org/edit/'.$this->wikipage;
  if($this->input->post('versions'))
	$url = 'http://wiki.openml.org/compare/'.$this->wikipage;

//call gollum
  $api_response = $this->curlhandler->post_multipart_helper( $url, $post_data );

//sync DB, search index
  if($this->input->post('content')){
	//update database - TO DO: check if there is a better way
  	$this->Dataset->query('update dataset set description = "'.addslashes($this->input->post('content')).'" where did='.$this->id);

	//update index
  	$this->elasticsearch->index('data', $this->id);
  }

//save successful, redirect to detail page
  if($this->input->post('content'))
  	header('Location: '.BASE_URL.'d/'.$this->id);
}


// Dataset update
else{

  $session_hash = $this->Api_session->createByUserId( $this->ion_auth->user()->row()->id );

  $description = $this->dataoverview->generate_xml(
    'data_set_description',
    $this->config->item('xml_fields_dataset_update')
  );
  $post_data = array(
      'description' => $description,
      'session_hash' => $session_hash
  );
  if( $_FILES['dataset']['error'] == 0 ) {
      $post_data['dataset'] = '@' . $_FILES['dataset']['tmp_name'];
  }
  //if data file didn't change, §insert the old url
  //if(!$this->input->post('url') && (!file_exists($_FILES['dataset']['tmp_name']) || !is_uploaded_file($_FILES['dataset']['tmp_name']))) {
  //	$post_data['url'] = = $this->record->{'url'};
  //}

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
      $this->response = 'Error '.$this->responsecode.': '.$xml->children('oml', true)->message . '. Please fill in all required (red) fields, upload a file or give a URL (not both), and avoid spaces in the dataset name.';
    } else if($xml->children('oml', true)->id){
      $this->response = '<h2><i class="fa fa-thumbs-o-up"></i> Great!</h2>Your data set was updated successfully. OpenML is currently reanalyzing the data. Refresh the page in a few minutes.';
      sm($this->response);
      su('d/'.$this->id);
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
