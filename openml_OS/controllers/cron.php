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
    
    $this->dir_suffix = 'dataset/cron/';
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
  
  function create_meta_dataset() {
    $meta_dataset = $this->Meta_dataset->getWhere( 'processed IS NULL' );
    
    if( $meta_dataset ) {
      $meta_dataset = $meta_dataset[0];
      $this->Meta_dataset->update( $meta_dataset->id, array( 'processed' => now() ) );
      $dataset_constr = ( $meta_dataset->datasets ) ? 'AND d.did IN (' . $meta_dataset->datasets . ') ' : '';
      $flow_constr = ( $meta_dataset->flows ) ? 'AND i.id IN (' . $meta_dataset->flows . ') ' : '';
      $function_constr = ( $meta_dataset->functions ) ? 'AND e.function IN (' . $meta_dataset->functions . ') ' : '';
      
      if ( create_dir(DATA_PATH . $this->dir_suffix) == false ) {
        $this->_error_meta_dataset( $meta_dataset->id, 'Failed to create data directory. ', $meta_dataset->user_id );
        return;
      }
      
      $tmp_path = '/tmp/' . rand_string( 20 ) . '.csv';
      
      $sql = 
        'SELECT "run_id", "setup_id", "task_id", "repeat", "fold", "sample", "sample_size", "function", "value", "textual"' .
        'UNION ALL ' .
        'SELECT r.rid AS run_id, s.sid AS setup_id, t.task_id AS task_id, '.
        'e.repeat, e.fold, e.sample, e.sample_size, e.function, e.value, '.
        'CONCAT(i.fullName, " on ", d.name) as textual '.
        'FROM run r, task t, task_inputs v, dataset d, algorithm_setup s, implementation i, evaluation_sample e '.
        'WHERE r.task_id = t.task_id AND v.task_id = t.task_id  '.
        'AND v.input = "source_data" AND v.value = d.did '.
        'AND r.setup = s.sid AND s.implementation_id = i.id '.
        'AND e.source = r.rid '.
         $dataset_constr . $flow_constr .  $function_constr .
//      'GROUP BY s.sid, t.task_id, e.repeat, e.fold, e.sample ' . 
        'INTO OUTFILE "'. $tmp_path .'" ' .
        'FIELDS TERMINATED BY "," ' .
        'ENCLOSED BY "\"" ' .
        'LINES TERMINATED BY "\n" ' . 
        ';';
      
      $this->Dataset->query( $sql ); 
      $success = file_exists( $tmp_path );      
      
      if( $success == false ) {
        $this->_error_meta_dataset( $meta_dataset->id, 'Failed to export query to tmp directory. ', $meta_dataset->user_id );
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
      $this->email->message("This is an automatically generated email. The your requested meta-dataset was created successfully and can be downloaded from the OpenML Control Panel. "); 
      $this->email->send();
    }
  }
  
  private function _error_meta_dataset( $id, $msg, $user_id ) {
    $this->Meta_dataset->update( $id, array( 'error_message' => $msg ) );
    
    $user = $this->ion_auth->user( $user_id )->row();
    $this->email->to( $user->email );
    $this->email->bcc( $this->config->item( 'email_debug' ) );
    $this->email->subject('OpenML Meta Dataset');
    $this->email->message("This is an automatically generated email. \n\nUnfortunatelly, the creation of the Meta Dataset was unsuccessfull. \n\nError message: $msg\n\nIn case of any questions, please don't hesitate to contact the OpenML Team. "); 
    $this->email->send();
  }
}
?>
