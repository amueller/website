<?php
class Category extends Community {
	
	function __construct()
    {
		parent::__construct();
		$this->table = 'category';
    }
	
	function threadsPerCategory() {
		$sql = 'SELECT `category`.`id`, `category`.`title`, COUNT( * ) AS `threads` FROM `category`, `thread` WHERE `thread`.`category_id` = `category`.`id` GROUP BY `category`.`id`;';
		$data = $this->db->query( $sql );
		$res = array();
		for( $i = 0; $i < $data->num_rows(); ++$i ) {
			$row = $data->row($i);
			$res[$row->id] = $row;
		}
		return $res;
	}
}
?>
