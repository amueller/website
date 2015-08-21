
  $(document).ready(function () {

// Update search query upon user actions
function updateQuery(type)
{
  var constr = '';
  if(type == 'source_data.name')
    constr = $("#"+type.replace('.name','')).val().replace(" ","_");
  else if(type == 'run_task.tasktype.tt_id')
    constr = $("#run_task\\.tasktype\\.tt_id").val();
  else
    constr = $("#"+type.replace('.','\\.')).val().replace(" ","_");
  var query = $("#openmlsearch").val();
  if(query.indexOf(type+":") > -1){
    var qparts = query.match(/(?:[^\s"]+|"[^"]*")+/g);
    for (i = 0; i < qparts.length; i++) {
      if(qparts[i].indexOf(type+":") > -1){
        attr = qparts[i].split(":");
        attr[1] = constr;
        qparts[i] = attr.join(":");
        query = qparts.join(" ");
      }
    }
  } else {
    query += " "+type+":"+constr;
  }
  if(!constr){
    query = query.replace(" "+type+":",'');
    query = query.replace(type+":",'');
  }
  console.log(query);
  $("#openmlsearch").val(query);
}

// Reset all search filters
function removeFilters()
{
  var query = $("#openmlsearch").val();
  var newQuery = "";
  if(query.indexOf(":") > -1){
    var qparts = query.match(/(?:[^\s"]+|"[^"]*")+/g);
    for (i = 0; i < qparts.length; i++) {
      if(qparts[i].indexOf(":") == -1){
        newQuery += " "+qparts[i];
      }
    }
  } else {
    newQuery = query;
  }
  $("#openmlsearch").val(newQuery);
}

    // fetch counts for menu bar
    client.search(<?php echo json_encode($this->alltypes); ?>).then(function (body) {
      var buckets = body.aggregations.type.buckets;
      for (var b in buckets.reverse()){
        $('#'+buckets[b].key+'counter').html(buckets[b].doc_count);
      }
    }, function (error) {
      console.trace(error.message);
    });

    $(document).on("change, keyup", "#qualities\\.NumberOfInstances", function() { updateQuery("qualities.NumberOfInstances"); });
    $(document).on("change, keyup", "#qualities\\.NumberOfFeatures", function() { updateQuery("qualities.NumberOfFeatures"); });
    $(document).on("change, keyup", "#qualities\\.NumberOfMissingValues", function() { updateQuery("qualities.NumberOfMissingValues"); });
    $(document).on("change, keyup", "#qualities\\.NumberOfClasses", function() { updateQuery("qualities.NumberOfClasses"); });
    $(document).on("change, keyup", "#qualities\\.DefaultAccuracy", function() { updateQuery("qualities.DefaultAccuracy"); });
    $(document).on("change, keyup", "#uploader", function() { updateQuery("uploader"); });

    $('#NumberOfInstances').keypress(function(event) { if (event.keyCode == 13) { $('#searchform').submit();}});
    $('#NumberOfFeatures').keypress(function(event) { if (event.keyCode == 13) { $('#searchform').submit();}});
    $('#NumberOfMissingValues').keypress(function(event) { if (event.keyCode == 13) { $('#searchform').submit();}});
    $('#NumberOfClasses').keypress(function(event) { if (event.keyCode == 13) { $('#searchform').submit();}});
    $('#DefaultAccuracy').keypress(function(event) { if (event.keyCode == 13) { $('#searchform').submit();}});

    $("#tags\\.tag").change(function() { updateQuery("tags.tag"); $('#searchform').submit();});

    $("#tasktype\\.tt_id").change(function() { updateQuery("tasktype.tt_id"); $('#searchform').submit();});
    $("#task_id").change(function() { updateQuery("task_id"); $('#searchform').submit();});
    $("#estimation_procedure\\.proc_id").change(function() { updateQuery("estimation_procedure.proc_id"); $('#searchform').submit();});
    $("#source_data").change(function() { updateQuery("source_data.name"); $('#searchform').submit();});

    $("#run_id").change(function() { updateQuery("run_id"); $('#searchform').submit();});
    $("#run_task\\.task_id").change(function() { updateQuery("run_task.task_id"); $('#searchform').submit();});
    $("#run_task\\.tasktype\\.tt_id").change(function() { updateQuery("run_task.tasktype.tt_id"); $('#searchform').submit();});
    $("#run_flow\\.flow_id").change(function() { updateQuery("run_flow.flow_id"); $('#searchform').submit();});

    $("#flow_id").change(function() { updateQuery("flow_id"); $('#searchform').submit();});
    $("#version").change(function() { updateQuery("version"); $('#searchform').submit();});

    $("#type").change(function() { updateQuery("type"); $('#searchform').submit();});

    $("#removefilters").click(function() { console.log("click"); removeFilters(); $('#searchform').submit();});

    $('#research').click(function() { $('#searchform').submit();});


    <?php
    if($this->table) {
    ?>
      $('#tableview').dataTable( {
    		"responsive": "true",
    		"dom": 'CT<"clear">lfrtip',
    		"aaData": <?php echo json_encode($this->tableview); ?>,
        "scrollY": "600px",
        "scrollCollapse": true,
    		"deferRender": true,
        "paging": false,
    		"processing": true,
    		"bSort" : true,
    		"bInfo": false,
    		"tableTools": {
    						"sSwfPath": "//cdn.datatables.net/tabletools/2.2.3/swf/copy_csv_xls_pdf.swf"
    				},
    		"aaSorting" : [],
    		"aoColumns": [
    	  <?php
          $cnt = sizeOf($this->cols);
    			foreach( $this->tableview[0] as $k => $v ) {
    			$newcol = '{ "mData": "'.$k.'" , "defaultContent": "", ';
    			if(is_numeric($v))
    				$newcol .= '"sType":"numeric", ';
    			if($k == 'name' || $k == 'runs' || $k == 'NumberOfInstances' || $k == 'NumberOfFeatures' || $k == 'NumberOfClasses')
          	$newcol .= '"bVisible":true},';
    			else
    				$newcol .= '"bVisible":false},';
    			if(array_key_exists($k,$this->cols)){
    				$this->cols[$k] = $newcol;
    			} else {
    				//$this->cols[] = $newcol;
    				$cnt++;
    			}
    		  	}
    			foreach( $this->cols as $k => $v ) {
     				echo $v;
    			}?>

    		]
    	    } );

    	$('.topmenu').show();

    function toggleResults( resultgroup ) {
    	var oDatatable = $('#tableview').dataTable(); // is not reinitialisation, see docs.

    	redrawScatterRequest = true;
    	redrawLineRequest = true;
    	for( var i = 1; i < colcount; i++) {
    		if( i > colmax * resultgroup && i <= colmax * (resultgroup+1) )
    			oDatatable.fnSetColumnVis( i, true );
    		else
    			oDatatable.fnSetColumnVis( i, false );
    	}
    }
    <?php } ?>

  });
