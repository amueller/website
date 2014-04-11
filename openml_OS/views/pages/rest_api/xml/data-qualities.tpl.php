<oml:data_qualities xmlns:oml="http://openml.org/openml">
  <?php foreach( $qualities as $quality ): ?>
  <oml:quality>
    <oml:name><?php echo $quality->quality; ?></oml:name>
    <oml:value><?php echo $quality->value; ?></oml:value>
  </oml:quality>
  <?php endforeach; ?>
</oml:data_qualities>
