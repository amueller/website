<?php
$this->counter = 0;
$this->threadsPerCategory = $this->Category->threadsPerCategory();
$this->categories 		  = $this->Category->get();
$this->threads 			  = array();

foreach($this->categories as $c) {
	$this->threads[$c->id] = $this->Thread->getByCategoryId( $c->id, 0, 5, 'post_date DESC' ); 
}
?>
