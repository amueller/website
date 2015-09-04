<?php

if(false !== strpos($_SERVER['REQUEST_URI'],'/s/')) {
	$info = explode('/', $_SERVER['REQUEST_URI']);
	$this->id = $this->subpage;
	$this->study_id = $this->id;

	//get data from ES
	$this->p = array();
	$this->p['index'] = 'openml';
	$this->p['type'] = 'study';
	$this->p['id'] = $this->study_id;
	try{
		$this->studyinfo = $this->searchclient->get($this->p)['_source'];
	} catch (Exception $e) {}

}


?>
