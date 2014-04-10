<div class="row openmlsectioninfo">
	<div class="col-sm-12">
		<h1>Run <?php echo $this->run_id ?></h1>
		<?php if (isset($this->record['run_id'])){ ?>
		<a href="http://openml.liacs.nl/api/?f=openml.run.get&run_id=<?php echo $this->run_id;?>">View XML</a>

	</div>
	<div class="col-sm-6">

		<h2>Task</h2>
		<div class='table-responsive'><table class='table table-striped'>
		<tr><td>Task</td><td><a href="t/<?php echo $this->record['task_id']; ?>">Task <?php echo $this->record['task_id']; ?> (<?php echo $this->record['task_name']; ?>)</a></td></tr>
		<tr><td>Input data</td><td><a href="d/<?php echo $this->record['data_id']; ?>"><?php echo $this->record['data_name']; ?> (<?php echo $this->record['data_version']; ?>)</a></td></tr>
		</table></div>
	</div>
	<div class="col-sm-6">

		<h2>Run Details</h2>
		<div class='table-responsive'><table class='table table-striped'>
		<tr><td>Uploader</td><td><?php echo $this->record['uploader']; ?></td></tr>
		<tr><td>Start time</td><td><?php echo $this->record['start_time']; ?></td></tr>
		<tr><td>Status</td><td><?php echo $this->record['status']; ?></td></tr>
		</table></div>

	</div>

	<div class="col-sm-12">

		<h3>Flow</h3>
		<div class='table-responsive'><table class='table table-striped'>
		<tr><td><a href="f/<?php echo $this->record['flow_id']; ?>"><?php echo $this->record['flow_name']; ?></a></td><td><?php echo $this->record['flow_description']; ?></td></tr>
		<?php foreach( $this->runsetup as $r ): ?>
		<tr><td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $r['description']; ?>"><?php echo $r['input']; ?></td><td><?php echo $r['value']; ?></td></tr>
		<?php endforeach; ?>
		</table></div>

	</div>
	<div class="col-sm-12">

		<h3>Evaluations</h3>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( (array)$this->runevaluations as $r ): ?>
		<tr><td><?php echo $r['function']; ?></td><td><?php echo $r['value']; if(isset($r['stdev'])) echo ' &plusmn; '. $r['stdev']; ?></td>
		<td><?php echo $r['array_data']; ?></td>
		<?php endforeach; ?>
		</table></div>
		<?php } else { ?>Sorry, this run is unknown.<?php } ?>
	</div>

</div> <!-- end openmlsectioninfo -->
