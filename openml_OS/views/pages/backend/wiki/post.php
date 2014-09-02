<?php
     $id = $this->input->post('id');

     $datasets = $this->Dataset->query( 'SELECT did from dataset'.($id != 'all' ? ' where did='.$id : '') );
     foreach($datasets as $d){
	$this->messages[] = $this->wiki->export_to_wiki($d->did);
     }
?>
