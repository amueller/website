<?php
/* TODO: SHOULD BE ABSTRACT CLASS. CURRENTLY NOT SUPPORTED BY CI. */
class Community extends CI_Model {
	
	protected $table;
	protected $include_deleted_activated;
	
	function __construct() {
		parent::__construct();
		$this->deleted_activated = 'deleted = "n" AND activated = "y" ';
	}
	
	function getById( $id, $orderby = null ) {
		if( is_numeric( $id ) == false )
			return false;
		
		$this->db->where( $this->deleted_activated . ' AND id = "'.$id.'"' );
		if( $orderby != null ) 
			$this->db->order_by( $orderby );
		$data = $this->db->get( $this->table );
		return ( $data->num_rows() > 0 ) ? $data->row() : false;
	}
	
	function getWhere( $where, $orderby = null ) {
		if( $orderby != null ) 
			$this->db->order_by( $orderby );
		$data = $this->db->where( $where )->get( $this->table );
		return ( $data->num_rows() > 0 ) ? $data->result() : false;
	}

	function get( $orderby = null ) {
		$this->db->where( $this->deleted_activated );
		if( $orderby != null ) 
			$this->db->order_by( $orderby );
		$data = $this->db->get( $this->table );
		return ( $data->num_rows() > 0 ) ? $data->result() : false;
	}

	function insert( $data ) {
		$this->db->insert( $this->table, $data);
		return $this->db->insert_id();
	}
	
	function update( $id, $data ) {
		return $this->db->where( '`id` = ' . $id )->update( $this->table, $data );
	}
}
?>
