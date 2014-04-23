<?php
/* TODO: SHOULD BE ABSTRACT CLASS. CURRENTLY NOT SUPPORTED BY CI. */
class Database_write extends Database_read {
  
  function __construct() {
    parent::__construct();
    $this->db = $this->load->database('write',true);
  }

  function insert( $data ) {
    $this->db->insert( $this->table, $data);
    return $this->db->insert_id();
  }
  
  function update( $id, $data ) {
    return $this->db->where( $this->id_column . ' = ' . $id )->update( $this->table, $data );
  }
  
  function delete( $id ) {
    return $this->db->delete( $this->table, array( $this->id_column => $id ) );
  }
  
  function deleteWhere( $clause ) {
    return $this->db->where( $clause )->delete( $this->table );
  }
}
?>
