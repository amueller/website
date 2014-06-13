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
    $sql = 'SELECT j.* from job j where ttid = "'.$task_type.'" AND workbench = "'.$workbench.'" AND not exists (select rid from run r where j.task_id = r.task_id and j.sid = r.setup);';

/*    'SELECT `a`.`setup_string`, `s`.`workbench`, `s`.`sid`, `s`.`ttid`, `t`.`task_id`
     FROM `schedule` `s`, `algorithm_setup` `a`, `task` `t`
     WHERE `a`.`sid` = `s`.`sid` and `s`.`ttid` = `t`.`ttid` and
     `s`.`active` = "true" and  `t`.`task_id` IN (select task_id from `task_inputs`) 
     AND not exists (select rid
                from `run` `r`
                where `t`.`task_id` = `r`.`task_id` and `s`.`sid` =
     `r`.`setup` and `r`.`start_time` IS NOT NULL) 
     AND `s`.`ttid` = "'.$task_type.'"
     AND `s`.`workbench` = "'.$workbench.'";';

/*      'SELECT `a`.`setup_string`, `s`.*, `r`.`start_time` 
       FROM `algorithm_setup` `a`,
        (SELECT `s`.`workbench`, `s`.`sid`, `s`.`ttid`, `t`.`task_id` 
         FROM `schedule` `s`, `task` `t` 
         WHERE `s`.`ttid` = `t`.`ttid`
         AND `s`.`active` = "true") AS `s`
       LEFT JOIN run `r` ON `s`.`task_id` = `r`.`task_id` AND `s`.`sid` = `r`.`setup`
       WHERE `r`.`start_time` IS NULL
       AND `a`.`sid` = `s`.`sid`
       AND `s`.`workbench` = "'.$workbench.'" 
       AND `s`.`ttid` = "'.$task_type.'"';*/
    $res = $this->query($sql);
    
    if(is_array($res) == false) {
      return false;
    } else {
      return $res[rand(0, count($res)-1)];
    }
  }
}
?>
