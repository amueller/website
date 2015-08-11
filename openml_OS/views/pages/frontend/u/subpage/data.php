<?php
if(in_array($this->usubpage, $this->legal_subpages)) {
  // this automatically loads a table with all configurations
  echo $this->datatable;
}?>
