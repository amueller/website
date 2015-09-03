<oml:runs xmlns:oml="http://openml.org/openml">
	<?php foreach( $runs as $r ): ?>
  <oml:run>
    <oml:run_id><?php echo $r->rid; ?></oml:run_id>
    <oml:task_id><?php echo $r->task_id; ?></oml:task_id>
    <oml:setup_id><?php echo $r->setup; ?></oml:setup_id>
    <oml:flow_id><?php echo $r->implementation_id; ?></oml:flow_id>
    <oml:uploader><?php echo $r->uploader; ?></oml:uploader>
    <oml:error_message><?php echo $r->error; ?></oml:error_message>
  </oml:run>
  <?php endforeach; ?>
</oml:runs>
