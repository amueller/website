<script>
$(function() {

 $("#source_data").autocomplete({
  html: true,
  minLength: 0,
  source: function(request, fresponse) {
    client.suggest({
    index: 'openml',
    type: 'data',
    body: {
     mysuggester: {
      text: request.term,
      completion: {
       field: 'suggest',
       fuzzy : true,
       size: 10
      }
     }
    }
   }, function (error, response) {
       fresponse($.map(response['mysuggester'][0]['options'], function(item) {
        if(item['payload']['type'] == 'data')
	return { 
		type: item['payload']['type'], 
		id: item['payload']['data_id'], 
		description: item['payload']['description'].substring(0,50), 
		text: item['text'] 
		};
	}));
   });
  },
  select: function( event, ui ) {$('#source_data').val(ui.item.id).trigger('change');}

}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( '<a><i class="' + icons[item.type] + '"></i> ' + item.text + ' <span>' + item.description + '</span></a>' )
        .appendTo( ul );
    }
});
</script>


<div id="filters" class="panel-collapse">
  <div class="form-group">
      <label class="control-label" for="task_id">Task id</label>
      <input type="text" class="form-control" id="task_id" name="task_id" placeholder="1, 100..200, <1000" value="<?php if(array_key_exists('task_id',$this->filters)){ echo $this->filters['task_id'];}?>" />
  </div>
        <div class="form-group">
	  <label class="control-label" for="ttselect">Task type</label>
          <select class="form-control input-small selectpicker" name="tasktype" id="tasktype.tt_id">
            <option value="">Any task type</option>
	    <?php
	      $taskparams['index'] = 'openml';
	      $taskparams['type']  = 'task_type';
	      $taskparams['body']['query']['match_all'] = array();
        $searchclient = $this->searchclient->search($taskparams);
	      $alltasks = $searchclient['hits']['hits'];

	      $dataparams['index'] = 'openml';
	      $dataparams['type']  = 'data';
	      $dataparams['body']['fields'] = ['id','name','version'];
	      $dataparams['body']['query']['match_all'] = array();
	      echo print_r($dataparams['body']);
        $searchclient = $this->searchclient->search($dataparams);      
	      $alldataresults = $searchclient['hits']['hits'];
	      $alldata = array();
	      foreach($alldataresults as $k => $v){
		$alldata[] = $v['fields']['name'].' ('.$v['fields']['version'].')';
	      }
	      $evalprocs['index'] = 'openml';
	      $evalprocs['type'] = 'measure';

	      $evalprocs['body']['query']['bool']['must'][]['match']['type'] = 'estimation_procedure';
	      if(array_key_exists('tasktype.tt_id',$this->filters)) 
		$evalprocs['body']['query']['bool']['must'][]['match']['task_type'] = $this->filters['tasktype.tt_id'];
        $searchclient = $this->searchclient->search($evalprocs);
	      $allevalprocs = $searchclient['hits']['hits'];
	      foreach($alltasks as $h){?>
	            <option value="<?php echo $h['_id']; ?>" <?php if(array_key_exists('tasktype.tt_id',$this->filters) and $h['_id'] == $this->filters['tasktype.tt_id']) echo 'selected'; ?>><?php echo $h['_source']['name']; ?></option>
	    <?php } ?>
          </select>
        </div>
	 <?php 
	  $prev_inputs = array();
	  foreach($alltasks as $h){
	     if(!array_key_exists('tasktype.tt_id',$this->filters) or $this->filters['tasktype.tt_id'] == $h['_id']){
		foreach($h['_source']['input'] as $k => $v){
		   if($v['io'] == 'input' and $v['requirement'] != 'hidden'){
			if(!in_array($k,$prev_inputs)){?>
	                  <div class="form-group">
      			    <label class="control-label" for="<?php echo $k; ?>"><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $v['description']; ?>"><?php echo $k; ?></a></label>
			    <?php if($v['type'] == 'Estimation Procedure') {?>
				<select class="form-control input-small selectpicker" name="estimation_procedure.proc_id" id="estimation_procedure.proc_id">
            			<option value="">Any procedure</option>
				<?php foreach($allevalprocs as $e){?>
		            		<option value="<?php echo $e['_id']; ?>" <?php if(array_key_exists('estimation_procedure.proc_id',$this->filters) and $e['_id'] == $this->filters['estimation_procedure.proc_id']) echo 'selected'; ?>><?php echo $e['_source']['name']; ?></option>
	    			<?php } ?>
				</select>
			    <?php } else { ?>
			    <input type="text" class="form-control" id="<?php echo $k; ?>" name="<?php echo $k; ?>" placeholder="" value="<?php if(array_key_exists($k,$this->filters)){ echo $this->filters[$k]; } elseif(array_key_exists($k.'.data_id',$this->filters)){ echo $this->filters[$k.'.data_id'];}?>" />
			    <?php } ?>
			  </div>
 	  <?php
			  $prev_inputs[] = $k;
			}
		   }
		}}
	  }
	?>
<button class="btn btn-default btn-small" style="width:100%; margin-top:10px;" id="research">Search</button>
</div> <!-- end filters -->

