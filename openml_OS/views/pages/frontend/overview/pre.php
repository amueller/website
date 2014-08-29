<?php

$this->legal_subpages = array('flows','data','runs');


if( $this->subpage == 'flows' ) {
  $sql = 'SELECT SQL_CALC_FOUND_ROWS `i`.`id`, `i`.`name`, `i`.`version`, `i`.`external_version`, `r`.`runs`, '.
         'IF(`r`.`runs` > 0,"",CONCAT("<i class=\\\\"fa fa-fw fa-times\\\\" onclick=\\\\"askConfirmation(",`i`.`id`,",\\\'",`i`.`name`,"\\\')\\\\"></i>")) AS `delete`, '.
         'CONCAT("<a href=\\\\"f/", `i`.`id`, "\\\\">", `i`.`name`, "</a>") AS `name_link`' .
         'FROM `implementation` `i` '.
         'LEFT JOIN `algorithm_setup` `s` ON `i`.`id` = `s`.`implementation_id` '.
         'LEFT JOIN (SELECT `setup`, count(*) AS `runs` FROM `run` GROUP BY `setup`) `r` ON `s`.`sid` = `r`.`setup` ' .
         'WHERE `i`.`uploader` = "' . $this->ion_auth->get_user_id() . '"';
  
  $this->columns = array( 'delete', 'id', 'name_link', 'version', 'external_version', 'runs' );
  $this->widths = array( 5, 5, 20, 5, 10, 5);
  $this->sql = $sql;
  $this->name = 'My flows';

  $this->api_delete_function = array( 
    'function'        => 'openml.implementation.delete', 
    'key'             => 'implementation_id',
    'filter'          => 'may_delete',
    'id_field'        => 'id',
    'identify_field'  => 'name' );

} elseif( $this->subpage == 'data' ) {
  
  $sql = 'SELECT SQL_CALC_FOUND_ROWS `d`.`did`, `d`.`name`, `d`.`upload_date`, `d`.`format`, `t`.`tasks`, '.
         'IF(`t`.`tasks` > 0,"",CONCAT("<i class=\\\\"fa fa-fw fa-times\\\\" onclick=\\\\"askConfirmation(",`d`.`did`,",\\\'",`d`.`name`,"\\\')\\\\"></i>")) AS `delete`, '.
         'CONCAT("<a href=\\\\"d/", `d`.`did`, "\\\\">", `d`.`name`, "</a>") AS `name_link`' .
         'FROM `dataset` `d` '.
         'LEFT JOIN (SELECT `value` AS `did`, count(*) AS `tasks` FROM `task_inputs` WHERE `input` = "source_data" GROUP BY `value`) `t` ON d.did = t.did ' .
         'WHERE `uploader` = "' . $this->ion_auth->get_user_id() . '"';

  $this->columns = array( 'delete', 'did', 'name_link', 'upload_date', 'format', 'tasks' );
  $this->widths = array( 5, 5, 20, 10, 10, 5);
  $this->sql = $sql;
  $this->name = 'My data';

  $this->api_delete_function = array( 
    'function'        => 'openml.data.delete', 
    'key'             => 'data_id',
    'filter'          => 'may_delete',
    'id_field'        => 'did',
    'identify_field'  => 'name' );
  
} elseif( $this->subpage == 'runs' ) {
  
  $sql = 'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`,`r`.`start_time`,`r`.`task_id`,`r`.`status`, `r`.`error`, `d`.`name` AS `dataset`, `i`.`fullName` AS `flow`, '.
         'CONCAT("<i class=\\\\"fa fa-fw fa-times\\\\" onclick=\\\\"askConfirmation(",`r`.`rid`,",\\\'run ",`r`.`rid`,"\\\')\\\\"></i>") AS `delete`, '.
         'CONCAT("<a href=\\\\"r/", `r`.`rid`, "\\\\">", `r`.`rid`, "</a>") AS `name_link`, ' .
         'CONCAT("Run ", `r`.`rid`) AS `name` ' .
         'FROM `algorithm_setup` `s`, `implementation` `i`, `run` `r` ' .
         'LEFT JOIN `task_inputs` `t` ON `r`.`task_id` = `t`.`task_id` AND `t`.`input` = "source_data" ' .
         'LEFT JOIN `dataset` `d` ON `t`.`value` = `d`.`did` ' .
         'WHERE `r`.`uploader` = ' . $this->ion_auth->get_user_id() . ' ' .
         'AND `r`.`setup` = `s`.`sid` AND `s`.`implementation_id` = `i`.`id` ';
  
  $this->columns = array( 'delete', 'name_link', 'start_time', 'task_id', 'dataset', 'flow', 'status', 'error' );
  $this->widths = array( 5, 5, 10, 10, 10, 10, 10, 10 );
  $this->sql = $sql;
  $this->name = 'My runs';


  $this->api_delete_function = array( 
    'function'        => 'openml.run.delete', 
    'key'             => 'run_id',
    'filter'          => 'may_delete',
    'id_field'        => 'rid',
    'identify_field'  => 'name' );
}

?>
