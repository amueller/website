<?php
  $p = array();
  $p['index'] = 'openml';
  $p['type'] = 'task_type';
?>

<li>
  <input type="text" class="form-control floating-label" id="task_id" name="task_id"
   data-hint="The ID of the task"
   value="<?php if(array_key_exists('task_id',$this->filters)){ echo $this->filters['task_id'];}?>"
   placeholder="Task ID">
</li>
<li>
    <select class="form-control input-small selectpicker" name="tasktype" id="tasktype.tt_id">
       <option value="">Task type &#x25BE;</option>
	    <?php
	      $p['body']['query']['match_all'] = array();
        $results = $this->searchclient->search($p);
	      $alltasks = $results['hits']['hits'];
	      foreach($alltasks as $h){?>
	            <option value="<?php echo $h['_id']; ?>" <?php if(array_key_exists('tasktype.tt_id',$this->filters) and $this->filters['tasktype.tt_id'] == $h['_id']){ echo 'selected';}?>><?php echo $h['_source']['name']; ?></option>
	      <?php } ?>
     </select>
 </li>

   <?php
  	  if(array_key_exists('tasktype.tt_id',$this->filters)){
        $p['id'] = $this->filters['tasktype.tt_id'];
        unset($p['body']);
        $inputs = $this->searchclient->get($p)['_source']['input'];
  		  foreach($inputs as $v){
  		  if($v['io'] == 'input' and $v['requirement'] != 'hidden'){
   ?>
   <li>
      <?php
      if($v['name'] == 'estimation_procedure'){?>
        <select class="form-control input-small selectpicker" name="tasktype" id="estimation_procedure.proc_id">
           <option value="">Estimation procedure &#x25BE;</option>
          <?php
            unset($p['id']);
            $p['type'] = 'measure';
            $p['body']['query']['bool']['must'] = array(
                array('match' => array('type' => 'estimation_procedure')),
                array('match' => array('task_type' => $this->filters['tasktype.tt_id'])),
            );
            print_r($p);
            $results = $this->searchclient->search($p);
            $alltasks = $results['hits']['hits'];
            foreach($alltasks as $h){?>
                  <option value="<?php echo $h['_source']['proc_id']; ?>" <?php if(array_key_exists('estimation_procedure.proc_id',$this->filters) and $this->filters['estimation_procedure.proc_id'] == $h['_source']['proc_id']){ echo 'selected';}?>><?php echo $h['_source']['name']; ?></option>
            <?php } ?>
         </select>
      <?php } else { ?>
      <input type="text" class="form-control floating-label" id="<?php echo $v['name']; ?>" name="<?php echo $v['name']; ?>" data-hint="<?php echo $v['description'];?>"
       value="<?php if(array_key_exists($v['name'],$this->filters)){ echo $this->filters[$v['name']];}?>" placeholder="<?php echo ucfirst(str_replace('_',' ',$v['name'])); ?>">
      <?php } ?>
   </li>
   <?php
       }}}
  	?>
<!-- end filters -->
