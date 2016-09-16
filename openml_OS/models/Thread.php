<?php
class Thread extends Community {

	function __construct()
    {
		parent::__construct();
		$this->table = 'thread';
		$this->search_ignore = array( 'the', 'are', 'and', 'but', 'does', 'etc', 'from' );
    }

	function getByCategoryId( $id, $start = null, $limit = null, $orderby = null ) {
		if( is_numeric( $id ) == false )
			return false;

		$this->db->where( '`deleted` = "n" AND `activated` = "y" AND `category_id` = "'.$id.'"' );
		if( $start !== null && $limit !== null )
			$this->db->limit($limit,$start);

		if( $orderby != null )
			$this->db->order_by( $orderby );

		$data = $this->db->get( $this->table );
		return ( $data->num_rows() > 0 ) ? $data->result() : false;
	}

	function search( $termsString, $orderby = '' ) {
		$terms = explode( ' ', preg_replace( '/[^A-Za-z0-9.\s\s+]/', '', $termsString ) );
		$conditions = array();
		foreach( $terms as $term ) {
			if( strlen( $term ) > 2 && ! in_array( $term, $this->search_ignore ) ) {
				// no myqsl real escape string, as the input is already safe. (regex)
				$conditions[] .= '`thread`.`title` LIKE "%'.$term.'%"';
				$conditions[] .= '`thread`.`body` LIKE "%'.$term.'%"';
			}
		}
		if( count( $conditions ) == 0 ) $conditions[] = '1 = 0'; // to prevent error when no search criteria is set
		$sql = 'SELECT `thread`.*, `category`.`title` as `category_title` FROM `thread` LEFT JOIN `category` ON `thread`.`category_id` = `category`.`id` WHERE `thread`.`deleted` = "n" AND `thread`.`activated` = "y" AND `category`.`deleted` = "n" AND `category`.`activated` = "y" AND ( ' . implode( ' OR ', $conditions ) . ' ) ' . $orderby . ';';
		$data = $this->db->query( $sql );
		return ( $data->num_rows() > 0 ) ? $data->result() : false;
	}
}
?>
