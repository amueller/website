

$(function() {
  if ( window.location.hash ) {
      $('.nav-tabs a[href='+window.location.hash+']').tab('show');
      console.log($('.nav-tabs a[href='+window.location.hash+']'));
  }

$("#datasetDropdown").autocomplete({
  html: true,
  minLength: 0,
  source: function(request, fresponse) {
    client.suggest({
    index: 'openml',
    type: 'data',
    body: {
     mysuggester: {
      text: request.term.split(/[, ]+/).pop(),
      completion: {
       field: 'suggest',
       fuzzy : true,
       size: 10
      }
     }
    }
   }, function (error, response) {
       fresponse($.map(response['mysuggester'][0]['options'], function(item) {
        if(item['payload']['type'] == 'data')
  return { 
    type: item['payload']['type'], 
    id: item['payload']['data_id'], 
    description: item['payload']['description'].substring(0,50), 
    text: item['text'] 
    };
  }));
   });
  },
  select: function( event, ui ) {
  $val = $('#datasetDropdown').val().split(/[, ]+/);
  $val.pop();
  $val = $val.join(", ");
  if($val.length>0)
    $val = $val + ", ";
  $('#datasetDropdown').val( $val + ui.item.id);  console.log(ui.item.id); return false;
  }

}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( '<a><i class="' + icons[item.type] + '"></i> ' + item.text + ' <span>' + item.description + '</span></a>' )
        .appendTo( ul );
    }

 $("#flowDropdown").autocomplete({
  html: true,
  minLength: 0,
  source: function(request, fresponse) {
    client.suggest({
    index: 'openml',
    type: 'flow',
    body: {
     mysuggester: {
      text: request.term.split(/[, ]+/).pop(),
      completion: {
       field: 'suggest',
       fuzzy : true,
       size: 10
      }
     }
    }
   }, function (error, response) {
       fresponse($.map(response['mysuggester'][0]['options'], function(item) {
        if(item['payload']['type'] == 'flow')
  return { 
    type: item['payload']['type'], 
    id: item['payload']['flow_id'], 
    description: item['payload']['description'].substring(0,50), 
    text: item['text'] 
    };
  }));
   });
  },
  select: function( event, ui ) {
  $val = $('#flowDropdown').val().split(/[, ]+/);
  $val.pop();
  $val = $val.join(", ");
  if($val.length>0)
    $val = $val + ", ";
  $('#flowDropdown').val( $val + ui.item.id);  console.log(ui.item.id); return false;
  }

}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( '<a><i class="' + icons[item.type] + '"></i> ' + item.text + ' <span>' + item.description + '</span></a>' )
        .appendTo( ul );
    }
});
