<?php foreach( $source as $imp ): ?>
<oml:component>
  <oml:identifier><?php echo $imp->identifier; ?></oml:identifier>
	<?php sub_xml( 'implementation-get', array( 'source' => $imp->implementation ), false ); ?>
</oml:component>
<?php endforeach; ?>
