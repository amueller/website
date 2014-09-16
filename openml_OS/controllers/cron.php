<?php
class Cron extends CI_Controller {
  
  function __construct() {
    parent::__construct();
    
    $this->controller = strtolower(get_class ($this));
    
    $this->load->model('Dataset');
    $this->load->model('Log');
    
    $this->load->model('Meta_dataset');
    $this->load->model('File');
    
    $this->load->helper('File_upload');
    $this->load->helper('directory');
    
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
      $this->Meta_dataset->update( 'id = ' . $meta_dataset->id, array( 'processed' => now() ) );
      $dataset_constr = ( $meta_dataset->datasets ) ? 'AND d.did IN (' . $meta_dataset->datasets . ') ' : '';
      $flow_constr = ( $meta_dataset->flows ) ? 'AND i.id IN (' . $meta_dataset->flows . ') ' : '';
      $function_constr = ( $meta_dataset->flows ) ? 'AND e.function IN (' . $meta_dataset->functions . ') ' : '';
      
      $sql = 
        'SELECT r.rid AS run_id, s.sid AS setup_id, t.task_id AS task_id, '.
        'd.did AS dataset_id, i.id AS implementation_id, e.repeat, e.fold, '.
        'e.sample_size, e.value, CONCAT(i.fullName, " on ", d.did) as textual '.
        'FROM run r, task t, task_inputs v, dataset d, algorithm_setup s, implementation i, evaluation_sample e '.
        'WHERE r.task_id = t.task_id AND v.task_id = t.task_id  '.
        'AND v.input = "source_data" AND v.value = d.did '.
        'AND r.setup = s.sid AND s.implementation_id = i.id '.
        'AND e.source = r.rid '.
         $dataset_constr . $flow_constr .  $function_constr .
        'GROUP BY s.sid, t.task_id, e.repeat, e.fold, e.sample;';
      $res = $this->Dataset->query( $sql );
      if( $res ) {
        if ( create_dir(DATA_PATH . $this->dir_suffix) == false ) {
          $this->Meta_dataset->update( 'id = ' . $meta_dataset->id, array( 'error_message' => 'Failed to create data directory. ' ) );
        }
        $filepath = getAvailableName( DATA_PATH . $this->dir_suffix, 'meta_dataset.arff' );
        $filename = end( explode( '/', $filepath ) );
        $filepointer = fopen( DATA_PATH . $this->dir_suffix . $filepath, 'w');
        if ( $filepointer == false ) {
          $this->Meta_dataset->update( 'id = ' . $meta_dataset->id, array( 'error_message' => 'Failed to create file: ' . $filename ) );
        }

        fputcsv( $filepointer, array_keys( get_object_vars( $res[0] ) ) );
        foreach( $res as $r ) {
          fputcsv( $filepointer, (array) $r );
        }
        fclose($filepointer);
        $file_id = $this->File->register_created_file( $this->dir_suffix, $filename, $meta_dataset->user_id, 'dataset', 'text/csv', 'private' );
        
        $this->Meta_dataset->update( 'id = ' . $meta_dataset->id, array( 'file_id' => $file_id ) );
      } else {
         $this->Meta_dataset->update( 'id = ' . $meta_dataset->id, array( 'error_message' => 'Dataset does not contain any instances.' ) );
      }
    }
  }
  
  private function _error($type, $did, $message) {
    $this->Log->cronjob( 'error', 'process_' . $type, 'Id ' . $did . ' processed with error: ' . $message );
    // TODO: email user about the error that occurred. 
  }
}
?>
