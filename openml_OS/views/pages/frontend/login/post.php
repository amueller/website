<?php
if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), false))
{
	$this->session->set_flashdata('message', $this->ion_auth->messages());
	redirect('frontend');
}
else
{
	$this->session->set_flashdata('message', $this->ion_auth->errors());
	redirect('frontend/page/login');
}
?>
