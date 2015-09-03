<?php
if(in_array($this->subpage, $this->activity_subpages)) {
  // this automatically loads a table with all configurations
  echo $this->datatable;
}?>
