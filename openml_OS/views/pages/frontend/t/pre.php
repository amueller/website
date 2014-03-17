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

?>
