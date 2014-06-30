<div class="bs-docs-container topborder">
  <div class="col-sm-12 col-md-2 searchbar">
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
      <?php foreach( $this->task_types as $task_type ): ?>
        <div class="tab-pane <?php if( isset($this->id) && $this->id == $task_type->ttid ) echo 'active'; ?> " id="<?php echo text_to_underscored($task_type->name); ?>">
          <form class="form" action="t/search/type/<?php echo $task_type->ttid; ?>" method="post">
            <input type="hidden" name="task_type" value="<?php echo $task_type->ttid; ?>" />
            
            <?php foreach( $task_type->io as $io ): $input_id = text_to_underscored($task_type->name . '_' . $io->name); ?>
            <?php $template_search = json_decode( $io->template_search ); if( $template_search && $template_search->display == "none" ) continue; ?>
            <div class="form-group">
              <label class="control-label" for="<?php echo $input_id; ?>"><?php echo ( $template_search && $template_search->name != false ) ? $template_search->name : text_neat_ucwords( $io->name ); ?></label>
              <?php if( $template_search && $template_search->type == "select" ): // make a dropdown
                  $sql = 'SELECT * FROM `'.$template_search->table.'` WHERE ttid = ' . $io->ttid; $types = $this->Dataset->query( $sql ); ?>
                <select class="form-control input-small selectpicker" name="<?php echo text_to_underscored($io->name);?>">
                  <option value="">Any</option>
                  <?php foreach($types as $type): ?>
                  <option value="<?php echo $type->{$template_search->key}; ?>"><?php echo $type->{$template_search->value}; ?></option>
                  <?php endforeach; ?>
                </select>
              <?php else: // makes a plain text input ?>
                <div>
                  <input type="text" class="form-control" id="<?php echo $input_id; ?>" name="<?php echo text_to_underscored($io->name);?>" />
                  <span class="help-block"><?php echo $io->description;?></span>
                </div>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
	          <button class="btn btn-default btn-small" style="width:100%; margin-top:10px;" type="submit">Search</button>
          </form>
        </div>
      <?php endforeach; ?>
      </div> <!-- end search tabs -->
    </div>


  </div> <!-- end col-2 -->

  <div class="col-sm-12 col-md-10 openmlsectioninfo">
    <div class="tab-content">
      <div class="tab-pane  <?php if(false === strpos($_SERVER['REQUEST_URI'],'/t/')) { echo 'active'; } ?>" id="intro">
        <div class="yellowheader">
          <h1><i class="fa fa-check"></i> Tasks</h1>
          <p>Tasks define machine learning problems in such a way that the obtained results are clearly interpretable and verifiable. <b>Task types</b> are general descriptions in terms of the (types of) given input, expected output and scientific protocols, e.g, cross-validation, to be used. Given specific <a href="d">input data</a>, OpenML then generates individual <b>tasks</b> to be solved. Tasks are machine-readable, fully contained and are read by <a href="f">flows</a>.</p>
        </div>
        <h2>Task types</h2>
        <?php foreach( $this->tasktypes as $r ):?>
        <div class="searchresult">
          <a href="t/type/<?php echo urlencode($r['id']); ?>"><?php echo $r['name']; ?></a><br />
          <div class="teaser"><?php echo teaser($r['description'], 200); ?></div>
          <div class="runStats"><?php echo $r['tasks'] . ' tasks'; ?></div>
        </div>
        <?php endforeach; ?>


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
