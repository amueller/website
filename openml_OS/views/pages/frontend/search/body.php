
<div class="container">
<script type="text/javascript" src="index.php/javascript/page/data"></script>
<script type="text/javascript">
	$(function() {
        var datasets = expdbDatasets();
		var evaluationmetrics = expdbEvaluationMetrics();
		var algorithms = expdbAlgorithms();
		var implementations = getImplementationsWithAlgorithms( ['SVM', 'C4.5'] ); // TODO: bind to algorithm field
		
		makeCommaSeperatedAutoComplete( "#datasetDropdown", datasets ); 
		makeCommaSeperatedAutoComplete( "#algorithmDropdown", algorithms ); 
        makeCommaSeperatedAutoComplete( "#implementationDropdown", implementations ); 
        makeCommaSeperatedAutoComplete( "#classificationDatasetVersionDropdown", expdbDatasetVersionOriginal() ); 
        makeCommaSeperatedAutoComplete( "#regressionDatasetVersionDropdown", expdbDatasetVersionOriginal() ); 
        makeAutoComplete( "#classificationEvaluationMeasureDropdown", expdbClassificationEvaluationMetrics() ); 
        makeAutoComplete( "#regressionEvaluationMeasureDropdown", expdbRegressionEvaluationMetrics() ); 
		
		$( "#evaluationmetricDropdown" ).autocomplete({
            source: evaluationmetrics,
			minLength: 1
        });
    });
</script>
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-search" id="qtabs">
		  <li class="<?php if($this->active_tab == 'searchtab') echo 'active';?>"><a href="#searchtab" data-toggle="tab"><i class="icon-search"></i>  All</a></li>
		  <li class="<?php if($this->active_tab == 'datasetsearchtab') echo 'active';?>"><a href="#datasetsearchtab" data-toggle="tab"><i class="icon-table"></i>  Datasets</a></li>
		  <li class="<?php if($this->active_tab == 'implementationsearchtab') echo 'active';?>"><a href="#implementationsearchtab" data-toggle="tab"><i class="icon-cogs"></i>  Implementations</a></li>
		  <li class="<?php if($this->active_tab == 'metricsearchtab') echo 'active';?>"><a href="#metricsearchtab" data-toggle="tab"><i class="icon-signal"></i>  Metrics</a></li>
		  <li class="<?php if($this->active_tab == 'tasktab') echo 'active';?>"><a href="#tasktab" data-toggle="tab"><i class="icon-check"></i>  Tasks</a></li>
		  <li class="<?php if($this->active_tab == 'wizardtab') echo 'active';?>"><a href="#wizardtab" data-toggle="tab"><i class="icon-bolt"></i>  Runs</a></li>
		  <li class="<?php if($this->active_tab == 'exampletab') echo 'active';?>"><a href="#exampletab" data-toggle="tab"><i class=" icon-beaker"></i>  Advanced</a></li>
		  <li class="<?php if($this->active_tab == 'sqltab') echo 'active';?>"><a href="#sqltab" data-toggle="tab"><i class="icon-pencil"></i>  SQL</a></li>
		  <li class="<?php if($this->active_tab == 'querygraphtab') echo 'active';?>"><a href="#querygraphtab" data-toggle="tab"><i class="icon-hand-up"></i>  Graph</a></li>
		  <li class="<?php if($this->active_tab == 'resultstab') echo 'active';?>"><a href="#resultstab" data-toggle="tab"><i class="icon-list"></i>  Results</a></li>
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
