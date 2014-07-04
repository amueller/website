<?php
class Data extends CI_Controller {
  
  function __construct() {
        parent::__construct();
    
    $this->controller = strtolower(get_class ($this));
    $this->nr_segments = count($this->uri->segments);
    
    $this->load->Model('Dataset');
    $this->load->Model('File');
    $this->load->Model('Implementation');
    $this->load->Model('Author');
  }
  
  function download($id,$name) {
    $file = $this->File->getById($id);
    if($file === false || file_exists(DATA_PATH . $file->filepath) === false ) {
      $this->_error404();
    } else {
      $this->_header_download($file);
      $this->_readfile_chunked(DATA_PATH . $file->filepath);
    }
  }
  
  function view($id,$name) {
    $file = $this->File->getById($id);
    if($file === false || file_exists(DATA_PATH . $file->filepath) === false ) {
      $this->_error404();
    } else {
      header('Content-type: ' . $file->mime_type);
      header('Content-Length: ' . $file->filesize);
      readfile(DATA_PATH . $file->filepath);
    }
  }
  
  function _error404() {
    header("Status: 404 Not Found");
    $this->load->view('404');
  }
  
  function _header_download($file) {
    header('Content-Description: File Transfer');
    header('Content-Type: ' . $file->mime_type);
    header('Content-Disposition: attachment; filename='.basename($file->filename_original));
//    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . $file->filesize);
  }
  
  function _readfile_chunked($filename,$retbytes=true) {
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
      @flush();
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
