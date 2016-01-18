<?php
class Api_task extends Api_model {

  protected $version = 'v1';

  function __construct() {
    parent::__construct();

    // load models
    $this->load->model('Task');
    $this->load->model('Task_tag');
    $this->load->model('Task_inputs');
    $this->load->model('Task_type');
    $this->load->model('Task_type_inout');
    $this->load->model('Data_quality');
    $this->load->model('Run');
  }

  function bootstrap($format, $segments, $request_type, $user_id) {
    $this->outputFormat = $format;

    $getpost = array('get','post');

    if (count($segments) == 1 && $segments[0] == 'list') {
      $this->task_list();
      return;
    }

    if (count($segments) == 2 && $segments[0] == 'list' && is_numeric($segments[1])) {
      $this->task_list($segments[1]);
      return;
    }

    if (count($segments) == 1 && is_numeric($segments[0]) && in_array($request_type, $getpost)) {
      $this->task($segments[0]);
      return;
    }

    if (count($segments) == 0 && $request_type == 'post') {
      $this->task_upload();
      return;
    }

    if (count($segments) == 1 && is_numeric($segments[0]) && $request_type == 'delete') {
      $this->task_delete($segments[0]);
      return;
    }

    if (count($segments) == 1 && $segments[0] == 'tag' && $request_type == 'post') {
      $this->task_tag($this->input->post('task_id'),$this->input->post('tag'));
      return;
    }

    if (count($segments) == 1 && $segments[0] == 'untag' && $request_type == 'post') {
      $this->task_untag($this->input->post('task_id'),$this->input->post('tag'));
      return;
    }

    $this->returnError( 100, $this->version );
  }


  private function task_list($ttid = null) {
    // TODO: add tag / active
    //$task_type_id = $this->input->get( 'task_type_id' );
    //if( $task_type_id == false ) {
    //  $this->_returnError( 480 );
    //  return;
    //}
    //$active = $this->input->get('active_only') ? ' AND d.status = "active" ' : '';
    $task_type_constraint = $ttid == null ? '' : 'AND `t`.`ttid` = "'.$ttid.'" ';
    $tasks_res = $this->Task->query(
      'SELECT t.task_id, tt.name, source.value as did, d.status, d.name AS dataset_name '.
      'FROM `task` `t`, `task_inputs` `source`, `dataset` `d`, `task_type` `tt` '.
      'WHERE `source`.`input` = "source_data" AND `source`.`task_id` = `t`.`task_id` AND `source`.`value` = `d`.`did` AND `tt`.`ttid` = `t`.`ttid` ' .
      $task_type_constraint .
       //$active .
       ' ORDER BY task_id; ' );
    if( is_array( $tasks_res ) == false || count( $tasks_res ) == 0 ) {
      $this->returnError( 481, $this->version );
      return;
    }
    // make associative array from it
    $dids = array();
    $tasks = array();
    foreach( $tasks_res as $task ) {
      $tasks[$task->task_id] = $task;
      $tasks[$task->task_id]->qualities = array();
      $tasks[$task->task_id]->inputs = array();
    }

    $dq = $this->Data_quality->query('SELECT t.task_id, q.data, q.quality, q.value FROM data_quality q, task_inputs t WHERE t.input = "source_data" AND t.value = q.data AND t.task_id IN (' . implode(',', array_keys($tasks)) . ') AND quality IN ("' .  implode('","', $this->config->item('basic_qualities') ) . '") ORDER BY quality like "NumberOf" desc, quality');
    $ti = $this->Task_inputs->getWhere( 'task_id IN (' . implode(',', array_keys($tasks) ) . ')', '`task_id`' );
    $tt = $this->Task_tag->query('SELECT tt.id, tt.tag FROM task_tag tt, task t WHERE tt.id = t.task_id ' . $task_type_constraint . ' ORDER BY id');

    for( $i = 0; $i < count($dq); ++$i ) { $tasks[$dq[$i]->task_id]->qualities[$dq[$i]->quality] = $dq[$i]->value; }
    for( $i = 0; $i < count($ti); ++$i ) { $tasks[$ti[$i]->task_id]->inputs[$ti[$i]->input] = $ti[$i]->value; }
    for( $i = 0; $i < count($tt); ++$i ) { $tasks[$tt[$i]->id]->tags[] = $tt[$i]->tag; }

    $this->xmlContents( 'tasks', $this->version, array( 'tasks' => $tasks ) );
  }


