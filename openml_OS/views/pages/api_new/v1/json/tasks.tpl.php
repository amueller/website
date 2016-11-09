{"tasks":{"task":[
  <?php $first = TRUE;
        if($tasks):
        foreach( $tasks as $task ):
          echo ($first ? "" : ",");
          $first = FALSE; ?>
  { "task_id":<?php echo $task->task_id; ?>,
    "task_type_id":<?php echo $task->ttid; ?>,
    "task_type":"<?php echo $task->name; ?>",
    "did":<?php echo $task->did; ?>,
    "name":"<?php echo $task->dataset_name; ?>",
    "status":"<?php echo $task->status; ?>",
    "format":"<?php echo $task->format; ?>"
    <?php if ($task->task_inputs): ?>
    ,"input": [
      <?php $task_inputs = str_getcsv($task->task_inputs);
            $input_values = str_getcsv($task->input_values);
            for ($i = 0; $i < count($task_inputs); ++$i):
              echo ($i == 0 ? "" : ","); ?>
      {"name":"<?php echo $task_inputs[$i]; ?>",
       "value":"<?php echo $input_values[$i]; ?>"}
    <?php endfor; ?>]
    <?php endif; ?>
    <?php  if ($task->qualities): ?>
    ,"quality": [
      <?php $qualities = str_getcsv($task->qualities);
            $values = str_getcsv($task->quality_values);
            for ($i = 0; $i < count($qualities); ++$i):
              echo ($i == 0 ? "" : ","); ?>
      {"name":"<?php echo $qualities[$i]; ?>",
       "value":"<?php echo $values[$i]; ?>"}
    <?php endfor; ?>]
    <?php endif; ?>
    <?php if( property_exists( $task, 'tags' ) ): ?>
    ,"tags": [
      <?php $first_t = TRUE;
            foreach( str_getcsv($task->tags) as $tag ):
            echo ($first_t ? "" : ",");
            $first_t = FALSE; ?>
      "<?php echo $tag;?>"
    <?php endforeach; ?>
    ]
    <?php endif; ?>
  }
<?php endforeach; endif; ?>
  ]}
}
