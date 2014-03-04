<oml:task_results xmlns:oml="http://openml.org/openml">
	<oml:task_id><?php echo $task->id; ?></oml:task_id>
	<oml:task_name><?php echo $task->name; ?></oml:task_name>
	<oml:task_type_id><?php echo $task->ttid; ?></oml:task_type_id>
	<oml:input_data><?php echo $task->did; ?></oml:input_data>
	<oml:estimation_procedure><?php echo $estimation_procedure->name; ?></oml:estimation_procedure>
  <?php if( is_array($results) && $results ): ?>
	<oml:evaluations>
		<?php foreach( $results as $rid => $metrics ): ?>
		<oml:run>
			<oml:run_id><?php echo $rid; ?></oml:run_id>
			<oml:implementation_id><?php echo $implementation_ids[$rid]; ?></oml:implementation_id>
			<oml:implementation><?php echo $implementations[$rid]; ?></oml:implementation>
			<?php foreach( $metrics as $name => $value ): ?>
			<oml:measure name="<?php echo $name;?>"><?php echo $value;?></oml:measure>
			<?php endforeach; ?>
		</oml:run>
		<?php endforeach; ?>
	</oml:evaluations>
  <?php endif; ?>
</oml:task_results>
