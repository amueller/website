var oTable;

$(document).ready(function() {
  oTable = $('.data_overview_table_<?php echo $this->counter; ?>').dataTable({
    "bServerSide": true,
    "sAjaxSource": "api_query/table_feed",
    "sServerMethod": "POST",
    "fnServerParams": function ( aoData ) {
      aoData.push( { 'value': '<?php echo implode(",",$this->columns); ?>', 'name' : 'columns' } );
      aoData.push( { 'value': '<?php echo htmlspecialchars($this->sql); ?>', 'name' : 'base_sql' } );
    },
    "aaSorting": <?php echo $this->sort; ?>,
    "bLengthChange": false,
    "bFilter": false,
    "iDisplayLength" : 30,
    "bAutoWidth": true,
    <?php echo column_widths($this->widths); ?>
    "bPaginate": true
  });
});

<?php if( $api_delete_function ): ?>

function askConfirmation( id, name ) {
  if(confirm('Are you sure you want to delete ' + name + '? This can not be undone. ')) {
    deleteItem( id, name, true );
  }
}

function deleteItem( id, name, msg ) {
$.ajax({
  type: "POST",
  url: "<?php echo BASE_URL; ?>api/?f=<?php echo $api_delete_function['function']; ?>",
  data: "<?php echo $api_delete_function['key']; ?>="+id,
  dataType: "xml"
}).done( function( resultdata ) {
    id_field = $(resultdata).find("oml\\:id, id");

    if( id_field.length ) {
      oTable.fnDraw();
      if( msg ) { alert( name + " was deleted. " ); }
    } else {
      code_field = $(resultdata).find("oml\\:code, code");
      message_field = $(resultdata).find("oml\\:message, message");
      if( msg ) { alert( "Error " + code_field.text() + ": " + message_field.text() ); }
    }
  } );
}
<?php endif; ?>
