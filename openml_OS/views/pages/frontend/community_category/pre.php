<?php
$this->cat 		= $this->Category->getById( gu('cid') );
$this->threads 	= $this->Thread->getByCategoryId( $this->cat->id, null, null, 'post_date DESC' );

$this->breadcrumbs = array( 'Community' => 'community', $this->cat->title => 'community_category/cid/' . $this->cat->id );
?>
