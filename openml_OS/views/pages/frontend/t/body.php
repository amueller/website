<div class="container-fluid topborder">
  <div class="row">
   <div class="col-lg-10 col-sm-12 col-lg-offset-1 openmlsectioninfo">
    <div class="tab-content">
      <div class="tab-pane  <?php if(false === strpos($_SERVER['REQUEST_URI'],'/t/')) { echo 'active'; } ?>" id="intro">
        <div class="yellowheader">
          <h1><a href="t"><i class="fa fa-trophy"></i></a> Tasks</h1>
          <p>Tasks define machine learning problems in such a way that the obtained results are clearly interpretable and verifiable. <b>Task types</b> are general descriptions in terms of the (types of) given input, expected output and scientific protocols, e.g, cross-validation, to be used. Given specific <a href="d">input data</a>, OpenML then generates individual <b>tasks</b> to be solved. Tasks are machine-readable, fully contained and are read by <a href="f">flows</a>.</p>
        </div>
        <h2>Task types</h2>
        <?php 
        foreach( $this->tasktypes as $r ):?>
        <div class="searchresult">
          <a href="t/type/<?php echo urlencode($r['id']); ?>"><?php echo $r['name']; ?></a><br />
          <div class="teaser"><?php echo teaser($r['description'], 200); ?></div>
          <div class="runStats"><?php echo $r['tasks'] . ' tasks'; ?></div>
        </div><?php 
        endforeach;
        ?>

        <h2>Tasks</h2>
	<?php 
	   if(false === strpos($_SERVER['REQUEST_URI'],'/t/')) {
	    loadpage('search', true, 'pre'); 
	    loadpage('search/subpage', true, 'results');
	   }
        ?> 

      </div> <!-- end intro tab -->

      <div class="tab-pane <?php if( isset($this->id) ) echo 'active'; ?>" id="typedetail">
        <?php 
        if(false !== strpos($_SERVER['REQUEST_URI'],'/t/type')) {
        subpage('tasktype'); 
        }?>
      </div> <!-- end task_type tab -->

      <div class="tab-pane <?php if( isset($this->task_id) ) echo 'active'; ?>" id="taskdetail">
        <?php if( isset($this->task_id) ) { o('task'); } ?>
      </div> <!-- end task tab -->

    </div> <!-- end tabs content -->
    </div> <!-- end col-10 -->
  </div> <!-- end row -->
</div> <!-- end container -->
