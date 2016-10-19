<oml:study xmlns:oml="http://openml.org/openml">
  <oml:id><?php echo $study->id; ?></oml:id>
  <oml:name><?php echo $study->name; ?></oml:name>
  <oml:description><?php echo $study->description; ?></oml:description>
  <oml:creation_date><?php echo $study->created; ?></oml:creation_date>
  <oml:creator><?php echo $study->creator; ?></oml:creator>
  <?php foreach($tags as $tag): ?>
  <oml:tag>
    <oml:name><?php echo $tag->tag; ?></oml:name>
    <?php if ($tag->window_start != null): ?>
    <oml:window_start><?php echo $tag->window_start; ?></oml:window_start> <!-- only entities tagged after this moment will be included in the study -->
    <?php endif; ?>
    <?php if ($tag->window_end != null): ?>
    <oml:window_end><?php echo $tag->window_end; ?></oml:window_end> <!-- only entities tagged before this moment will be included in the study -->
    <?php endif; ?>
    <oml:write_access><?php echo $tag->write_access; ?></oml:write_access>
  </oml:tag>
  <?php endforeach; ?>
  
  <?php if (is_array($data)):?>
  <oml:data>
    <?php foreach($data as $data_id): ?>
    <oml:data_id><?php echo $data_id; ?></oml:data_id>
    <?php endforeach;?>
  </oml:data>
  
  <?php if (is_array($tasks)):?>
  <oml:tasks>
    <?php foreach($task as $task_id): ?>
    <oml:task_id><?php echo $task_id; ?></oml:task_id>
    <?php endforeach;?>
  </oml:tasks>
  
</oml:study>
