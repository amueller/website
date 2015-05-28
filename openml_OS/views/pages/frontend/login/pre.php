<?php
$this->active = 'profile';
$this->message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');


if( array_key_exists( 'HTTP_REFERER', $_SERVER ) ) {
  if( startsWith( BASE_URL, $_SERVER['HTTP_REFERER'] ) ) {
    $this->session->set_flashdata('login_redirect', $_SERVER['HTTP_REFERER'] );
  } else {
    $this->session->set_flashdata('login_redirect', false );
  }
}

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
