<?php
class Run_evaluated extends Database_write {
  function __construct() {
    parent::__construct();
    $this->table = 'run_evaluated';
    $this->id_column = array('run_id', 'evaluation_engine_id');
  }

  function getUnevaluatedRun($evaluation_engine_id, $order, $ttid) {
    $this->db->from('`task` `t`')->join('`run` `r`', '`t`.`task_id` = `r`.`task_id`', 'inner');
    $this->db->join('`run_evaluated` `e`', '`r`.`rid` = `e`.`run_id` AND `e`.`evaluation_engine_id` = ' . $evaluation_engine_id, 'left');
    $this->db->where('`e`.`run_id` IS NULL')->limit('1');
    if ($ttid != false) {
      $this->db->where('`t`.`ttid` = "' . $ttid . '"');
    }

    if ($order == 'random') {
      $this->db->order_by('RAND()');
    } elseif ($order == 'reverse') {
      $this->db->order_by('r.rid DESC');
    }

    $data = $this->db->select('r.*')->get();

    return ( $data && $data->num_rows() > 0 ) ? $data->result() : false;
  }
}
?>
