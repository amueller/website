<?php
$this->active = 'profile';
$this->message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

$this->identity = array('name' => 'identity',
	'id' => 'identity',
	'type' => 'text',
	'value' => $this->form_validation->set_value('identity'),
);
$this->password = array('name' => 'password',
	'id' => 'password',
	'type' => 'password',
);
?>
