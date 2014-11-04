<script>
var oTable;

$(document).ready(function() {
  oTable = $('.data_overview_table_<?php echo $counter; ?>').dataTable({
    "bServerSide": true,
    "sAjaxSource": "api_query/table_feed",
    "sServerMethod": "POST",
    "fnServerParams": function ( aoData ) {
      aoData.push( { 'value': '<?php echo implode(",",$columns); ?>', 'name' : 'columns' } );
      aoData.push( { 'value': '<?php echo htmlspecialchars($sql); ?>', 'name' : 'base_sql' } );
    },
    "aaSorting": <?php echo $sort; ?>,        
    "bLengthChange": false,
    "bFilter": false,
    "iDisplayLength" : 30,
    "bAutoWidth": true,
    <?php echo column_widths($column_widths); ?>
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
</script>

<div class="bs-docs-container topborder">
  <div class="container">
    <div class="col-sm-12">
      <h2><?php echo $table_name; ?></h2>
      <table class="table table-striped data_overview_table_<?php echo $counter; ?>">
        <thead>
          <tr>
            <?php foreach( $columns as $key ): ?>
              <td><?php echo $key; ?></td>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>
</div>
