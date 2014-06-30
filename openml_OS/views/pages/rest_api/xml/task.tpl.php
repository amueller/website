<oml:task xmlns:oml="http://openml.org/openml">
	<oml:task_id><?php echo $task->task_id;?></oml:task_id>
	<oml:task_type><?php echo $task_type->name;?></oml:task_type>
	<?php foreach( $parsed_io as $key => $item ): ?>
  <oml:input name="<?php echo $key; ?>">
		<?php echo $item; ?>
  </oml:input>
	<?php endforeach; ?>
</oml:task>
