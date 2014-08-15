<?php
$id = gu('id');
$code = gu('code');
$this->load->library('elasticSearch');
print_r($code);
if ($code !== false)
{
	$activation = $this->ion_auth->activate($id, $code);
}
else if ($this->ion_auth->is_admin())
{
	$activation = $this->ion_auth->activate($id);
}
print_r($activation);

if ($activation)
{
	//index the user
   	print_r($this->elasticsearch->index('user', $id )); 
	
	//redirect them to the auth page
	$this->session->set_flashdata('message', $this->ion_auth->messages());
	print_r('Redirect');
	redirect('login', 'refresh');
}
else
{
	//redirect them to the forgot password page
	$this->session->set_flashdata('message', $this->ion_auth->errors());
	redirect('login', 'refresh');
}
?>
