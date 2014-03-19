<?php
class Runfile extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'runfile';
    $this->id_column = 'did';
    
    $this->load->model('File');
  }
  
  function fileFromRun( $rid, $field ) {
    $res = end( $this->getWhere( array( 'source' => $rid, 'field' => $field ) ) );
    return $this->File->getById( $res->file_id );
  }
  
}
?>