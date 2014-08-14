<?php
if(in_array($this->subpage, $this->legal_subpages)) {
  echo $this->dataoverview->generate_table( 
    $this->name, 
    $this->keys, 
    $this->items, 
    $this->api_delete_function );
} else {
?>
<a href="overview/data">My data</a><br/>
<a href="overview/flows">My flows</a><br/>
<a href="overview/runs">My runs</a><br/>

<?php } ?>
