<?php
$this->thread = $this->Thread->getById( gu('tid') );
$this->author = $this->Author->getById( $this->thread->author_id );
$this->category = $this->Category->getById( $this->thread->category_id );

$this->breadcrumbs = array( 'Community' => 'community', $this->category->title => 'community_category/cid/' . $this->category->id, $this->thread->title => 'community_thread/tid/' . $this->thread->id );
?>
