{"tasks":{"task":[
  <?php $first = TRUE;
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
    <?php if( property_exists( $task, 'inputs' ) ): ?>
    ,"input": [
      <?php $first_in = TRUE;
            foreach( $task->inputs as $input => $value ):
            echo ($first_in ? "" : ",");
            $first_in = FALSE; ?>
      {"name":"<?php echo $input; ?>",
       "value":"<?php echo $value; ?>"}
    <?php endforeach; endif; ?>
    ]
    <?php if( property_exists( $task, 'qualities' ) ): ?>
    ,"quality": [
      <?php $first_q = TRUE;
            foreach( $task->qualities as $quality => $value ):
            echo ($first_q ? "" : ",");
            $first_q = FALSE; ?>
      {"name":"<?php echo $quality; ?>",
       "value":<?php echo $value; ?>}
    <?php endforeach; endif; ?>
    ]
    <?php if( property_exists( $task, 'tags' ) ): ?>
    ,"tags": [
      <?php $first_t = TRUE;
            foreach( $task->tags as $tag ):
            echo ($first_t ? "" : ",");
            $first_t = FALSE; ?>
      "<?php echo $tag;?>"
    <?php endforeach; endif; ?>
    ]
  }
<?php endforeach; ?>
  ]}
}
