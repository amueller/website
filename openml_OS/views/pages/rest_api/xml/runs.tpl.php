<oml:runs xmlns:oml="http://openml.org/openml">
	<?php foreach( $runs as $r ): ?>
  <oml:run>
    <oml:run_id><?php echo $r->rid; ?></oml:run_id>
    <oml:task_id><?php echo $r->task_id; ?></oml:task_id>
    <oml:setup_id><?php echo $r->setup; ?></oml:setup_id>
    <oml:implementation_id><?php echo $r->implementation_id; ?></oml:implementation_id>
  </oml:run>
  <?php endforeach; ?>
</oml:runs>
