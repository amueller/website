<oml:job xmlns:oml="http://openml.org/openml">
  <?php if( $source != false ): ?>
    <oml:learner><?php echo $source->learner; ?></oml:learner>
    <oml:task_id><?php echo $source->task_id; ?></oml:task_id>
  <?php endif; ?>
</oml:job>