<?php
class Api_evaluation extends Api_model {

  protected $version = 'v1';

  function __construct() {
    parent::__construct();

    // load models
    $this->load->model('Evaluation');
  }

  function bootstrap($format, $segments, $request_type, $user_id) {
    $this->outputFormat = $format;

    $getpost = array('get','post');

    if (count($segments) >= 1 && $segments[0] == 'list') {
      array_shift($segments);
      $this->evaluation_list($segments);
      return;
    }

    $this->returnError( 100, $this->version );
  }


  private function evaluation_list($segs) {
    $query_string = array();
    for ($i = 0; $i < count($segs); $i += 2)
      $query_string[$segs[$i]] = urldecode($segs[$i+1]);

    $task_id = element('task', $query_string);
    $setup_id = element('setup',$query_string);
    $implementation_id = element('flow',$query_string);
    $uploader_id = element('uploader',$query_string);
    $run_id = element('run',$query_string);
    $function_name = element('function',$query_string);

    if ($task_id == false && $setup_id == false && $implementation_id == false && $uploader_id == false && $run_id == false) {
      $this->returnError( 540, $this->version );
      return;
    }

    if (!(is_safe($task_id) && is_safe($setup_id) && is_safe($implementation_id) && is_safe($uploader_id) && is_safe($run_id) && is_safe($function_name))) {
      $this->returnError(541, $this->version );
      return;
    }

    $where_task = $task_id == false ? '' : ' AND `r`.`task_id` IN (' . $task_id . ') ';
    $where_setup = $setup_id == false ? '' : ' AND `r`.`setup` IN (' . $setup_id . ') ';
    $where_uploader = $uploader_id == false ? '' : ' AND `r`.`uploader` IN (' . $uploader_id . ') ';
    $where_impl = $implementation_id == false ? '' : ' AND `s`.`implementation_id` IN (' . $implementation_id . ') ';
    $where_run = $run_id == false ? '' : ' AND `r`.`rid` IN (' . $run_id . ') ';
    $where_function = $function_name == false ? '' : ' AND `e`.`function` = "' . $function_name . '" ';

    //pre-test
    $where_runs = $where_task . $where_setup . $where_uploader . $where_impl . $where_run;
    $sql_test =
      'SELECT distinct r.rid ' . 'FROM run r, algorithm_setup s ' . 'WHERE r.setup = s.sid ' . $where_runs;
    $res_test = $this->Evaluation->query( $sql_test );

    if (count($res_test) > 10000) {
      $this->returnError(543, $this->version, $this->openmlGeneralErrorCode, 'Size of result set: ' . count($res) . ' runs; max size: 10000. ');
      return;
    }

    //get evaluations
    $where_total = $where_task . $where_setup . $where_uploader . $where_impl . $where_run . $where_function;

    $sql =
      'SELECT r.rid, r.task_id, s.implementation_id, e.function, e.value, e.array_data ' .
      'FROM evaluation e, run r, algorithm_setup s ' .
      'WHERE r.setup = s.sid AND e.source = r.rid ' . $where_total .
      'ORDER BY r.rid; ';
    $res = $this->Evaluation->query( $sql );

    if ($res == false) {
      $this->returnError(542, $this->version);
      return;
    }

    $this->xmlContents( 'evaluations', $this->version, array( 'evaluations' => $res ) );
  }
}
?>
