<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ElasticSearch {
  
  public function __construct() {
    $this->CI = &get_instance();
    $this->CI->load->model('Dataset');
    $this->CI->load->model('Author');
    $this->CI->load->model('Data_quality');
    $this->CI->load->model('Algorithm_quality');
    $this->db = $this->CI->Dataset;
    $this->client = new Elasticsearch\Client();

    $this->data_names = $this->CI->Dataset->getAssociativeArray('did','name','name IS NOT NULL');
    $this->flow_names = $this->CI->Implementation->getAssociativeArray('id','fullName','name IS NOT NULL');
    $this->user_names = $this->CI->Author->getAssociativeArray('id, first_name','first_name IS NOT NULL');

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

     return 'Succesfully reinitialized index for data';
  }

  public function rebuild_index_for_user(){
	return 'Succesfully built index for user';
  }
  public function rebuild_index_for_task(){
	return 'Succesfully built index for task';
  }

  public function rebuild_index_for_measure(){
	return 'Succesfully built index for measure';
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

	    $params['body'][] = array(
		    'flow_id' 		=> $d->id,
		    'name'    		=> $d->name,
		    'version' 		=> $d->version,
		    'description' 	=> $d->description,
		    'full_description' 	=> $d->fullDescription,
		    'installation_notes'=> $d->installationNotes,
		    'uploader' 		=> $this->user_names[$d->uploader],
		    'creator'		=> $d->creator,
		    'contributor' 	=> $d->contributor,
		    'dependencies' 	=> $d->dependencies,
		    'date'		=> $d->upload_date.' CET',
		    'runs' 		=> $d->runs,
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
		$params['body'][sizeof($params['body'])-1] = array_merge(end($params['body']),array_map(array($this, 'checkNumeric'),$qualities));
	}

	$responses = $this->client->bulk($params);
	
	return 'Succesfully indexed '.sizeof($responses['items']).' of '.sizeof($datasets).' datasets.';


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

	    $params['body'][] = array(
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
		    'runs' 		=> $d->runs,
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
		$params['body'][sizeof($params['body'])-1] = array_merge(end($params['body']),array_map(array($this, 'checkNumeric'),$qualities));
	}

	$responses = $this->client->bulk($params);
	
	return 'Succesfully indexed '.sizeof($responses['items']).' of '.sizeof($datasets).' datasets.';
  }

  public function checkNumeric($v){
	if(is_integer($v))
		return intval($v);
	else if(is_numeric($v))
		return doubleval($v);
	else
		return $v;
  }

  public function rebuild_index_for_task_type(){
	return 'Succesfully built index for task type';
  }

  public function rebuild_index_for_run(){
	return 'Succesfully built index for run';
  }

}
