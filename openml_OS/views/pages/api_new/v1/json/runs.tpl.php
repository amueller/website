{"runs":{"run":[
  <?php $first = TRUE;
        foreach( $runs as $r ):
          echo ($first ? "" : ",");
          $first = FALSE; ?>
  {"run_id":<?php echo $r->rid; ?>,
   "task_id":<?php echo $r->task_id; ?>,
   "setup_id":<?php echo  $r->setup; ?>,
   "flow_id":<?php echo $r->flow_id; ?>,
   "uploader":<?php echo $r->uploader; ?>,
   "error_message":"<?php echo $r->error_message; ?>"
	 <?php if( property_exists( $r, 'tags' ) ): ?>
	 ,"tags": [
		 <?php $first_t = TRUE;
					 foreach( $r->tags as $tag ):
					 echo ($first_t ? "" : ",");
					 $first_t = FALSE; ?>
		 "<?php echo $tag;?>"
	 <?php endforeach; ?>
	 ]
 	 <?php endif; ?>
  }
  <?php endforeach; ?>
  ]}
}
