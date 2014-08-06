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

    $this->client = new Elasticsearch\Client();

    $this->data_names = $this->CI->Dataset->getAssociativeArray('did','name','name IS NOT NULL');
    $this->flow_names = $this->CI->Implementation->getAssociativeArray('id','fullName','name IS NOT NULL');
    $this->procedure_names = $this->CI->Estimation_procedure->getAssociativeArray('id','name','name IS NOT NULL');
    $this->all_tasks = array();
    $this->user_names = array();
    $author = $this->userdb->query('select id, first_name, last_name from users');
    foreach( $author as $a ) {
	$this->user_names[$a->id] = $a->first_name.' '.$a->last_name;
    }

  }
  
  public function test() {
	return $this->client->ping();
  }

  public function get_types() {
	$params['index'] = 'openml';
	return array_keys($this->client->indices()->getMapping($params)['openml']['mappings']);
  }

  public function rebuild_index_for_type($t){
	$method_name = 'rebuild_index_for_' . $t;
	if( method_exists( $this, $method_name ) ) {
		return $this->$method_name();
	}
	else{
	   return 'No function exists to rebuild index of type '.$t; 
	}
  }

  public function initialize_index_for_type($t){
	$method_name = 'initialize_index_for_' . $t;
	if( method_exists( $this, $method_name ) ) {
		return $this->$method_name();
	}
	else{
	   return 'No function exists to initialize index of type '.$t; 
	}
  }

  public function mapping_delete($m){
     $params['index'] = 'openml';
     if(in_array($m,array_keys($this->client->indices()->getMapping($params)['openml']['mappings']))){
	$params = [
		'index' => 'openml',
		'type'	=> $m	
	];
	$this->client->indices()->deleteMapping($params);
     }
  }

  public function initialize_index_for_data(){
     
     $this->mapping_delete('data');  

     $typeMapping = ['_all' => [
                	'enabled' => true,
                	'stored' => 'yes',
			'type' => 'string',
			'analyzer' => 'snowball'
		],
                'properties' => [
                    'description' => [
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ],
                    'name' => [
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ],
                    'suggest' => [
                        'type' => 'completion',
			'index_analyzer' => 'standard',
			'search_analyzer' => 'standard',
			'payloads' => true,
			'max_input_length' => 100
                    ]
                ]
            ];
     $params['index'] = 'openml';
     $params['type'] = 'data';
     $params['body']['data'] = $typeMapping;
     $this->client->indices()->putMapping($params);

     return 'Successfully reinitialized index for data';
  }

  public function initialize_index_for_flow(){
     
     $this->mapping_delete('flow');  

     $typeMapping = ['_all' => [
                	'enabled' => true,
                	'stored' => 'yes',
			'type' => 'string',
			'analyzer' => 'snowball'
		],
                'properties' => [
                    'description' => [
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ],
                    'full_description' => [
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ],

                    'name' => [
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ],
                    'suggest' => [
                        'type' => 'completion',
			'index_analyzer' => 'standard',
			'search_analyzer' => 'standard',
			'payloads' => true,
			'max_input_length' => 100
                    ]
                ]
            ];
     $params['index'] = 'openml';
     $params['type'] = 'flow';
     $params['body']['flow'] = $typeMapping;
     $this->client->indices()->putMapping($params);

     return 'Successfully reinitialized index for flows';
  }


  public function initialize_index_for_measure(){
     
     $this->mapping_delete('measure');  

     $typeMapping = ['_all' => [
                	'enabled' => true,
                	'stored' => 'yes',
			'type' => 'string',
			'analyzer' => 'snowball'
		],
                'properties' => [
                    'description' => [
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ],
                    'name' => [
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ],
                    'suggest' => [
                        'type' => 'completion',
			'index_analyzer' => 'standard',
			'search_analyzer' => 'standard',
			'payloads' => true,
			'max_input_length' => 100
                    ]
                ]
            ];
     $params['index'] = 'openml';
     $params['type'] = 'measure';
     $params['body']['measure'] = $typeMapping;
     $this->client->indices()->putMapping($params);

     return 'Successfully reinitialized index for measures';
  }

  public function initialize_index_for_task_type(){
     
     $this->mapping_delete('task_type');  

     $typeMapping = ['_all' => [
                	'enabled' => true,
                	'stored' => 'yes',
			'type' => 'string',
			'analyzer' => 'snowball'
		],
                'properties' => [
                    'description' => [
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ],
                    'name' => [
                        'type' => 'string',
			'analyzer' => 'snowball'
                    ],
                    'suggest' => [
                        'type' => 'completion',
			'index_analyzer' => 'standard',
			'search_analyzer' => 'standard',
			'payloads' => true,
			'max_input_length' => 100
                    ]
                ]
            ];
     $params['index'] = 'openml';
     $params['type'] = 'task_type';
     $params['body']['task_type'] = $typeMapping;
     $this->client->indices()->putMapping($params);

     return 'Successfully reinitialized index for task types';
  }

  public function initialize_index_for_user(){
     
     $this->mapping_delete('user');  

     $typeMapping = ['_all' => [
                	'enabled' => true,
                	'stored' => 'yes',
			'type' => 'string',
			'analyzer' => 'snowball'
		],
                'properties' => [
                    'suggest' => [
                        'type' => 'completion',
			'index_analyzer' => 'standard',
			'search_analyzer' => 'standard',
			'payloads' => true,
			'max_input_length' => 100
                    ]
                ]
            ];
     $params['index'] = 'openml';
     $params['type'] = 'user';
     $params['body']['user'] = $typeMapping;
     $this->client->indices()->putMapping($params);

     return 'Successfully reinitialized index for users';
  }

  public function initialize_index_for_run(){
     
     $this->mapping_delete('run');  

     $typeMapping = ['_all' => [
                	'enabled' => true,
                	'stored' => 'yes',
			'type' => 'string',
			'analyzer' => 'snowball'
		]
            ];
     $params['index'] = 'openml';
     $params['type'] = 'run';
     $params['body']['run'] = $typeMapping;
     $this->client->indices()->putMapping($params);

     return 'Successfully reinitialized index for runs';
  }

  public function initialize_index_for_task(){
     
     $this->mapping_delete('task');  

     $typeMapping = ['_all' => [
                	'enabled' => true,
                	'stored' => 'yes',
			'type' => 'string',
			'analyzer' => 'snowball'
		],
                'properties' => [
                    'suggest' => [
                        'type' => 'completion',
			'index_analyzer' => 'standard',
			'search_analyzer' => 'standard',
			'payloads' => true,
                    ]
                ]
            ];
     $params['index'] = 'openml';
     $params['type'] = 'task';
     $params['body']['task'] = $typeMapping;
     $this->client->indices()->putMapping($params);

     return 'Successfully reinitialized index for tasks';
  }


  public function rebuild_index_for_user(){
  
	$params['index']     = 'openml';
	$params['type']      = 'user';

	$users = $this->userdb->query('select id, first_name, last_name, email, affiliation, country, image, created_on from users where active="1"');

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
		    'date'		=> $d->created_on.' CET',
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
 private function fetch_tasks(){
	$tasks = $this->db->query('SELECT t.task_id, tt.ttid, tt.name, count(rid) as runs FROM task t left join run r on (r.task_id=t.task_id), task_type tt WHERE t.ttid=tt.ttid group by t.task_id');

	foreach( $tasks as $d ) {
	    $this->all_tasks[$d->task_id] = $this->build_task($d); 
	}
 }

 public function rebuild_index_for_task(){
  
	$params['index']     = 'openml';
	$params['type']      = 'task';

	$this->fetch_tasks();

	foreach( $this->all_tasks as $d ) {
	    $params['body'][] = array(
		'index' => array(
		    '_id' => $d->task_id
		)
	    );	    
	    $params['body'][] = $this->all_tasks[$d->task_id];
	}

	$responses = $this->client->bulk($params);
	
	return 'Successfully indexed '.sizeof($responses['items']).' out of '.sizeof($tasks).' tasks.';
  }

  private function build_task($d){

	$newdata = array(
		    'task_id' 		=> $d->task_id,
		    'runs' 		=> $this->checkNumeric($d->runs),
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

 private function fetch_setups(){
	$index = array();
	foreach( $this->db->query('SELECT setup, input, value FROM input_setting') as $v ) {
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

 public function rebuild_index_for_run(){
  
	$params['index']     = 'openml';
	$params['type']      = 'run';

	$setups = $this->fetch_setups();
	$runmax = intval($this->db->query('SELECT max(rid) as maxrun from run')[0]->maxrun);
	$runcount = intval($this->db->query('SELECT count(rid) as runcount from run')[0]->runcount);
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
		    'run_task'		=> $this->all_tasks[$r->task_id],
		    'date'		=> $r->start_time.' CET',
		    'run_flow'		=> array(
						'flow_id' => $r->implementation_id,
						'name' => $this->flow_names[$r->implementation_id],
						'parameters' => array_key_exists($r->setup,$setups) ? $setups[$r->setup] : array()
					),
		    'output_files'	=> array_key_exists($r->rid,$runfiles) ? $runfiles[$r->rid] : array(),
		    'evaluations'	=> array_key_exists($r->rid,$evals) ? $evals[$r->rid] : array()
		);
  }

  public function rebuild_index_for_task_type(){
  
	$params['index']     = 'openml';
	$params['type']      = 'task_type';

	$types = $this->db->query('SELECT ttid, name, description FROM task_type');

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
		    'input'		=> array()
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



  public function rebuild_index_for_flow(){
  
	$params['index']     = 'openml';
	$params['type']      = 'flow';

	$flows = $this->db->query('select i.id, i.name, i.version, i.uploader, i.creator, i.contributor, i.description, i.fullDescription, i.installationNotes, i.dependencies, i.uploadDate, count(rid) as runs from implementation i left join algorithm_setup s on (s.implementation_id=i.id) left join run r on (r.setup=s.sid) group by i.id');

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
		    'date'		=> $d->uploadDate.' CET',
		    'runs' 		=> $this->checkNumeric($d->runs),
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





  public function rebuild_index_for_measure(){
  
	$params['index']     = 'openml';
	$params['type']      = 'measure';

	$procs = $this->db->query('SELECT e.*, t.description FROM estimation_procedure e, estimation_procedure_type t WHERE e.type=t.name');

	foreach( $procs as $d ) {
	    $params['body'][] = array(
		'index' => array(
		    '_id' => $d->id
		)
	    );	    

	    $params['body'][] = $this->build_procedure($d);
	}

	$funcs = $this->db->query('SELECT * FROM math_function WHERE functionType="EvaluationFunction"');

	foreach( $funcs as $d ) {
	    $id = str_replace("_","-",$d->name);
	    $params['body'][] = array(
		'index' => array(
		    '_id' => $id
		)
	    );	    

	    $params['body'][] = $this->build_function($d);
	}

	$dataqs = $this->db->query('SELECT * FROM quality WHERE type="DataQuality"');

	foreach( $dataqs as $d ) {
	    $id = str_replace("_","-",$d->name);
	    $params['body'][] = array(
		'index' => array(
		    '_id' => $id
		)
	    );	    

	    $params['body'][] = $this->build_dataq($d);
	}

	$flowqs = $this->db->query('SELECT * FROM quality WHERE type="AlgorithmQuality"');

	foreach( $flowqs as $d ) {
	    $id = str_replace("_","-",$d->name);
	    $params['body'][] = array(
		'index' => array(
		    '_id' => $id
		)
	    );	    

	    $params['body'][] = $this->build_flowq($d);
	}

	$responses = $this->client->bulk($params);
	return 'Successfully indexed '.sizeof($responses['items']).' out of '.(sizeof($procs)+sizeof($funcs)+sizeof($dataqs)+sizeof($flowqs)).' measures.';
  }

  private function build_procedure($d){
	return array(
		    'proc_id' 		=> $d->id,
		    'type'    		=> 'estimation_procedure',
		    'task_type'  	=> $d->ttid,
		    'name'    		=> $d->name,
		    'description' 	=> $d->description,
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

  public function rebuild_index_for_data(){

	$params['index']     = 'openml';
	$params['type']      = 'data';

	$datasets = $this->db->query('select d.did, d.name, d.version, d.description, d.format, d.creator, d.contributor, d.collection, d.uploader, d.upload_date, count(rid) as runs from dataset d left join task_inputs t on (t.value=d.did and t.input="source_data") left join run r on (r.task_id=t.task_id) group by did');

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
	$new_data = array(
		    'data_id' 		=> $d->did,
		    'name'    		=> $d->name,
		    'version' 		=> $d->version,
		    'description' 	=> $d->description,
		    'format'		=> $d->format,
		    'uploader' 		=> $this->user_names[$d->uploader],
		    'creator'		=> $d->creator,
		    'contributor' 	=> $d->contributor,
		    'collection' 	=> $d->collection,
		    'date'		=> $d->upload_date.' CET',
		    'runs' 		=> $this->checkNumeric($d->runs),
		    'suggest'		=> array(
						'input' => array($d->name,$d->description),
						'output'=> $d->name,
						'weight'=> 5,
						'payload' => array(
							'type' => 'data',
							'data_id' => $d->did,
							'description' => substr($d->description, 0, 100) 
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
