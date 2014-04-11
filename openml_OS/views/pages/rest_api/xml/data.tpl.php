<oml:data xmlns:oml="http://openml.org/openml">
  <?php foreach( $datasets as $d ): ?>
  <oml:did><?php echo $d->did; ?></oml:did>
  <?php endforeach; ?>
</oml:data>