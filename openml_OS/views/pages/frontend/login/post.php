<?php
if (!empty($_POST['submitlogin'])) {
	if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), false))
	{
			redirect($this->input->post('location'));
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
