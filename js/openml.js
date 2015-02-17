var client = new $.es.Client({
  hosts: 'http://openml.org:80'
});

/**client.ping({
  requestTimeout: 1000,
  // undocumented params are appended to the query string
  hello: "elasticsearch!"
}, function (error) {
  if (error) {
    console.error('Javascript cannot reach search index!');
  } else {
    console.log('All is well');
  }
});**/

var icons = {
	estimation_procedure : 'fa fa-signal',
	evaluation_measure : 'fa fa-signal',
	data_quality : 'fa fa-signal',
	flow_quality : 'fa fa-signal',
	measure : 'fa fa-signal',
	flow : 'fa fa-cogs',
        data : 'fa fa-database',
	run  : 'fa fa-star',
        user : 'fa fa-user',
        task : 'fa fa-trophy'
};


var urlprefix = {
	estimation_procedure : 'a/estimation-procedures',
	evaluation_measure : 'a/evaluation-measures',
	data_quality : 'a/data-qualities',
	flow_quality : 'a/flow-qualities',
	flow : 'f',
        data : 'd',
	run  : 'r',
        user : 'u',
        task : 't'
};

$(function() {

 $("#openmlsearch").autocomplete({
  html: true,
  source: function(request, fresponse) {
    client.suggest({
    index: 'openml',
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
	return {
		type: item['payload']['type'],
		id: item['payload'][item['payload']['type']+'_id'],
		description: item['payload']['description'].substring(0,50),
		text: item['text']
		};
	}));
   });
  }
}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( '<a href="' + urlprefix[item.type] + '/' + item.id +'"><i class="' + icons[item.type] + '"></i> ' + item.text + ' <span>' + item.description + '</span></a>' )
        .appendTo( ul );
    }
});

$(document).ready(function()
{
    function updateQuery(type)
    {
      var constr = '';
      if(type == 'source_data.data_id')
	constr = $("#"+type.replace('.data_id','')).val().replace(" ","_");
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

      $("#openmlsearch").val(query);
    }
    $(document).on("change, keyup", "#NumberOfInstances", function() { updateQuery("NumberOfInstances"); });
    $(document).on("change, keyup", "#NumberOfFeatures", function() { updateQuery("NumberOfFeatures"); });
    $(document).on("change, keyup", "#NumberOfMissingValues", function() { updateQuery("NumberOfMissingValues"); });
    $(document).on("change, keyup", "#NumberOfClasses", function() { updateQuery("NumberOfClasses"); });

    $('#NumberOfInstances').keypress(function(event) { if (event.keyCode == 13) { $('#searchform').submit();}});
    $('#NumberOfFeatures').keypress(function(event) { if (event.keyCode == 13) { $('#searchform').submit();}});
    $('#NumberOfMissingValues').keypress(function(event) { if (event.keyCode == 13) { $('#searchform').submit();}});
    $('#NumberOfClasses').keypress(function(event) { if (event.keyCode == 13) { $('#searchform').submit();}});

    $("#tasktype\\.tt_id").change(function() { updateQuery("tasktype.tt_id"); $('#searchform').submit();});
    $("#task_id").change(function() { updateQuery("task_id"); $('#searchform').submit();});
    $("#estimation_procedure\\.proc_id").change(function() { updateQuery("estimation_procedure.proc_id"); $('#searchform').submit();});
    $("#source_data").change(function() { updateQuery("source_data.data_id"); $('#searchform').submit();});
    $("#run_id").change(function() { updateQuery("run_id"); $('#searchform').submit();});
    $("#run_task\\.task_id").change(function() { updateQuery("run_task.task_id"); $('#searchform').submit();});

    $('#research').click(function() { $('#searchform').submit();});
});




function makeCommaSeperatedAutoComplete( selector, datasource ) {
	function split( val ) {
		return val.split( /,\s*/ );
	}
	function extractLast( term ) {
		return split( term ).pop();
	}

	$( selector )
	// don't navigate away from the field on tab when selecting an item
		.bind( "keydown", function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB &&
					$( this ).data( "autocomplete" ).menu.active ) {
				event.preventDefault();
			}

		})
		.autocomplete({
			minLength: 0,
			source: function( request, response ) {
				// delegate back to autocomplete, but extract the last term
				response( $.ui.autocomplete.filter(
					datasource, extractLast( request.term ) ) );
			},
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push( ui.item.value );
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				this.value = terms.join( ", " );
				$( selector ).trigger('change');
				return false;
			}
		});
}

