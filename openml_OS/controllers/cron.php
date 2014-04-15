<?php
class Cron extends CI_Controller {
  
  function __construct() {
    parent::__construct();
    
    $this->controller = strtolower(get_class ($this));
    
    $this->load->model('Dataset');
    $this->load->model('Data_feature');
    $this->load->model('Data_quality');
    $this->load->model('Run');
    $this->load->model('Log');
    
    $this->load->helper('Api');
    $this->load->helper('File_upload');
    
    // TODO: copied from rest_api, for functionality in cron.
    $this->data_tables = array( 'dataset','evaluation','evaluation_fold', 'evaluation_sample', 'runfile');
    $this->supportedMetrics = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
    $this->supportedAlgorithms = $this->Algorithm->getColumn('name');
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
    $models = array(
      'Algorithm',
      'Algorithm_setup',
      'Estimation_procedure',
      'Implementation',
      'Implementation_component',
      'Input',
      'Input_setting',
      'Math_function',
      'Quality',
      'Task_type',
      'Task_type_function',
      'Task_type_io',
      'Schedule'
    );
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
  function process_dataset( $did = false ) {
    if( $did == false ) {
      $datasets = $this->Dataset->getWhere( '`error` = "false"', '`processed` ASC, `did` ASC' );
    } else {
      $datasets = $this->Dataset->getWhere( '`did` = "' . $did . '"' );
    }
    
    $processed = 0;
    if( is_array( $datasets ) ) {
      foreach( $datasets as $d ) {
        $alreadyProcessed = $d->processed !== null;
        $message = false;
        
        $res = $this->Dataset->process( $d->did, $alreadyProcessed, $message );
        if( $res === true ) {
          $this->Log->cronjob( 'success', 'process_dataset', 'Did ' . $d->did . ' processed successfully. '  );
        } else {
          $this->Dataset->update( $d->did, array( 'processed' => now(), 'error' => 'true' ) );
          $this->_error( 'dataset', $d->did, $message );
        }
        if(++$processed == 5 || $alreadyProcessed ) break;
      }
    }
  }
  
  function process_run( $rid = false ) {
    if( $rid == false ) {
      $runs = $this->Run->getWhere( '`error` IS NULL AND `processed` IS NULL' );
    } else {
      $runs = $this->Run->getWhere( '`rid` = "'.$rid.'"');
    }
    
    $processed = 0;
    if( is_array( $runs ) ) {
      foreach( $runs as $r ) {
        if(++$processed > 5 )break;
        $code = 0;
        $message = false;
        
        $res = $this->Run->process( $r->rid, $code, $message );
        if( $res == true ) {
          $this->Log->cronjob( 'success', 'process_run', 'Rid ' . $r->rid . ' processed successfully. '  );
        } else {
          $this->_error( 'run', $r->rid, 'Error code ' . $code . ': ' . $message );
        }
      }
    }
  }
  
  private function _error($type, $did, $message) {
    $this->Log->cronjob( 'error', 'process_' . $type, 'Id ' . $did . ' processed with error: ' . $message );
    // TODO: email user about the error that occurred. 
  }
}
?>
