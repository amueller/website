<?php
class Files extends CI_Controller {
  
  function __construct() {
    parent::__construct();
    
    $this->controller = strtolower(get_class ($this));
    $this->nr_segments = count($this->uri->segments);
    
    $this->load->Model('Dataset');
    $this->load->Model('File');
    $this->load->Model('Implementation');
    $this->load->Model('Author');
    $this->load->Model('Api_session');
    
    // authentication
    $this->provided_hash = $this->input->get_post('session_hash') != false;
    $this->provided_valid_hash = $this->Api_session->isValidHash( $this->input->get_post('session_hash') );
    $this->authenticated = $this->provided_valid_hash || $this->ion_auth->logged_in();
    $this->user_id = false;
    if($this->provided_valid_hash) {
      $this->user_id = $this->Api_session->getByHash( $this->input->get_post('session_hash') )->author_id;
    } elseif($this->ion_auth->logged_in()) {
      $this->user_id = $this->ion_auth->user()->row()->id;
    }
  }
  
  function download($id,$name) {
    $file = $this->File->getById($id);
    if( $this->_check_rights( $file ) ) {
      if($file === false || file_exists(DATA_PATH . $file->filepath) === false ) {
        $this->_error404();
      } else {
        $this->_header_download($file->filename_original,$file->filesize);
        $this->_readfile_chunked(DATA_PATH . $file->filepath);
      }
    } // else, an appropriate message is shown. 
  }
  
  function view($id,$name) {
    $file = $this->File->getById($id);
    if( $this->_check_rights( $file ) ) {
      if($file === false || file_exists(DATA_PATH . $file->filepath) === false ) {
        $this->_error404();
      } else {
        header('Content-type: ' . $file->mime_type);
        header('Content-Length: ' . $file->filesize);
        readfile(DATA_PATH . $file->filepath);
      }
    } // else, an appropriate message is shown. 
  }
  
  private function _check_rights( $file ) {
    if( $file->access_policy == 'public' ) {
      return true;
    }
    
    elseif( $file->access_policy == 'private' ) {
      if( $this->user_id == $file->creator ) {
        return true;
      } else {
        $this->_error403();
      }
    }
    
    elseif( $file->access_policy == 'deleted' ) {
      $this->_error404();
    }
    
    elseif( $file->access_policy == 'none' ) {
      $this->_error403();
    }
  }
  
  private function _error404() {
    header("Status: 404 Not Found");
    $this->load->view('404');
  }
  
  private function _error403() {
    header("Status: 403 Forbidden");
    $this->load->view('403');
  }
  
  private function _header_download($filename,$filesize) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($filename));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . $filesize);
  }
  
  private function _readfile_chunked($filename,$retbytes=true) {
    $chunksize = 1*(1024*1024); // how many bytes per chunk
    $buffer = '';
    $cnt =0;
    
    $handle = fopen($filename, 'rb');
    if ($handle === false) {
      return false;
    }
    while (!feof($handle)) {
      $buffer = fread($handle, $chunksize);
      echo $buffer;
      @ob_flush();
      flush();
      if ($retbytes) {
        $cnt += strlen($buffer);
      }
    }
    $status = fclose($handle);
    if ($retbytes && $status) {
      return $cnt; // return num. bytes delivered like readfile() does.
    }
    return $status;
  }
}
?>
