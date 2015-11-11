// auto-suggest for the filters
function updateUploader(name){
  console.log('Uploader is ' + name);
  $('#uploader').val(name+'');
  updateQuery("uploader");
  $('#searchform').submit();
}


// Update search query upon user actions
function updateQuery(type)
{
  var constr = '';
  if(type == 'source_data.name')
    constr = $("#"+type.replace('.name','')).val().replace(/\s/g,"_");
  else if(type == 'run_task.tasktype.tt_id')
    constr = $("#run_task\\.tasktype\\.tt_id").val();
  else
    constr = $("#"+type.replace('.','\\.')).val().replace(/\s/g,"_");
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
  $("#openmlsearch").val(query);
}


  $(document).ready(function () {


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

 function bindInput(elem){
   $('#'+elem.replace(/\./g, '\\.')).keyup(function(event) {
     if (event.keyCode == 13) { $('#searchform').submit();}
     else {updateQuery(elem);}});
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

    //autocomplete
    $(document).on("change, keyup", "#uploader", function() { updateQuery("uploader"); });

    //normal typing
    bindInput("qualities.NumberOfInstances");
    bindInput("qualities.NumberOfFeatures");
    bindInput("qualities.NumberOfMissingValues");
    bindInput("qualities.NumberOfClasses");
    bindInput("qualities.DefaultAccuracy");
    bindInput("tags.tag");
    bindInput("tasktype.tt_id");
    bindInput("task_id");
    bindInput("estimation_procedure.proc_id");
    bindInput("source_data.name");
    bindInput("run_id");
    bindInput("run_task.task_id");
    bindInput("run_task.tasktype.tt_id");
    bindInput("run_flow.flow_id");
    bindInput("flow_id");
    bindInput("version");
    bindInput("type");
    bindInput("task_id");

    //buttons
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
    		"aoColumns": <?php echo json_encode($this->mCols); ?>
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

    if ( $( "#uploader" ).length ) {
    $("#uploader").autocomplete({
      html: true,
      position: {
          my: "left top+13" // Shift 0px to the left, 20px down.
      },
      source: function(request, fresponse) {
        client.suggest({
          index: 'openml',
          type: 'user',
          body: {
            mysuggester: {
              text: request.term,
              completion: {
                field: 'suggest',
                size: 10
              }
            }
          }
        }, function (error, response) {
          fresponse($.map(response['mysuggester'][0]['options'], function(item) {
            console.log(item['text']);
            if(item['payload']['type'] == 'user'){
            return {
              type: item['payload']['type'],
              id: item['payload'][item['payload']['type']+'_id'],
              text: item['text']
            };}
          }));
        });
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
      .append( '<a onclick="updateUploader(\'' + item.text + '\')"><i class="' + icons[item.type] + '"></i> ' + item.text + '</a>' )
      .appendTo( ul );
    }
  }

  });
