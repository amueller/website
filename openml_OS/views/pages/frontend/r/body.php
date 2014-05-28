<!-- File upload. Somehow, putting this in the javascript file doesn't work :/ -->
<script>
	$(document)
		.on('change', '.btn-file :file', function() {
			var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
	});
	
	$(document).ready( function() {
		$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
			
			var input = $(this).parents('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;
			
			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}
		});
	});		
</script>
<script type="text/javascript" src="index.php/javascript/page/data"></script>

<div class="sectionheader">
<div class="sectionlogo"><a href="">OpenML</a></div>
<div class="sectiontitlered"><a href="r">Runs</a></div>
</div>
<div class="bs-docs-container topborder">
    <div class="col-xs-12 col-sm-3 col-md-2 searchbar">
        <!-- Upload stuff -->
	<div class="upload">
        <button type="button" data-toggle="tab" data-target="#runshare" class="btn btn-danger" style="width:100%; text-align:left;"><i class="fa fa-cloud-upload fa-lg" style="padding-right:5px;"></i> Add run</button>
        </div><!-- upload -->

	<!-- Search -->
	<form class="form" method="post" action="r">
	<div class="input-group" style="margin-bottom:7px;">
	  <span class="input-group-addon" style="background-color:#d9534f; color:#FFFFFF; border-color:#d9534f"><i class="fa fa-search fa-fw"></i></span>
	  <input type="text" class="form-control" style="width: 100%; height: 30px; font-size: 11pt;" id="openmlsearch" name="searchterms" placeholder="Search runs" value="<?php if( $this->terms != false ) echo $this->terms; ?>" />
	</div>
	<h4>Analyze</h4>
	<ul class="runmenu" id="qtabs">		
		<li class="<?php if($this->active_tab == 'wizardtab') echo 'active';?>"><a href="#wizardtab" data-toggle="tab">Compare flows</a></li>
		<li class="<?php if($this->active_tab == 'curvestab') echo 'active';?>"><a href="#curvestab" data-toggle="tab">Draw learning curves</a></li>
		<li class="<?php if($this->active_tab == 'exampletab') echo 'active';?>"><a href="#exampletab" data-toggle="tab">Advanced queries</a></li>
		<li class="<?php if($this->active_tab == 'sqltab') echo 'active';?>"><a href="#sqltab" data-toggle="tab">SQL editor</a></li>
  		<li style="display:none;"><a href="#resultstab" data-toggle="tab">Results</a></li>
	</ul>

	<h4>Visualize</h4>
	<ul class="runmenu" id="vtabs">		
		<li><a href="#tabletab" data-toggle="tab" onclick="showResultTab();">Table</a></li>
		<li><a href="#scatterplottab" data-toggle="tab" onclick="showResultTab();onclickScatterPlot();">Scatterplot</a></li>
		<li><a href="#linetab" data-toggle="tab" onclick="showResultTab();onclickLinePlot();">Line plot</a></li>
	</ul>

    </div> <!-- end col-2 -->

    <div class="col-xs-12 col-sm-9 col-md-10 openmlsectioninfo">
     <div class="tab-content">
      <!-- DETAIL -->     
      <div class="tab-pane <?php  if(false !== strpos($_SERVER['REQUEST_URI'],'/r/')) echo 'active';?>" id="runtab">
		<?php subpage('run'); ?>
      </div>
      <div class="tab-pane <?php if(false === strpos($_SERVER['REQUEST_URI'],'/r/')) { echo 'active'; } ?>" id="intro">
      <?php 
	if( $this->terms == false) { ?>
      <div class="redheader">
      <h1>Runs</h1>
      <p>A run is an application of a specific <a href="f">flow</a> on a specific <a href="t">task</a>, including all details such as parameter settings and all results. OpenML collects and organizes all runs from all users, so that their results can be easily compared over all tasks and flows, analyzed, visualized or simply downloaded.</p>
      </div>
      <h2>Recent runs</h2>
      <?php } ?> 
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

				<?php } elseif($r['type'] == 'dataset') { ?>

				<a href="d/<?php echo urlencode($r['id']); ?>"><?php echo $r['name']; ?></a><br />
				<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
				<div class="runStats"><?php echo $r['runs'];?> runs - <?php echo $r['instances'];?> instances - <?php echo $r['features'];?> features - <?php echo $r['classes'];?> classes - <?php echo $r['missing'];?> missing values</div>

				<?php } elseif($r['type'] == 'implementation') { ?>
				
				<a href="f/<?php echo urlencode($r['id']); ?>"><?php echo $r['name']; ?></a><br />
				<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
				<div class="runStats"><?php echo $r['runs'] . ' runs'; ?></div>
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
        <!-- SHARE -->
        <div class="tab-pane fade sharing" id="runshare">
	      <h1 class="modal-title" id="myModalLabel">Add runs</h1>
              <div id="responseImplementationTxt" class="<?php echo $this->initialMsgClass;?>"><?php echo $this->initialMsg; ?></div>
	      <form method="post" id="datasetForm" action="api/?f=openml.data.upload" enctype="multipart/form-data">
		  <input type="hidden" id="generated_input_dataset_description" name="description" value="" />
	      <div class="row">
	 	  <p>Manual run upload is under development.</p>
		  <p>Psst... It is much easier to upload runs using the <a href="plugins">OpenML plugins</a>, or programmatically <a href="developers">using the API</a>.</p>
	      </div>
	      </form>
        </div> <!-- end tab share -->
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

     </div> <!-- end tabs content -->


    </div> <!-- end col-9 -->
</div> <!-- end container -->

<script>
	window.onload = initData;
</script>
