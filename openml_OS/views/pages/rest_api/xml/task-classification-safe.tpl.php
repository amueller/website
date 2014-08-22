<oml:task-classification-safe xmlns:oml="http://openml.org/openml">
  <?php foreach( $tasks as $t ): ?>
  <oml:task>
	<oml:task_id><?php echo $t->task_id; ?></oml:task_id>
	<oml:data_name><?php echo $t->name; ?></oml:data_name>
	<oml:data_version><?php echo $t->version; ?></oml:data_version>
	<oml:estimation_procedure><?php echo $t->pname; ?></oml:estimation_procedure>
  </oml:task>
  <?php endforeach; ?>
</oml:task-classification-safe>
