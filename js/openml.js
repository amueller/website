var client = new $.es.Client({
  hosts: 'localhost:9200'
});

client.ping({
  requestTimeout: 1000,
  // undocumented params are appended to the query string
  hello: "elasticsearch!"
}, function (error) {
  if (error) {
    console.error('elasticsearch cluster is down!');
  } else {
    console.log('All is well');
  }
});

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

function showmore(){
    $('.description').switchClass("hideContent", "showContent", 400);
    $('.show-more').hide();
}
