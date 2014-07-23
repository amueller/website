<?php
class Cron extends CI_Controller {
  
  function __construct() {
    parent::__construct();
    
    $this->controller = strtolower(get_class ($this));
    
    $this->load->model('Dataset');
    $this->load->model('Log');
    
    $this->load->helper('File_upload');
    $this->load->helper('directory');
  }
  
  
  function install_database() {
    // TODO: we might scan the directory and pick up all models that contain a SQL file. Decide later. 
    $models = directory_map(DATA_PATH . 'sql/', 1);
    
    
    foreach( $models as $m ) {
      $modelname = ucfirst( substr( $m, 0, strpos( $m, '.' ) ) );
      if( $this->load->is_model_loaded( $modelname ) == false ) { $this->load->model( $modelname ); }
      if( $this->$modelname->get() === false ) {
        $sql = file_get_contents( DATA_PATH . 'sql/' . $m );
        $result = $this->Dataset->query( $sql );
      }
    }
  }
  
  
  private function _error($type, $did, $message) {
    $this->Log->cronjob( 'error', 'process_' . $type, 'Id ' . $did . ' processed with error: ' . $message );
    // TODO: email user about the error that occurred. 
  }
}
?>
