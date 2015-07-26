<?php
  $p = array();
  $p['index'] = 'openml';
  $p['type'] = 'measure';
?>

<li>
    <select class="form-control input-small selectpicker" name="tasktype" id="type">
       <option value="">Measure type</option>
	    <?php
        $p['body']['size'] = 0;
	      $p['body']['query']['match_all'] = array();
  	    $p['body']['aggs']['type']['terms']['field'] = "type";
        $results = $this->searchclient->search($p);
	      $measuretypes = $results['aggregations']['type']['buckets'];
	      foreach($measuretypes as $t){?>
	            <option value="<?php echo $t['key']; ?>" <?php if(array_key_exists('type',$this->filters) and $this->filters['type'] == $t['key']){ echo 'selected';}?>><?php echo $t['key']; ?></option>
	      <?php } ?>
     </select>
 </li>
