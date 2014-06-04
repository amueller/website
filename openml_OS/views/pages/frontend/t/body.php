<div class="sectionheader">
  <div class="sectionlogo"><a href="">OpenML</a></div>
  <div class="sectiontitleyellow"><a href="t">Tasks</a></div>
</div>
<div class="bs-docs-container topborder">
  <div class="col-xs-12 col-sm-3 col-md-2 searchbar">
    <!-- Search -->
    <h4 style="margin-top:3px;">Task types</h4>
    <div class="upload">
      <button type="button" data-toggle="tab" data-target="#createtype" class="btn btn-warning btn-sm" style="width:100%; text-align:left;"><i class="fa fa-wrench fa-lg" style="padding-right:5px;"></i> Create task type</button>
    </div><!-- upload -->

    <form class="form" method="post" action="t">
      <div class="input-group" style="margin-bottom:7px;">
        <span class="input-group-addon" style="background-color:#f0ad4e; color:#FFFFFF; border-color:#f0ad4e"><i class="fa fa-search fa-fw"></i></span>
        <input type="text" class="form-control" style="width: 100%; height: 30px; font-size: 11pt;" id="openmlsearch" name="typeterms" placeholder="Search task types" value="<?php if( $this->terms != false ) echo $this->typeterms; ?>" />
      </div>
    </form>
    <h4>Tasks</h4>
    <div class="upload">
      <button type="button" data-toggle="tab" data-target="#createtask" class="btn btn-warning btn-sm" style="width:100%; text-align:left;"><i class="fa fa-wrench fa-lg" style="padding-right:5px;"></i> Create task</button>
    </div><!-- upload -->
    <form class="form" method="post" action="t">
      <div class="input-group" style="margin-bottom:7px;">
        <span class="input-group-addon" style="background-color:#f0ad4e; color:#FFFFFF; border-color:#f0ad4e"><i class="fa fa-search fa-fw"></i></span>
        <input type="text" class="form-control" style="width: 100%; height: 30px; font-size: 11pt;" id="openmlsearch" name="typeterms" placeholder="Search tasks" value="<?php if( $this->terms != false ) echo $this->typeterms; ?>" />
      </div>
    </form>
    <div class="option-heading">
      <a data-toggle="collapse" href="#tasksearch">
        <i class="fa fa-caret-down fa-fw"></i> Advanced task search
      </a>
    </div>
    <div id="tasksearch" class="panel-collapse <?php if( false === strpos($_SERVER['REQUEST_URI'],'/t/search')) echo 'collapse'; ?>">
      <form class="form" id="typeselect" action="t" method="post">
        <div class="form-group">
          <select class="form-control input-small selectpicker" name="task_type" id="ttselect">
            <option value="0">Select task type</option>
            <?php foreach( $this->tasktypes as $r ):?>
            <option value="<?php echo $r['id']; ?>" <?php if( isset($this->id) && $r['id'] == $this->id ) echo 'selected'; ?>><?php echo $r['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </form>
      <script>
        $("#ttselect").change(function() {
          if( $(this).val() > 0){
            $("#typeselect").attr("action", "t/type/" + $(this).val());
          }
          $("#typeselect").submit();
        });
      </script>
      <div class="tab-content">
        <div class="tab-pane <?php if( isset($this->id) && $this->id == 1 ) echo 'active'; ?> " id="supervised_classification">
          <form class="form" action="t/search/type/1" method="post">
            <input type="hidden" name="task_type" value="1" />

            <div class="form-group">
              <label class="control-label" for="classificationDatasetVersionDropdown">Dataset</label>
              <div>
                <input type="text" class="form-control" id="classificationDatasetVersionDropdown" name="datasets" placeholder="Include all datasets" />
                <span class="help-block">A comma-separated list of datasets.</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="classificationTargetFeature">Target feature</label>
              <div>
                <input type="text" class="form-control" id="classificationTargetFeature" name="target_feature" placeholder="Use default target feature" />
                <span class="help-block">Name of the target feature.</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="datasetDropdown">Estimation procedure</label>
              <select class="form-control input-small selectpicker" name="estimation_procedure">
                <?php foreach($this->ep as $e): if($e->ttid != 1)continue; ?>
                <option value="<?php echo $e->id; ?>"><?php echo $e->name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label" for="classificationEvaluationMeasureDropdown">Evaluation measure</label>
              <div >
                <input type="text" class="form-control" id="classificationEvaluationMeasureDropdown" name="evaluation_measure" placeholder="evaluation measure" value="predictive_accuracy" />
                <span class="help-block">The measure to optimize for. </span>
              </div>
            </div>
	    <button class="btn btn-default btn-small" style="width:100%; margin-top:10px;" type="submit">Search</button>
          </form>
        </div>
        <div class="tab-pane <?php if( isset($this->id) && $this->id == 2 ) echo 'active'; ?>" id="supervised_regression"> 
          <form class="form" action="t/search/type/2" method="post">
            <input type="hidden" name="task_type" value="2" />
            <div class="form-group">
              <label class="control-label" for="regressionDatasetVersionDropdown">Dataset</label>
              <div >
                <input type="text" class="form-control" id="regressionDatasetVersionDropdown" name="datasets" placeholder="Include all datasets" />
                <span class="help-block">A comma-separated list of datasets.</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="regressionTargetFeature">Target feature</label>
              <div>
                <input type="text" class="form-control" id="regressionTargetFeature" name="target_feature" placeholder="class" />
                <span class="help-block">Name of the target feature.</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="datasetDropdown">Estimation procedure</label>
              <div >
                <select class="form-control input-small selectpicker" name="estimation_procedure">
                  <?php foreach($this->ep as $e): if($e->ttid != 2)continue; ?>
                  <option value="<?php echo $e->id; ?>"><?php echo $e->name; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="regressionEvaluationMeasureDropdown">Evaluation measure</label>
              <div >
                <input type="text" class="form-control" id="regressionEvaluationMeasureDropdown" name="evaluation_measure" placeholder="evaluation measure" value="mean_absolute_error" />
                <span class="help-block">The measure to optimize for.</span>
              </div>
            </div>
	    <button class="btn btn-default btn-small" style="width:100%; margin-top:10px;" type="submit">Search</button>
          </form>
        </div>
        <div class="tab-pane <?php if( isset($this->id) && $this->id == 3 ) echo 'active'; ?>" id="learning_curve">  
          <form class="form" action="t/search/type/3" method="post">
            <input type="hidden" name="task_type" value="3" />
            <div class="form-group">
              <label class="control-label" for="learningCurveDatasetVersionDropdown">Dataset</label>
              <div >
                <input type="text" class="form-control" id="learningCurveDatasetVersionDropdown" name="datasets" placeholder="Include all datasets" />
                <span class="help-block">A comma-separated list of datasets</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="datastreamsMinimalDatasetSize">Minimal dataset size</label>
              <div >
                <input type="text" class="form-control" id="datastreamsMinimalDatasetSize" name="minimal_dataset_size" placeholder="No minimum" value="50000" />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="datasetDropdown">Estimation procedure</label>
              <div>
                <select class="form-control input-small selectpicker" name="estimation_procedure">
                  <?php foreach($this->ep as $e): if($e->ttid != 3)continue; ?>
                  <option value="<?php echo $e->id; ?>"><?php echo $e->name; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="dataStreamEvaluationMeasureDropdown">Evaluation measure</label>
              <div >
                <input type="text" class="form-control" id="dataStreamEvaluationMeasureDropdown" name="evaluation_measure" placeholder="evaluation measure" value="predictive_accuracy" />
                <span class="help-block">The measure to optimize for</span>
              </div>
            </div>
	    <button class="btn btn-default btn-small" style="width:100%; margin-top:10px;" type="submit">Search</button>
          </form>
        </div>
        <div class="tab-pane <?php if( isset($this->id) && $this->id == 4 ) echo 'active'; ?>" id="data_stream_classification">    
          <form class="form" action="t/search/type/4" method="post">
            <input type="hidden" name="task_type" value="4" />
            <div class="form-group">
              <label class="control-label" for="learningCurveDatasetVersionDropdown">Dataset</label>
              <div >
                <input type="text" class="form-control" id="learningCurveDatasetVersionDropdown" name="datasets" placeholder="Include all datasets" />
                <span class="help-block">A comma-separated list of datasets</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="learningCurveTargetFeature">Target feature</label>
              <div>
                <input type="text" class="form-control" id="learningCurveTargetFeature" name="target_feature" placeholder="Use default target feature" />
                <span class="help-block">Name of the target feature</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="estimation_procedure">Estimation procedure</label>
              <div >
                <select class="form-control input-small selectpicker" name="estimation_procedure">
                  <?php foreach($this->ep as $e): if($e->ttid != 4)continue; ?>
                  <option value="<?php echo $e->id; ?>"><?php echo $e->name; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="learningCurveEvaluationMeasureDropdown">Evaluation measure</label>
              <div >
                <input type="text" class="form-control" id="learningCurveEvaluationMeasureDropdown" name="evaluation_measure" placeholder="evaluation measure" value="predictive_accuracy" />
                <span class="help-block">The measure to optimize for</span>
              </div>
            </div>
	    <button class="btn btn-default btn-small" style="width:100%; margin-top:10px;" type="submit">Search</button>
          </form>
        </div>
      </div> <!-- end search tabs -->
    </div> <!-- end collapse -->



  </div> <!-- end col-2 -->

  <div class="col-xs-12 col-sm-9 col-md-10 openmlsectioninfo">
    <div class="tab-content">
      <div class="tab-pane  <?php if(false === strpos($_SERVER['REQUEST_URI'],'/t/')) { echo 'active'; } ?>" id="intro">
        <div class="yellowheader">
          <h1>Tasks</h1>
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


      </div> <!-- end intro tab -->

      <div class="tab-pane <?php if( isset($this->id) ) echo 'active'; ?>" id="typedetail">
        <?php 
        if(false !== strpos($_SERVER['REQUEST_URI'],'/t/type')) {
        subpage('tasktype'); 
        }?>
      </div>

      <div class="tab-pane <?php if( isset($this->task_id) ) echo 'active'; ?>" id="taskdetail">
        <?php if( isset($this->task_id) ) { o('task'); } ?>
      </div>

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

      <div class="tab-pane <?php if( false !== strpos($_SERVER['REQUEST_URI'],'search')) { echo 'active'; }?>" id="search">
        <div class="row">
            <div class="col-xs-6"><div class="searchstats">Found <?php echo ($this->found_tasks) ? count($this->found_tasks) : 'none'; ?> tasks matching your criteria.</div></div>
            <div class="col-xs-6"><a style="float:right; clear:both;" data-toggle="collapse" href="#collapseAllIDs">Show task ID list</a></div>
        </div>
        <?php if($this->task_message != false):?>
        <div class="alert alert-warning"><?php echo $this->task_message; ?></div>
        <?php elseif($this->found_tasks): ?>
        <div class="panel-collapse collapse" id="collapseAllIDs">
          <div class="panel panel-body panel-default">
            <?php echo implode(', ', object_array_get_property( $this->found_tasks, 'task_id' ) ); ?>
          </div>
        </div>
        <?php foreach( $this->found_tasks as $t ): ?>
              <a href="t/<?php echo $t->task_id; ?>"><?php echo $t->name; ?></a><br>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="alert alert-warning">No search terms specified. </div>
        <?php endif; ?>
      </div>

    </div> <!-- end tabs content -->
  </div> <!-- end col-9 -->
</div> <!-- end container -->
