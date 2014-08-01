<div class="bs-docs-container topborder">
  <div class="container">
    <div class="col-md-12">
      <div class="row">
        <h2>Job creation</h2>
        <div class="form-group">
	        <label class="control-label" for="input_dataset_licence">Select Task type</label>
		      <select id="selectTaskType" class="form-control">
		        <?php foreach( $this->task_types as $tt ): ?>
            <option name="<?php echo $tt->ttid; ?>"><?php echo $tt->name; ?></option>
            <?php endforeach; ?>
		      </select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <form action="" method="post">
            <div class="form-group">
                <label class="control-label" for="NumberOfInstances">Number of instances</label>
                <input type="text" class="form-control" id="NumberOfInstances" name="NumberOfInstances" placeholder="100..200, 500, >10000" value="<?php if($this->input->post('NumberOfInstances')){ echo $this->input->post('NumberOfInstances');}?>" />
            </div>
            <div class="form-group">
                <label class="control-label" for="NumberOfFeatures">Number of features</label>
                <input type="text" class="form-control" id="NumberOfFeatures" name="NumberOfFeatures" placeholder="10..20, 50, >100" value="<?php if($this->input->post('NumberOfFeatures')){ echo $this->input->post('NumberOfFeatures');}?>" />
            </div>
            <div class="form-group">
                <label class="control-label" for="NumberOfMissingValues">Number of missing values</label>
                <input type="text" class="form-control" id="NumberOfMissingValues" name="NumberOfMissingValues" placeholder="100..200, 500, >10000" value="<?php if($this->input->post('NumberOfMissingValues')){ echo $this->input->post('NumberOfMissingValues');}?>" />
            </div>
            <div class="form-group">
                <label class="control-label" for="NumberOfClasses">Number of classes</label>
                <input type="text" class="form-control" id="NumberOfClasses" name="NumberOfClasses" placeholder="2, 0..10, >10" value="<?php if($this->input->post('NumberOfClasses')){ echo $this->input->post('NumberOfClasses');}?>" />
            </div>
            <div class="form-group">
              <label class="control-label" for="Workbench">Workbench</label>
              <input type="text" class="form-control" id="Workbench" name="Workbench" placeholder="Weka_3.7.10, Moa_2014.03" value="<?php if($this->input->post('Workbench')){ echo $this->input->post('Workbench');}?>" />
            </div>
            <div class="form-group">
               <input type="checkbox" name="DefaultOnly" value="true" <?php if($this->input->post('DefaultOnly') == 'true' ){ echo 'checked';}?> />&nbsp;Default parameter settings only
            </div>
            <button class="btn btn-default btn-small" name="filter" value="true" style="width:100%; margin-top:10px;">Filter</button>
          </form>
        </div>
        <div class="col-md-9">
        
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
                  <div class="container-fluid">
                    <div class="row">
                    <?php if( $tt->tasks ): foreach( $tt->tasks as $task ): $t = 'Task ' . $task->task_id . ' - ' . $this->datasets[$task->source_data]; ?>
                      <div class="col-md-4"><input type="checkbox" class="check_tasks" name="tasks[]" value="<?php echo htmlspecialchars( $task->task_id ); ?>" <?php if( in_array( $task->task_id, $this->active_tasks ) ) echo 'checked'; ?>/>
                        &nbsp;<?php echo cutoff( $t, 25); ?></div>
                    <?php endforeach; ?>
                      <div class="col-md-4"><input type="checkbox" onclick="$('.check_tasks').prop('checked', this.checked);" /><b>&nbsp;Select all. </b></div>           
                    <?php else: ?>
                      <div class="col-md-4">No tasks.</div> 
                    <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Select Algorithms</label>
                  <div class="container-fluid">
                    <div class="row">
                    <?php if( $this->setups ): foreach( $this->setups as $setup ): $alg = $setup->name . '(' . $setup->version . ')';?>
                      <div class="col-md-4">
                        <div data-toggle="tooltip" data-placement="right" title="<?php echo htmlspecialchars( $setup->setup_string ); ?>">
                          <input type="checkbox" class="check_setups" name="setups[]" value="<?php echo $setup->sid; ?>" <?php if( in_array( $setup->sid, $this->active_setups ) ) echo 'checked'; ?> />&nbsp;<?php echo cutoff( $alg, 25); ?>
                        </div>
                      </div>
                    <?php endforeach; ?>
                      <div class="col-md-4"><input type="checkbox" onclick="$('.check_setups').prop('checked', this.checked);" /><b>&nbsp;Select all. </b></div>  
                    <?php else: ?>
                      <div class="col-md-4">No setups.</div> 
                    <?php endif; ?>
                    </div>
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
  </div>
</div>
