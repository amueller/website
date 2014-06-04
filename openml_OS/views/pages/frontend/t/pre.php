<?php

$this->initialMsgClass = '';
$this->initialMsg = '';

if (!$this->ion_auth->logged_in()) {
	$this->initialMsgClass = 'alert alert-warning';
	$this->initialMsg = 'Before submitting content, please login first!';
}

$this->terms = safe($this->input->post('searchterms'));

$this->active_tab = gu('tab');
if($this->active_tab == false) $this->active_tab = 'searchtab';

// task search
$this->ep = $this->Estimation_procedure->get();
$this->found_tasks = array();
$this->task_message = false;

// task types
$this->tasktypes =  array();
$types = $this->Implementation->query('SELECT tt.ttid, tt.name, tt.description, count(t.task_id) as tasks FROM task_type tt left join task t on t.ttid=tt.ttid group by tt.ttid order by tasks desc');
if( $types != false ) {
	  foreach( $types as $i ) {
		  $result = array(
			  'id' => $i->ttid,
			  'name' => $i->name,
			  'description' => $i->description,
			  'tasks' => $i->tasks
		  );
		  $this->tasktypes[] = $result;
	  }
}


/// TYPE DETAIL

$this->record = array();
$this->taskio = array();

if(false !== strpos($_SERVER['REQUEST_URI'],'/t/type') || false !== strpos($_SERVER['REQUEST_URI'],'/t/search/type')) {
	$this->id = end(explode('/', $_SERVER['REQUEST_URI']));
	$type = $this->Implementation->query('SELECT * FROM task_type WHERE ttid=' . $this->id );
	if( $type != false ) {
		$this->record = array(
			  'id' => $type[0]->ttid,
			  'name' => $type[0]->name,
			  'description' => $type[0]->description,
			  'authors' => $type[0]->creator,
			  'contributors' => $type[0]->contributors
			);

	$io = $this->Implementation->query('SELECT i.name, i.description, i.type, i.io, i.requirement, t.description as typedescription  FROM task_type_inout i left join task_io_types t on i.type = t.name WHERE ttid=' . $this->id );
	if( $io != false ) {
	  foreach( $io as $i ) {
		$inout = array(
			  'name' => $i->name,
			  'description' => $i->description,
			  'typedescription' => $i->typedescription,
			  'type' => $i->type,
			  'category' => $i->io,
			  'requirement' => $i->requirement
			);
		$this->taskio[] = $inout;
	  }
	}
	}
}

if(false === strpos($_SERVER['REQUEST_URI'],'type') && false !== strpos($_SERVER['REQUEST_URI'],'/t/')) {

	$info = explode('/', $_SERVER['REQUEST_URI']);
	$this->task_id = $info[array_search('t',$info)+1];
}
?>
