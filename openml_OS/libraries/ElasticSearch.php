<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ElasticSearch {

  public function __construct() {
    $this->CI = &get_instance();
    $this->CI->load->model('Dataset');
    $this->CI->load->model('Author');
    $this->CI->load->model('Data_quality');
    $this->CI->load->model('Dataset_tag');
    $this->CI->load->model('Implementation_tag');
    $this->CI->load->model('Setup_tag');
    $this->CI->load->model('Task_tag');
    $this->CI->load->model('Run_tag');
    $this->CI->load->model('Algorithm_quality');
    $this->CI->load->model('Estimation_procedure');
    $this->db = $this->CI->Dataset;
    $this->userdb = $this->CI->Author;

    $params['hosts'] = array ('http://es.openml.org');
    //, http://'.ES_USERNAME.':'.ES_PASSWORD.'@es.openml.org'
    $this->client = new Elasticsearch\Client($params);

    $this->data_names = $this->CI->Dataset->getAssociativeArray('did','name','name IS NOT NULL');
    $this->flow_names = $this->CI->Implementation->getAssociativeArray('id','fullName','name IS NOT NULL');
    $this->procedure_names = $this->CI->Estimation_procedure->getAssociativeArray('id','name','name IS NOT NULL');
    $this->user_names = array();
    $author = $this->userdb->get();
    if( is_array( $author ) )
    foreach( $author as $a ) {
      $this->user_names[$a->id] = $a->first_name.' '.$a->last_name;
    }

    $this->mappings['data'] = array(
      '_all' => array(
        'enabled' => true,
        'stored' => 'yes',
        'type' => 'string',
        'analyzer' => 'snowball'
      ),
      '_timestamp' => array( 'enabled' => true),
      '_type' => array( 'enabled' => true	),
      'properties' => array(
        'date' => array(
          'type' => 'date',
          'format' => 'yyyy-MM-dd HH:mm:ss'),
          'uploader' => array(
            'type' => 'string',
            'analyzer' => 'keyword'
          ),
          'exact_name' => array(
            'type' => 'string',
            'index' => 'not_analyzed'
          ),
          'tags' => array(
            'type' => 'nested',
            'properties' => array(
              'tag' => array('type' => 'string'),
              'uploader' => array('type' => 'string'))),
              'last_update' => array(
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss'),
                'description' => array(
                  'type' => 'string',
                  'analyzer' => 'snowball'),
                  'data_id' => array('type' => 'long'),
                  'version' => array('type' => 'float'),
                  'name' => array(
                    'type' => 'string',
                    'analyzer' => 'snowball'),
                    'visibility' => array(
                      'type' => 'string',
                      'index' => 'not_analyzed'),
                      'format' => array(
                        'type' => 'string',
                        'index' => 'not_analyzed'),
                        'suggest' => array(
                          'type' => 'completion',
                          'index_analyzer' => 'simple',
                          'search_analyzer' => 'simple',
                          'payloads' => true,
                          'max_input_length' => 100)
                        )
                      );
                      $this->mappings['flow'] = array('_all' => array(
                        'enabled' => true,
                        'stored' => 'yes',
                        'type' => 'string',
                        'analyzer' => 'snowball'
                      ),
                      '_timestamp' => array( 'enabled' => true),
                      '_type' => array( 'enabled' => true	),
                      'properties' => array(
                        'date' => array(
                          'type' => 'date',
                          'format' => 'yyyy-MM-dd HH:mm:ss'
                        ),
                        'exact_name' => array(
                          'type' => 'string',
                          'index' => 'not_analyzed'
                        ),
                        'tags' => array(
                          'type' => 'nested',
                          'properties' => array(
                            'tag' => array('type' => 'string'),
                            'uploader' => array('type' => 'string'))),
                            'flow_id' => array('type' => 'long'),
                            'version' => array('type' => 'float'),
                            'last_update' => array(
                              'type' => 'date',
                              'format' => 'yyyy-MM-dd HH:mm:ss'
                            ),
                            'uploader' => array(
                              'type' => 'string',
                              'analyzer' => 'keyword'
                            ),
                            'description' => array(
                              'type' => 'string',
                              'analyzer' => 'snowball'
                            ),
                            'full_description' => array(
                              'type' => 'string',
                              'analyzer' => 'snowball'
                            ),
                            'name' => array(
                              'type' => 'string',
                              'analyzer' => 'snowball'
                            ),
                            'suggest' => array(
                              'type' => 'completion',
                              'index_analyzer' => 'standard',
                              'search_analyzer' => 'standard',
                              'payloads' => true,
                              'max_input_length' => 100
                            )
                          )
                        );
                        $this->mappings['user'] = array('_all' => array(
                          'enabled' => true,
                          'stored' => 'yes',
                          'type' => 'string',
                          'analyzer' => 'snowball'
                        ),
                        '_timestamp' => array( 'enabled' => true),
                        '_type' => array( 'enabled' => true	),
                        'properties' => array(
                          'date' => array(
                            'type' => 'date',
                            'format' => 'yyyy-MM-dd HH:mm:ss'
                          ),
                          'last_update' => array(
                            'type' => 'date',
                            'format' => 'yyyy-MM-dd HH:mm:ss'
                          ),
                          'suggest' => array(
                            'type' => 'completion',
                            'index_analyzer' => 'standard',
                            'search_analyzer' => 'standard',
                            'payloads' => true,
                            'max_input_length' => 100
                          )
                        )
                      );
                      $this->mappings['task'] = array('_all' => array(
                        'enabled' => true,
                        'stored' => 'yes',
                        'type' => 'string',
                        'analyzer' => 'snowball'
                      ),
                      '_timestamp' => array( 'enabled' => true),
                      '_type' => array( 'enabled' => true	),
                      'properties' => array(
                        'date' => array(
                          'type' => 'date',
                          'format' => 'yyyy-MM-dd HH:mm:ss'),
                          'suggest' => array(
                            'type' => 'completion',
                            'index_analyzer' => 'standard',
                            'search_analyzer' => 'standard',
                            'payloads' => true,
                          ),
                          'tags' => array(
                            'type' => 'nested',
                            'properties' => array(
                              'tag' => array('type' => 'string'),
                              'uploader' => array('type' => 'string'))),
                            'task_id' => array('type' => 'long'),
                            'date' => array(
                              'type' => 'date',
                              'format' => 'yyyy-MM-dd HH:mm:ss')
                            )
                          );
                          $this->mappings['task_type'] = array('_all' => array(
                            'enabled' => true,
                            'stored' => 'yes',
                            'type' => 'string',
                            'analyzer' => 'snowball'
                          ),
                          '_timestamp' => array( 'enabled' => true),
                          '_type' => array( 'enabled' => true	),
                          'properties' => array(
                            'description' => array(
                              'type' => 'string',
                              'analyzer' => 'snowball'
                            ),
                            'name' => array(
                              'type' => 'string',
                              'analyzer' => 'snowball'
                            ),
                            'date' => array(
                              'type' => 'date',
                              'format' => 'yyyy-MM-dd HH:mm:ss'),
                              'suggest' => array(
                                'type' => 'completion',
                                'index_analyzer' => 'standard',
                                'search_analyzer' => 'standard',
                                'payloads' => true,
                                'max_input_length' => 100
                              )
                            )
                          );
                          $this->mappings['run'] = array('_all' => array(
                            'enabled' => true,
                            'stored' => 'yes',
                            'type' => 'string',
                            'analyzer' => 'snowball'
                          ),
                          '_timestamp' => array( 'enabled' => true),
                          '_type' => array( 'enabled' => true	),
                          'properties' => array(
                            'date' => array(
                              'type' => 'date',
                              'format' => 'yyyy-MM-dd HH:mm:ss'
                            ),
                            'tags' => array(
                              'type' => 'nested',
                              'properties' => array(
                                'tag' => array('type' => 'string'),
                                'uploader' => array('type' => 'string'))),
                              'run_id' => array('type' => 'long'),
                              'last_update' => array(
                                'type' => 'date',
                                'format' => 'yyyy-MM-dd HH:mm:ss'
                              ),
                              'uploader' => array(
                                'type' => 'string',
                                'analyzer' => 'keyword'
                              ),
                              'evaluations' => array(
                                'type' => 'nested',
                                'properties' => array(
                                  'evaluation_measure' => array('type' => 'string')
                                )
                              )
                            )
                          );
                          $this->mappings['study'] = array('_all' => array(
                            'enabled' => true,
                            'stored' => 'yes',
                            'type' => 'string',
                            'analyzer' => 'snowball'
                          ),
                          '_timestamp' => array( 'enabled' => true),
                          '_type' => array( 'enabled' => true	),
                          'properties' => array(
                            'date' => array(
                              'type' => 'date',
                              'format' => 'yyyy-MM-dd HH:mm:ss'
                            ),
                            'study_id' => array('type' => 'long'),
                            'uploader' => array(
                                'type' => 'string',
                                'analyzer' => 'keyword'
                            )
                            )
                          );
                          $this->mappings['measure'] = array('_all' => array(
                            'enabled' => true,
                            'stored' => 'yes',
                            'type' => 'string',
                            'analyzer' => 'snowball'
                          ),
                          '_timestamp' => array( 'enabled' => true),
                          '_type' => array( 'enabled' => true	),
                          'properties' => array(
                            'description' => array(
                              'type' => 'string',
                              'analyzer' => 'snowball'
                            ),
                            'name' => array(
                              'type' => 'string',
                              'analyzer' => 'snowball'
                            ),
                            'date' => array(
                              'type' => 'date',
                              'format' => 'yyyy-MM-dd HH:mm:ss'),
                              'suggest' => array(
                                'type' => 'completion',
                                'index_analyzer' => 'standard',
                                'search_analyzer' => 'standard',
                                'payloads' => true,
                                'max_input_length' => 100
                              )
                            )
                          );
                        }

                        public function test() {
                          return $this->client->ping();
                        }

                        public function get_types() {
                          $params['index'] = 'openml';
                          $array_data = $this->client->indices()->getMapping($params);
                          return array_keys($array_data['openml']['mappings']);
                        }

                        public function index($type, $id = false){
                          $method_name = 'index_' . $type;
                          if( method_exists( $this, $method_name ) ) {
                            try {
                              return $this->$method_name($id);
                            } catch( Exception $e ) {
                              // TODO: log?
                            }
                          }
                          else{
                            return 'No function exists to build index of type '.$type;
                          }
                        }

                        public function index_from($type, $id = false){
                          $method_name = 'index_' . $type;
                          if( method_exists( $this, $method_name ) ) {
                            try {
                              return $this->$method_name(false,$id);
                            } catch( Exception $e ) {
                              // TODO: log?
                            }
                          }
                          else{
                            return 'No function exists to build index of type '.$type;
                          }
                        }

                        public function delete($type, $id = false){
                          $deleteParams = array();
                          $deleteParams['index'] = 'openml';
                          $deleteParams['type'] = $type;
                          $deleteParams['id'] = $id;
                          $response = $client->delete($deleteParams);
                          return $response;
                        }

                        public function initialize_settings(){

                          $params['index'] = 'openml';
                          $params['body']['index']['analysis']['analyzer']['keyword-ci'] = array('tokenizer' => 'keyword', 'filter' => 'lowercase');
                          $this->client->indices()->putSettings($params);

                          return 'Successfully updated settings';
                        }

                        public function initialize_index($t){

                          $this->mapping_delete($t);

                          $params['index'] = 'openml';
                          $params['type'] = $t;
                          $params['body'][$t] = $this->mappings[$t];
                          $this->client->indices()->putMapping($params);

                          return 'Successfully reinitialized index for '.$t;
                        }

                        public function mapping_delete($m){
                          $params['index'] = 'openml';
                          $array_data = $this->client->indices()->getMapping($params);
                          $keys = array_keys($array_data['openml']['mappings']);
                          if(in_array($m,$keys)){
                            $params = array(
                              'index' => 'openml',
                              'type'	=> $m
                            );
                            $this->client->indices()->deleteMapping($params);
                          }
                        }

                        public function index_user($id, $start_id = 0){

                          $params['index']     = 'openml';
                          $params['type']      = 'user';

                          $users = $this->userdb->query('select id, first_name, last_name, email, affiliation, country, bio, image, created_on from users where active="1"'.($id?' and id='.$id:''));

                          if($id and !$users)
                          return 'Error: user '.$id.' is unknown';

                          foreach( $users as $d ) {
                            $params['body'][] = array(
                              'index' => array(
                                '_id' => $d->id
                              )
                            );

                            $params['body'][] = $this->build_user($d);
                          }

                          $responses = $this->client->bulk($params);
                          return 'Successfully indexed '.sizeof($responses['items']).' out of '.sizeof($users).' users.';
                        }

                        private function build_user($d){
                          $user = array(
                            'user_id' 		=> $d->id,
                            'first_name' 	=> $d->first_name,
                            'last_name' 	=> $d->last_name,
                            'email' 		=> $d->email,
                            'affiliation' 	=> $d->affiliation,
                            'country'	 	=> $d->country,
                            'bio' 		=> $d->bio,
                            'image'		=> $d->image,
                            'date'		=> $d->created_on,
                            'visibility'	=> 'public',
                            'suggest'		=> array(
                              'input' => array($d->first_name,$d->last_name),
                              'output'=> $d->first_name.' '.$d->last_name,
                              'weight'=> 5,
                              'payload' => array(
                                'type' => 'user',
                                'user_id' => $d->id,
                                'description' => substr($d->affiliation, 0, 100)
                              )
                            )
                          );
                          $data_up = $this->db->query('select count(did) as count from dataset where uploader='.$d->id);
                          if($data_up)
                          $user['datasets_uploaded'] = $data_up[0]->count;

                          $flows_up = $this->db->query('select count(id) as count from implementation where uploader='.$d->id);
                          if($flows_up)
                          $user['flows_uploaded'] = $flows_up[0]->count;

                          $runs_up = $this->db->query('select count(rid) as count from run where uploader='.$d->id);
                          if($runs_up)
                          $user['runs_uploaded'] = $runs_up[0]->count;

                          $runs_data = $this->db->query('select count(rid) as count FROM run r, task_inputs t, dataset d WHERE r.task_id=t.task_id and t.input="source_data" and t.value=d.did and d.uploader='.$d->id);
                          if($runs_data)
                          $user['runs_on_datasets'] = $runs_data[0]->count;

                          $runs_flows = $this->db->query('select count(rid) as count FROM run r, algorithm_setup s, implementation i WHERE r.setup=s.sid and s.implementation_id=i.id and i.uploader='.$d->id);
                          if($runs_flows)
                          $user['runs_on_flows'] = $runs_flows[0]->count;

                          return $user;
                        }

                        public function index_study($id, $start_id = 0){

                          $params['index']     = 'openml';
                          $params['type']      = 'study';

                          $studies = $this->db->query('select * from study'.($id?' where id='.$id:''));

                          if($id and !$studies)
                            return 'Error: study '.$id.' is unknown';

                          foreach( $studies as $s ) {
                            $params['body'][] = array(
                              'index' => array(
                                '_id' => $s->id
                              )
                            );

                            $params['body'][] = $this->build_study($s);
                          }

                          $responses = $this->client->bulk($params);
                          return 'Successfully indexed '.sizeof($responses['items']).' out of '.sizeof($studies).' studies.';
                        }

                        private function build_study($d){
                          $study = array(
                            'study_id' 		=> $d->id,
                            'name' 	=> $d->name,
                            'description' => $d->description,
                            'date' 	=> $d->created,
                            'uploader_id'	 	=> $d->creator,
                            'uploader' 		=> array_key_exists($d->creator,$this->user_names) ? $this->user_names[$d->creator] : 'Unknown',
                            'visibility'	 	=> $d->visibility,
                            'suggest'		=> array(
                              'input' => array($d->name,$d->description),
                              'output'=> $d->name,
                              'weight'=> 5,
                              'payload' => array(
                                'type' => 'study',
                                'study_id' => $d->id,
                                'description' => substr($d->description, 0, 100)
                                )
                                )
                          );
                          $study['datasets_included'] = 0;
                          $study['tasks_included'] = 0;
                          $study['flows_included'] = 0;
                          $study['runs_included'] = 0;

                          $data_tagged = $this->db->query("select count(id) as count from dataset_tag where tag='study_".$d->id."'");
                          if($data_tagged)
                            $study['datasets_included'] = $data_tagged[0]->count;

                          $task_tagged = $this->db->query("select count(id) as count from task_tag where tag='study_".$d->id."'");
                          if($task_tagged)
                            $study['tasks_included'] = $task_tagged[0]->count;

                          $flows_tagged = $this->db->query("select count(id) as count from implementation_tag where tag='study_".$d->id."'");
                          if($flows_tagged)
                            $study['flows_included'] = $flows_tagged[0]->count;

                          $runs_tagged = $this->db->query("select count(id) as count from run_tag where tag='study_".$d->id."'");
                          if($runs_tagged)
                            $study['runs_included'] = $runs_tagged[0]->count;

                          return $study;
                        }

                        public function index_task($id, $start_id = 0){
                          $params['index']     = 'openml';
                          $params['type']      = 'task';

                          $taskmaxquery = $this->db->query('SELECT min(task_id) as mintask, max(task_id) as maxtask from task'.($id?' where task_id='.$id:''));
                          $taskcountquery = $this->db->query('SELECT count(task_id) as taskcount from task'.($id?' where task_id='.$id:''));
                          $taskmin = intval($taskmaxquery[0]->mintask);
                          $taskmax = intval($taskmaxquery[0]->maxtask);
                          $taskcount = intval($taskcountquery[0]->taskcount);

                          $task_id = max($taskmin,$start_id);
                          $submitted = 0;
                          $incr = min(100,$taskcount);
                          while ($task_id <= $taskmax){
                            $tasks = null;
                            $params['body'] = array();
                            $tasks = $this->db->query('select a.*, b.runs from (SELECT t.task_id, tt.ttid, tt.name, t.creation_date FROM task t, task_type tt where t.ttid=tt.ttid and task_id>='.$task_id.' and task_id<'.($task_id+$incr).') as a left outer join (select task_id, count(rid) as runs from run r group by task_id) as b on a.task_id=b.task_id');
                            if($tasks){
                            foreach( $tasks as $t ) {
                              $params['body'][] = array(
                                'index' => array(
                                  '_id' => $t->task_id
                                )
                              );
                              $params['body'][] = $this->build_task($t);
                            }
                            $responses = $this->client->bulk($params);

                            $submitted += sizeof($responses['items']);
                            }
                            $task_id += $incr;
                          }

                          return 'Successfully indexed '.$submitted.' out of '.$taskcount.' tasks.';
                        }

                        private function build_task($d){

                          $newdata = array(
                            'task_id' 		=> $d->task_id,
                            'runs' 		=> $this->checkNumeric($d->runs),
                            'visibility'	=> 'public',
                            'tasktype'		=> array(
                              'tt_id' => $d->ttid,
                              'name' => $d->name
                            ),
                            'date' 		=> $d->creation_date
                          );

                          $description = array();
                          $description[] = $d->name;

                          $task = $this->db->query('SELECT i.input, ti.type, i.value  FROM task_inputs i, task_type_inout ti, task t  where i.input=ti.name and ti.ttid=t.ttid and t.task_id=i.task_id and i.task_id='.$d->task_id);
                          $did = 0;
                          if($task){
                            foreach( $task as $t ) {
                              if($t->type == 'Dataset'){
                                $description[] = $this->data_names[$t->value];
                                $newdata[$t->input] = array(
                                  'type' => $t->type,
                                  'data_id' => $t->value,
                                  'name' => $this->data_names[$t->value]
                                );
                                $did = $t->value;
                              }
                              else if($t->type == 'Estimation Procedure'){
                                $description[] = $this->procedure_names[$t->value];
                                $newdata[$t->input] = array(
                                  'type' => $t->type,
                                  'proc_id' => $t->value,
                                  'name' => $this->procedure_names[$t->value]
                                );
                              }
                              else if($t->input == 'target_feature'){
                                $description[] = $t->value;
                                $newdata[$t->input] = $t->value;
                                $targets = $this->db->query('SELECT data_type, ClassDistribution FROM data_feature where did='.$did.' and name="'.$t->value.'"');
                                if($targets){
                                  if($targets[0]->data_type == "nominal"){
                                    $distr = json_decode($targets[0]->ClassDistribution);
                                    if($distr){
                                      $newdata['target_values'] = $distr[0];
                                    }
                                  }
                                }
                              }
                              else{
                                if(strpos($t->value,'http') === false){
                                  $description[] = $t->value;}
                                  $newdata[$t->input] = $t->value;
                                }
                              }
                            }

                            $newdata['tags'] = array();
                            $tags = $this->CI->Task_tag->getAssociativeArray('tag', 'uploader', 'id = '.$d->task_id);
                            if( $tags != false ){
                              foreach( $tags as $t => $u ) {
                                $newdata['tags'][] = array(
                                  'tag' => $t,
                                  'uploader' => $u );
                                }
                              }

                            $newdata['suggest'] = array(
                              'input' => $description,
                              'output'=> 'Task '.$d->task_id,
                              'payload' => array(
                                'type' => 'task',
                                'task_id' => $d->task_id,
                                'description' => substr(implode(' ',$description), 0, 100)
                                )
                              );
                              return $newdata;
                            }

                            private function fetch_setups($id = false){
                              $index = array();
                              $setups = $this->db->query('SELECT s.setup, i.fullName, s.value FROM input_setting s, input i where i.id=s.input_id'.($id?' and s.setup='.$id:''));
                              if($setups)
                              foreach($setups as $v ) {
                                $index[$v->setup][] = array('parameter' => $v->fullName, 'value' => $v->value);
                              }
                              return $index;
                            }

                            private function fetch_runfiles($min,$max){
                              $index = array();
                              foreach( $this->db->query('SELECT source, field, name, format, file_id from runfile where source >= '.$min.' and source < '.$max) as $r ) {
                                $index[$r->source][$r->field]['url'] = 'http://openml.org/data/download/'.$r->file_id.'/'.$r->name;
                                $index[$r->source][$r->field]['format'] = $r->format;
                              }
                              return $index;
                            }

                            function roundnum($i){
                              if(is_numeric($i))
                              return round($i,4);
                              else return $i;
                            }

                            private function fetch_evaluations($min,$max){
                              $index = array();
                              $folddata = $this->db->query('SELECT source, function, fold, `repeat`, value FROM evaluation_fold WHERE source >= '.$min.' and source < '.$max);
                              $allfolds = array();

                              if($folddata){
                                $curr_src = array();
                                $folds = array();
                                $curr_fold = array();
                                $rp = 0;
                                $src = 0;
                                $fct = "";
                                foreach($folddata as $f ) {
                                  if($f->source != $src){
                                    if(!empty($curr_fold)) $folds[] = $curr_fold;
                                    if(!empty($folds)) $curr_src[$fct] = $folds;
                                    if(!empty($curr_src)) $allfolds[$src] = $curr_src;
                                    $src = $f->source;
                                    $curr_src = array();
                                    $folds = array();
                                    $curr_fold = array();
                                    $fct = $f->function;
                                    $rp = $f->repeat;
                                  }
                                  elseif($f->function != $fct){
                                    if(!empty($curr_fold)) $folds[] = $curr_fold;
                                    if(!empty($folds)) $curr_src[$fct] = $folds;
                                    $folds = array();
                                    $curr_fold = array();
                                    $fct = $f->function;
                                    $rp = $f->repeat;
                                  }
                                  elseif($f->repeat != $rp){
                                    if(!empty($curr_fold)) $folds[] = $curr_fold;
                                    $rp = $f->repeat;
                                    $curr_fold = array();
                                  }
                                  if($f->value) $curr_fold[] = round($f->value,4);
                                }
                                $folds[] = $curr_fold;
                                $curr_src[$fct] = $folds;
                                $allfolds[$src] = $curr_src;
                              }

                              $evals = $this->db->query('SELECT source, function, value, stdev, array_data FROM evaluation WHERE source >= '.$min.' and source < '.$max);
                              if($evals){
                                foreach($evals as $r ) {
                                  $neweval = array(
                                    'evaluation_measure' => $r->function
                                  );
                                  if($r->value){$neweval['value'] = (is_numeric($r->value) ? round($r->value,4) : $r->value);}
                                  if($r->stdev){$neweval['stdev'] = round($r->stdev,4);}
                                  if($r->array_data){
                                    $arrayd = str_replace('?','null',$r->array_data);
                                    if(json_decode($arrayd)){
                                      $arrayd = array_map(array($this, 'roundnum'),json_decode($arrayd));
                                      $neweval['array_data'] = $arrayd;
                                    } else {
                                      $neweval['data'] = $arrayd;
                                    }
                                  }
                                  if(array_key_exists($r->source,$allfolds) and array_key_exists($r->function,$allfolds[$r->source]))
                                  $neweval['per_fold'] = $allfolds[$r->source][$r->function];
                                  $index[$r->source][] = $neweval;
                                }
                              }
                              return $index;
                            }


                            //update task, dataset, flow to make sure that their indexed run counts are up to date? Only needed for sorting on number of runs.
                            private function update_runcounts($run){
                              $runparams['index'] = 'openml';
                              $runparams['type'] = 'run';
                              $runparams['body']['query']['match']['run_task.task_id'] = $run->task_id;
                              $result = $this->client->search($runparams);
                              $runcount = $this->checkNumeric($result['hits']['total']);

                              $params['index'] = 'openml';
                              $params['type'] = 'task';
                              $params['id'] = $run->task_id;
                              $params['body'] = array( 'doc' => array( 'runs' => $runcount ) );
                              $this->client->update($params);

                              $runparams = array();
                              $runparams['index'] = 'openml';
                              $runparams['type'] = 'run';
                              $runparams['body']['query']['match']['run_flow.flow_id'] = $run->implementation_id;
                              $result = $this->client->search($runparams);
                              $runcount = $this->checkNumeric($result['hits']['total']);

                              $params['type'] = 'flow';
                              $params['id'] = $run->implementation_id;
                              $params['body'] = array( 'doc' => array( 'runs' => $runcount ) );
                              $this->client->update($params);
                            }

                            private function index_single_run($id){

                              $params['index']     = 'openml';
                              $params['type']      = 'run';
                              $params['id']        = $id;

                              $run = $this->db->query('SELECT rid, uploader, setup, implementation_id, task_id, start_time FROM run r, algorithm_setup s where s.sid=r.setup and rid='.$id);
                              if(!$run)
                              return 'Error: run '.$id.' is unknown';

                              $setups = $this->fetch_setups($run[0]->setup);
                              $runfiles = $this->fetch_runfiles($id,$id+1);
                              $evals = $this->fetch_evaluations($id,$id+1);
                              $params['body'] = $this->build_run($run[0],$setups,$runfiles,$evals);
                              //echo json_encode($params);
                              $responses = $this->client->index($params);
                              //print_r($responses);
                              $this->update_runcounts($run[0]);

                              return 'Successfully indexed '.sizeof($responses['_id']).' run(s).';
                            }

                            public function index_run($id, $start_id = 0){
                              if($id)
                              return $this->index_single_run($id);

                              $params['index']     = 'openml';
                              $params['type']      = 'run';

                              $setups = $this->fetch_setups();
                              $runmaxquery = $this->db->query('SELECT max(rid) as maxrun from run');
                              $runcountquery = $this->db->query('SELECT count(rid) as runcount from run');
                              $runmax = intval($runmaxquery[0]->maxrun);
                              $runcount = intval($runcountquery[0]->runcount);

                              $rid = $start_id;
                              $submitted = 0;
                              $incr = 100;
                              while ($rid < $runmax){
                                set_time_limit(600);
                                $runs = null;
                                $runfiles = null;
                                $evals = null;
                                $params['body'] = array();

                                $runs = $this->db->query('SELECT rid, uploader, setup, implementation_id, task_id, start_time FROM run r, algorithm_setup s where s.sid=r.setup and rid>='.$rid.' and rid<'.($rid+$incr));
                                $runfiles = $this->fetch_runfiles($rid,$rid+$incr);
                                $evals = $this->fetch_evaluations($rid,$rid+$incr);

                                foreach( $runs as $r ) {
                                  try {
                                  $params['body'][] = array(
                                    'index' => array(
                                      '_id' => $r->rid
                                    )
                                  );
                                  $params['body'][] = $this->build_run($r,$setups,$runfiles,$evals);
                                  } catch( Exception $e ) {
                                    // TODO: log?
                                  }
                                }
                                $responses = $this->client->bulk($params);

                                $submitted += sizeof($responses['items']);
                                $rid += $incr;
                              }

                              return 'Successfully indexed '.$submitted.' out of '.$runcount.' runs.';
                            }

                            private function build_run($r,$setups,$runfiles,$evals){
                              $new_data = array(
                                'run_id' 		=> $r->rid,
                                'uploader' 		=> array_key_exists($r->uploader,$this->user_names) ? $this->user_names[$r->uploader] : 'Unknown',
                                'uploader_id' => intval($r->uploader),
                                'run_task'		=> $this->build_task($r->task_id),
                                'date'		=> $r->start_time,
                                'run_flow'		=> array(
                                  'flow_id' => $r->implementation_id,
                                  'name' => $this->flow_names[$r->implementation_id],
                                  'parameters' => array_key_exists($r->setup,$setups) ? $setups[$r->setup] : array()
                                ),
                                'output_files'	=> array_key_exists($r->rid,$runfiles) ? $runfiles[$r->rid] : array(),
                                'evaluations'	=> array_key_exists($r->rid,$evals) ? $evals[$r->rid] : array(),
                                'visibility'	=> 'public'
                              );

                              $new_data['tags'] = array();
                              $tags = $this->CI->Run_tag->getAssociativeArray('tag', 'uploader', 'id = '.$r->rid);
                              if( $tags != false ){
                                foreach( $tags as $t => $u ) {
                                  $new_data['tags'][] = array(
                                    'tag' => $t,
                                    'uploader' => $u );
                                  }
                                }

                              return $new_data;
                            }

                            public function index_task_type($id, $start_id = 0){

                              $params['index']     = 'openml';
                              $params['type']      = 'task_type';

                              $types = $this->db->query('SELECT tt.ttid, tt.name, tt.description, count(task_id) as tasks, tt.date FROM task_type tt, task t where tt.ttid=t.ttid'.($id?' and tt.ttid='.$id:'').' group by tt.ttid');

                              if($id and !$types)
                              return 'Error: task type '.$id.' is unknown';

                              foreach( $types as $d ) {
                                $params['body'][] = array(
                                  'index' => array(
                                    '_id' => $d->ttid
                                  )
                                );

                                $params['body'][] =$this->build_task_type($d);
                              }

                              $responses = $this->client->bulk($params);

                              return 'Successfully indexed '.sizeof($responses['items']).' out of '.sizeof($types).' task types.';
                            }

                            private function build_task_type($d){
                              $new_data = array(
                                'tt_id' 		=> $d->ttid,
                                'name'    		=> $d->name,
                                'description' 	=> $d->description,
                                'tasks'		=> $d->tasks,
                                'visibility'	=> 'public',
                                'date' 		=> $d->date,
                                'suggest'		=> array(
                                  'input' => array($d->name,$d->description),
                                  'output'=> $d->name,
                                  'weight'=> 5,
                                  'payload' => array(
                                    'type' => 'task_type',
                                    'tt_id' => $d->ttid,
                                    'description' => substr($d->description, 0, 100)
                                  )
                                ),
                              );

                              $inputs = $this->db->query('SELECT name, type, description, io, requirement FROM task_type_inout where ttid='.$d->ttid);

                              foreach( $inputs as $i ) {
                                $new_data['input'][] = array(
                                  'name'    => $i->name,
                                  'type' 		=> $i->type,
                                  'description'	=> $i->description,
                                  'io' 		      => $i->io,
                                  'requirement' => $i->requirement
                                );
                              }
                              return $new_data;
                            }



                            public function index_flow($id, $start_id = 0){

                              $params['index']     = 'openml';
                              $params['type']      = 'flow';

                              $flows = $this->db->query('select i.*, count(rid) as runs from implementation i left join algorithm_setup s on (s.implementation_id=i.id) left join run r on (r.setup=s.sid)'.($id?' where i.id='.$id:'').' group by i.id');

                              if($id and !$flows)
                              return 'Error: flow '.$id.' is unknown';

                              foreach( $flows as $d ) {
                                $params['body'][] = array(
                                  'index' => array(
                                    '_id' => $d->id
                                  )
                                );

                                $params['body'][] =$this->build_flow($d);
                              }

                              $responses = $this->client->bulk($params);

                              return 'Successfully indexed '.sizeof($responses['items']).' out of '.sizeof($flows).' flows.';
                            }

                            private function build_flow($d){
                              $new_data = array(
                                'flow_id' 		=> $d->id,
                                'name'    		=> $d->name,
                                'exact_name'	=> $d->name,
                                'version' 		=> $d->version,
                                'external_version' => $d->external_version,
                                'licence' 	  => $d->licence,
                                'description' 	=> $d->description,
                                'full_description' 	=> $d->fullDescription,
                                'installation_notes'=> $d->installationNotes,
                                'uploader' 		=> array_key_exists($d->uploader,$this->user_names) ? $this->user_names[$d->uploader] : 'Unknown',
                                'uploader_id' => $d->uploader,
                                'creator'		=> $d->creator,
                                'contributor' 	=> $d->contributor,
                                'dependencies' 	=> $d->dependencies,
                                'date'		=> $d->uploadDate,
                                'runs' 		=> $this->checkNumeric($d->runs),
                                'visibility'	=> $d->visibility,
                                'suggest'		=> array(
                                  'input' => array(str_replace("weka.","",$d->name),$d->description),
                                  'output'=> $d->name,
                                  'weight'=> 5,
                                  'payload' => array(
                                    'type' => 'flow',
                                    'flow_id' => $d->id,
                                    'description' => substr($d->description, 0, 100)
                                    )
                                    )
                                  );

                                  $new_data['qualities'] = array();
                                  $qualities = $this->CI->Algorithm_quality->getAssociativeArray('quality','value','implementation_id = '.$d->id);
                                  if( $qualities != false )
                                  $new_data['qualities'] = array_map(array($this, 'checkNumeric'),$qualities);

                                  $new_data['tags'] = array();
                                  $tags = $this->CI->Implementation_tag->getAssociativeArray('tag', 'uploader', 'id = '.$d->id);
                                  if( $tags != false ){
                                    foreach( $tags as $t => $u ) {
                                      $new_data['tags'][] = array(
                                        'tag' => $t,
                                        'uploader' => $u );
                                      }
                                    }

                                    $new_data['components'] = array();
                                    $components = $this->db->query('SELECT identifier, i.id, i.fullName, n.description FROM implementation_component c, implementation i, input n WHERE c.child = i.id and n.implementation_id = c.parent and n.name= c.identifier and c.parent='.$d->id);
                                    if( $components != false ){
                                      foreach( $components as $p ) {
                                        $com = array(
                                          'identifier' => $p->identifier,
                                          'id' => $p->id,
                                          'name' => $p->fullName,
                                          'description' => $p->description
                                        );
                                        $new_data['components'][] = $com;
                                      }
                                    }

                                    $new_data['parameters'] = array();
                                    $parameters = $this->db->query('select * from input where implementation_id='.$d->id);
                                    if($parameters){
                                      foreach( $parameters as $p ) {
                                        $par = array(
                                          'name' => $p->name,
                                          'full_name' => $p->fullName,
                                          'description' => $p->description,
                                          'default_value' => $p->defaultValue,
                                          'recommended_range' => $p->recommendedRange,
                                          'data_type' => $p->dataType
                                        );
                                        $new_data['parameters'][] = $par;
                                      }
                                    }

                                    return $new_data;
                                  }

                                  public function index_measure($id, $start_id = 0){

                                    $params['index']     = 'openml';
                                    $params['type']      = 'measure';

                                    $procs = $this->db->query('SELECT e.*, t.description FROM estimation_procedure e, estimation_procedure_type t WHERE e.type=t.name'.($id?' and e.id='.$id:''));
                                    if($procs)
                                    foreach( $procs as $d ) {
                                      $params['body'][] = array(
                                        'index' => array(
                                          '_id' => $d->id
                                        )
                                      );

                                      $params['body'][] = $this->build_procedure($d);
                                    }

                                    $funcs = $this->db->query('SELECT * FROM math_function WHERE functionType="EvaluationFunction"'.($id?' and name="'.$id.'"':''));
                                    if($funcs)
                                    foreach( $funcs as $d ) {
                                      $nid = str_replace("_","-",$d->name);
                                      $params['body'][] = array(
                                        'index' => array(
                                          '_id' => $nid
                                        )
                                      );

                                      $params['body'][] = $this->build_function($d);
                                    }

                                    $dataqs = $this->db->query('SELECT * FROM quality WHERE type="DataQuality"'.($id?' and name="'.$id.'"':''));
                                    if($dataqs)
                                    foreach( $dataqs as $d ) {
                                      $nid = str_replace("_","-",$d->name);
                                      $params['body'][] = array(
                                        'index' => array(
                                          '_id' => $nid
                                        )
                                      );

                                      $params['body'][] = $this->build_dataq($d);
                                    }

                                    $flowqs = $this->db->query('SELECT * FROM quality WHERE type="AlgorithmQuality"'.($id?' and name="'.$id.'"':''));
                                    if($flowqs)
                                    foreach( $flowqs as $d ) {
                                      $nid = str_replace("_","-",$d->name);
                                      $params['body'][] = array(
                                        'index' => array(
                                          '_id' => $nid
                                        )
                                      );

                                      $params['body'][] = $this->build_flowq($d);
                                    }

                                    if($id and !array_key_exists('body',$params))
                                    return "No measure found with id ".$id;

                                    $responses = $this->client->bulk($params);
                                    return 'Successfully indexed '.sizeof($responses['items']).' out of '.(($procs?sizeof($procs):0)+($funcs?sizeof($funcs):0)+($dataqs?sizeof($dataqs):0)+($flowqs?sizeof($flowqs):0)).' measures ('.($procs?sizeof($procs):0).' procedures, '.($funcs?sizeof($funcs):0).' functions, '.($dataqs?sizeof($dataqs):0).' data qualities, '.($flowqs?sizeof($flowqs):0).' flow qualities).';
                                  }

                                  private function build_procedure($d){
                                    return array(
                                      'proc_id' 		=> $d->id,
                                      'type'    		=> 'estimation_procedure',
                                      'task_type'  	=> $d->ttid,
                                      'name'    		=> $d->name,
                                      'description' 	=> $d->description,
                                      'folds' 	    => $d->folds,
                                      'repeats' 	  => $d->repeats,
                                      'percentage'  => $d->percentage,
                                      'stratified_sampling' => $d->stratified_sampling,
                                      'visibility'	=> 'public',
                                      'date' 		=> $d->date,
                                      'suggest'		=> array(
                                        'input' => array($d->name,$d->description),
                                        'output'=> $d->name,
                                        'weight'=> 5,
                                        'payload' => array(
                                          'type' => 'estimation_procedure',
                                          'proc_id' => $d->id,
                                          'description' => substr($d->description, 0, 100)
                                        )
                                      )
                                    );
                                  }

                                  private function build_function($d){
                                    $id = str_replace("_","-",$d->name);
                                    return array(
                                      'eval_id' 		=> $id,
                                      'type'    		=> 'evaluation_measure',
                                      'name'    		=> $d->name,
                                      'description' 	=> $d->description,
                                      'min' 	      => $d->min,
                                      'max' 	      => $d->max,
                                      'unit' 	      => $d->unit,
                                      'higherIsBetter' => $d->higherIsBetter,
                                      'visibility'	=> 'public',
                                      'date' 		=> $d->date,
                                      'suggest'		=> array(
                                        'input' => array($d->name,$d->description),
                                        'output'=> $d->name,
                                        'weight'=> 5,
                                        'payload' => array(
                                          'type' => 'evaluation_measure',
                                          'eval_id' => $id,
                                          'description' => substr($d->description, 0, 100)
                                        )
                                      )
                                    );
                                  }

                                  private function build_dataq($d){
                                    $id = str_replace("_","-",$d->name);
                                    return array(
                                      'quality_id' 	=> $id,
                                      'type'    		=> 'data_quality',
                                      'name'    		=> $d->name,
                                      'description' 	=> $d->description,
                                      'function' 	=> $d->function,
                                      'priority' 	=> $d->priority,
                                      'visibility'	=> 'public',
                                      'date' 		=> $d->date,
                                      'suggest'		=> array(
                                        'input' => array($d->name,$d->description),
                                        'output'=> $d->name,
                                        'weight'=> 5,
                                        'payload' => array(
                                          'type' => 'data_quality',
                                          'quality_id' => $id,
                                          'description' => substr($d->description, 0, 100)
                                        )
                                      )
                                    );
                                  }

                                  private function build_flowq($d){
                                    $id = str_replace("_","-",$d->name);
                                    return array(
                                      'quality_id' 	=> $id,
                                      'type'    		=> 'flow_quality',
                                      'name'    		=> $d->name,
                                      'description' 	=> $d->description,
                                      'function' 	=> $d->function,
                                      'priority' 	=> $d->priority,
                                      'visibility'	=> 'public',
                                      'date' 		=> $d->date,
                                      'suggest'		=> array(
                                        'input' => array($d->name,$d->description),
                                        'output'=> $d->name,
                                        'weight'=> 5,
                                        'payload' => array(
                                          'type' => 'data_quality',
                                          'quality_id' => $id,
                                          'description' => substr($d->description, 0, 100)
                                        )
                                      )
                                    );
                                  }

                                  public function index_data($id, $start_id = 0){

                                    $params['index']     = 'openml';
                                    $params['type']      = 'data';

                                    $datasets = $this->db->query('select d.*, count(rid) as runs from dataset d left join task_inputs t on (t.value=d.did and t.input="source_data") left join run r on (r.task_id=t.task_id)'.($id?' where did='.$id:'').' group by did');

                                    if($id and !$datasets)
                                    return 'Error: data set '.$id.' is unknown';

                                    foreach( $datasets as $d ) {
                                      $params['body'][] = array(
                                        'index' => array(
                                          '_id' => $d->did
                                        )
                                      );

                                      $params['body'][] = $this->build_data($d);
                                    }

                                    $responses = $this->client->bulk($params);

                                    return 'Successfully indexed '.sizeof($responses['items']).' out of '.sizeof($datasets).' datasets.';
                                  }

                                  private function build_data($d){
                                    $headless_description = trim(preg_replace('/\s+/',' ',preg_replace('/^\*{2,}.*/m', '', $d->description)));
                                    $new_data = array(
                                      'data_id' 		=> $d->did,
                                      'name'    		=> $d->name,
                                      'exact_name'	=> $d->name,
                                      'version' 		=> $d->version,
                                      'version_label' 	=> $d->version_label,
                                      'description' 	=> $d->description,
                                      'format'		=> $d->format,
                                      'uploader' 		=> $this->user_names[$d->uploader],
                                      'uploader_id'	=> intval($d->uploader),
                                      'visibility' 	=> $d->visibility,
                                      'creator'		=> $d->creator,
                                      'contributor' 	=> $d->contributor,
                                      'date'		=> $d->upload_date,
                                      'update_comment'	=> $d->update_comment,
                                      'last_update'	=> $d->last_update,
                                      'licence'		=> $d->licence,
                                      'visibility'	=> $d->visibility,
                                      'url'		=> $d->url,
                                      'default_target_attribute' => $d->default_target_attribute,
                                      'row_id_attribute' 	=> $d->row_id_attribute,
                                      'ignore_attribute'  => $d->ignore_attribute,
                                      'runs' 		=> $this->checkNumeric($d->runs),
                                      'suggest'		=> array(
                                        'input' => array($d->name,substr($headless_description, 0, 100)),
                                        'output'=> $d->name,
                                        'weight'=> 5,
                                        'payload' => array(
                                          'type' => 'data',
                                          'data_id' => $d->did,
                                          'description' => substr($headless_description, 0, 100)
                                          )
                                          )
                                        );


                                        $new_data['qualities'] = array();
                                        $qualities = $this->CI->Data_quality->getAssociativeArray('quality','value','data = '.$d->did);
                                        if( $qualities != false )
                                        $new_data['qualities'] = array_map(array($this, 'checkNumeric'),$qualities);

                                        $new_data['tags'] = array();
                                        $tags = $this->CI->Dataset_tag->getAssociativeArray('tag', 'uploader', 'id = '.$d->did);
                                        if( $tags != false ){
                                          foreach( $tags as $t => $u ) {
                                            $new_data['tags'][] = array(
                                              'tag' => $t,
                                              'uploader' => $u );
                                            }
                                          }

                                          $new_data['features'] = array();
                                          $features = $this->db->query("SELECT name, `index`, data_type, is_target, is_row_identifier, is_ignore, NumberOfDistinctValues, NumberOfMissingValues, MinimumValue, MaximumValue, MeanValue, StandardDeviation, ClassDistribution FROM `data_feature` WHERE did=" . $d->did . " order by is_target limit 100");
                                          if( $features != false ){
                                            foreach( $features as $f ) {
                                              $feat = array(
                                                'name' => $f->name,
                                                'index' => $f->index,
                                                'type' => $f->data_type,
                                                'distinct' => $f->NumberOfDistinctValues,
                                                'missing' => $f->NumberOfMissingValues
                                              );
                                              if($f->is_target == "true")
                                              $feat['target'] = "1";
                                              if($f->is_row_identifier == "true")
                                              $feat['identifier'] = "1";
                                              if($f->is_ignore == "true")
                                              $feat['ignore'] = "1";
                                              if($f->data_type == "numeric"){
                                                $feat['min'] = $f->MinimumValue;
                                                $feat['max'] = $f->MaximumValue;
                                                $feat['mean'] = $f->MeanValue;
                                                $feat['stdev'] = $f->StandardDeviation;
                                              } elseif($f->data_type == "nominal"){
                                                $feat['distr'] = json_decode($f->ClassDistribution);
                                              }
                                              $new_data['features'][] = $feat;
                                            }
                                          }

                                          return $new_data;
                                        }

                                        public function checkNumeric($v){
                                          if(is_integer($v))
                                          return intval($v);
                                          else if(is_numeric($v))
                                          return doubleval($v);
                                          else
                                          return $v;
                                        }

                                      }
