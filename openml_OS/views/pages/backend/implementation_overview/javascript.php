
function deleteImplementation( id, msg ) {
  $.ajax({
    type: "POST",
    url: "<?php echo BASE_URL; ?>api/?f=openml.implementation.delete",
    data: 'implementation_id='+id,
    dataType: "xml"
  }).done( function( resultdata ) { 
      
      id_field = $(resultdata).find("oml\\:id");
      if( id_field.length ) {
        $("#implementations_row_" + id_field.text() ).remove();
        if( msg ) { alert( "Implementation " + id_field.text() + " was deleted. " ); }
      } else {
        code_field = $(resultdata).find("oml\\:code");
        message_field = $(resultdata).find("oml\\:message");
        if( msg ) { alert( "Error " + code_field.text() + ": " + message_field.text() ); }
      }
    } );
}
