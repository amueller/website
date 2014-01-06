

$(document).ready(function() {
	var oTable = $('#my_runs').dataTable({
//		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "api_query/table_feed",
		"sServerMethod": "POST",
		"fnServerParams": function ( aoData ) {
			<?php echo array_to_parsed_string($this->dt_runs, "aoData.push( { 'value': '[VALUE]', 'name' : '[KEY]' } );\n" ); ?>
		},
		"fnDrawCallback": function( oSettings ) {
		  for ( var i=0, iLen=oSettings.aoData.length ; i<iLen ; i++ ) {
				oSettings.aoData[i].nTr.className += " runTableRow_" + oSettings.aoData[i]._aData[3];
			}
		},
		"aaSorting": [[0, 'desc']],        
		"bLengthChange": false,
        "bFilter": false,
		"iDisplayLength" : 100,
		"bAutoWidth": false,
		<?php echo column_widths($this->dt_runs['column_widths']); ?>
		"bPaginate": true
	});
} );

