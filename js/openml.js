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

// scrolls left menu to top
function scrollMenuTop(){
  $('#mainmenu').animate({ scrollTop: 0 }, { duration: 500, queue: false });
}

window.mobilecheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
}

$(function(){

//scrollbars
var container = document.getElementById('mainmenu');
Ps.initialize(container);
//$("#mainmenu").find(".ps-scrollbar-y-rail").css("opacity",0);

//var container2 = document.getElementsByClassName('openmlsectioninfo');
//if(container2.length > 0){
//  Ps.initialize(container2[0], {minScrollbarLength:100});
//}

// DELETING ACTIONS

  //bind to action icons
  $(document).on('click', '.delete_action', function(event) {
       var itemName = $(this).data("name");
       var itemID = $(this).data("id");
       var itemType = $(this).data("type");
       swal({title: "Are you sure?",
             text: "You are about to delete "+itemName+". You will not be able to recover this "+itemType+"!",
             type: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: "Yes, delete it!",
             closeOnConfirm: false},
           function(){
             deleteItem( itemType, itemID, itemName );
           });
      return false;
  });

  // deleting items
  function deleteItem( type, id, name ) {
  $.ajax({
    type: "DELETE",
    url: "http://www.openml.org/api_new/v1/"+type+"/"+id,
    dataType: "xml"
  }).done( function( resultdata ) {
      console.log(resultdata.responseText);
      id_field = $(resultdata.responseText).find("oml\\:id, id");
      if( id_field.length ) {
        swal("Deleted!", name + " has been deleted.", "success");
        location.reload();
      } else {
        code_field = $(resultdata).find("oml\\:code, code");
        message_field = $(resultdata).find("oml\\:message, message");
        swal("Error " + code_field.text(), message_field.text(), "error");
      }
    }).fail( function( resultdata ) {
        console.log(resultdata.responseText);
        code_field = $(resultdata.responseText).find("oml\\:code, code");
        message_field = $(resultdata.responseText).find("oml\\:message, message");
        if(code_field.text() == 102)
          swal("Error", "Your login has expired. Log in and try again.", "error");
        else
          swal("Error " + code_field.text(), message_field.text(), "error");
    });
  }


});

$(function() {

  // brings up login window on restricted links
  $('.loginfirst').focus(function() { if(!logged_in){$('#login-dialog').modal('show'); return false;}});
  $('.loginfirst').click(function() { if(!logged_in){$('#login-dialog').modal('show'); return false;}});

  // attaches page-specific menu below main menu
  $("#submenucontainer").append($(".submenu"));
  $(".submenu").css('float', 'none');

  // shows/hides menu when menu icon is clicked
  $("#menubutton").click(function () {

    var visible = $('#mainmenu').is(":visible" );
    var options = { direction: 'left' };
    $('#mainmenu').toggle('slide', options, 500);

    if(visible){
      $('#mainmenu').scrollTop($("#submenucontainer").offset().top - 80);
      $('#mainpanel').removeClass('rightpanel');
    } else {
      if(window.innerWidth>992){$('#mainpanel').addClass('rightpanel');}
      if(!$("#submenucontainer").is(':empty') && $('.navbar-brand').html() != 'Search'){
        $('#mainmenu').animate({
          scrollTop: ($("#submenucontainer").offset().top - 80)
        }, { duration: 500, queue: false });
      }
    }
  });

  // automatically show/hide the menu depending on the page width
  if($('#wrap').width()>992 && $('#section-brand').html() != 'OpenML'){
    $('#mainmenu').css("display","block");
    $('#mainmenu').scrollTop($("#submenucontainer").offset().top - 80);
    $('#mainpanel').addClass('rightpanel');
  } else {
    $('a[data-toggle="tab"]').click(function () {
      var options = { direction: 'left' };
      $('#mainmenu').toggle('slide', options, 500);
    });
  }

  // highlighting for subsections in submenu
  $(".collapse").on('shown.bs.collapse', function () {
    $(this).prev().css( "color", $(".topactive > :first-child").css("color"));
    $(this).prev().css( "font-weight", "bold" );
  });
  $(".collapse").on('hidden.bs.collapse', function () {
    $(this).prev().css( "color", "#424242" );
    $(this).prev().css( "font-weight", "normal" );
  });

  // auto-suggest for the search box
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
          console.log(item);
          return {
            type: item['payload']['type'],
            id: item['payload'][item['payload']['type']+'_id'],
            description: (typeof myVar === 'string' ? item['payload']['description'].substring(0,50) : ''),
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

  // ENDLESS SCROLL (is used on multiple pages, and thus defined system-wide)

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
        if(next_data_url)
          $.get(next_data_url+'&dataonly=1', function(preview_data) {
            next_data_cache = preview_data;
          });
      } else {
        $( ".loadingmore" ).html(" ");
        $( ".pagination" ).css("display","block");
      }
    }
    if (next_data_cache) {
      showFollowing(next_data_cache);
      is_loading = 0;
    } else if(next_data_url) {
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
      if(prev_data_url && curr_data_url != prev_data_url){
        $.get(prev_data_url+'&dataonly=1', function(preview_data) {
          prev_data_cache = preview_data;
        });}
      }
      if (prev_data_cache) {
        showPrevious(prev_data_cache);
        is_loading = 0;
      } else if (prev_data_url && curr_data_url != prev_data_url){
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

  function isElementInViewport (el) {

    //special bonus for those using jQuery
    if (typeof jQuery === "function" && el instanceof jQuery) {
        el = el[0];
    }

    var rect = el.getBoundingClientRect();

    //console.log(rect.bottom + ' > 0 && ' + rect.top + ' < ' + $(window).height() + ' = ' + (rect.top <= $(window).height() && rect.bottom >= 0 ));

    return (
      rect.top <= $(window).height() &&
      rect.bottom >= 0
    );
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
    var scrcount = 0;

    $('.openmlsectioninfo').scroll(function() {
      $(".listitempage").each(function(index) {
        if (mostlyVisible(this)) {
          if(currentUrl != $(this).attr("data-url")){
            if(window.location.href.indexOf('search') >= 0)
              history.replaceState(null, null, $(this).attr("data-url").replace("&dataonly=1",""));
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

    // special behavior on mobile devices
    window.addEventListener( "scroll", function( event ) {
      scrcount++;
      if(scrcount % 10 == 0){
        $(".listitempage").each(function(index) {
          if (isElementInViewport(this)) {
            if(currentUrl != $(this).attr("data-url")){
              if(window.location.href.indexOf('search') >= 0)
                history.replaceState(null, null, $(this).attr("data-url").replace("&dataonly=1",""));
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
      }
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
      $(document).on('click', '.searchresult', function() {
          window.location = $(this).find("a:first").attr("href");
          return false;
      });

      $(".searchresult").hover(function () {
          window.status = $(this).find("a:first").attr("href");
      }, function () {
          window.status = "";
      });

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
