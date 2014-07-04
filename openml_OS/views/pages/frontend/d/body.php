<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1 openmlsectioninfo">
     <div class="tab-content">

      <div class="tab-pane <?php if(false === strpos($_SERVER['REQUEST_URI'],'/d/')) { echo 'active'; } ?>" id="intro">
      <div class="greenheader">
      <h1><i class="fa fa-database"></i> Data</h1>
      <p>Input data for machine learning applications, challenging the community to find the best performing algorithms. They are either uploaded or referenced by url. OpenML indexes all data sets and keeps tracks of versions, citations and reuse. Moreover, for selected data formats, OpenML also computes <a href="a">data characteristics</a>, generates <a href="t">tasks</a>, collects all results from all users, and organizes everything online.</p>
      </div>
     <p></p>
     <hr>
     	<?php
	    loadpage('search', true, 'pre'); 
	    loadpage('search/subpage', true, 'results'); 
        ?> 
     </div> <!-- end intro tab -->

     <div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'],'/d/')) { echo 'active'; } ?>" id="codedetail">
     	<?php 
	 if(false !== strpos($_SERVER['REQUEST_URI'],'/d/')) {
		subpage('dataset'); 
	}?>
     </div>
     </div> <!-- end tabs content -->
    </div> <!-- end col-10 -->
  </div> <!-- end row -->
</div> <!-- end container -->
