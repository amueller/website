<?php
class Api_splits extends CI_Controller {
  
  function __construct() {
    parent::__construct();
    
    $this->directory = DATA_PATH . 'splits/';
    
    if( file_exists( $this->directory ) == false ) {
      mkdir( $this->directory, 0755, true );
    }
    
    $this->load->model('Dataset');
    $this->load->model('Task');
    $this->load->model('Task_inputs');
    $this->load->model('Estimation_procedure');
    $this->load->model('Log');
    $this->load->model('Run');
    
    $this->load->helper('file_upload');
    
    $this->db = $this->load->database('read',true);
    $this->task_types = array( 1, 2, 3, 6, 7 );
    $this->evaluation = PATH . APPPATH . 'third_party/OpenML/Java/evaluate.jar';
    $this->config = " -config 'cache_allowed=false;server=http://www.openml.org/;api_key=".API_KEY."' ";
  }
  
  function different_predictions($run_ids) {
    if (is_safe($run_ids) == false) {
      die('run id input not safe. ');
    } 
    
    $runs = $this->Run->getWhere('`rid` IN (' . $run_ids . ')');
    if (count($runs) == 0) {
      die('no runs found.');
    }
    
    $task_id = $runs[0]->task_id;
    
    $command = 'java -jar '.$this->evaluation.' -f "different_predictions" -t ' . $task_id . ' -r ' . $run_ids . $this->config;
    
    $this->Log->cmd( 'API Splits::different_predictions(' . $run_ids . ')', $command );
    
    if( function_enabled('system') ) {
      header('Content-type: text/plain');
      system( CMD_PREFIX . $command );
    } else {
      die('failed to generate arff file: php "system" function disabled. ');
    }
  }
  
  function all_wrong($run_ids) {
    if (is_safe($run_ids) == false) {
      die('run id input not safe. ');
    } 
    
    $runs = $this->Run->getWhere('`rid` IN (' . $run_ids . ')');
    if (count($runs) == 0) {
      die('no runs found.');
    }
    
    $task_id = $runs[0]->task_id;
    
    $command = 'java -jar '.$this->evaluation.' -f "all_wrong" -t ' . $task_id . ' -r ' . $run_ids . $this->config;
    
    $this->Log->cmd( 'API Splits::all_wrong(' . $run_ids . ')', $command );
    
    if( function_enabled('system') ) {
      header('Content-type: text/plain');
      system( CMD_PREFIX . $command );
    } else {
      die('failed to generate arff file: php "system" function disabled. ');
    }
  }
  
  function get( $task_id ) {
    $filepath = $this->directory . '/' . $task_id . '.arff';
    if( file_exists( $filepath ) == false ) {
      $this->generate( $task_id, $filepath );
    }
    
    header('Content-type: text/plain');
    header('Content-Length: ' . filesize( $filepath ) );
    readfile_chunked( $filepath );
  }
  
  function md5( $task_id ) {
    $filepath = $this->directory . '/' . $task_id . '.arff';
    if( file_exists( $filepath ) == false ) {
      $this->generate( $task_id, $filepath );
    }
    
    echo md5_file( $filepath );
  }
  
  private function generate( $task_id, $filepath = false ) {
    $task = $this->Task->getById( $task_id );
    if( $task === false || in_array( $task->ttid, $this->task_types ) === false ) {
      die('Task not providing datasplits.');
    }
    $values = $this->Task_inputs->getTaskValuesAssoc( $task_id );
    
    $estimation_procedure = null;
    if( array_key_exists( 'estimation_procedure', $values ) ) {
      $estimation_procedure = $this->Estimation_procedure->getById( $values['estimation_procedure'] );
    }
    
    if($estimation_procedure == false) {
      die('estimation procedure not found');
    }
    
    $dataset = $this->Dataset->getById( $values['source_data'] );
    $epstr = $this->Estimation_procedure->toString( $estimation_procedure );
    $target_feature = ( $task->ttid == 7 ) ? $values['target_feature_event'] : $values['target_feature'];
    
    // TODO: very important. sanity check input
    $testset_str = array_key_exists('custom_testset', $values) && is_cs_natural_numbers($values['custom_testset']) ?  '-test "' . $values['custom_testset'] . '"' : '';
    
    $command = 'java -jar '.$this->evaluation.' -f "generate_folds" -d "'.$dataset->url.'" -e "'.$epstr.'" -c "'.$target_feature.'" ' . $testset_str . $this->config; 
    
    if (array_key_exists('custom_testset', $values)) {
      $command .= '-test "' . $values['custom_testset'] . '" ';
    }
    
    if( $filepath ) $command .= ' -o ' . $filepath;
    //if( $md5 ) $command .= ' -m';
    $this->Log->cmd( 'API Splits::get(' . $task_id . ')', $command );
    
    if( function_enabled('system') ) {
      header('Content-type: text/plain');
      system( CMD_PREFIX . $command );
    } else {
      die('failed to generate arff file: php "system" function disabled. ');
    }
  }
}
?>
