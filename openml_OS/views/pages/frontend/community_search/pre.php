<?php

$this->terms = $this->input->post('searchterms');
if( $this->terms == false )
	redirect('frontend/page/community');

$this->threads 			= $this->Thread->search( $this->terms, 'ORDER BY post_date DESC' );
$this->breadcrumbs 		= array( 'Community' => 'community', 'Search on "' . $this->terms . '"' => 'community_search' );
$this->cat 				= $this->Category->getById( gu('cid') );
?>
