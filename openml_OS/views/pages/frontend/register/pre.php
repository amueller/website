<?php
$this->active = 'profile';
$this->message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

$this->emailField = array(
	'name' => 'email',
	'id' => 'email',
	'type' => 'text',
	'value' => $this->input->post('email'),
);

$this->password = array(
	'name' => 'password',
	'id' => 'password',
	'type' => 'password',
);

$this->password_confirm = array(
	'name' => 'password_confirm',
	'id' => 'password_confirm',
	'type' => 'password',
);

$this->first_name = array(
	'name' => 'first_name',
	'id' => 'first_name',
	'type' => 'text',
	'value' => $this->input->post('first_name'),
);

$this->last_name = array(
	'name' => 'last_name',
	'id' => 'last_name',
	'type' => 'text',
	'value' => $this->input->post('last_name'),
);

$this->country = array(
	'name' => 'country',
	'id' => 'country',
	'type' => 'text',
	'value' => $this->input->post('country'),
);

$this->affiliation = array(
	'name' => 'affiliation',
	'id' => 'affiliation',
	'type' => 'text',
	'value' => $this->input->post('affiliation'),
);

$this->image = array(
	'name' => 'image',
	'id' => 'image',
	'type' => 'file',
);
?>
