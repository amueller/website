<script type="text/javascript" src="javascript/page/data"></script>

<div class="bs-docs-container topborder">
  <div class="container">
    <div class="col-sm-12">
<?php
  if(false === strpos($_SERVER['REQUEST_URI'],'/new/')) {
    subpage('data');
  } else {
    subpage(end(explode('/', $_SERVER['REQUEST_URI'])));
  }
?>
   </div>
  </div>
</div>
