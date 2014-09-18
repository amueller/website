<?php
if (!$this->ion_auth->logged_in()) {
  sm('Please login first');
  su('login');
}

$this->measures = array("predictive_accuracy", "build_cpu_time", "area_under_roc_curve");

$sql = 'SELECT `m`.`id`, `m`.`request_date`, `m`.`datasets`, `m`.`flows`, `m`.`functions`, ' .
       'IF(`f`.`id` IS NOT NULL, CONCAT("<a href=\"'.DATA_URL.'download/", `f`.`id`, "/", `f`.`filename_original`, "\" target=\"_blank\"><i class=\"fa fa-file-excel-o\"></i></a>"), "") AS `download` ' .
       'FROM `meta_dataset` `m` LEFT JOIN `file` `f` ON `m`.`file_id` = `f`.`id` ' .
       'WHERE user_id = ' . $this->ion_auth->get_user_id() . ' ' .
       'ORDER BY request_date DESC; ';

$this->columns = array( 'id', 'request_date', 'datasets', 'flows', 'functions', 'download' );
$this->items = $this->Author->query( $sql );
$this->name = false;
?>
