<?php
  $p = array();
  $p['index'] = 'openml';
  $p['type'] = 'measure';
  $fs = array('NumberOfInstances' => 'Number of instances','NumberOfFeatures' => 'Number of features','NumberOfMissingValues' => 'Number of missing values','NumberOfClasses' => 'Number of classes','DefaultAccuracy' => 'Default accuracy');
  foreach($fs as $f => $v){
?>
  <li>
      <input type="text" class="form-control floating-label" id="<?php echo $f; ?>" name="<?php echo $f; ?>" data-hint="<?php $p['id'] = $f; echo $this->searchclient->get($p)['_source']['description'];?>"
       value="<?php if(array_key_exists($f,$this->filters)){ echo $this->filters[$f];}?>" placeholder="<?php echo $v; ?>">
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
