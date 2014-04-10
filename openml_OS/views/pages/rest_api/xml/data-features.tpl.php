<oml:data_features xmlns:oml="http://openml.org/openml">
  <oml:data_set>
    <oml:id><?php echo $did; ?></oml:id>
    <oml:name><?php echo $name; ?></oml:name>
  </oml:data_set>
  <?php foreach( $features as $feature ): ?>
  <oml:feature>
    <oml:name><?php echo $feature->name; ?></oml:name>
    <oml:data_type><?php echo $feature->data_type; ?></oml:data_type>
    <oml:index><?php echo $feature->index; ?></oml:index>
  </oml:feature>
  <?php endforeach; ?>
</oml:data_features>
