<?php
/* TODO: SHOULD BE ABSTRACT CLASS. CURRENTLY NOT SUPPORTED BY CI. */
class Database_read extends CI_Model {
  
  protected $table;
  protected $id_column;
  
  function __construct() {
    parent::__construct();
    $this->load->model('Log');
    $this->db = $this->load->database('read',true);
  }

  function get( $orderby = null ) {
    if( $orderby != null ) 
      $this->db->order_by( $orderby );
    $data = $this->db->get( $this->table );
    return ( $data->num_rows() > 0 ) ? $data->result() : false;
  }
  
  function query( $sql ) {
    $this->Log->sql( $sql);
    $data = $this->db->query( $sql );
    if($data === true || $data === false) return $data;
    return ( $data->num_rows() > 0 ) ? $data->result() : false;
  }
  
  function getWhere( $where, $orderby = null ) {
    if( $orderby != null ) 
      $this->db->order_by( $orderby );
    $data = $this->db->where( $where )->get( $this->table );
    return ( $data->num_rows() > 0 ) ? $data->result() : false;
  }
  
  function getById( $id, $orderby = null ) {
    $data = $this->getWhere( $this->id_column . ' = "' . $id . '"', $orderby );
    return ( $data !== false ) ? $data[0] : false;
  }
  
  function getWhereSingle( $where, $orderby = null ) {
    $this->db->limit(0,1);
    $data = $this->getWhere( $where, $orderby );
    return ( $data !== false ) ? $data[0] : false;
  }
  
  function getColumn( $column, $orderby = null) {
    if( $orderby != null ) 
      $this->db->order_by( $orderby );
    $data = $this->db->select( $column )->get( $this->table );
    $res = array();
    foreach( $data->result() as $row )
      $res[] = $row->{$column};
    
    return count( $res ) > 0 ? $res : false;
  }
  
  function getColumnWhere( $column, $where, $orderby = null ) {
    $this->db->where( $where );
    return $this->getColumn( $column, $orderby );
  }
  
  function getColumnFunction( $function, $orderby = null ) {
    if( $orderby != null ) 
      $this->db->order_by( $orderby );
    $data = $this->db->select( $function . ' AS `name`', false )->get( $this->table );
    $res = array();
    foreach( $data->result() as $row )
      $res[] = $row->{'name'};
    
    return count( $res ) > 0 ? $res : false;
  }
  
  function getColumnFunctionWhere( $function, $where, $orderby = null ) {
    $this->db->where( $where );
    return $this->getColumnFunction( $function, $orderby );
  }
  
  function getAssociativeArray( $key, $value, $where, $orderby = null ) {
    $this->db->select( $key . ' AS `key`, ' . $value . ' AS `value`', false );
    $data = $this->getWhere( $where, $orderby );
    if($data === false) return false;
    
    $res = array();
    foreach( $data as $item ) {
      $res[$item->{'key'}] = $item->{'value'};
    }
    return $res;
  }
  
  function getDistinct( $column, $excludeEmpty = true ) {
    if( $excludeEmpty ) $this->db->where( $column . ' IS NOT NULL AND ' . $column . ' != ""' );
    $this->db->distinct();
    return $this->getColumn( $column );
  }
  
  function getColumns( $columns, $orderby = null ) {
    if( $orderby != null ) 
      $this->db->order_by( $orderby );
    $data = $this->db->select( $columns, false )->get( $this->table );
    return $data->num_rows() > 0 ? $data->result() : false;
  }
  
  function getColumnsWhere( $columns, $where, $orderby = null ) {
    $this->db->where( $where );
    return $this->getColumns( $columns, $orderby );
  }
  
  function numberOfRecords() {
    return $this->db->count_all($this->table);
  }
  
  function getHighestIndex( $tables, $column ) {
    $res = array();
    foreach( $tables as $table ) {
      $data = $this->db->select_max( $column )->get( $table )->row();
      $res[] = $data->{$column};
    }    
    return max( $res ) + 1;
  }
  
  function incrementVersionNumber( $name ) {
    $data = $this->getWhere( 'name = "' . $name . '"'  );
    if( $data === false )
      return 1;
      
    $highest = $data[0];
    for( $i = 1; $i < count($data); $i++ ) {
      if( version_compare( $highest->version, $data[$i]->version ) < 0 ) {
        $highest = $data[$i];
      }
    }
    
    $newVersion = explode( '.', $highest->version );
    return $newVersion[0] + 1;
  }
}
?>
