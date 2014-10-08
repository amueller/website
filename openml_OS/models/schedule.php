<?php
class Schedule extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'schedule';
    $this->id_column = array('sid','task_id');
  }
  
  function getJob( $workbench, $task_type ) {
    $sql = 'SELECT `s`.`sid`, `s`.`task_id`, `a`.`setup_string`, `s`.`last_assigned` FROM `schedule` `s`, `task` `t`, `algorithm_setup` `a`, `implementation` `i` WHERE `i`.`id` = `a`.`implementation_id` AND `a`.`sid` = `s`.`sid` AND `s`.`task_id` = `t`.`task_id` AND (`a`.`sid`,`t`.`task_id`) NOT IN (SELECT setup, task_id FROM run) AND `i`.`dependencies` = "' . $workbench . '" AND `t`.`ttid` = "' . $task_type . '";';
    
    $res = $this->query( $sql );

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
