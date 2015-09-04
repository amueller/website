<oml:tasks xmlns:oml="http://openml.org/openml">
  <?php foreach( $tasks as $task ): ?>
  <oml:task>
    <oml:task_id><?php echo $task->task_id; ?></oml:task_id>
    <oml:task_type><?php echo $task->name; ?></oml:task_type>
    <oml:did><?php echo $task->did; ?></oml:did>
    <oml:name><?php echo $task->dataset_name; ?></oml:name>
    <oml:status><?php echo $task->status; ?></oml:status>
    <?php if( property_exists( $task, 'inputs' ) ): foreach( $task->inputs as $input => $value ): ?>
      <oml:input name="<?php echo $input; ?>"><?php echo $value; ?></oml:input>
    <?php endforeach; endif; ?>
    <?php if( property_exists( $task, 'qualities' ) ): foreach( $task->qualities as $quality => $value ): ?>
      <oml:quality name="<?php echo $quality; ?>"><?php echo $value; ?></oml:quality>
    <?php endforeach; endif; ?>
    <?php if( property_exists( $task, 'tags' ) ): foreach( $task->tags as $tag ): ?>
      <oml:tag><?php echo $tag; ?></oml:tag>
    <?php endforeach; endif; ?>
  </oml:task>
  <?php endforeach; ?>
</oml:tasks>
