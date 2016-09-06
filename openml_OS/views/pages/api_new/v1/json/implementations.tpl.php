{"flows":{"flow":[
  <?php $first = TRUE;
        foreach( $implementations as $i ):
          echo ($first ? "" : ",");
          $first = FALSE; ?>
  {"id":<?php echo $i->id; ?>,
   "full_name":<?php echo $i->fullName; ?>,
   "name":<?php echo $i->name; ?>,
   "version":<?php echo $i->version; ?>,
   "external_version":<?php echo $i->external_version; ?>,
   "uploader":<?php echo $i->uploader; ?>
  }
  <?php endforeach; ?>
  ]}
}
