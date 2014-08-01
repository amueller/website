<div class="bs-docs-container topborder">
  <div class="container">
    <div class="col-sm-12">
      <h2>Task Overview</h2>
      <div class="form-group">
	      <label class="control-label" for="input_dataset_licence">Select Task type</label>
		    <select id="selectTaskType" class="form-control">
		      <?php foreach( $this->task_types as $tt ): ?>
          <option name="<?php echo $tt->ttid; ?>"><?php echo $tt->name; ?></option>
          <?php endforeach; ?>
		    </select>
      </div>
      <ul class="nav nav-tabs" id="form-task-type-tabs" style="display: none; ">
        <li><a href="#task-type-0" role="tab" data-toggle="tab">Select task type</a></li>
        <?php foreach( $this->task_types as $tt ): ?>
          <li><a href="#task-type-<?php echo $tt->ttid; ?>" role="tab" data-toggle="tab"><?php echo $tt->name; ?></a></li>
        <?php endforeach; ?>
      </ul>
      <div class="tab-content">
      <?php foreach( $this->task_types as $tt ): ?>
        <div class="tab-pane" id="task-type-<?php echo $tt->ttid; ?>">
          <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#task-type-<?php echo $tt->ttid; ?>-all" role="tab" data-toggle="tab">All</a></li>
            <li><a href="#task-type-<?php echo $tt->ttid; ?>-missing" role="tab" data-toggle="tab">Missing Values</a></li>
            <li><a href="#task-type-<?php echo $tt->ttid; ?>-illegal" role="tab" data-toggle="tab">Illegal Values</a></li>
            <li><a href="#task-type-<?php echo $tt->ttid; ?>-duplicates" role="tab" data-toggle="tab">Duplicate Tasks</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="task-type-<?php echo $tt->ttid; ?>-all">
              <h4>All <?php echo $tt->name; ?> tasks</h4>
              <table class="taskstable"><?php echo generate_table( $tt->inputs, $tt->tasks ); ?></table>
            </div>
            <div class="tab-pane" id="task-type-<?php echo $tt->ttid; ?>-missing">
              <h4><?php echo $tt->name; ?> tasks with missing "required" values</h4>
              <table class="taskstable"><?php echo generate_table( $this->missingheader, $tt->missing ); ?></table>
            </div>
            <div class="tab-pane" id="task-type-<?php echo $tt->ttid; ?>-illegal">
              <h4><?php echo $tt->name; ?> tasks with illegal values</h4>
              <table class="taskstable"><?php echo generate_table( $this->missingheader, $tt->illegal ); ?></table>
            </div>
            <div class="tab-pane" id="task-type-<?php echo $tt->ttid; ?>-duplicates">
              <h4><?php echo $tt->name; ?> groups of tasks with the same values</h4>
              <?php foreach( $tt->duplicate_groups as $duplicates ): ?>
                Task_id - # runs <br/>
                <?php foreach( $duplicates as $d ): $runs = $this->Run->getColumnFunctionWhere( 'count(*)', 'task_id = ' . $d ); ?>
                  <?php echo $d; ?> - <?php echo $runs[0]; ?><a onclick="deletetask(); ">Delete</a><br/>
                <?php endforeach; ?>
                <hr/>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
