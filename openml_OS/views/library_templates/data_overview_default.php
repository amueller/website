<script>
  $(document).ready( function() {
    $('.data_overview_table').dataTable( {
      "bPaginate": true,
      "iDisplayLength" : 30,
      "bLengthChange": false,
      "bFilter": false,
      "bSort": true,
      "aaSorting": [],
      "bInfo": true
    } );
  } );
  
  <?php if( $api_delete_function ): ?>
  function deleteItem( id, name, msg ) {
  $.ajax({
    type: "POST",
    url: "<?php echo BASE_URL; ?>api/?f=<?php echo $api_delete_function['function']; ?>",
    data: "<?php echo $api_delete_function['key']; ?>="+id,
    dataType: "xml"
  }).done( function( resultdata ) { 
      id_field = $(resultdata).find("oml\\:id");
      if( id_field.length ) {
        $("#overviewtable_row_" + id_field.text() ).remove();
        if( msg ) { alert( name + " was deleted. " ); }
      } else {
        code_field = $(resultdata).find("oml\\:code");
        message_field = $(resultdata).find("oml\\:message");
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
      <table class="table table-striped data_overview_table">
        <thead>
          <tr>
            <?php if($api_delete_function): ?><td></td><?php endif; ?>
            <?php foreach( $keys as $key ): ?>
              <td><?php echo $key; ?></td>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php if( is_array($items) ) foreach( $items as $item ): ?>
            
              <tr id="overviewtable_row_<?php echo $item->id; ?>">
                <?php if($api_delete_function): ?>
                  <td>
                    <?php if($item->{$api_delete_function['filter']}): ?>
                    <i class="fa fa-fw fa-times" onclick="if(confirm('Are you sure you want to delete <?php echo $item->{$api_delete_function['identify_field']}; ?>? This can not be undone. ')) deleteItem( '<?php echo $item->{$api_delete_function['id_field']}; ?>', '<?php echo $item->{$api_delete_function['identify_field']}; ?>', true );"></i>
                    <?php endif; ?>
                  </td>
                <?php endif; ?>
                <?php foreach( $keys as $key ): ?>
                  <td><?php if( property_exists ($item, $key ) ) { echo $item->$key; } ?></td>
                <?php endforeach; ?>
              </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
