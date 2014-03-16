<?php
class Schedule extends Database_read {
  
  function __construct() {
    parent::__construct();
    $this->table = 'schedule';
    $this->id_column = 'rid';
  }
  
  // TODO: this function lacks history. A task can be given to two runners at the same 
  // time, by accident. We want to avoid that. 
  function getJob( $workbench, $task_type ) {
    $sql = 
      'SELECT `s`.`learner`,`s`.`workbench`, `t`.`task_id`,`r`.`start_time` 
       FROM `schedule` `s`, `task` `t` 
       LEFT JOIN `run` `r` ON `t`.`task_id` = `r`.`task_id` 
       WHERE `s`.`ttid` = `t`.`ttid` AND start_time IS NULL
       AND `s`.`workbench` = "'.$workbench.'" 
       AND `s`.`ttid` = "'.$task_type.'"';
    $res = $this->query($sql);
    
    if(is_array($res) == false) {
      return false;
    } else {
      return $res[rand(0, count($res))];
    }
  }
}
?>
