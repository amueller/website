<div class="row openmlsectioninfo">
	<div class="col-sm-12">
		<h1><a href="t"><i class="fa fa-trophy"></i></a> Task <?php echo $this->task_id; ?></h1>
		<?php if (isset($this->record['task_id'])){ ?>		
		<a href="api/?f=openml.task.search&task_id=<?php echo $this->task_id;?>">View XML</a>

		<h2><?php echo $this->record['type_name'] ?></h2>
		<p><?php echo $this->record['type_description'] ?></p>

		<h3>Given inputs</h3>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'input') continue; ?>
		<tr><td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $r['description']; ?>"><?php echo $r['name']; ?></td>
		<td><?php if($r['type'] == 'Dataset') 
				{ echo '<a href="d/' . $r['value']. '">' . $r['value'] . ' - ' . $r['dataset'] . '</a>';}
			elseif($r['type'] == 'EstimationProcedure') 
				{ echo '<a href="a/evalproc/' . $r['value']. '">' . $r['value'] . ' - ' . $r['evalproc'] . '</a>';}
			elseif(strpos($r['value'], "http") === 0 ) 
				{ echo '<a href="' .$r['value']. '">' . $r['value'] . '</a>';}
			else { echo $r['value']; } ?></td>
		<td><a class="pop" data-html="true" data-toggle="popover" data-placement="left" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a> (<?php echo $r['requirement']; ?>)</td>
		</tr>
		<?php endforeach; ?>
		</table></div>

		<h3>Required outputs</h3>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'output' || $r['requirement'] == 'hidden') continue; ?>
		<tr><td><?php echo $r['name']; ?></td>
		<td><?php echo $r['description']; ?></td>
		<td><a class="pop" data-html="true" data-toggle="popover" data-placement="left" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a> (<?php echo $r['requirement']; ?>)</td>
		</tr>
		<?php endforeach; ?>
		</table></div>

		<h3>Runs</h3>
		<h4><?php echo $this->record['runcount']; ?> completed runs</h4>	
		<?php if(isset($this->sourcedata_id)) { ?>
		See results for <a href="d/<?php echo $this->sourcedata_id; ?>"><?php echo $this->sourcedata_name; ?></a>
		<?php } ?>		

		<h4>Run details</h4>		
		<?php 
			$prefix = '';
			foreach( explode(',', $this->record['runs']) as $r): echo $prefix; ?>
			<a href="r/<?php echo $r; ?>"><?php echo $r; ?></a> 
		<?php	$prefix = ', ';
			endforeach; ?>
		<?php } else { ?>Sorry, this task is unknown.<?php } ?>		
	</div> <!-- end col-md-12 -->

</div> <!-- end openmlsectioninfo -->
