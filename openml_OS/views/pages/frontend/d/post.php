<?php 
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
	$url = 'http://localhost:4567/edit/'.$this->wikipage;
  elseif($this->input->post('versions'))
	$url = 'http://localhost:4567/compare/'.$this->wikipage;

//call gollum
  $api_response = $this->curlhandler->post_multipart_helper( $url, $post_data );

//sync DB, search index
  if($this->input->post('content')){
	//update database - TO DO: check if there is a better way
  	$this->Dataset->query('update dataset set description = "'.addslashes($this->input->post('content')).'"');

	//update index
  	$this->elasticsearch->index('data', $this->id);
  }

//save successful, redirect to detail page
  if($this->input->post('content'))
  	header('Location: '.BASE_URL.'d/'.$this->id);
?>
