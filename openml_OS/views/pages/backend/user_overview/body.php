<?php

echo $this->dataoverview->generate_table_static( 
  $this->name, 
  $this->columns, 
  $this->items, 
  $this->api_delete_function );

?>
