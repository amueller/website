<?php
class Updatedb extends CI_Controller {
	
  function __construct() {
    parent::__construct();
		
    $this->controller = strtolower(get_class ($this));
    
    $this->load->model('Algorithm_quality');
    $this->load->model('Implementation');
  }
  
  function fix($table) {
    $this->fix_table($table,'implementation');
  }
  
  private function fix_table( $table, $column ) {
    $sql = 'SELECT DISTINCT(`a`.`'.$column.'`),`i`.`id` FROM `'.$table.'` AS `a` LEFT JOIN `implementation` AS `i` ON `a`.`'.$column.'` = `i`.`fullName`;';
    //echo $sql . '<br/>';
    $result = $this->Implementation->query( $sql );
    
    if(is_array($result)) {
      foreach( $result as $r ) {
        $sql = 'UPDATE ' . $table . ' SET `implementation_id` = "'.$r->id.'" WHERE `'.$column.'` = "'.$r->implementation.'";';
        // echo $sql . '<br/>';
        $this->Implementation->query( $sql );
      }
    }
    
    // check
    $sql = 'SELECT * FROM `'.$table.'` AS `a` LEFT JOIN `implementation` AS `i` ON `a`.`'.$column.'` = `i`.`fullName` WHERE `a`.`implementation_id` <> `i`.`id`';
    //echo $sql . '<br/>';
    $result = $this->Implementation->query( $sql );
    if(is_array($result)) {
      foreach( $result as $r ) {
        var_dump($r);
      }
    }
  }
}
?>
