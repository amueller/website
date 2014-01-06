<?php
$this->initialMsgClass = '';
$this->initialMsg = '';

if (!$this->ion_auth->logged_in()) {
	$this->initialMsgClass = 'alert alert-warning';
	$this->initialMsg = 'Before submitting content, please login first!';
}
?>
