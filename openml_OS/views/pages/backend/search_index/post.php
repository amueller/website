<?php
     if($this->input->post('inittypes')){
	$this->init_types = $this->input->post('inittypes');
	foreach( $this->init_types as $t ):
		$this->messages[] = $this->elasticsearch->initialize_index_for_type($t);
	endforeach;
     }

     if($this->input->post('types')){
	$this->index_types = $this->input->post('types');
	foreach( $this->index_types as $t ):
		$this->messages[] = $this->elasticsearch->rebuild_index_for_type($t);
	endforeach;
     }
?>
