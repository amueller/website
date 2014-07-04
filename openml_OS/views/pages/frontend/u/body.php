<div class="container-fluid topborder">
  <div class="row">
   <div class="col-lg-10 col-sm-12 col-lg-offset-1 openmlsectioninfo">
    <div class="tab-content">
      <div class="tab-pane  <?php if(false === strpos($_SERVER['REQUEST_URI'],'/u/')) { echo 'active'; } ?>" id="intro">
        <div class="yellowheader">
          <h1><a href="t"><i class="fa fa-user"></i></a> You</h1>
          <p>This will become a page just for you, with an overview of all your OpenML friends, data, flows, runs, achievements and much more. Stay tuned.</p>
        </div>
      </div> <!-- end intro tab -->

      <div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'],'/u/')) { echo 'active'; }?>" id="userdetail">
        <?php 
        subpage('user'); 
        ?>
      </div> <!-- end task_type tab -->

    </div> <!-- end tabs content -->
    </div> <!-- end col-10 -->
  </div> <!-- end row -->
</div> <!-- end container -->
