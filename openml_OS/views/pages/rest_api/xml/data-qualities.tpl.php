<oml:data_qualities xmlns:oml="http://openml.org/openml">
  <oml:data_set>
    <oml:id><?php echo $did; ?></oml:id>
    <oml:name><?php echo $name; ?></oml:name>
  </oml:data_set>
  <?php foreach( $qualities as $quality ): ?>
  <oml:quality>
    <oml:name><?php echo $quality->quality; ?></oml:name>
    <oml:value><?php echo $quality->value; ?></oml:value>
  </oml:quality>
  <?php endforeach; ?>
</oml:data_qualities>
