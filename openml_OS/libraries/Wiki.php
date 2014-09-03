<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wiki {

  public function __construct() {
    $this->CI = &get_instance();
    $this->CI->load->model('Dataset');
    $this->db = $this->CI->Dataset;
    $this->userdb = $this->CI->Author;
    $this->wiki_path = '/Library/WebServer/Documents/wiki/';
    //$this->wiki_path = '/openmldata/weblog/wiki/';
    $this->CI->load->helper('file');
    $this->CI->load->Library('curlHandler');
  }

  public function export_to_wiki($id){

        $d = $this->db->getByID($id);
        $user = $this->userdb->getById($d->uploader);
	$wikipage = $d->name.'-'.$d->version;
	$preamble = '**Author**: '.trim($d->creator, '"').'  '.PHP_EOL;
	if($d->contributor)
		$preamble .= trim($d->contributor, '"').'  '.PHP_EOL;
	$preamble .= '**Source**: '.($d->original_data_url ? '[original]('.$d->original_data_url.')' : 'Unknown').' - '.$d->collection_date.'  '.PHP_EOL.PHP_EOL;
	$preamble .= '**Please cite**: '.$d->citation.'  '.PHP_EOL;
	
	$data = $d->description;

	$post_data = array(
	      'page' => $wikipage,
	      'path' => '/',
	      'content' => $preamble.$data,
	      'format' => 'md',
	      'message' => 'Automatically added');

	$url = 'http://localhost:4567/create';

	//call gollum
  	$api_response = $this->CI->curlhandler->post_multipart_helper( $url, $post_data );
	if(strlen($api_response)>0)
		return $api_response;

	return "Successfully added ".$wikipage;
  }
}
