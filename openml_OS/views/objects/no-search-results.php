<div class="noresult">
	<i class="fa fa-search fa-2x "></i><br><br> 
	We could not find any <?php if($this->filtertype) {echo '<b>' . str_replace('_',' ',$this->filtertype) . 's</b>';} else {echo 'resources';} ?> matching your query.<br /><br /><br /> 

	<i class="fa fa-heart" style="color: #d9534f;"></i><br>Start something great, 

	<?php if($this->filtertype and $this->filtertype!='user'){
		echo '<a href="new/'. str_replace('_','',$this->filtertype) . '">';
		if($this->filtertype == 'data')
			echo 'upload new data</a>'; 
		else if($this->filtertype == 'flow' or $this->filtertype == 'measure')
			echo 'upload new flows</a>';
		else if($this->filtertype == 'run')
			echo 'submit new runs</a>';    
		else if($this->filtertype == 'task')
			echo 'create new tasks</a>'; 
		else if($this->filtertype == 'task_type')
			echo 'create new task types</a>'; 
		else if($this->filtertype == 'task_type')
			echo 'create new task types</a>';
		}
		else if($this->filtertype=='user')
			echo 'invite people to join OpenML.';
		else
			echo 'upload new <a href="new/data">data</a>, <a href="new/flow">flows</a>, <a href="new/run">runs</a>, <a href="new/task">tasks</a> or <a href="new/tasktype">task types</a>.'; 
	?>
</div>
