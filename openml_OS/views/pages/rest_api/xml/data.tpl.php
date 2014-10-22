<oml:data xmlns:oml="http://openml.org/openml">
  <?php foreach( $datasets as $data ): ?>
  <oml:task>
    <oml:did><?php echo $data->did; ?></oml:did>
    <oml:status><?php echo $data->status; ?></oml:status>
    <?php foreach( $data->qualities as $quality => $value ): ?>
    <oml:quality name="<?php echo $quality; ?>"><?php echo $value; ?></oml:quality>
    <?php endforeach; ?>
  </oml:task>
	<?php endforeach; ?>
</oml:data>