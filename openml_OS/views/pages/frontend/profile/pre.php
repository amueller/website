<?php
$this->active = 'profile';
$this->message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
if (!$this->ion_auth->logged_in())
{
	sm('Please login first. ');
	redirect('frontend/page/login');
}
$this->user = $this->ion_auth->user()->row();

if( $this->user->external_source != false ) {
	sm('Profile editing forbidden for social media users. ');
	redirect('frontend/page/home');
}

$this->password_old = array(
	'name' => 'password_old',
	'id' => 'password_old',
	'type' => 'password',
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
	'value' => $this->user->first_name,
);

$this->last_name = array(
	'name' => 'last_name',
	'id' => 'last_name',
	'type' => 'text',
	'value' => $this->user->last_name,
);

$this->country = array(
	'name' => 'country',
	'id' => 'country',
	'type' => 'text',
	'value' => $this->user->country,
);

$this->affiliation = array(
	'name' => 'affiliation',
	'id' => 'affiliation',
	'type' => 'text',
	'value' => $this->user->affiliation,
);

$this->image = array(
	'name' => 'image',
	'id' => 'image',
	'type' => 'file',
);
?>
