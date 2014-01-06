<oml:components>
	<?php 
	foreach( $source as $imp )
		sub_xml( 'implementation-get', array( 'source' => $imp ), false );
	?>
</oml:components>
