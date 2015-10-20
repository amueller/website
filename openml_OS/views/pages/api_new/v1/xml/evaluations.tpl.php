<oml:evaluations xmlns:oml="http://openml.org/openml">
  <?php foreach( $evaluations as $e ): ?>
  <oml:evaluation>
    <oml:run_id><?php echo $e->rid; ?></oml:run_id>
    <oml:function><?php echo $e->{'function'}; ?></oml:function>
    <oml:value><?php echo $e->value; ?></oml:value>
    <oml:array_data><?php echo $e->array_data; ?></oml:array_data>
  </oml:evaluation>
  <?php endforeach; ?>
</oml:evaluations>
