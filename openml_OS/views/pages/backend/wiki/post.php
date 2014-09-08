<?php
   if($this->input->post('id')){
     $id = $this->input->post('id');

     $datasets = $this->Dataset->query( 'SELECT did from dataset'.($id != 'all' ? ' where did='.$id : '') );
     foreach($datasets as $d){
	$this->messages[] = $this->wiki->export_to_wiki($d->did);
     }
   } else if($this->input->post('wiki-id')){
     $id = $this->input->post('wiki-id');

     $datasets = $this->Dataset->query( 'SELECT did from dataset'.($id != 'all' ? ' where did='.$id : '') );
     foreach($datasets as $d){
	$this->messages[] = $this->wiki->import_from_wiki($d->did);
     }
   }
?>
