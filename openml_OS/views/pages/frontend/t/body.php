<div class="sectionheader">
<div class="sectionlogo"><a href="">OpenML</a></div>
<div class="sectiontitleyellow"><a href="t">Tasks</a></div>
</div>
<div class="bs-docs-container topborder">
    <div class="col-xs-12 col-sm-3 col-md-2 searchbar">
	<h4 style="margin-top:0px;">Task types</h4>
        <!-- Upload stuff -->
	<div class="upload">
        <button type="button" data-toggle="tab" data-target="#createtype" class="btn btn-warning" style="width:100%; text-align:left;"><i class="fa fa-wrench fa-lg" style="padding-right:5px;"></i> Create task type</button>
        </div><!-- upload -->

	<!-- Search -->
	<form class="form" method="post" action="d">
	<div class="input-group" style="margin-bottom:7px;">
	  <span class="input-group-addon" style="background-color:#f0ad4e; color:#FFFFFF; border-color:#f0ad4e"><i class="fa fa-search fa-fw"></i></span>
	  <input type="text" class="form-control" style="width: 100%; height: 30px; font-size: 11pt;" id="openmlsearch" name="typeterms" placeholder="Search task types" value="<?php if( $this->terms != false ) echo $this->typeterms; ?>" />
	</div>

	<h4>Tasks</h4>
        <!-- Upload stuff -->
	<div class="upload">
        <button type="button" data-toggle="tab" data-target="#createtask" class="btn btn-warning" style="width:100%; text-align:left;"><i class="fa fa-wrench fa-lg" style="padding-right:5px;"></i> Create task</button>
        </div><!-- upload -->

	<ul class="runmenu" id="ttabs" style="margin-top:20px;">		
		<li class="<?php if($this->active_tab == 'supervised_classification') echo 'active';?>"><a href="#supervised_classification" data-toggle="tab"><i class="fa fa-search"></i> Supervised classification</a></li>
		<li class="<?php if($this->active_tab == 'supervised_regression') echo 'active';?>"><a href="#supervised_regression" data-toggle="tab"><i class="fa fa-search"></i> Supervised regression</a></li>
		<li class="<?php if($this->active_tab == 'data_stream_classification') echo 'active';?>"><a href="#data_stream_classification" data-toggle="tab"><i class="fa fa-search"></i> Data stream classification</a></li>
		<li class="<?php if($this->active_tab == 'learning_curve') echo 'active';?>"><a href="#learning_curve" data-toggle="tab"><i class="fa fa-search"></i> Learning curve analysis</a></li>
  		<li style="display:none;"><a href="#results" data-toggle="tab">Results</a></li>
	</ul>


    </div> <!-- end col-2 -->

    <div class="col-xs-12 col-sm-9 col-md-10 openmlsectioninfo">
     <div class="tab-content">
      <div class="tab-pane <?php if(false === strpos($_SERVER['REQUEST_URI'],'search')) { echo 'active'; } ?>" id="intro">
      <div class="yellowheader">
       <h1><i class="fa fa-check-square-o"></i> Tasks</h1>
       <p>Clear definitions of machine learning challenges and how to solve them.</p>
      </div>
      <h2>Popular</h2>
      </div> <!-- end intro tab -->
     <div class="tab-pane sharing" id="createtype">
	      <h1 class="modal-title" id="myModalLabel">Create new task type</h1>
              <div id="responseImplementationTxt" class="<?php echo $this->initialMsgClass;?>"><?php echo $this->initialMsg; ?></div>
	      <form method="post" id="datasetForm" action="api/?f=openml.data.upload" enctype="multipart/form-data">
		  <input type="hidden" id="generated_input_dataset_description" name="description" value="" />
	      <div class="row">
	 	  <p>Manual task type creation is under development. Check back soon.</p>
	      </div>
	      </form>
     </div> <!-- end tab create type -->
     <div class="tab-pane sharing" id="createtask">
	      <h1 class="modal-title" id="myModalLabel">Create new task</h1>
              <div id="responseImplementationTxt" class="<?php echo $this->initialMsgClass;?>"><?php echo $this->initialMsg; ?></div>
	      <form method="post" id="datasetForm" action="api/?f=openml.data.upload" enctype="multipart/form-data">
		  <input type="hidden" id="generated_input_dataset_description" name="description" value="" />
	      <div class="row">
	 	  <p>Manual task creation is under development. Check back soon.</p>
	      </div>
	      </form>
     </div> <!-- end tab create type -->

  <div class="tab-pane" id="supervised_classification">
      <div class="yellowheader">
       <h1>Supervised Classification tasks</h1>
       <p>Search for supervised classification tasks on specific datasets or other specific inputs.</p>
      </div>
    <form class="form-horizontal" action="t#results" method="post">
      <input type="hidden" name="task_type" value="1" />

      <div class="form-group">
        <label class="col-md-2 control-label" for="datasetDropdown">Estimation procedure</label>
        <div class="col-md-10">
          <select class="form-control input-small" name="estimation_procedure">
            <?php foreach($this->ep as $e): if($e->ttid != 1)continue; ?>
            <option value="<?php echo $e->id; ?>"><?php echo $e->name; ?></option>
            <?php endforeach; ?>
          </select>
          <span class="help-block">
            Choose the estimation procedure used to evaluate the results. 
            If your preferred evaluation method is not in this list, please send us an email.
          </span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="classificationDatasetVersionDropdown">Dataset</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="classificationDatasetVersionDropdown" name="datasets" placeholder="Include all datasets" />
          <span class="help-block">A comma separated list of the datasets to include. Leave empty to include all datasets.</span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="classificationEvaluationMeasureDropdown">Evaluation measure</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="classificationEvaluationMeasureDropdown" name="evaluation_measure" placeholder="evaluation measure" value="predictive_accuracy" />
          <span class="help-block">The evaluation measure to optimize for. </span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="specify_target_feature_btn">Target feature</label>
        <div class="col-md-10">
          <input type="checkbox" checked="checked" name="default_target_feature" id="specify_classification_target_feature_btn" /> Use default target feature
        </div>
      </div>
      <div class="form-group" id="specify_classification_target_feature">
        <label class="col-md-2 control-label" for="classificationTargetFeature">Specify target feature</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="classificationTargetFeature" name="target_feature" placeholder="class" />
          <span class="help-block">Specify the name of the target feature (case sensitive). Datasets that do not contain such a feature will be excluded from the search</span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
          <button type="submit" class="btn btn-primary">
            Run Query
          </button>
        </div>
      </div>
    </form>
  </div>
  <div class="tab-pane" id="supervised_regression">
      <div class="yellowheader">
       <h1>Supervised Regression tasks</h1>
       <p>Search for supervised regression tasks on specific datasets or other specific inputs.</p>
      </div>    
    <form class="form-horizontal" action="t#results" method="post">
      <input type="hidden" name="task_type" value="2" />
      <div class="form-group">
        <label class="col-md-2 control-label" for="datasetDropdown">Estimation procedure</label>
        <div class="col-md-10">
          <select class="form-control input-small" name="estimation_procedure">
            <?php foreach($this->ep as $e): if($e->ttid != 2)continue; ?>
            <option value="<?php echo $e->id; ?>"><?php echo $e->name; ?></option>
            <?php endforeach; ?>
          </select>
          <span class="help-block">
            Choose the estimation procedure used to evaluate the results. 
            If your preferred evaluation method is not in this list, please send us an email.
          </span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="regressionDatasetVersionDropdown">Dataset</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="regressionDatasetVersionDropdown" name="datasets" placeholder="Include all datasets" />
          <span class="help-block">A comma separated list of the datasets to include. Leave empty to include all datasets.</span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="regressionEvaluationMeasureDropdown">Evaluation measure</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="regressionEvaluationMeasureDropdown" name="evaluation_measure" placeholder="evaluation measure" value="mean_absolute_error" />
          <span class="help-block">The evaluation measure to optimize for. </span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="specify_target_feature_btn">Target feature</label>
        <div class="col-md-10">
          <input type="checkbox" checked="checked" name="default_target_feature" id="specify_regression_target_feature_btn" /> Use default target feature
        </div>
      </div>
      <div class="form-group" id="specify_regression_target_feature">
        <label class="col-md-2 control-label" for="regressionTargetFeature">Specify target feature</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="regressionTargetFeature" name="target_feature" placeholder="class" />
          <span class="help-block">Specify the name of the target feature (case sensitive). Datasets that do not contain such a feature will be excluded from the search</span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
          <button type="submit" class="btn btn-primary">
            Run Query
          </button>
        </div>
      </div>
    </form>
  </div>
  <div class="tab-pane" id="data_stream_classification">
      <div class="yellowheader">
       <h1>Data Stream Classification tasks</h1>
       <p>Search for data stream classification tasks on specific streams or other specific inputs.</p>
      </div>    
    <form class="form-horizontal" action="t#results" method="post">
      <input type="hidden" name="task_type" value="4" />
      <div class="form-group">
        <label class="col-md-2 control-label" for="datasetDropdown">Estimation procedure</label>
        <div class="col-md-10">
          <select class="form-control input-small" name="estimation_procedure">
            <?php foreach($this->ep as $e): if($e->ttid != 4)continue; ?>
            <option value="<?php echo $e->id; ?>"><?php echo $e->name; ?></option>
            <?php endforeach; ?>
          </select>
          <span class="help-block">
            Choose the estimation procedure used to evaluate the results. 
            If your preferred evaluation method is not in this list, please send us an email.
          </span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="datastreamsMinimalDatasetSize">Minimal dataset size</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="datastreamsMinimalDatasetSize" name="minimal_dataset_size" placeholder="No minimun" value="50000" />
          <span class="help-block">The minimal number of instances that datasets should cover. Leave empty to insert datasets of any size</span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="dataStreamEvaluationMeasureDropdown">Evaluation measure</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="dataStreamEvaluationMeasureDropdown" name="evaluation_measure" placeholder="evaluation measure" value="predictive_accuracy" />
          <span class="help-block">The evaluation measure to optimize for. </span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
          <button type="submit" class="btn btn-primary">
            Run Query
          </button>
        </div>
      </div>
    </form>
  </div>
  <div class="tab-pane" id="learning_curve">
      <div class="yellowheader">
       <h1>Learning curve analysis tasks</h1>
       <p>Search for learning curve analysis tasks on specific datasets or other specific inputs.</p>
      </div>        
    <form class="form-horizontal" action="t#results" method="post">
      <input type="hidden" name="task_type" value="3" />
      <div class="form-group">
        <label class="col-md-2 control-label" for="datasetDropdown">Estimation procedure</label>
        <div class="col-md-10">
          <select class="form-control input-small" name="estimation_procedure">
            <?php foreach($this->ep as $e): if($e->ttid != 3)continue; ?>
            <option value="<?php echo $e->id; ?>"><?php echo $e->name; ?></option>
            <?php endforeach; ?>
          </select>
          <span class="help-block">
            Choose the estimation procedure used to evaluate the results. 
            If your preferred evaluation method is not in this list, please send us an email.
          </span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="learningCurveDatasetVersionDropdown">Dataset</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="learningCurveDatasetVersionDropdown" name="datasets" placeholder="Include all datasets" />
          <span class="help-block">A comma separated list of the datasets to include. Leave empty to include all datasets.</span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="learningCurveEvaluationMeasureDropdown">Evaluation measure</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="learningCurveEvaluationMeasureDropdown" name="evaluation_measure" placeholder="evaluation measure" value="predictive_accuracy" />
          <span class="help-block">The evaluation measure to optimize for. </span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label" for="specify_learningCurve_target_feature_btn">Target feature</label>
        <div class="col-md-10">
          <input type="checkbox" checked="checked" name="default_target_feature" id="specify_learningCurve_target_feature_btn" /> Use default target feature
        </div>
      </div>
      <div class="form-group" id="specify_learningCurve_target_feature">
        <label class="col-md-2 control-label" for="learningCurveTargetFeature">Specify target feature</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="learningCurveTargetFeature" name="target_feature" placeholder="class" />
          <span class="help-block">Specify the name of the target feature (case sensitive). Datasets that do not contain such a feature will be excluded from the search</span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
          <button type="submit" class="btn btn-primary">
            Run Query
          </button>
        </div>
      </div>
    </form>
  </div>
  <div class="tab-pane" id="results">
    <h4>Results (<?php echo ($this->found_tasks) ? count($this->found_tasks) : 'none'; ?>)</h4>
    <?php if($this->task_message != false):?>
      <div class="alert alert-warning"><?php echo $this->task_message; ?></div>
    <?php elseif($this->found_tasks): ?>
      <div class="panel panel-default">
        <div class="panel-heading">All task ID&#39;s:</div>
        <div class="panel-body">
          <?php echo implode(', ', object_array_get_property( $this->found_tasks, 'task_id' ) ); ?>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">All tasks:</div>
        <div class="panel-body">
          <div class="row">
            <?php foreach( $this->found_tasks as $t ): ?>
            <div class="col-md-4"><a href="api/?f=openml.task.search&task_id=<?php echo $t->task_id; ?>"><?php echo $t->name; ?></a></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-warning">No search terms specified. </div>
    <?php endif; ?>
  </div>

     </div> <!-- end tabs content -->
    </div> <!-- end col-9 -->
</div> <!-- end container -->
