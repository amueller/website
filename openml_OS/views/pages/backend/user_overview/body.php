<?php

echo $this->dataoverview->generate_table( 
  $this->name, 
  $this->keys, 
  $this->items, 
  $this->api_delete_function );

?>
