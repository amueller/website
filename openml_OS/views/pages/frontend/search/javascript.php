
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

// ENDLESS SCROLL

var next_data_url; // replaced when loading more
var prev_data_url; // replaced when loading more
var next_data_cache = false;
var prev_data_cache = false;
var last_scroll = 0;
var is_loading = 0; // simple lock to prevent loading when loading
var hide_on_load = false; // ID that can be hidden when content has been loaded

function loadFollowing() {
console.log("following");
if(getParameterByName('table') != 1){ //only scroll if cards are shown
  is_loading = 1; // note: this will break when the server doesn't respond
  function showFollowing(data) {
    next_data_cache = false;
    if(!$(data).find("#itempage").is(':empty') && $(data).find("#itempage")[0].childElementCount > 0) {
      $(data).find("#itempage").appendTo("#scrollingcontent");
      next_data_url = $(data).find("#itempage").attr("data-next-url");
      $.get(next_data_url+'&dataonly=1', function(preview_data) {
        next_data_cache = preview_data;
      });
    } else {
      $( ".loadingmore" ).html("No more data");
      $( ".pagination" ).css("display","block");
    }
  }
  if (next_data_cache) {
    showFollowing(next_data_cache);
    is_loading = 0;
  } else {
    $( ".loadingmore" ).html("Loading more...");
    $.get(next_data_url+'&dataonly=1', function(data) {
      showFollowing(data);
      is_loading = 0;
    });
  }
}
}

function loadPrevious() {
if(getParameterByName('table') != 1){ //only scroll if cards are shown
  is_loading = 1; // note: this will break when the server doesn't respond
  function showPrevious(data) {
    prev_data_cache = false;
    var scroll_pos = $('.openmlsectioninfo').scrollTop();
    $(data).find("#itempage").prependTo("#scrollingcontent");
    item_height = $(".listitempage:first").height();
    $('.openmlsectioninfo').animate({
      scrollTop: scroll_pos + item_height
    }, 0);
    prev_data_url = $(data).find("#itempage").attr("data-prev-url");
    if(curr_data_url != prev_data_url){
      $.get(prev_data_url+'&dataonly=1', function(preview_data) {
        prev_data_cache = preview_data;
      });}
    }
    if (prev_data_cache) {
      showPrevious(prev_data_cache);
      is_loading = 0;
    } else if (curr_data_url != prev_data_url){
      $.get(prev_data_url+'&dataonly=1', function(data) {
        showPrevious(data);
        is_loading = 0;
      });
    } else
    is_loading = 0;
  }
}

function mostlyVisible(element) {
  // if ca 25% of element is visible
  var scroll_pos = $('#scrollingcontent').scrollTop();
  var window_height = $('.openmlsectioninfo').height();
  var el_top = $(element).offset().top;
  var el_height = $(element).height();
  var el_bottom = el_top + el_height;
  return ((el_bottom - el_height*0.25 > scroll_pos) &&  (el_top < (scroll_pos+0.5*window_height)));
}

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
  results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function initPaginator() {

  var seenUrls = new Set();
  var currentUrl = $(document).find("#itempage").attr("data-url");

  $('.openmlsectioninfo').scroll(function() {
    console.log("scroll");

    $(".listitempage").each(function(index) {
      if (mostlyVisible(this)) {
        if(currentUrl != $(this).attr("data-url")){
          history.replaceState(null, null, $(this).attr("data-url"));
          currentUrl = $(this).attr("data-url");
          if(!seenUrls.has($(this).attr("data-next-url"))){
            seenUrls.add($(this).attr("data-next-url"));
            loadFollowing();
          }
          else if(!seenUrls.has($(this).attr("data-prev-url"))){
            seenUrls.add($(this).attr("data-prev-url"));
            loadPrevious();
          }
        }
        return(false);
      }
    });
  });

  curr_data_url = $(document).find("#itempage").attr("data-url");
  next_data_url = $(document).find("#itempage").attr("data-next-url");
  prev_data_url = $(document).find("#itempage").attr("data-prev-url");
  seenUrls.add(curr_data_url);
  if(curr_data_url != prev_data_url){
    seenUrls.add(prev_data_url);
    loadPrevious();
  }
  seenUrls.add(next_data_url);
  loadFollowing();
}


    // initialize endless scrolling
    initPaginator();

    // handle clicks on cards
    $(".searchresult").click(function(){
        window.location = $(this).find("a:first").attr("href");
        return false;
    });

    $(".searchresult").hover(function () {
        window.status = $(this).find("a:first").attr("href");
    }, function () {
        window.status = "";
    });

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
    $("#uploader").change(function() { updateQuery("uploader"); $('#searchform').submit();});

    $("#flow_id").change(function() { updateQuery("flow_id"); $('#searchform').submit();});
    $("#version").change(function() { updateQuery("version"); $('#searchform').submit();});

    $("#type").change(function() { updateQuery("type"); $('#searchform').submit();});

    $("#removefilters").click(function() { console.log("click"); removeFilters(); $('#searchform').submit();});

    $('#research').click(function() { $('#searchform').submit();});

    $('.loginfirst').focus(function() { if(!logged_in){$('#login-dialog').modal('show'); return false;}});
    $('.loginfirst').click(function() { if(!logged_in){$('#login-dialog').modal('show'); return false;}});


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
