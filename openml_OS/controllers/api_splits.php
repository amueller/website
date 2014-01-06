<?php
class Api_splits extends CI_Controller {
	
	function __construct() {
        parent::__construct();
		
		$this->load->model('Dataset');
		$this->load->model('Task');
		$this->load->model('Task_values');
		$this->load->model('Estimation_procedure');
		$this->load->model('Task_type_io');
		$this->load->model('Log');
		
		$this->db = $this->load->database('read',true);
		$this->task_types = array( 1, 2 );
		$this->evaluation = APPPATH . 'third_party/OpenML/Java/evaluate.jar';
	}
	
	function get( $task_id ) {
		$task = $this->Task->getById( $task_id );
		if( $task === false || in_array( $task->ttid, $this->task_types ) === false ) {
			die('Task not providing datasplits.');
		}
		$values = $this->Task_values->getTaskValuesAssoc( $task_id );
		/* TODO: values is a bit tricky here, since these numbers must never change. 
		 * values[1] - did
         * values[2] - target attribute
         * values[3] - evaluation_type
		 * values[4] - splits url. *THIS* url
         * values[5] - repeats
         * values[6] - folds
         * values[7] - percentage
		 * values[8] - stratified
		 */
		
		$task_type  = 'ttid = ' . $task->ttid;
		$type    	= ' AND type  = "' . $values[3] . '"';
		$repeats 	= ' AND repeats ' . (($values[5] == NULL) ? ' IS NULL ' : ' = ' . $values[5]);
		$folds   	= ' AND folds ' . (($values[6] == NULL) ? ' IS NULL ' : ' = ' . $values[6]);
		$percentage = ' AND percentage ' . (($values[7] == NULL) ? ' IS NULL ' : ' = ' . $values[7]);
		$stratified = ' AND stratified_sampling ' . (($values[8] == NULL) ? ' IS NULL ' : ' = ' . $values[8]);
		
		$estimation_procedure = $this->Estimation_procedure->get_by_parameters( $task->ttid, $values[3], $values[5], $values[6], $values[7], $values[8] );
		if($estimation_procedure == false) {
			die('estimation procedure not found');
		}
		
		$dataset = $this->Dataset->getById( $values[1] );
		$epstr = $this->Estimation_procedure->toString( $estimation_procedure );

		$command = 'java -jar '.$this->evaluation.' -f "generate_folds" -d "'.$dataset->url.'" -e "'.$epstr.'" -c "'.$values[2].'" -r "'.$dataset->row_id_attribute.'"';
    	$this->Log->cmd( 'API Splits::get(' . $task_id . ')', $command ); 
		
		if( function_enabled('system') ) {
			header('Content-type: text/plain');
			system( $command );
		} else {
			die('failed to generate arff file. ');
		}
	}
}
?>
