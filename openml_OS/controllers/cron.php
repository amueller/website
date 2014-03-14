<?php
class Cron extends CI_Controller {
  
  function __construct() {
    parent::__construct();
    
    $this->controller = strtolower(get_class ($this));
    
    $this->load->model('Dataset');
    $this->load->model('Data_features');
    $this->load->model('Data_quality');
    $this->load->model('Run');
    $this->load->model('Log');
    
    $this->load->helper('Api');
  }
  
  function build_search_index() {
    if( file_exists(DATA_PATH.'search_index') === false ) {
      $cd = mkdir(DATA_PATH.'search_index');
    }
    $command = 'java -jar '.APPPATH.'third_party/OpenML/Java/luceneSearch.jar index -index '.DATA_PATH.'search_index -server '. DB_HOST_EXPDB .' -database '. DB_NAME_EXPDB .' -username "'. DB_USER_EXPDB_READ .'" -password "' . DB_PASS_EXPDB_READ . '"';
    $code = 0;
    $res = array();
    
    $this->Log->cmd( 'Build Search Index', $command ); 
    if(function_enabled('exec') === false ) {
      return false;
    }
    exec( CMD_PREFIX . $command,$res,$code);
    
    if( $code == 0 ) {
      $this->Log->cronjob( 'success', 'build_search_index', 'Created a new search index. Java response suppressed. ' );
    } else {
      $this->Log->cronjob( 'error', 'build_search_index', 'Failed to create a search index. Java response: ' . arr2string( $res ) );
    }
  }
  
  function install_database() {
    // TODO: we might scan the directory and pick up all models that contain a SQL file. Decide later. 
    $models = array('Algorithm','Estimation_procedure','Implementation','Math_function','Quality','Task_type','Task_type_function','Task_type_io');
    foreach( $models as $m ) {
      $this->load->model( $m );
      if( $this->$m->get() === false ) {
        $file = DATA_PATH . 'sql/' . strtolower( $m ) . '.sql';
        if( file_exists( $file ) ) {
          $sql = file_get_contents( $file );
          $result = $this->Dataset->query( $sql );
        }
      }
    }
  }
  
  // manually perform this cronjob. Type the following command:
  // cronjob command: wget -O - http://openml.liacs.nl/cron/process_dataset
  // or CLI  command: watch -n 10 "wget -O - http://openml.liacs.nl/cron/process_dataset" (specify server correct)
  function process_dataset() {
    $datasets = $this->Dataset->getWhere( 'error = "false"', '`processed` ASC, `did` ASC' );
    
    $processed = 0;
    if( is_array( $datasets ) ) {
      foreach( $datasets as $d ) {
        if(++$processed > 5 )break;
        $message = false;
        
        $res = $this->Dataset->process( $d->did, $message );
        if( $res === true ) {
          $this->Log->cronjob( 'success', 'process_dataset', 'Did ' . $d->did . ' processed successfully. '  );
        } else {
          $this->_error( $d->did, $message );
        }
      }
    }
  }
  
  function process_run() {
    $runs = $this->Run->getWhere( '`error` IS NULL AND `processed` IS NULL' );
    
    $processed = 0;
    if( is_array( $runs ) ) {
      foreach( $runs as $r ) {
        if(++$processed > 5 )break;
        $code = 0;
        $message = false;
        
        $res = $this->Run->process( $r->rid, $code, $message );
        if( $res === true ) {
          $this->Log->cronjob( 'success', 'process_run', 'Rid ' . $r->rid . ' processed successfully. '  );
        } else {
          $this->_error( $r->rid, 'Error code ' . $code . ': ' . $message );
        }
      }
    }
  }
  
  private function _error($did, $message) {
    $this->Dataset->update( $did, array( 'processed' => now(), 'error' => 'true' ) );
    $this->Log->cronjob( 'error', 'process_dataset', 'Did ' . $did . ' processed with error: ' . $message );
    // TODO: email user about the error that occurred. 
  }
}
?>
