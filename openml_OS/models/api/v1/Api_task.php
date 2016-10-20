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

    if (count($segments) >= 1 && $segments[0] == 'list') {
      array_shift($segments);
      $this->task_list($segments);
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
      $this->entity_tag_untag('task', $this->input->post('task_id'), $this->input->post('tag'), false, 'task');
      return;
    }

    if (count($segments) == 1 && $segments[0] == 'untag' && $request_type == 'post') {
      $this->entity_tag_untag('task', $this->input->post('task_id'), $this->input->post('tag'), true, 'task');
      return;
    }

    $this->returnError(100, $this->version);
  }


  private function task_list($segs) {
    $legal_filters = array('type', 'tag', 'data_tag', 'status', 'limit', 'offset', 'data_id', 'data_name', 'number_instances', 'number_features', 'number_classes', 'number_missing_values');
    $query_string = array();
    for ($i = 0; $i < count($segs); $i += 2) {
      $query_string[$segs[$i]] = urldecode($segs[$i+1]);
      if (in_array($segs[$i], $legal_filters) == false) {
        $this->returnError(480, $this->version, $this->openmlGeneralErrorCode, 'Legal filter operators: ' . implode(',', $legal_filters) .'. Found illegal filter: ' . $segs[$i]);
        return;
      }
    }
    $type = element('type',$query_string);
    $tag = element('tag',$query_string);
    $data_tag = element('data_tag',$query_string);
    $status = element('status',$query_string);
    $limit = element('limit',$query_string);
    $offset = element('offset',$query_string);
    $data_id = element('data_id',$query_string);
    $data_name = element('data_name',$query_string);
    $nr_insts = element('number_instances',$query_string);
    $nr_feats = element('number_features',$query_string);
    $nr_class = element('number_classes',$query_string);
    $nr_miss = element('number_missing_values',$query_string);

    if (!(is_safe($tag) && is_safe($data_tag) && is_safe($status) && is_safe($type) && is_safe($limit) && is_safe($offset) && is_safe($data_id) && is_safe($data_name) && is_safe($nr_insts) && is_safe($nr_feats) && is_safe($nr_class) && is_safe($nr_miss))) {
      $this->returnError(481, $this->version );
      return;
    }

    $where_type = $type == false ? '' : 'AND `t`.`ttid` = "'.$type.'" ';
    $where_tag = $tag == false ? '' : ' AND `t`.`task_id` IN (select id from task_tag where tag="' . $tag . '") ';
    $where_data_tag = $data_tag == false ? '' : ' AND `d`.`did` IN (select id from dataset_tag where tag="' . $data_tag . '") ';
    $where_status = $status == false ? '' : ' AND `d`.`status` = '. $status;
    $where_did = $data_id == false ? '' : ' AND `d`.`did` = '. $data_id;
    $where_data_name = $data_name == false ? '' : ' AND `d`.`name` = "'. $data_name . '"';
    $where_insts = $nr_insts == false ? '' : ' AND `d`.`did` IN (select data from data_quality dq where quality="NumberOfInstances" and value ' . (strpos($nr_insts, '..') !== false ? 'BETWEEN ' . str_replace('..',' AND ',$nr_insts) : '= '. $nr_insts) . ') ';
    $where_feats = $nr_feats == false ? '' : ' AND `d`.`did` IN (select data from data_quality dq where quality="NumberOfFeatures" and value ' . (strpos($nr_feats, '..') !== false ? 'BETWEEN ' . str_replace('..',' AND ',$nr_feats) : '= '. $nr_feats) . ') ';
    $where_class = $nr_class == false ? '' : ' AND `d`.`did` IN (select data from data_quality dq where quality="NumberOfClasses" and value ' . (strpos($nr_class, '..') !== false ? 'BETWEEN ' . str_replace('..',' AND ',$nr_class) : '= '. $nr_class) . ') ';
    $where_miss = $nr_miss == false ? '' : ' AND `d`.`did` IN (select data from data_quality dq where quality="NumberOfMissingValues" and value ' . (strpos($nr_miss, '..') !== false ? 'BETWEEN ' . str_replace('..',' AND ',$nr_miss) : '= '. $nr_miss) . ') ';

    $where_total = $where_type . $where_tag . $where_data_tag . $where_status . $where_did . $where_data_name . $where_insts . $where_feats . $where_class . $where_miss;
    $where_task_total = $where_type . $where_tag;
    
    $where_limit = $limit == false ? '' : ' LIMIT ' . $limit;
    if($limit != false && $offset != false){
      $where_limit =  ' LIMIT ' . $offset . ',' . $limit;
    }
    
    // three level query. in case scalability once forces us to drop some info. 
    $core = 'SELECT `t`.`task_id` , `t`.`ttid` , `tt`.`name` , `source`.`value` AS `did` , `d`.`status` , `d`.`format` , `d`.`name` AS `dataset_name` , GROUP_CONCAT( `ti`.`input` ) AS `task_inputs` , GROUP_CONCAT( `ti`.`value` ) AS `input_values` ' .
            'FROM `task` `t` , `task_type` `tt` , `task_inputs` `ti` , `task_inputs` `source` , `dataset` `d` ' .
            'WHERE `ti`.`task_id` = `t`.`task_id` AND `source`.`input` = "source_data" ' .
            'AND `source`.`task_id` = `t`.`task_id` AND `source`.`value` = `d`.`did` ' .
            'AND `tt`.`ttid` = `t`.`ttid` ' . $where_total .
            'GROUP BY t.task_id' . $where_limit;
    $tags = 'SELECT `core`.*, GROUP_CONCAT(`task_tag`.`tag`) AS `tags` FROM `task_tag` RIGHT JOIN (' . $core . ') `core` ON `core`.`task_id` = `task_tag`.`id` GROUP BY `core`.`task_id`';
    $full = 'SELECT tags.*, GROUP_CONCAT(`quality`) AS `qualities`, GROUP_CONCAT(`value`) AS `quality_values` FROM data_quality dq RIGHT JOIN (' . $tags . ') tags ON dq.data = tags.did GROUP BY tags.task_id WHERE dq.task_id IN ("' . implode('","', $this->config->item('basic_qualities')).'");';
    
    $task_res = $this->Task->query($full);
    
    if(is_array($tasks_res) == false || count($tasks_res) == 0) {
      $this->returnError(482, $this->version);
      return;
    }

    $this->xmlContents( 'tasks', $this->version, array( 'tasks' => $tasks_res ) );
  }


  private function task($task_id) {
    if($task_id == false) {
      $this->returnError(150, $this->version);
      return;
    }

    $task = $this->Task->getById($task_id);
    if($task === false) {
      $this->returnError(151, $this->version);
      return;
    }

    $task_type = $this->Task_type->getById($task->ttid);
    if ($task_type === false) {
      $this->returnError(151, $this->version);
      return;
    }

    $inputs = $this->Task_inputs->getAssociativeArray('input', 'value', 'task_id = ' . $task_id);


    $parsed_io = $this->Task_type_inout->getParsed($task_id);
    $tags = $this->Task_tag->getColumnWhere('tag', 'id = ' . $task_id);

    $name = 'Task ' . $task_id . ' (' . $task_type->name . ')';

    if (array_key_exists('source_data', $inputs)) {
      $dataset = $this->Dataset->getById($inputs['source_data']);
      $name = 'Task ' . $task_id . ': ' . $dataset->name . ' (' . $task_type->name . ')';
    }


    $this->xmlContents('task-get', $this->version, array('task' => $task, 'task_type' => $task_type, 'name' => $name, 'parsed_io' => $parsed_io, 'tags' => $tags));
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

    $description = isset( $_FILES['description'] ) ? $_FILES['description'] : false;
    if( ! check_uploaded_file( $description ) ) {
      $this->returnError(530, $this->version);
      return;
    }

    $descriptionFile = $_FILES['description']['tmp_name'];

    $xsd = xsd('openml.task.upload', $this->controller, $this->version);
    if (!$xsd) {
      $this->returnError(531, $this->version, $this->openmlGeneralErrorCode);
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

    $task_type_id = intval($xml->children('oml', true)->{'task_type_id'});
    $inputs = array();
    $tags = array();
    
    // for legal input check
    $legal_inputs = $this->Task_type_inout->getAssociativeArray('name', 'requirement', 'ttid = ' . $task_type_id . ' AND io = "input"');
    // for required input check
    $required_inputs = $this->Task_type_inout->getAssociativeArray('name', 'requirement', 'ttid = ' . $task_type_id . ' AND io = "input" AND requirement = "required"');
    
    foreach($xml->children('oml', true) as $input) {
      // iterate over all fields, to extract tags and inputs. 
      if ($input->getName() == 'input') {
        $name = $input->attributes() . '';
        
        // check if input is no duplicate
        if (array_key_exists($name, $inputs)) {
          $this->returnError(536, $this->version, $this->openmlGeneralErrorCode, 'problematic input: ' . $name);
          return;
        }
        
        // check if input is legal
        if (array_key_exists($name, $legal_inputs) == false) {
          $this->returnError(535, $this->version, $this->openmlGeneralErrorCode, 'problematic input: ' . $name);
          return;
        }
        
        // TODO: custom check. if key is source data, check if dataset exists. 
        // TODO: custom check. if key is estimation procedure, check if EP exists (and collides with task_type_id). 
        // TODO: custom check. if key is target value, check if it exists. 
        
        $inputs[$name] = $input . '';
        // maybe a required input is satisfied
        unset($required_inputs[$name]);
        
      } elseif ($input->getName() == 'tag') {
        $tags[] = $input . '';
      }
    }
    
    // required inputs should be empty by now
    if (count($required_inputs) > 0) {
      $this->returnError(537, $this->version, $this->openmlGeneralErrorCode, 'problematic input(s): ' . implode(', ', array_keys($required_inputs)));
      return;
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
    
    // update elastic search index.
    $this->elasticsearch->index('task', $id);

    foreach($tags as $tag) {
      $this->entity_tag_untag('task', $id, $tag, false, 'task', true);
      // if tagging went wrong, an error is displayed. (TODO: something else?)
      if (!$success) return;
    }

    $this->xmlContents( 'task-upload', $this->version, array( 'id' => $id ) );
  }
}
?>
