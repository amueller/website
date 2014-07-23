<div class="bs-docs-container topborder">
  <div class="container">
    <div class="col-sm-12">
      <h2>Job creation</h2>
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
          <form method="post" action="">
            <div class="form-group">
	            <label class="control-label" for="task-type-<?php echo $tt->ttid; ?>-experiment">Experiment</label>
              <input type="text" id="task-type-<?php echo $tt->ttid; ?>-experiment" name="experiment" value="<?php echo $this->experiment; ?>" <?php if($this->experiment) { echo 'readonly'; } ?> />
            </div>
            <div class="form-group">
              <label class="control-label">Select Tasks</label>
              <div class="row">
                <?php if( $tt->tasks ): foreach( $tt->tasks as $task ): ?>
                  <div class="col-md-4"><input type="checkbox" name="tasks[]" value="<?php echo htmlspecialchars( $task->task_id ); ?>" <?php if( in_array( $task->task_id, $this->active_tasks ) ) echo 'checked'; ?>/>
                    &nbsp;Task <?php echo $task->task_id; ?> - <?php echo $this->datasets[$task->source_data]; ?></div>
                <?php endforeach; else: ?>
                  <div class="col-md-4">No tasks.</div> 
                <?php endif; ?>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Select Algorithms</label>
              <div class="row">
                <?php if( $this->setups ): foreach( $this->setups as $setup ): ?>
                  <div class="col-md-4">
                    <span data-toggle="tooltip" data-placement="right" title="<?php echo htmlspecialchars( $setup->setup_string ); ?>"><input type="checkbox" name="setups[]" value="<?php echo $setup->sid; ?>" <?php if( in_array( $setup->sid, $this->active_setups ) ) echo 'checked'; ?> />&nbsp;<?php echo $setup->name . '(' . $setup->version . ')'; ?></span></div>
                <?php endforeach; else: ?>
                  <div class="col-md-4">No setups.</div> 
                <?php endif; ?>
              </div>
            </div>
            <div class="form-group">
              <input class="btn btn-primary" type="submit" value="Submit"/>
            </div>
          </form>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
