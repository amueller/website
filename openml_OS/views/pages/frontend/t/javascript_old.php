


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
