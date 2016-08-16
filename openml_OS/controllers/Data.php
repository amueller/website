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
    $this->load->Model('Api_session');

    $this->load->helper('file_upload');

    // authentication
    $this->provided_hash = $this->input->get_post('api_key') != false;
    $this->provided_valid_hash = $this->Author->getWhere( 'session_hash = "' . $this->input->get_post('api_key') . '"' ); // TODO: and add date?
    $this->authenticated = $this->provided_valid_hash || $this->ion_auth->logged_in();
    $this->user_id = false;
    if($this->provided_valid_hash) {
      $this->user_id = $this->provided_valid_hash[0]->id;
    } elseif($this->ion_auth->logged_in()) {
      $this->user_id = $this->ion_auth->user()->row()->id;
    }
  }

  function download($id,$name = 'undefined') {
    $file = $this->File->getById($id);
    if( $this->_check_rights( $file ) ) {
      if($file === false || file_exists(DATA_PATH . $file->filepath) === false ) {
        $this->_error404();
      } else {
        $this->_header_download($file);
        readfile_chunked(DATA_PATH . $file->filepath);
      }
    } else {
      $this->_error403();
    }
  }

  function view($id,$name = 'undefined') {
    $file = $this->File->getById($id);
    if( $this->_check_rights( $file ) ) {
      if($file === false || file_exists(DATA_PATH . $file->filepath) === false ) {
        $this->_error404();
      } else {
        header('Content-type: ' . $file->mime_type);
        header('Content-Length: ' . $file->filesize);
        readfile(DATA_PATH . $file->filepath);
      }
    } else {
      $this->_error403();
    }
  }

  private function _check_rights( $file ) {
    if( $file->access_policy == 'public' ) {
      return true;
    }

    if( $this->ion_auth->is_admin( $this->user_id ) ) {
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

  private function _header_download($file) {
    header('Content-Description: File Transfer');
    header('Content-Type: ' . ($file->extension == 'arff' ? 'text/plain' : $file->mime_type));
    header('Content-Disposition: attachment; filename='.basename($file->filename_original));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . $file->filesize);
  }
}
?>
