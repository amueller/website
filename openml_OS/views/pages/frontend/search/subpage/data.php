<div id="filters" class="panel-collapse <?php if(strpos($this->terms,':') === false) echo 'collapse'; ?>">
  <div class="form-group">
      <label class="control-label" for="NumberOfInstances">Number of instances</label>
      <input type="text" class="form-control" id="NumberOfInstances" name="NumberOfInstances" placeholder="100..200, 500, >10000" value="<?php if(array_key_exists('NumberOfInstances',$this->filters)){ echo $this->filters['NumberOfInstances'];}?>" />
  </div>
  <div class="form-group">
      <label class="control-label" for="NumberOfFeatures">Number of features</label>
      <input type="text" class="form-control" id="NumberOfFeatures" name="NumberOfFeatures" placeholder="10..20, 50, >100" value="<?php if(array_key_exists('NumberOfFeatures',$this->filters)){ echo $this->filters['NumberOfFeatures'];}?>" />
  </div>
  <div class="form-group">
      <label class="control-label" for="NumberOfMissingValues">Number of missing values</label>
      <input type="text" class="form-control" id="NumberOfMissingValues" name="NumberOfMissingValues" placeholder="100..200, 500, >10000" value="<?php if(array_key_exists('NumberOfMissingValues',$this->filters)){ echo $this->filters['NumberOfMissingValues'];}?>" />
  </div>
  <div class="form-group">
      <label class="control-label" for="NumberOfClasses">Number of classes</label>
      <input type="text" class="form-control" id="NumberOfClasses" name="NumberOfClasses" placeholder="2, 0..10, >10" value="<?php if(array_key_exists('NumberOfClasses',$this->filters)){ echo $this->filters['NumberOfClasses'];}?>" />
  </div>
  <button class="btn btn-default btn-small" style="width:100%; margin-top:10px;" id="research">Search</button>
</div> <!-- end filters -->

