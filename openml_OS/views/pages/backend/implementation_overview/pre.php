<?php
$sql = 'SELECT `i`.*, `r`.`runs` '.
       'FROM `implementation` `i`, `algorithm_setup` `s` '.
       'LEFT JOIN (SELECT `setup`, count(*) AS `runs` FROM `run` GROUP BY `setup`) `r` ON `s`.`sid` = `r`.`setup` ' .
       'WHERE `i`.`id` = `s`.`implementation_id` '.
       'AND `i`.`uploader` = ' . $this->ion_auth->get_user_id() . ';';

$this->implementations = $this->Implementation->query( $sql );

$this->inputs = array( 'id', 'name', 'version', 'external_version', 'nr_of_runs' );

?>
