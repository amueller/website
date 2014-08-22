<oml:data-safe xmlns:oml="http://openml.org/openml">
  <?php foreach( $datasets as $d ): ?>
  <oml:data>
	<oml:did><?php echo $d->did; ?></oml:did>
	<oml:name><?php echo $d->name; ?></oml:name>
	<oml:version><?php echo $d->version; ?></oml:version>
  </oml:data>
  <?php endforeach; ?>
</oml:data-safe>