function makeAutoComplete( selector, datasource ) {
	$( selector ).autocomplete({
		source: datasource
	});
}

// CARDS

function showmore(){
    $('.description').switchClass("hideContent", "showContent", 400);
    $('.show-more').hide();
}

function showmoreprops(){
    $('.properties').switchClass("hideProperties", "showProperties", 400);
    $('.show-more-props').hide();
}

function showmorefeats(){
    $('.features').switchClass("hideFeatures", "showFeatures", 400);
    visualize_all();
    $('.show-more-features').hide();
    $('.show-all-features').show();
}

function showsearch(){
  if($('#menusearchframe').hasClass("hidden-xs")){
    $('#menusearchframe').removeClass("hidden-xs");
    $('#menusearchframe').addClass("col-xs-12");
  } else {
    $('#menusearchframe').addClass("hidden-xs");
    $('#menusearchframe').removeClass("col-xs-12");
  }
}

// GUIDE MENU

$(function(){
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  $('ul.sidenav li.active').removeClass('active');
  $(this).parent('li').addClass('active');
  window.location.hash = '!'+$(this).attr("href").replace('#','');
});

});

function scrollToAnchor(aid){
    console.log($(aid).offset().top);
    $('#rest_services').animate({scrollTop: $(aid).offset().top},2000);
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
  if(getParameterByName('table') != 1){ //only scroll if cards are shown

  is_loading = 1; // note: this will break when the server doesn't respond
  function showFollowing(data) {
    $( ".loadingmore" ).html("Loading more...");
    console.log("load following");
    next_data_cache = false;
    if(!$(data).find("#itempage").is(':empty') && $(data).find("#itempage")[0].childElementCount > 0) {
        $(data).find("#itempage").appendTo("#scrollingcontent");
        next_data_url = $(data).find("#itempage").attr("data-next-url");
        $.get(next_data_url, function(preview_data) {
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
    $.get(next_data_url, function(data) {
      showFollowing(data);
      is_loading = 0;
    });
  }
 }
}

function loadPrevious() {
  if(getParameterByName('table') != 1){ //only scroll if cards are shown
  console.log("load previous");
    is_loading = 1; // note: this will break when the server doesn't respond
    function showPrevious(data) {
      console.log("show previous");
      curr_data_url = $(data).find("#itempage").attr("data-url");
      prev_data_url = $(data).find("#itempage").attr("data-prev-url");
      prev_data_cache = false;
      $(data).find("#itempage").prependTo("#scrollingcontent");
      item_height = $(".listitempage:first").height();
      $('.openmlsectioninfo').animate({
        scrollTop: $("#scrollingcontent").offset().top + item_height - $("#openmlheader").height() - 75
      }, 0);
      if(curr_data_url != prev_data_url){
      $.get(prev_data_url, function(preview_data) {
        prev_data_cache = preview_data;
      });}
    }
    if (prev_data_cache) {
      showPrevious(prev_data_cache);
      is_loading = 0;
    } else if (curr_data_url != prev_data_url){
      $.get(prev_data_url, function(data) {
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
  $(window).scroll(function() {
    // handle scroll events to update content
    var scroll_pos = $(window).scrollTop();
    if (scroll_pos <= 0.9*$("#openmlheader").height()) {
      if (is_loading==0) loadPrevious();
    }
    if (scroll_pos >= 0.9*($(document).height() - $(window).height())) {
      if (is_loading==0) loadFollowing();
    }
  });

  $('.openmlsectioninfo').scroll(function() {
    // Adjust the URL based on the top item shown
    // for reasonable amounts of items
    //if (Math.abs(scroll_pos - last_scroll)>$(window).height()*0.1) {
      $(".listitempage").each(function(index) {
          if (mostlyVisible(this)) {
            history.replaceState(null, null, $(this).attr("data-url"));
            return(false);
          }
        });
      //}
  });
  curr_data_url = $(document).find("#itempage").attr("data-url");
  next_data_url = $(document).find("#itempage").attr("data-next-url");
  prev_data_url = $(document).find("#itempage").attr("data-prev-url");
  if(curr_data_url != prev_data_url){
    loadPrevious();
  }
  loadFollowing();
}
