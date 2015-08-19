<?php
  $this->load_javascript = array('//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.3/highlight.min.js');
  $this->load_css = array('css/highlight.css');

  $this->team = $this->Author->getWhere('core = "true"');
  array_unshift($this->team, $this->team[1]);
  unset($this->team[2]);

?>
