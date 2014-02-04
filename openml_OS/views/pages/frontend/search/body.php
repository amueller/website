
<div class="container">
<script type="text/javascript" src="index.php/javascript/page/data"></script>

<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-search" id="qtabs">
		  <li class="<?php if($this->active_tab == 'searchtab') echo 'active';?>"><a href="#searchtab" data-toggle="tab"><i class="fa fa-search"></i>  All</a></li>
		  <li class="<?php if($this->active_tab == 'datasetsearchtab') echo 'active';?>"><a href="#datasetsearchtab" data-toggle="tab"><i class="fa fa-table"></i>  Datasets</a></li>
		  <li class="<?php if($this->active_tab == 'implementationsearchtab') echo 'active';?>"><a href="#implementationsearchtab" data-toggle="tab"><i class="fa fa-cogs"></i>  Implementations</a></li>
		  <li class="<?php if($this->active_tab == 'metricsearchtab') echo 'active';?>"><a href="#metricsearchtab" data-toggle="tab"><i class="fa fa-signal"></i>  Metrics</a></li>
		  <li class="<?php if($this->active_tab == 'tasktab') echo 'active';?>"><a href="#tasktab" data-toggle="tab"><i class="fa fa-check"></i>  Tasks</a></li>
		  <li class="<?php if($this->active_tab == 'wizardtab') echo 'active';?>"><a href="#wizardtab" data-toggle="tab"><i class="fa fa-bolt"></i>  Runs</a></li>
		  <li class="<?php if($this->active_tab == 'curvestab') echo 'active';?>"><a href="#curvestab" data-toggle="tab"><i class="fa fa-bolt"></i>  Learning Curves</a></li>
		  <li class="<?php if($this->active_tab == 'exampletab') echo 'active';?>"><a href="#exampletab" data-toggle="tab"><i class=" fa fa-flask"></i>  Advanced</a></li>
		  <li class="<?php if($this->active_tab == 'sqltab') echo 'active';?>"><a href="#sqltab" data-toggle="tab"><i class="fa fa-pencil"></i>  SQL</a></li>
		  <!--<li class="<?php if($this->active_tab == 'querygraphtab') echo 'active';?>"><a href="#querygraphtab" data-toggle="tab"><i class="fa fa-hand-o-up"></i>  Graph</a></li>-->
		  <li class="<?php if($this->active_tab == 'resultstab') echo 'active';?>"><a href="#resultstab" data-toggle="tab"><i class="fa fa-list"></i>  Results</a></li>
		</ul>
		<hr style="margin:0px;padding-top:0px">
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<!--Body content-->
		<div class="tab-content" style="overflow: visible;">
			<div class="tab-pane <?php if($this->active_tab == 'searchtab') echo 'active';?>" id="searchtab">
				<?php o( 'top-search.php' ); ?>
				<?php subpage( 'search-results' ); ?>
			</div>
			<div class="tab-pane <?php if($this->active_tab == 'datasetsearchtab') echo 'active';?>" id="datasetsearchtab">
				<?php o( 'top-search.php' ); ?>
				<?php subpage( 'search-results-datasets' ); ?>
			</div>
			<div class="tab-pane <?php if($this->active_tab == 'implementationsearchtab') echo 'active';?>" id="implementationsearchtab">
				<?php o( 'top-search.php' ); ?>
				<?php subpage( 'search-results-algorithms' ); ?>
			</div>
			<div class="tab-pane <?php if($this->active_tab == 'metricsearchtab') echo 'active';?>" id="metricsearchtab">
				<?php o( 'top-search.php' ); ?>
				<?php subpage( 'search-results-functions' ); ?>
			</div>
			<div class="tab-pane <?php if($this->active_tab == 'exampletab') echo 'active';?>" id="exampletab">
				<?php subpage('examples'); ?>
			</div>
			<div class="tab-pane <?php if($this->active_tab == 'tasktab') echo 'active';?>" id="tasktab">
				<?php subpage('tasks'); ?>
			</div>
			<div class="tab-pane <?php if($this->active_tab == 'wizardtab') echo 'active';?>" id="wizardtab">
				<?php subpage('wizard'); ?>
			</div>
      
			<div class="tab-pane <?php if($this->active_tab == 'curvestab') echo 'active';?>" id="curvestab">
				<?php subpage('curves'); ?>
			</div>
			  
			<div class="tab-pane <?php if($this->active_tab == 'querygraphtab') echo 'active';?>" id="querygraphtab">
				<?php subpage('querygraph'); ?>
			</div>

			<div class="tab-pane <?php if($this->active_tab == 'sqltab') echo 'active';?>" id="sqltab">
				<?php subpage('sql'); ?>
			</div>
		 
			<div class="tab-pane <?php if($this->active_tab == 'resultstab') echo 'active';?>" id="resultstab">
				<?php subpage('results'); ?>
			</div>
		</div>
	</div>
</div>
<script>
	window.onload = initData;
</script>
</div>
