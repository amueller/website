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

$(function() {
  // attaches page-specific menu below main menu
  $("#submenucontainer").append($(".submenu"));

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
