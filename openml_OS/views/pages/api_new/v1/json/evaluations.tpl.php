{"evaluations":{"evaluation":[
  <?php $first = TRUE;
        foreach( $datasets as $data ):
          echo ($first ? "" : ",");
          $first = FALSE; ?>
  {"run_id":<?php echo $e->rid; ?>,
   "task_id":<?php echo $e->task_id; ?>,
   "setup_id":<?php echo $e->sid; ?>,
   "flow_id":<?php echo $e->implementation_id; ?>,
   "array_data":<?php echo $e->{'function'}; ?>,
   <?php if($e->value != null): ?>"value":<?php echo $e->value; ?>,<?php endif; ?>
   <?php if($e->array_data != null): ?>"array_data":<?php echo $e->array_data; ?><?php endif; ?>
  }
  <?php endforeach; ?>
  ]}
}
