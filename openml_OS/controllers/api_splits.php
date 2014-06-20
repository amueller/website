<?php
class Api_splits extends CI_Controller {
  
  function __construct() {
    parent::__construct();
    
    $this->load->model('Dataset');
    $this->load->model('Task');
    $this->load->model('Task_inputs');
    $this->load->model('Estimation_procedure');
    $this->load->model('Task_type_io');
    $this->load->model('Log');
    
    $this->db = $this->load->database('read',true);
    $this->task_types = array( 1, 2, 3 );
    $this->evaluation = PATH . APPPATH . 'third_party/OpenML/Java/evaluate.jar';
  }
  
  function get( $task_id, $estimation_procedure_id ) {
    $this->generate( $task_id, $estimation_procedure_id, false );
  }
  
  function md5( $task_id, $estimation_procedure_id ) {
    $this->generate( $task_id, $estimation_procedure_id, true );
  }
  
  private function generate( $task_id, $estimation_procedure_id, $md5 ) {
    $task = $this->Task->getById( $task_id );
    if( $task === false || in_array( $task->ttid, $this->task_types ) === false ) {
      die('Task not providing datasplits.');
    }
    $values = $this->Task_inputs->getTaskValuesAssoc( $task_id );
    $estimation_procedure = $this->Estimation_procedure->getById( $estimation_procedure_id );
    
    if($estimation_procedure == false) {
      die('estimation procedure not found');
    }
    
    $dataset = $this->Dataset->getById( $values[1] );
    $epstr = $this->Estimation_procedure->toString( $estimation_procedure );

    $command = 'java -jar '.$this->evaluation.' -f "generate_folds" -d "'.$dataset->url.'" -e "'.$epstr.'" -c "'.$values[2].'" -r "'.$dataset->row_id_attribute.'"';
    if( $md5 ) $command .= ' -m';
    $this->Log->cmd( 'API Splits::get(' . $task_id . ')', $command );
    
    if( function_enabled('system') ) {
      header('Content-type: text/plain');
      system( CMD_PREFIX . $command );
    } else {
      die('failed to generate arff file. ');
    }
  }
}
?>
