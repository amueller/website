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
$types = $this->Implementation->query('SELECT tt.ttid, tt.name, tt.description, count(t.task_id) as tasks FROM task_type tt, task t WHERE  t.ttid=tt.ttid group by tt.ttid order by tasks desc');
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

/// TASK DETAIL

if(false === strpos($_SERVER['REQUEST_URI'],'type') && false !== strpos($_SERVER['REQUEST_URI'],'/t/')) {
	$this->task_id = end(explode('/', $_SERVER['REQUEST_URI']));
	$task = $this->Implementation->query('SELECT t.task_id, t.ttid, tt.name, tt.description FROM task t, task_type tt WHERE t.ttid=tt.ttid and task_id=' . $this->task_id );
	if( $task != false ) {
		$this->record = array(
			  'task_id' => $task[0]->task_id,
			  'type_id' => $task[0]->ttid,
			  'type_name' => $task[0]->name,
			  'type_description' => $task[0]->description			
			);
	$count = $this->Implementation->query('SELECT group_concat(rid) as runs, count(rid) as count from run where task_id=' . $this->task_id );
	$this->record['runcount'] = $count[0]->count;
	$this->record['runs'] = $count[0]->runs;
	

	$io = $this->Implementation->query('SELECT io.name, io.type, io.description, tt.description as typedescription, io.io, io.requirement, ti.value FROM task_type_inout io left join task_inputs ti on (io.name = ti.input and ti.task_id=' . $this->task_id . ") left join task_io_types tt on io.type=tt.name WHERE io.ttid=" . $this->record['type_id'] );
	if( $io != false ) {
	  foreach( $io as $i ) {
		$inout = array(
			  'name' => $i->name,
			  'type' => $i->type,
			  'description' => $i->description,
			  'typedescription' => $i->typedescription,
			  'category' => $i->io,
			  'value' => $i->value,
			  'requirement' => $i->requirement
			);
		if($i->type == 'Dataset' && is_numeric($i->value)){
			$dataset = $this->Implementation->query('SELECT name, version FROM dataset where did=' . $i->value); 
			$inout['dataset'] = $dataset[0]->name . " (" . $dataset[0]->version . ")";
			$this->sourcedata_id = $i->value;
			$this->sourcedata_name = $inout['dataset'];
		}
		elseif($i->type == 'EstimationProcedure'){
			$ep = $this->Implementation->query('SELECT name FROM estimation_procedure where id=' . $i->value); 
			$inout['evalproc'] = $ep[0]->name;
		}

		$this->taskio[] = $inout;
	  }
	}
	}
}



?>
