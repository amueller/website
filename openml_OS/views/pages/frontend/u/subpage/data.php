<?php
if(in_array($this->subpage, $this->legal_subpages)) {
  // this automatically loads a table with all configurations
  echo $this->datatable;
}?>
