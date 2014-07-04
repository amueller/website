<?php
	$info = explode('/', $_SERVER['REQUEST_URI']);	
	$this->user_id = $info[array_search('u',$info)+1];
        $this->author = $this->Author->getById($this->user_id);
?>
