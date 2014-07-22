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

  function insert_batch( $data ) {
    if( $data ) {
      return $this->db->insert_batch( $this->table, $data);
    } else {
      return false;
    }
  }

  function insert_ignore( $data ) {
    $insert_query = $this->db->insert_string( $this->table, $data );
    $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
    $this->db->query($insert_query);
    return $this->db->insert_id();
  }
  
  function update( $id, $data ) {
    return $this->db->where( $this->_where_clause_on_id($id) )->update( $this->table, $data );
  }
  
  function delete( $id ) {
    return $this->db->delete( $this->table, array( $this->id_column => $id ) );
  }
  
  function deleteWhere( $clause ) {
    return $this->db->where( $clause )->delete( $this->table );
  }
}
?>
