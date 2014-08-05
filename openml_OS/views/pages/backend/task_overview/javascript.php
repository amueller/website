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

function deleteTask( tid ) {
  $.ajax({
    type: "POST",
    url: "<?php echo BASE_URL; ?>api/?f=openml.task.delete",
    data: 'task_id='+tid,
    dataType: "xml"
  }).done( function( resultdata ) { 
      
      id_field = $(resultdata).find("oml\\:id");
      
      if( id_field.length ) {
        $("#duplicate_task_" + id_field.text() ).remove();
        alert( "Task " + id_field.text() + " was deleted. " );
      } else {
        code_field = $(resultdata).find("oml\\:code");
        message_field = $(resultdata).find("oml\\:message");
        alert( "Error " + code_field.text() + ": " + message_field.text() );
      }
    } );
}

