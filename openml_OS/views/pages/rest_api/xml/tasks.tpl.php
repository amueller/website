<oml:tasks xmlns:oml="http://openml.org/openml">
	<?php foreach( $tasks as $task ): ?>
  <oml:task>
    <oml:task_id><?php echo $task->task_id; ?></oml:task_id>
    <oml:task_type><?php echo $task->name; ?></oml:task_type>
    <oml:did><?php echo $task->did; ?></oml:did>
    <oml:name><?php echo $task->name; ?></oml:name>
    <oml:status><?php echo $task->status; ?></oml:status>
    <?php foreach( $task->qualities as $quality => $value ): ?>
    <oml:quality name="<?php echo $quality; ?>"><?php echo $value; ?></oml:quality>
    <?php endforeach; ?>
  </oml:task>
	<?php endforeach; ?>
</oml:tasks>
