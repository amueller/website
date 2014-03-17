/// SHARING

$(document).ready(function() { 
    // bind form using ajaxForm 
    $('.pop').popover();
    $('.selectpicker').selectpicker();

    // make tab selection persistent
    if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');

    return $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      return location.hash = $(e.target).attr('href').substr(1);
    });
});


function showResultTab(){
$('#ttabs a:[href="#results"]').tab('show');
}

function redrawchart(){

var theQuery = 'select * from task_type';
var query =  encodeURI("<?php echo BASE_URL; ?>"+"api_query/?q="+encodeURIComponent(theQuery), "UTF-8");

$.getJSON(query,function(jsonData){
        var data = jsonData.data;
	console.log(data);
	for(var i=0;i<data.length;i++){
	}
}).fail(function(){ console.log('failure', arguments); });
}

$(document).ready(function() {
   redrawchart();
});

