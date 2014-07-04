<div id="filters" class="panel-collapse <?php if(strpos($this->terms,':') === false) echo 'collapse'; ?>">
  <div class="form-group">
      <label class="control-label" for="run_id">Run id</label>
      <input type="text" class="form-control" id="run_id" name="run_id" placeholder="1, 100..200, <1000" value="<?php if(array_key_exists('run_id',$this->filters)){ echo $this->filters['run_id'];}?>" />
  </div>

  <div class="form-group">
      <label class="control-label" for="run_task.task_id">Task id</label>
      <input type="text" class="form-control" id="run_task.task_id" name="run_task.task_id" placeholder="1, 100..200, <1000" value="<?php if(array_key_exists('run_task.task_id',$this->filters)){ echo $this->filters['run_task.task_id'];}?>" />
  </div>



</div> <!-- end filters -->

