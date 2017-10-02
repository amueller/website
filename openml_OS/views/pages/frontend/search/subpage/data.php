<?php
  $p = array();
  $p['index'] = 'openml';
  $p['type'] = 'measure';
  $fs = array('NumberOfInstances' => 'Number of instances','NumberOfFeatures' => 'Number of features','NumberOfMissingValues' => 'Number of missing values','NumberOfClasses' => 'Number of classes','DefaultAccuracy' => 'Default accuracy');
  foreach($fs as $f => $v){
?>
  <li>
      <input type="text" class="form-control floating-label" id="qualities.<?php echo $f; ?>" name="qualities.<?php echo $f; ?>" data-hint="<?php $p['id'] = $f; echo $this->searchclient->get($p)['_source']['description'];?>"
       value="<?php if(array_key_exists("qualities.".$f,$this->filters)){ echo $this->filters["qualities.".$f];}?>" placeholder="<?php echo $v; ?>">
  </li>
<?php } ?>
<li>
    <input type="text" class="form-control floating-label" id="uploader" name="uploader" data-hint="The person who uploaded the dataset"
     value="<?php if(array_key_exists('uploader',$this->filters)){ echo $this->filters['uploader'];}?>" placeholder="Uploader">
</li>
<li>
    <input type="text" class="form-control floating-label" id="tags.tag" name="tags.tag" data-hint="A tag that has been added to this dataset"
     value="<?php if(array_key_exists('tags.tag',$this->filters)){ echo $this->filters['tags.tag'];}?>" placeholder="Tag">
</li>
<li>
    <input type="text" class="form-control floating-label" id="status" name="status" data-hint="Dataset status (active, in_preparation, deactivated,...)"
     value="<?php echo (array_key_exists('status',$this->filters) ? $this->filters['status'] : 'active')?>" placeholder="Status">
</li>
