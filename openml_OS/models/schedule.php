<?php
class Schedule extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'schedule';
    $this->id_column = array('sid','task_id');
  }
  
  function getJob( $workbench, $task_type ) {
    // quick check
    $sql = 'SELECT * FROM `schedule` WHERE `dependencies` = "' . $workbench . '" AND `active` = "true" AND `ttid` = "' . $task_type . '" AND last_assigned = NULL limit 0,1;';
    
    $res = $this->query( $sql );

    // pick up abandoned jobs
    if(is_array($res) == false) {
	$sql = 'SELECT * FROM `schedule` WHERE `dependencies` = "' . $workbench . '" AND `active` = "true" AND `ttid` = "' . $task_type . '" ORDER BY last_assigned ASC limit 0,1;';

    	$res = $this->query( $sql );
    }

    if(is_array($res) == false) {
      return false;
    } else {
      $current = $res[0];
      $this->update( array( $current->sid, $current->task_id ), array( 'last_assigned' => now() ) );
      return $res[0];
    }
  }
}
?>
