<?php
if (!$this->ion_auth->logged_in()) {
	redirect('frontend/page/login');
}

$this->form_validation->set_rules('title', 		'Title', 	'xss_clean');
$this->form_validation->set_rules('category', 	'Category', 'required|numeric|xss_clean');
$this->form_validation->set_rules('body', 		'Body', 	'required|xss_clean');

if ($this->form_validation->run() == true) {
	$thread = array(
		'title' => gp('title'),
		'activated' => 'y',
		'body' => gp('body'),
		'post_date' => now(),
		'author_id' => $this->ion_auth->user()->row()->id,
		'category_id' => gp('category')
	);

	$id = $this->Thread->insert( $thread );
	if($id){
		redirect('frontend/page/community_thread/tid/'.$id);
	} else {
		sm('Failed to create thread. Please try again. ');
		redirect('frontend/page/community_create/cid/'.gp('category'));
	}
} else {
	sm( validation_errors() );
	redirect('frontend/page/community_create/cid/'.gp('category'));
}
?>
