<?php

$this->breadcrumbs = array( 'Community' => 'community', 'Ask a new question' => 'community_create' );

if (!$this->ion_auth->logged_in()) {
	redirect('frontend/page/login');
}

$this->categories = $this->Category->get( );

$this->title = array(
	'name' => 'title',
	'id' => 'title',
	'type' => 'text',
	'placeholder' => 'title or subject'
);

$this->category = array();
foreach($this->categories as $c) {
	$this->category[$c->id] = $c->title;
}

$this->body = array(
	'name' => 'body',
	'id' => 'body',
	'type' => 'text',
	'rows' => '200',
    'style'       => 'width:100%;height:500px;',
	'placeholder' => 'Comments, questions or other content.'
);

?>
