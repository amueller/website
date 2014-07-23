<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1">
    <div class="col-sm-12 col-md-3 searchbar">
	<ul class="menu" id="qtabs">		
		<li class="<?php if($this->active_tab == 'wizardtab') echo 'active';?>"><a href="#wizardtab" data-toggle="tab">Compare flows</a></li>
		<li class="<?php if($this->active_tab == 'curvestab') echo 'active';?>"><a href="#curvestab" data-toggle="tab">Draw learning curves</a></li>
		<li class="<?php if($this->active_tab == 'exampletab') echo 'active';?>"><a href="#exampletab" data-toggle="tab">Advanced queries</a></li>
		<li class="<?php if($this->active_tab == 'sqltab') echo 'active';?>"><a href="#sqltab" data-toggle="tab">SQL editor</a></li>
  		<li style="display:none;"><a href="#resultstab" data-toggle="tab">Results</a></li>
	</ul>

	<ul class="menu" id="vtabs">		
		<li><a href="#tabletab" data-toggle="tab" onclick="showResultTab();">Table</a></li>
		<li><a href="#scatterplottab" data-toggle="tab" onclick="showResultTab();onclickScatterPlot();">Scatterplot</a></li>
		<li><a href="#linetab" data-toggle="tab" onclick="showResultTab();onclickLinePlot();">Line plot</a></li>
	</ul>

    </div> <!-- end col-2 -->

    <div class="col-sm-12 col-md-9 openmlsectioninfo">
     <div class="tab-content">
      <!-- DETAIL -->     
      <div class="tab-pane <?php  if(false !== strpos($_SERVER['REQUEST_URI'],'/r/')) echo 'active';?>" id="runtab">
		<?php o('run'); ?>
      </div>
        <!-- ADVANCED -->     
	<div class="tab-pane fade <?php if($this->active_tab == 'exampletab') echo 'active';?>" id="exampletab">
		<?php subpage('examples'); ?>
	</div>
        <!-- COMPARE -->     
	<div class="tab-pane fade <?php if($this->active_tab == 'wizardtab') echo 'active';?>" id="wizardtab">
		<?php subpage('wizard'); ?>
	</div>
        <!-- CURVES -->     
	<div class="tab-pane fade <?php if($this->active_tab == 'curvestab') echo 'active';?>" id="curvestab">
		<?php subpage('curves'); ?>
	</div>
        <!-- GRAPH -->     	
	<div class="tab-pane fade <?php if($this->active_tab == 'querygraphtab') echo 'active';?>" id="querygraphtab">
		<?php subpage('querygraph'); ?>
	</div>
        <!-- SQL -->     
	<div class="tab-pane fade <?php if($this->active_tab == 'sqltab') echo 'active';?>" id="sqltab">
		<?php subpage('sql'); ?>
	</div>
     <div class="tab-pane fade <?php if($this->active_tab == 'resultstab') echo 'active';?>" id="resultstab">
		<?php subpage('results'); ?>
     </div>
      <div class="tab-pane <?php if(false === strpos($_SERVER['REQUEST_URI'],'/r/')) { echo 'active'; } ?>" id="intro">

      <div class="redheader">
      <h1><i class="fa fa-star"></i> Runs</h1>
      <p>A run is an application of a specific <a href="f">flow</a> on a specific <a href="t">task</a>, including all details such as parameter settings and all results. OpenML collects and organizes all runs from all users, so that their results can be easily compared over all tasks and flows, analyzed, visualized or simply downloaded.</p>
      </div>
      <h2>Recent runs</h2>
	<?php
	if($this->total_count>0) {
		echo '<div class="searchstats">Showing ' . $this->total_count . ' results (' . $this->time . ' seconds)</div>';	
		
		foreach( $this->results_all as $r ):?>
			<div class="searchresult">
				<i class="<?php echo $r['icon'] ?>"></i>
				<?php if($r['type'] == 'run') { ?>

				<a href="r/<?php echo $r['id'] ?>">Run <?php echo $r['id']; ?></a><br />
				<div class="teaser">Runs <a href="f/<?php echo $r['flow'] ?>"><?php echo $r['flowname'] ?></a> on <a href="t/<?php echo $r['task'] ?>">task <?php echo $r['task'] ?></a>: <?php echo $r['taskname'] ?> on data set <a href="d/<?php echo $r['data'] ?>"><?php echo $r['dataname'] ?></a></div>
				<div class="runStats">Uploaded by <?php echo $r['uploader'] ?> on <?php echo $r['time'];?></div>

				<?php } ?>
			</div> <?php
		endforeach;
	} else {
		if( $this->terms != false ) {
			o('no-search-results');
		} else {
	    o('no-results');
	  }
	}?> 
     </div> <!-- end intro tab -->
     </div> <!-- end tabs content -->


    </div> <!-- end col-9 -->
    </div> <!-- end col-10 -->
  </div> <!-- end row -->
</div> <!-- end container -->
<script>
//	window.onload = initData;
</script>
