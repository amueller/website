<?php
$sql = 'SELECT GROUP_CONCAT(`r`.`rid`) AS `runs`, COUNT(*) as `duplicates`, `r`.`task_id`, `r`.`setup`, `d`.`name` AS `dataset` ' .  
       'FROM `run` `r` ' . 
       'LEFT JOIN `task_inputs` `t` ON `r`.`task_id` = `t`.`task_id` AND `t`.`input` = "source_data" ' . 
       'LEFT JOIN `dataset` `d` ON `t`.`value` = `d`.`did` ' .
       'WHERE `r`.`uploader` = ' . $this->ion_auth->get_user_id() . ' ' .
       'GROUP BY `r`.`task_id`, `r`.`setup` ' .
       'HAVING COUNT(*) > 1 ' .
       'ORDER BY `duplicates` DESC';

$this->runs = $this->Run->query( $sql );

$this->inputs = array( 'task_id', 'dataset', 'setup' );

?>
