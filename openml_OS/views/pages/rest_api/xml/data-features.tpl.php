<oml:data_features xmlns:oml="http://openml.org/openml">
  <?php foreach( $features as $feature ): ?>
  <oml:feature>
    <oml:name><?php echo $feature->name; ?></oml:name>
    <oml:data_type><?php echo $feature->data_type; ?></oml:data_type>
    <oml:index><?php echo $feature->index; ?></oml:index>
  </oml:feature>
  <?php endforeach; ?>
</oml:data_features>
