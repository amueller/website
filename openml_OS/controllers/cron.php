<?php
class Cron extends CI_Controller {

  function __construct() {
    parent::__construct();

    $this->controller = strtolower(get_class ($this));

    $this->load->model('Dataset');
    $this->load->model('Log');

    $this->load->model('Meta_dataset');
    $this->load->model('File');

    $this->load->helper('file_upload');
    $this->load->helper('text');
    $this->load->helper('directory');

    $this->load->library('email');
    $this->email->from( EMAIL_FROM, 'The OpenML Team');

    $this->load->model('Algorithm_setup');
    $this->load->model('File');
    $this->load->model('Data_quality');
    $this->load->model('Implementation');
    $this->load->model('Math_function');
    $this->load->model('Schedule');
    $this->load->model('Study');
    $this->load->model('Task');
    $this->load->model('Task_type');
    $this->load->model('Task_type_inout');
    $this->load->model('Estimation_procedure');
    $this->load->model('Run');
    $this->load->Library('elasticSearch');
    $this->load->Library('elasticSearchLibrary');

    $this->dir_suffix = 'dataset/cron/';
  }

  public function index($type, $id = false){
      $time_start = microtime(true);

      if(!$id){
        echo "starting ".$type." indexer";
        $this->elasticsearch->index($type);
      } else {
        echo "starting ".$type." indexer from id ".$id;
        $this->elasticsearch->index($type, $id);
      }

      $time_end = microtime(true);
      $time = $time_end - $time_start;
      echo "\nIndexing done in $time seconds\n";
  }

  public function indexfrom($type, $id = false){
      if(!$id){
        echo "starting ".$type." indexer";
        $this->elasticsearch->index($type);
      } else {
        echo "starting ".$type." indexer from id ".$id;
        $this->elasticsearch->index_from($type, $id);
      }
  }

