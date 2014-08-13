<?php
$this->form_validation->set_rules('first_name', 'First Name', 'xss_clean');
$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
$this->form_validation->set_rules('Country', 'Country', 'xss_clean');
$this->form_validation->set_rules('affiliation', 'Affiliation', 'xss_clean');
$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

if ($this->form_validation->run() == true)
{
  $username = $this->input->post('email');
  $email    = $this->input->post('email');
  $password = $this->input->post('password');
  
  $additional_data = array(
    'first_name' => $this->input->post('first_name'),
    'last_name'  => $this->input->post('last_name'),
    'affiliation'=> $this->input->post('affiliation'),
    'country'    => $this->input->post('country'),
    'external_source' => null,
    'external_id' => null
  );
  
  if( check_uploaded_file( $_FILES['image'] ) ) {
    resize_image_squared($_FILES['image']['tmp_name'], $this->config->item('max_avatar_size') );
    $file_id = $this->File->register_uploaded_file($_FILES['image'], 'userdata/', -1, 'userimage');
    if($file_id) {
      $additional_data['image'] = $this->data_controller . 'view/' . $file_id . '/' . $_FILES['image']['name'];
    }
  }
  $user_id = $this->ion_auth->register($username, $password, $email, $additional_data);
  if ( $user_id )
  {
    // add to index
    $this->elasticsearch->index('user', $user_id ); 
    
    //check to see if we are creating the user
    //redirect them back to the admin page
    $this->session->set_flashdata('message', $this->ion_auth->messages());
    redirect('frontend/page/register');
  } else {
    $this->session->set_flashdata('message', $this->ion_auth->errors());
    redirect('frontend/page/register');
  }
}
else 
{
  $this->session->set_flashdata('message', validation_errors() );
  redirect('frontend/page/register');
}
  
?>
