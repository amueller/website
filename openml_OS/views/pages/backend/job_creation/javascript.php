$(document).ready( function() {
  //check for change on the categories menu
  $('#form-task-type-tabs li a').eq($('#selectTaskType option:selected').attr('name')).tab('show');
  
  $('#selectTaskType').change(function() {
    $('#form-task-type-tabs li a').eq($('#selectTaskType option:selected').attr('name')).tab('show');
  });
} );