  function install_database() {
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

  function create_meta_dataset( $id = false ) {
    if( $id == false ) {
      $meta_dataset = $this->Meta_dataset->getWhere( 'processed IS NULL' );
      echo 'No id specified, requesting first dataset in queue.' . "\n";
    } else {
      $meta_dataset = $this->Meta_dataset->getWhere( 'id = "' . $id . '"' );
      echo 'Requesting dataset with id ' . $id . ".\n";
    }

    if( $meta_dataset ) {
      $meta_dataset = $meta_dataset[0];
      echo 'Processing meta-dataset with id ' . $meta_dataset->id . ".\n";
      $this->Meta_dataset->update( $meta_dataset->id, array( 'processed' => now() ) );
      $dataset_constr = ( $meta_dataset->datasets ) ? 'AND d.did IN (' . $meta_dataset->datasets . ') ' : '';
      $task_constr = ( $meta_dataset->tasks ) ? 'AND t.task_id IN (' . $meta_dataset->tasks . ') ' : '';
      $flow_constr = ( $meta_dataset->flows ) ? 'AND i.id IN (' . $meta_dataset->flows . ') ' : '';
      $setup_constr = ( $meta_dataset->setups ) ? 'AND s.sid IN (' . $meta_dataset->setups . ') ' : '';
      $function_constr = ( $meta_dataset->functions ) ? 'AND e.function IN (' . $meta_dataset->functions . ') ' : '';

      $quality_colum = 'data_quality';
      $evaluation_column = 'evaluation';
      $evaluation_keys = array( 'function' => 'e.function' );
      $quality_keys = array();

      if( $meta_dataset->task_type == 3 ) {
        $evaluation_keys = array(
          'repeat' => 'e.repeat',
          'fold' => 'e.fold',
          'sample' => 'e.sample',
          'sample_size' => 'e.sample_size',
          'function' => 'e.function'
        );

        $evaluation_column = 'evaluation_sample';
      }
      if( $meta_dataset->task_type == 4 ) {
        $evaluation_keys = array(
          'interval_start' => 'e.interval_start',
          'interval_end'   => 'e.interval_end',
          'function' => 'e.function'
        );
        $quality_keys = array(
          'interval_start' => 'q.interval_start',
          'interval_end'   => 'q.interval_end'
        );
        $quality_colum = 'data_quality_interval';
        $evaluation_column = 'evaluation_interval';

      }

      if ( create_dir(DATA_PATH . $this->dir_suffix) == false ) {
        $this->_error_meta_dataset( $meta_dataset->id, 'Failed to create data directory. ', $meta_dataset->user_id );
        return;
      }

      $tmp_path = '/tmp/' . rand_string( 20 ) . '.csv';

      if( $meta_dataset->type == 'qualities' ) {
        $quality_keys_string = '';
        if( $quality_keys ) {
          $quality_keys_string = implode( ', ', $quality_keys ) . ',';
          $quality_keys_key_string = '"' . implode( '", "', array_keys( $quality_keys ) ) . '",';
        }
        $sql =
          'SELECT "data_id", "task_id", "name", "quality", ' . $quality_keys_key_string . ' "value" ' .
          'UNION ALL ' .
          'SELECT d.did, t.task_id, d.name, q.quality, ' . $quality_keys_string . 'q.value ' .
          'FROM dataset d, '.$quality_colum.' q, task t, task_inputs i ' .
          'WHERE t.task_id = i.task_id ' .
          'AND i.input = "source_data" ' .
          'AND i.value = q.data ' .
          'AND d.did = q.data ' .
          'AND t.ttid = "' . $meta_dataset->task_type . '" ' .
          $dataset_constr . $task_constr .
          'INTO OUTFILE "'. $tmp_path .'" ' .
          'FIELDS TERMINATED BY "," ' .
          'ENCLOSED BY "\"" ' .
          'LINES TERMINATED BY "\n" ' .
          ';';
      } else {
        $sql =
          'SELECT "run_id", "setup_id", "task_id", "' . implode( '", "', array_keys( $evaluation_keys ) ) . '" ' .
          ', "value", "task_name", "flow_name" ' .
          'UNION ALL ' .
          'SELECT r.rid AS run_id, s.sid AS setup_id, t.task_id AS task_id, '.
          implode( ', ', $evaluation_keys ) . ', e.value '.
          ', CONCAT("Task_", t.task_id, "_", d.name), i.fullName '.
//          ',s.setup_string ' .
//          ',CONCAT(i.fullName, " on ", d.name) as textual '.
          'FROM run r, task t, task_inputs v, dataset d, algorithm_setup s, implementation i, '. $evaluation_column .' e '.
          'WHERE r.task_id = t.task_id AND v.task_id = t.task_id  '.
          'AND v.input = "source_data" AND v.value = d.did '.
          'AND r.setup = s.sid AND s.implementation_id = i.id '.
          'AND e.source = r.rid '.
          'AND t.ttid = "' . $meta_dataset->task_type . '"' .
          $dataset_constr . $task_constr . $flow_constr . $setup_constr . $function_constr .
           /* the GROUP BY line makes stuff slower, we might want to comment it out. */
          'GROUP BY r.setup, r.task_id, ' . implode( ',', $evaluation_keys ) . ' ' .
          'INTO OUTFILE "'. $tmp_path .'" ' .
          'FIELDS TERMINATED BY "," ' .
          'ENCLOSED BY "\"" ' .
          'LINES TERMINATED BY "\n" ' .
          ';';
      }

      $this->Dataset->query( $sql );
      $success = file_exists( $tmp_path );

      if( $success == false ) {
        $error = 'MySQL Error #' . $this->Dataset->mysqlErrorNo() . ': ' . $this->Dataset->mysqlErrorMessage();
        $this->_error_meta_dataset( $meta_dataset->id, $error, $meta_dataset->user_id );
        return;
      }

      $filename = getAvailableName( DATA_PATH . $this->dir_suffix, 'meta_dataset.csv' );
      $filepath = DATA_PATH . $this->dir_suffix . $filename;
      $success = rename( $tmp_path, $filepath );

      if( $success == false ) {
        $this->_error_meta_dataset( $meta_dataset->id, 'Failed to move csv to data directory. Filename: ' . $filename, $meta_dataset->user_id );
        return;
      }

      $file_id = $this->File->register_created_file( $this->dir_suffix, $filename, $meta_dataset->user_id, 'dataset', 'text/csv', 'private' );

      $this->Meta_dataset->update( $meta_dataset->id, array( 'file_id' => $file_id ) );

      $user = $this->ion_auth->user( $meta_dataset->user_id )->row();
      $this->email->to( $user->email );
      $this->email->subject('OpenML Meta Dataset');
      $this->email->message("This is an automatically generated email. The your requested meta-dataset was created successfully and can be downloaded from " . BASE_URL );
      $this->email->send();
    } else {
      echo 'No meta-dataset to process. '."\n";
    }
  }

  private function _error_meta_dataset( $id, $msg, $user_id ) {
    echo $msg . "\n";
    $this->Meta_dataset->update( $id, array( 'error_message' => $msg ) );

    $user = $this->ion_auth->user( $user_id )->row();
    $this->email->to( $user->email );
    $this->email->bcc( $this->config->item( 'email_debug' ) );
    $this->email->subject('OpenML Meta Dataset');
    $this->email->message("This is an automatically generated email. \n\nUnfortunatelly, the creation of the Meta Dataset was unsuccessfull. \n\nThe full error message is available to the system administrators. In case of any questions, please don't hesitate to contact the OpenML Team. ");
    $this->email->send();
  }
}
?>