  private function task($task_id) {
    if( $task_id == false ) {
      $this->returnError( 150, $this->version );
      return;
    }

    $task = $this->Task->getById( $task_id );
    if( $task === false ) {
      $this->returnError( 151, $this->version );
      return;
    }

    $task_type = $this->Task_type->getById( $task->ttid );
    if( $task_type === false ) {
      $this->returnError( 151, $this->version );
      return;
    }

    $parsed_io = $this->Task_type_inout->getParsed( $task_id );
    $tags = $this->Task_tag->getColumnWhere( 'tag', 'id = ' . $task_id );
    $this->xmlContents( 'task-get', $this->version, array( 'task' => $task, 'task_type' => $task_type, 'parsed_io' => $parsed_io, 'tags' => $tags ) );
  }


  private function task_delete($task_id) {

    $task = $this->Task->getById( $task_id );
    if( $task == false ) {
      $this->returnError( 452, $this->version );
      return;
    }

    $runs = $this->Run->getWhere( 'task_id = "' . $task->task_id . '"' );

    if( $runs ) {
      $this->returnError( 454, $this->version );
      return;
    }


    $result = true;
    $result = $result && $this->Task_inputs->deleteWhere('task_id = ' . $task->task_id );

    if( $result ) {
      $result = $this->Task->delete( $task->task_id );
    }

    if( $result == false ) {
      $this->returnError( 455, $this->version );
      return;
    }

    $this->elasticsearch->delete('task', $task_id);
    $this->xmlContents( 'task-delete', $this->version, array( 'task' => $task ) );
  }

  public function task_upload() {

    if (isset($_FILES['description']) == false || $_FILES['source']['error'] > 0) {
      $this->returnError(530, $this->version);
      return;
    }

    $descriptionFile = $_FILES['description']['tmp_name'];
    $xsd = xsd('openml.task.upload', $this->controller, $this->version);
    if (!$xsd) {
      $this->returnError( 531, $this->version, $this->openmlGeneralErrorCode );
      return;
    }

    if( validateXml( $descriptionFile, $xsd, $xmlErrors ) == false ) {
      // TODO: do later!
      $this->returnError(532, $this->version, $this->openmlGeneralErrorCode, $xmlErrors);
      return;
    }

    if (!$this->ion_auth->in_group($this->groups_upload_rights, $this->user_id)) {
      $this->returnError( 104, $this->version );
      return;
    }

    $xml = simplexml_load_file($descriptionFile);

    $task_type_id = $xml->children('oml', true)->{'task_type_id'};
    $inputs = array();

    foreach($xml->children('oml', true) as $input) {
      if ($input->getName() == 'input') {
        $name = $input->attributes() . '';
        $inputs[$name] = $input . '';
      }
    }

    $search = $this->Task->search($task_type_id, $inputs);
    if ($search) {
      $task_ids = array();
      foreach($search as $s) { $task_ids[] = $s->task_id; }

      $this->returnError(533, $this->version, $this->openmlGeneralErrorCode, 'matched id(s): [' . implode(',', $task_ids) . ']');
      return;
    }

    // THE INSERTION
    $task = array(
      'ttid' => '' . $task_type_id,
      'creator' => $this->user_id,
      'creation_date' => now()
    );

    $id = $this->Task->insert($task);
    // TODO: sanity check on input data!

    if ($id == false) {
      $this->returnError( 534, $this->version );
      return;
    }


    foreach($inputs as $name => $value) {
      $task_input = array(
        'task_id' => $id,
        'input' => $name,
        'value' => $value
      );
      $this->Task_inputs->insert($task_input);
    }

    $this->xmlContents( 'task-upload', $this->version, array( 'id' => $id ) );
  }

  private function task_tag($id, $tag) {

    $error = -1;
    $result = tag_item( 'task', $id, $tag, $this->user_id, $error );


    //update index
    $this->elasticsearch->index('task', $id);
    //update studies
    if(startsWith($tag,'study_')){
      $this->elasticsearch->index('study', end(explode('_',$tag)));
    }

    if( $result == false ) {
      $this->returnError( $error, $this->version );
      return;
    } else {
      $this->xmlContents( 'entity-tag', $this->version, array( 'id' => $id, 'type' => 'task' ) );
    }
  }

  private function task_untag($id, $tag) {

    $error = -1;
    $result = untag_item( 'task', $id, $tag, $this->user_id, $error );

    //update index
    $this->elasticsearch->index('task', $id);

    if( $result == false ) {
      $this->returnError( $error, $this->version );
      return;
    } else {
      $this->xmlContents( 'entity-untag', $this->version, array( 'id' => $id, 'type' => 'task' ) );
    }
  }
}
?>
