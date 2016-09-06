{"data":{"dataset":[
  <?php $first = TRUE;
        foreach( $datasets as $data ):
          ($first ? $first = FALSE : echo ","); ?>
  {"did":<?php echo $data->did; ?>,
   "name":<?php echo $data->name; ?>,
   "version":<?php echo $data->version; ?>,
   "status":<?php echo $data->status; ?>,
   "format":<?php echo $data->format; ?>,
   "jsonSpecific": "true",
   "quality":[
    <?php $firstq = TRUE;
          foreach( $data->qualities as $quality => $value ):
            ($firstq ? $firstq = FALSE : echo ","); ?>
    {"name":<?php echo $quality; ?>,
     "value":<?php echo $value; ?>
    }
    <?php endforeach; ?>
    ]
  }
  <?php endforeach; ?>
  ]}
}
