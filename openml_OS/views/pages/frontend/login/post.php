<?php
if (!empty($_POST['submitlogin'])) {
	if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), false))
	{
		$this->session->set_flashdata('message', $this->ion_auth->messages());
	  $redirect = $this->session->flashdata('login_redirect');
	  if($redirect == false ) {
		  redirect('home');
			exit();
	  } else {
	    redirect($redirect);
			exit();
	  }
	}
	else
	{
		$this->session->set_flashdata('message', $this->ion_auth->errors());
		redirect('login');
		exit();
	}
}
?>
