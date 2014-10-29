<?php
if( $this->user->external_source != false ) {
	sm('Profile editing forbidden for social media users. ');
	redirect('frontend/page/home');
}

$this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
$this->form_validation->set_rules('Country', 'Country', 'xss_clean');
$this->form_validation->set_rules('affiliation', 'Affiliation', 'xss_clean');
$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password]');

if ($this->form_validation->run() == true) {
	
	$user = clean_array( $_POST, array( 'first_name', 'last_name', 'affiliation', 'country', 'bio', 'image' ) );
	
	if( check_uploaded_file( $_FILES['image'] ) ) {
		resize_image_squared($_FILES['image']['tmp_name'], $this->config->item('max_avatar_size') );
		$file_id = $this->File->register_uploaded_file($_FILES['image'], 'userdata/', -1, 'userimage');
		if($file_id) {
			$user['image'] = $this->data_controller . 'view/' . $file_id . '/' . $_FILES['image']['name'];
		}
	}
	
	if( $this->input->post('password') != false ) {
		$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

		$change = $this->ion_auth->change_password($identity, $this->input->post('password_old'), $this->input->post('password'));

		if ($change == false) {
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect('frontend/page/profile');
		}
	}


	$update = $this->ion_auth->update($this->ion_auth->user()->row()->id,$user);
	
	if($update) {
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('frontend/page/profile');
	} else {
		$this->session->set_flashdata('message', $this->ion_auth->errors());
		redirect('frontend/page/profile');
	}
	
} else {

	$this->session->set_flashdata('message', validation_errors() );
	redirect('frontend/page/profile');

}
?>
