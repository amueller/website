<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ElasticSearch {

  public function __construct() {
    $this->CI = &get_instance();
    $this->CI->load->model('Dataset');
    $this->CI->load->model('Author');
    $this->CI->load->model('Data_quality');
    $this->CI->load->model('Algorithm_quality');
    $this->CI->load->model('Estimation_procedure');
    $this->db = $this->CI->Dataset;
    $this->userdb = $this->CI->Author;
    
    $params['hosts'] = array ('http://openml.org:80');
    $this->client = new Elasticsearch\Client($params);

    $this->data_names = $this->CI->Dataset->getAssociativeArray('did','name','name IS NOT NULL');
    $this->flow_names = $this->CI->Implementation->getAssociativeArray('id','fullName','name IS NOT NULL');
    $this->procedure_names = $this->CI->Estimation_procedure->getAssociativeArray('id','name','name IS NOT NULL');
    $this->all_tasks = array();
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
                'properties' => array(
		    'date' => array(
			'type' => 'date',
			'format' => 'yyyy-MM-dd HH:mm:ss'
		    ),
		    'last_update' => array(
			'type' => 'date',
			'format' => 'yyyy-MM-dd HH:mm:ss'
		    ),
                    'description' => array(
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ),
                    'name' => array(
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ),
                    'visibility' => array(
                        'type' => 'string',
			'index' => 'not_analyzed'
                    ),
                    'format' => array(
                        'type' => 'string',
			'index' => 'not_analyzed'
                    ),

                    'suggest' => array(
                        'type' => 'completion',
			'index_analyzer' => 'simple',
			'search_analyzer' => 'simple',
			'payloads' => true,
			'max_input_length' => 100
                    )
                )
            );
     $this->mappings['flow'] = array('_all' => array(
                	'enabled' => true,
                	'stored' => 'yes',
			'type' => 'string',
			'analyzer' => 'snowball'
		),
		'_timestamp' => array( 'enabled' => true),
                'properties' => array(
		    'date' => array(
			'type' => 'date',
			'format' => 'yyyy-MM-dd HH:mm:ss'
		    ),
		    'last_update' => array(
			'type' => 'date',
			'format' => 'yyyy-MM-dd HH:mm:ss'
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
                'properties' => array(
                    'suggest' => array(
                        'type' => 'completion',
			'index_analyzer' => 'standard',
			'search_analyzer' => 'standard',
			'payloads' => true,
                    )
                )
            );
       $this->mappings['task_type'] = array('_all' => array(
                	'enabled' => true,
                	'stored' => 'yes',
			'type' => 'string',
			'analyzer' => 'snowball'
		),
		'_timestamp' => array( 'enabled' => true),
                'properties' => array(
                    'description' => array(
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
       $this->mappings['run'] = array('_all' => array(
                	'enabled' => true,
                	'stored' => 'yes',
			'type' => 'string',
			'analyzer' => 'snowball'
		),
		'_timestamp' => array( 'enabled' => true),
                'properties' => array(
		    'date' => array(
				'type' => 'date',
				'format' => 'yyyy-MM-dd HH:mm:ss'
		    ),
		    'last_update' => array(
			'type' => 'date',
			'format' => 'yyyy-MM-dd HH:mm:ss'
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
                'properties' => array(
                    'description' => array(
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

  public function delete($type, $id = false){
	$deleteParams = array();
	$deleteParams['index'] = 'openml';
	$deleteParams['type'] = $type;
	$deleteParams['id'] = $id;
	$response = $client->delete($deleteParams);
	return $response;
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

  public function index_user($id){

	$params['index']     = 'openml';
	$params['type']      = 'user';

	$users = $this->userdb->query('select id, first_name, last_name, email, affiliation, country, image, created_on from users where active="1"'.($id?' and id='.$id:''));

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
	return array(
		    'user_id' 		=> $d->id,
		    'first_name' 	=> $d->first_name,
		    'last_name' 	=> $d->last_name,
		    'email' 		=> $d->email,
		    'affiliation' 	=> $d->affiliation,
		    'country'	 	=> $d->country,
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
  }

 // Special case - tasks are pre-fetched because they are also needed to build the run index
 private function fetch_tasks($id = false){
	$tasks = $this->db->query('SELECT t.task_id, tt.ttid, tt.name, count(rid) as runs FROM task t left join run r on (r.task_id=t.task_id), task_type tt WHERE t.ttid=tt.ttid'.($id?' and t.task_id='.$id:'').' group by t.task_id');

	if($tasks)
		foreach( $tasks as $d ) {
		    $this->all_tasks[$d->task_id] = $this->build_task($d);
		}
 }

 public function index_task($id){

	$params['index']     = 'openml';
	$params['type']      = 'task';

	$this->fetch_tasks($id);

	if($id and !array_key_exists($id,$this->all_tasks))
		return 'Error: task '.$id.' is unknown';

	foreach( $this->all_tasks as $k => $v ) {
	    $params['body'][] = array(
		'index' => array(
		    '_id' => $k
		)
	    );
	    $params['body'][] = $v;
	}

	$responses = $this->client->bulk($params);

	return 'Successfully indexed '.sizeof($responses['items']).' out of '.sizeof($this->all_tasks).' tasks.';
  }

  private function build_task($d){

	$newdata = array(
		    'task_id' 		=> $d->task_id,
		    'runs' 		=> $this->checkNumeric($d->runs),
		    'visibility'	=> 'public',
		    'tasktype'		=> array(
						'tt_id' => $d->ttid,
						'name' => $d->name
					)
		);

	$description = array();
	$description[] = $d->name;

	$task = $this->db->query('SELECT i.input, ti.type, i.value  FROM task_inputs i, task_type_inout ti, task t  where i.input=ti.name and ti.ttid=t.ttid and t.task_id=i.task_id and i.task_id='.$d->task_id);
	if($task){
	    foreach( $task as $t ) {
		if($t->type == 'Dataset'){
			$description[] = $this->data_names[$t->value];
			$newdata[$t->input] = array(
						'type' => $t->type,
						'data_id' => $t->value,
						'name' => $this->data_names[$t->value]
						);
		}
		else if($t->type == 'Estimation Procedure'){
			$description[] = $this->procedure_names[$t->value];
			$newdata[$t->input] = array(
						'type' => $t->type,
						'proc_id' => $t->value,
						'name' => $this->procedure_names[$t->value]
						);
		}
		else{
			if(strpos($t->value,'http') === false){
				$description[] = $t->value;}
			$newdata[$t->input] = $t->value;
		}
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
	$setups = $this->db->query('SELECT setup, input, value FROM input_setting'.($id?' where setup='.$id:''));
	if($setups)
		foreach($setups as $v ) {
			$index[$v->setup][$v->input] = $v->value;
		}
	return $index;
 }

 private function fetch_runfiles($min,$max){
	$index = array();
	foreach( $this->db->query('SELECT source, field, name, format, file_id from runfile where source >= '.$min.' and source < '.$max) as $r ) {
		$index[$r->source][$r->field] = 'http://openml.liacs.nl/data/download/'.$r->file_id.'/'.$r->name;
	}
	return $index;
 }

 private function fetch_evaluations($min,$max){
	$index = array();
	$evals = $this->db->query('SELECT source, function, value, stdev, array_data FROM evaluation WHERE source >= '.$min.' and source < '.$max);
	if($evals){
	    foreach($evals as $r ) {
		if($r->value){
			if($r->stdev)
				$index[$r->source][$r->function] = $r->value.' +- '.$r->stdev;
			else
				$index[$r->source][$r->function] = $r->value;
		} else {
			$index[$r->source][$r->function] = $r->array_data;
		}
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

	$this->fetch_tasks($run[0]->task_id);
	$setups = $this->fetch_setups($run[0]->setup);
	$runfiles = $this->fetch_runfiles($id,$id+1);
	$evals = $this->fetch_evaluations($id,$id+1);
	$params['body'] = $this->build_run($run[0],$setups,$runfiles,$evals);

	$responses = $this->client->index($params);

	$this->update_runcounts($run[0]);

	return 'Successfully indexed '.sizeof($responses['_id']).' run(s).';
 }

 public function index_run($id){
	if($id)
		return $this->index_single_run($id);

	$params['index']     = 'openml';
	$params['type']      = 'run';

	$setups = $this->fetch_setups();
  $runmaxquery = $this->db->query('SELECT max(rid) as maxrun from run');
  $runcountquery = $this->db->query('SELECT count(rid) as runcount from run');
	$runmax = intval($runmaxquery[0]->maxrun);
	$runcount = intval($runcountquery[0]->runcount);
	if(!$this->all_tasks)
		$this->fetch_tasks();

	$rid = 0;
	$submitted = 0;
	$incr = 1000;
	while ($rid < $runmax){
		$rid += 1;

		$runs = $this->db->query('SELECT rid, uploader, setup, implementation_id, task_id, start_time FROM run r, algorithm_setup s where s.sid=r.setup and rid>='.$rid.' and rid<'.($rid+$incr));
		$runfiles = $this->fetch_runfiles($rid,$rid+$incr);
		$evals = $this->fetch_evaluations($rid,$rid+$incr);

		$params['body'] = array();
		foreach( $runs as $r ) {
			$params['body'][] = array(
				'index' => array(
				    '_id' => $r->rid
				)
			    );
			$params['body'][] = $this->build_run($r,$setups,$runfiles,$evals);
			$rid = max($rid,intval($r->rid));
		}

		$responses = $this->client->bulk($params);
		$submitted += sizeof($responses['items']);
	}

	return 'Successfully indexed '.$submitted.' out of '.$runcount.' runs.';
  }

  private function build_run($r,$setups,$runfiles,$evals){
	return array(
		    'run_id' 		=> $r->rid,
		    'uploader' 		=> array_key_exists($r->uploader,$this->user_names) ? $this->user_names[$r->uploader] : 'Unknown',
        'uploader_id' => $r->uploader,
		    'run_task'		=> $this->all_tasks[$r->task_id],
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
  }

  public function index_task_type($id){

	$params['index']     = 'openml';
	$params['type']      = 'task_type';

	$types = $this->db->query('SELECT tt.ttid, tt.name, tt.description, count(task_id) as tasks FROM task_type tt, task t where tt.ttid=t.ttid'.($id?' and tt.ttid='.$id:'').' group by tt.ttid');

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
		$new_data['input'][$i->name] = array(
		    'type' 		=> $i->type,
		    'description'	=> $i->description,
		    'io' 		=> $i->io,
		    'requirement' 	=> $i->requirement
		);
	}
	return $new_data;
  }



  public function index_flow($id){

	$params['index']     = 'openml';
	$params['type']      = 'flow';

	$flows = $this->db->query('select i.id, i.name, i.version, i.uploader, i.creator, i.contributor, i.description, i.fullDescription, i.installationNotes, i.dependencies, i.uploadDate, count(rid) as runs from implementation i left join algorithm_setup s on (s.implementation_id=i.id) left join run r on (r.setup=s.sid)'.($id?' where i.id='.$id:'').' group by i.id');

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
		    'version' 		=> $d->version,
		    'description' 	=> $d->description,
		    'full_description' 	=> $d->fullDescription,
		    'installation_notes'=> $d->installationNotes,
		    'uploader' 		=> array_key_exists($d->uploader,$this->user_names) ? $this->user_names[$d->uploader] : 'Unknown',
		    'creator'		=> $d->creator,
		    'contributor' 	=> $d->contributor,
		    'dependencies' 	=> $d->dependencies,
		    'date'		=> $d->uploadDate,
		    'runs' 		=> $this->checkNumeric($d->runs),
		    'visibility'	=> 'public',
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

	$qualities = $this->CI->Algorithm_quality->getAssociativeArray('quality','value','implementation_id = '.$d->id);
	if( $qualities != false )
		$new_data = array_merge($new_data,array_map(array($this, 'checkNumeric'),$qualities));
	return $new_data;
  }

  public function index_measure($id){

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
		    'visibility'	=> 'public',
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
		    'visibility'	=> 'public',
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
		    'visibility'	=> 'public',
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
		    'visibility'	=> 'public',
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

  public function index_data($id){

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

	$qualities = $this->CI->Data_quality->getAssociativeArray('quality','value','data = '.$d->did);
	if( $qualities != false )
		$new_data = array_merge($new_data,array_map(array($this, 'checkNumeric'),$qualities));
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
