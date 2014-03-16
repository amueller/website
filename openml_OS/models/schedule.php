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
      'SELECT s.*, r.start_time
       FROM
        (SELECT `s`.`learner`,`s`.`workbench`, `s`.`setup_id`, `s`.`ttid`, `t`.`task_id` 
         FROM `schedule` `s`, `task` `t` WHERE `s`.`ttid` = `t`.`ttid`) AS `s`
       LEFT JOIN run `r` ON `s`.`task_id` = `r`.`task_id` AND `s`.setup_id = `r`.`setup`
       WHERE r.start_time IS NULL
       AND `s`.`workbench` = "'.$workbench.'" 
       AND `s`.`ttid` = "'.$task_type.'"';
    $res = $this->query($sql);
    
    if(is_array($res) == false) {
      return false;
    } else {
      return $res[rand(0, count($res)-1)];
    }
  }
}
?>