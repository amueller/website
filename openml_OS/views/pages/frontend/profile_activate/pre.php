<?php
$id = gu('id');
$code = gu('code');
$this->load->library('elasticSearch');
alert($code);
if ($code !== false)
{
	$activation = $this->ion_auth->activate($id, $code);
}
else if ($this->ion_auth->is_admin())
{
	$activation = $this->ion_auth->activate($id);
}
alert($activation);

if ($activation)
{
	//index the user
   	$this->elasticsearch->index('user', $id ); 
	
	//redirect them to the auth page
	$this->session->set_flashdata('message', $this->ion_auth->messages());
	redirect('login', 'refresh');
}
else
{
	//redirect them to the forgot password page
	$this->session->set_flashdata('message', $this->ion_auth->errors());
	redirect('login', 'refresh');
}
?>
