$(document).ready( function() {
  //check for change on the categories menu
  $('#form-task-type-tabs li a').eq($('#selectTaskType option:selected').attr('name')).tab('show');
  
  $('#selectTaskType').change(function() {
    $('#form-task-type-tabs li a').eq($('#selectTaskType option:selected').attr('name')).tab('show');
  });
  
  var oDatatable = $('.taskstable').dataTable( {
    "bPaginate": true,
    "aLengthMenu": [[10, 50, 100, 250, -1], [10, 50, 100, 250, "All"]],
    "iDisplayLength" : 50,
    "bLengthChange": true,
    "bFilter": false,
    "bSort": true,
    "aaSorting": [],
    "bInfo": true
  } );
} );
