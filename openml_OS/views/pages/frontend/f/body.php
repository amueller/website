<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1 openmlsectioninfo">
     <div class="tab-content">

      <div class="tab-pane <?php if(false === strpos($_SERVER['REQUEST_URI'],'/f/')) { echo 'active'; } ?>" id="intro">
       <div class="blueheader">
      <h1><i class="fa fa-cogs"></i> Flows</h1>
      <p>Flows are implementations (programs, scripts, workflows) that solve OpenML tasks. They are either uploaded or referenced by url, so that anyone can easily find and run them, often through a <a href="plugins">plugin</a>. OpenML indexes all flows, keeps track of versions, citations and reuse, collects all results from all users, and organizes everything online.</p>
      </div>
      <hr>
     	<?php
	    loadpage('search', true, 'pre'); 
	    loadpage('search/subpage', true, 'results'); 
        ?> 
     </div> <!-- end intro tab -->

     <div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'],'/f/')) { echo 'active'; } ?>" id="codedetail">
     	<?php 
	 if(false !== strpos($_SERVER['REQUEST_URI'],'/f/')) {
		subpage('implementation'); 
	}?>
     </div>
     </div> <!-- end tabs content -->
    </div> <!-- end col-10 -->
  </div> <!-- end row -->
</div> <!-- end container -->
