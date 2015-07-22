var client = new $.es.Client({
  hosts: 'http://es.openml.org'
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

function scrollMenuTop(){
  $('#mainmenu').animate({ scrollTop: 0 }, { duration: 500, queue: false });
}


$(function() {

  $("#submenucontainer").append($(".submenu"));

  $("#menubutton").click(function () {

    var visible = $('#mainmenu').is(":visible" );
    var options = { direction: 'left' };
    $('#mainmenu').toggle('slide', options, 500);

    if(visible){
      $('#mainmenu').scrollTop($("#submenucontainer").offset().top - 70);
      $('#mainpanel').removeClass('rightpanel');
    } else {
      if(window.innerWidth>992){$('#mainpanel').addClass('rightpanel');}
      if(!$("#submenucontainer").is(':empty') && $('.navbar-brand').html() != 'Search'){
        $('#mainmenu').animate({
          scrollTop: ($("#submenucontainer").offset().top - 70)
        }, { duration: 500, queue: false });
      }
    }
  });

  if($('#wrap').width()>992 && $('#section-brand').html() != 'OpenML'){
    $('#mainmenu').css("display","block");
    $('#mainmenu').scrollTop($("#submenucontainer").offset().top - 70);
    $('#mainpanel').addClass('rightpanel');
  } else {
    $('a[data-toggle="tab"]').click(function () {
      var options = { direction: 'left' };
      $('#mainmenu').toggle('slide', options, 500);
    });
  }

  $(".collapse").on('shown.bs.collapse', function () {
    $(this).prev().css( "color", $(".topactive > :first-child").css("color"));
    $(this).prev().css( "font-weight", "bold" );
  });
  $(".collapse").on('hidden.bs.collapse', function () {
    $(this).prev().css( "color", "#424242" );
    $(this).prev().css( "font-weight", "normal" );
  });

  $("#openmlsearch").autocomplete({
    html: true,
    position: {
        my: "left top+13" // Shift 0px to the left, 20px down.
    },
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
  //reflow hidden charts and tables when they become visible
  jQuery(document).on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e) { // on tab selection event
    jQuery( ".reflow-chart" ).each(function() { // target each element with the .contains-chart class
        var chart = jQuery(this).highcharts(); // target the chart itself
        if(chart) chart.reflow() // reflow that chart
    });
    jQuery( ".reflow-table" ).each(function() { // target each element with the .contains-chart classt
        $( $.fn.dataTable.tables( true ) ).DataTable().columns.adjust();
    });
  });

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
      // set correct url
      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('ul.sidenav li.active').removeClass('active');
        $(this).parent('li').addClass('active');
        window.location.hash = '!'+$(this).attr("href").replace('#','');
      });

      // show page indicated by #!
      if (location.hash.substr(0,2) == "#!") {
        var e = $("a[href='#" + location.hash.substr(2) + "']");
        e.tab("show");
        e.closest("ul").collapse('show');
        e.closest("li").addClass('active');
      } else { //set default
        //$("#startlist").collapse('show');
      }

      //scroll to top when selected tab changes
      $('.switchtab').click(function (e) {
        e.preventDefault();
        $('a[href="' + $(this).attr('href') + '"]').tab('show');
        $('.guidesection').animate({ scrollTop: 0 }, 0);
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

      !function ($) {

        $(window).load(function(){

          // make code pretty
          window.prettyPrint && prettyPrint()

          // popover demo
          $("[data-toggle=popover]")
            .popover()
        });

      }(window.jQuery)

      $(window).load(function(){
        $('#popover').popover({
            trigger: 'click',
            placement: 'bottom',
            html: true,
            container: 'body',
            animation: 'false',
            content: function() { return $('#openmllinks').html(); }
        });
        $('#popover2').popover({
            trigger: 'click',
            placement: 'bottom',
            html: true,
            container: 'body',
            animation: 'false',
            content: $('#sociallinks')
        });
        $('#popover').on('shown.bs.popover', function () {
           $('.popover').css('left','inherit')
           $('.popover').css('right','10px')
           $('.arrow').css('left','inherit')
           $('.arrow').css('right','10px')
        });
        $('#popover2').on('shown.bs.popover', function () {
           $('.popover').css('left','inherit')
           $('.popover').css('right','10px')
           $('.arrow').css('left','inherit')
           $('.arrow').css('right','55px')
           $('#sociallinks').css('display','block')
        });
        $('#popover2').on('hide.bs.popover', function () {
           $('body').append($('#sociallinks'))
           $('#sociallinks').css('display','none')
        });
        $('.tip').tooltip();
        // This command is used to initialize some elements and make them work properly
        $.material.options.autofill = true;
        $.material.init();
      });

      $(document).click(function (e) {
          $('#popover').each(function () {
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            if ($(this).data('bs.popover').tip().hasClass('in')) {
          $(this).popover('toggle');
            }
            return;
        }
          });
          $('#popover2').each(function () {
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            if ($(this).data('bs.popover').tip().hasClass('in')) {
          $(this).popover('toggle');
            }
            return;
        }
          });
      });
      $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
      });
