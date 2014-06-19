<?php
    if (!$this->ion_auth->logged_in()) {
    	header("Location: ../login");
	die();	
    }
?>
