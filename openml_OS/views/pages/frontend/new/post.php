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
  $required_inputs = $this->Task_type_inout->getWhere( '`io` = "input" AND `requirement` <> "hidden" AND `ttid` = "'.$ttid.'"' );
  $inputs = array();
  foreach( $required_inputs as $i ) {
    if( $i->requirement == 'optional' && $this->input->post($i->name) == false ) { continue; }
    $inputs[$i->name] = $this->input->post($i->name);
  }

  $constraints = $this->Dataset->nameVersionConstraints( $this->input->post( 'source_data' ), 'd' );
  $target_feature = '`d`.`default_target_attribute`';
  if( trim( $this->input->post( 'target_feature' ) ) ) {
    $target_feature = '"'.trim( $this->input->post( 'target_feature' ) ).'"';
  } else {
    unset( $inputs['target_feature'] );
  }
  // TODO: stupid mapping, add logic in DB instead of here. 
  if( $ttid == 2 ) { // exception. 
    $datatype = array( 'numeric' );
  }

  $sql = 
    'SELECT `d`.`did`, `f`.`name` ' . 
    'FROM `dataset` `d`,`data_feature` `f` ' . 
    'WHERE `d`.`did` = `f`.`did` ' .
    'AND `f`.`name` = ' . $target_feature . ' ' .
    'AND `f`.`data_type` IN ("' . implode( '","', $datatype ) . '") ' . 
    'AND ' . $constraints . ' ' .
    'ORDER BY `did`;';

  $datasets = $this->Dataset->query( $sql );

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
    
    $new_tasks = $this->Task->create_batch( $ttid, $results );
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

$fields =  ['name','description','format','creator','contributor','collection_date','licence','default_target_attribute','row_id_attribute','version_label','citation','visibility','original_data_url','paper_url'];
$imploded = [false,false,false,true,true,false,false,false,false,false,false,false,false,false,false];

$xml = new SimpleXMLElement('<oml:data_set_description xmlns:oml="http://openml.org/openml"/>');

for($i = 0; $i < sizeof($fields); $i+=1) {
	if(!$imploded[$i]){
		$xml->addChild('oml:'.$fields[$i], $this->input->post($fields[$i]));
	}
	else{
		$pieces = explode(',', $this->input->post($fields[$i]));
		foreach($pieces as $element){
			$xml->addChild('oml:'.$fields[$i], trim($element) );
		}
	}
}

// TODO: This is a temporarily fix
$session_hash = $this->Api_session->createByUserId( $this->ion_auth->user()->row()->id );

// TODO: handle url i.s.o. file

$post_data = array(
    'description' => $xml->asXML(),
    'session_hash' => $session_hash,
    'dataset' => '@' . $_FILES['dataset']['tmp_name']
);

$url = BASE_URL.'/api/?f=openml.data.upload';

// Send the request & save response to $resp

$api_response = $this->curlhandler->post_multipart_helper( $url, $post_data );

$xml = simplexml_load_string( $api_response );

$this->responsetype = 'alert succes';
$this->responsecode = -1;
$this->response = 'Data was uploaded with id: ';
if( property_exists( $xml->children('oml', true), 'code' ) ) {
  $this->responsetype = 'alert error';
  $this->responsecode = $xml->children('oml', true)->code;
  $this->response = $xml->children('oml', true)->message;
} else {
  $this->response .= $xml->children('oml', true)->id;
}

// TODO: handle code and give special message

/**
$errorCodes = new array();
$errorCodes[131] = 'Please make sure that all mandatory (red) fields are filled in. Don\'t use spaces in name or version fields. (Error 131) ';
$errorCodes[135] = 'Please make sure that all mandatory (red) fields are filled in. Don\'t use spaces in name or version fields. (Error 135) ';
$errorCodes[137] = 'Please login first.';
$errorCodes[138] = 'Please login first.';

var message = '';
var status = '';
if($(responseText).find('id, oml\\:id').text().length) {
	message = type + ' uploaded successfully. <a href="d/' + $(responseText).find('id, oml\\:id').text() + '">View online.</a>';
	status = 'alert-success';
} else {
	var errorcode = $(responseText).find('code, oml\\:code').text();
	var errormessage = $(responseText).find('message, oml\\:message').text();
	status = 'alert-warning';
	if(errorcode in errorCodes) {
		message = errorCodes[errorcode];
	} else {
		message = 'Errorcode ' + errorcode + ': ' + errormessage;
	}
}
$('#response'+type+'Txt').removeClass();
$('#response'+type+'Txt').addClass('alert');
$('#response'+type+'Txt').addClass(status);
$('#response'+type+'Txt').html(message);
}
**/

}

?>
