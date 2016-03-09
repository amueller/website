<?php
if (!empty($_POST['submitlogin'])) {
	if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), false))
	{
		  if(strpos($this->input->post('location'), 'login') !== false){ //avoid redirecting to login page after successful login
				redirect('home');
			} else { // redirect to whereever you were on the website
				redirect($this->input->post('location'));
			}
			exit();
	}
	else
	{
		$this->session->set_flashdata('message', $this->ion_auth->errors());
		redirect('home');
		exit();
	}
}

?>
