<?php
class Run_evaluated extends Database_write {
  function __construct() {
    parent::__construct();
    $this->table = 'run_evaluated';
    $this->id_column = array('run_id', 'evaluation_engine_id');
  }

  function getUnevaluatedRun($evaluation_engine_id, $order, $ttid) {
     if($ttid != false){
       $this->db->from('`task` `t`')->join('`run` `r`', '`t`.`task_id` = `r`.`task_id`', 'inner');
     } else {
       $this->db->from('`run` `r`');
     }
     $this->db->join('`run_evaluated` `e`', '`r`.`rid` = `e`.`run_id` AND `e`.`evaluation_engine_id` = ' . $evaluation_engine_id, 'left');

     // When random results are needed, to avoid that multiple evaluators evaluate the same run,
     // get 100 unordered results and randomly select one (or more) of them.
     // This is much faster than randomizing the results in the query.
     $randomcount = 100;
     if ($order == 'random') {
       $this->db->where('`e`.`run_id` IS NULL')->limit($randomcount);
     } else {
       $this->db->where('`e`.`run_id` IS NULL')->limit('1');
     }
     if ($ttid != false) {
       $this->db->where('`t`.`ttid` = "' . $ttid . '"');
     }

     // Reverse order if needed (slower query)
     if ($order == 'reverse') {
       $this->db->order_by('r.rid DESC');
     }

     // This always returns one result. Can easily be adapted to return multiple
     // results for batch processing
     $data = $this->db->select('r.*')->get();
     if ($data && $data->num_rows() > 0){
       if ($order == 'random'){
          $result = $data->result();
          return array($result[array_rand($result)]);
        } else {
          return $data->result();
        }
     }
  }

}
?>
