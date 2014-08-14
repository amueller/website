<?php

$this->legal_subpages = array('flows','data','runs');


if( $this->subpage == 'flows' ) {

  $sql = 'SELECT `i`.`id`, `i`.`name`, `i`.`version`, `i`.`external_version`, `r`.`runs`, '.
         'IF(`r`.`runs` > 0,"0","1") AS `may_delete`, '.
         'CONCAT(\'<a href="f/\', `i`.`id`, \'">\', `i`.`name`, \'</a>\') AS `name_link`' .
         'FROM `implementation` `i` '.
         'LEFT JOIN `algorithm_setup` `s` ON `i`.`id` = `s`.`implementation_id` '.
         'LEFT JOIN (SELECT `setup`, count(*) AS `runs` FROM `run` GROUP BY `setup`) `r` ON `s`.`sid` = `r`.`setup` ' .
         'WHERE `i`.`uploader` = "' . $this->ion_auth->get_user_id() . '";';

  $this->keys = array( 'id', 'name_link', 'version', 'external_version', 'runs' );
  $this->items = $this->Implementation->query( $sql );
  $this->name = 'My flows';

  $this->api_delete_function = array( 
    'function'        => 'openml.implementation.delete', 
    'key'             => 'implementation_id',
    'filter'          => 'may_delete',
    'id_field'        => 'id',
    'identify_field'  => 'name' );

} elseif( $this->subpage == 'data' ) {
  
  $sql = 'SELECT `d`.`did`, `d`.`name`, `d`.`upload_date`, `d`.`format`, `t`.`tasks`, '.
         'IF(`t`.`tasks` > 0,"0","1") AS `may_delete`, '.
         'CONCAT(\'<a href="d/\', `d`.`did`, \'">\', `d`.`name`, \'</a>\') AS `name_link` ' .
         'FROM `dataset` `d` '.
         'LEFT JOIN (SELECT `value` AS `did`, count(*) AS `tasks` FROM `task_inputs` WHERE `input` = "source_data" GROUP BY `value`) `t` ON d.did = t.did ' .
         'WHERE `uploader` = "' . $this->ion_auth->get_user_id() . '";';

  $this->keys = array( 'did', 'name_link', 'upload_date', 'format', 'tasks' );
  $this->items = $this->Dataset->query( $sql );
  $this->name = 'My data';

  $this->api_delete_function = array( 
    'function'        => 'openml.data.delete', 
    'key'             => 'data_id',
    'filter'          => 'may_delete',
    'id_field'        => 'did',
    'identify_field'  => 'name' );
  
} elseif( $this->subpage == 'runs' ) {
  
  $sql = 'SELECT `r`.`rid`,`r`.`start_time`,`r`.`task_id`,`r`.`status`, `r`.`error`, `d`.`name` AS `dataset`, `i`.`fullName` AS `flow`, "1" AS `may_delete`, '.
         'CONCAT(\'<a href="r/\', `r`.`rid`, \'">Run \', `r`.`rid`, \'</a>\') AS `name_link` ' .
         'FROM `algorithm_setup` `s`, `implementation` `i`, `run` `r` ' .
         'LEFT JOIN `task_inputs` `t` ON `r`.`task_id` = `t`.`task_id` AND `t`.`input` = "source_data" ' .
         'LEFT JOIN `dataset` `d` ON `t`.`value` = `d`.`did` ' .
         'WHERE `r`.`uploader` = ' . $this->ion_auth->get_user_id() . ' ' .
         'AND `r`.`setup` = `s`.`sid` AND `s`.`implementation_id` = `i`.`id` ' .
         'ORDER BY `r`.`start_time` DESC';
  
  $this->keys = array( 'rid', 'start_time', 'name_link', 'task_id', 'dataset', 'flow', 'status', 'error' );
  $this->items = $this->Run->query( $sql );
  $this->name = 'My runs';


  $this->api_delete_function = array( 
    'function'        => 'openml.run.delete', 
    'key'             => 'rid',
    'filter'          => 'may_delete',
    'id_field'        => 'rid',
    'identify_field'  => 'name' );
}

?>
