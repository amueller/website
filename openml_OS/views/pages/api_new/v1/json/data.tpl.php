{"data":{"dataset":[
  <?php $first = true;
        foreach ($datasets as $data):
          echo ($first ? "" : ",");
          $first = false; ?>
  {"did":<?php echo $data->did; ?>,
   "name":"<?php echo $data->name; ?>",
   "version":<?php echo $data->version; ?>,
   "status":"<?php echo $data->status; ?>",
   "format":"<?php echo $data->format; ?>",
   "quality":[
    <?php $firstq = TRUE;
          foreach( $data->qualities as $quality => $value ):
            echo ($firstq ? "" : ",");
            $firstq = FALSE; ?>
    {"name":"<?php echo $quality; ?>",
     "value":"<?php echo $value; ?>"
    }
    <?php endforeach; ?>
    ],
    "tags":[
     <?php $firstt = TRUE;
           foreach( $data->tags as $tag ):
             echo ($firstt ? "" : ",");
             $firstt = FALSE;
             echo '"'.$tag.'"';
           endforeach; ?>
     ]
  }
  <?php endforeach; ?>
  ]}
}
