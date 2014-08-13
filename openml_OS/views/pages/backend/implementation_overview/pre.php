<?php
$sql = 'SELECT `i`.*, `r`.`runs` '.
       'FROM `implementation` `i` '.
       'LEFT JOIN `algorithm_setup` `s` ON `i`.`id` = `s`.`implementation_id` '.
       'LEFT JOIN (SELECT `setup`, count(*) AS `runs` FROM `run` GROUP BY `setup`) `r` ON `s`.`sid` = `r`.`setup` ' .
       'WHERE 1 '.
       'AND `i`.`uploader` = ' . $this->ion_auth->get_user_id() . ';';

$this->implementations = $this->Implementation->query( $sql );

$this->inputs = array( 'id', 'name', 'version', 'external_version', 'runs' );

?>
