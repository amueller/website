<oml:run xmlns:oml="http://openml.org/openml">
  <oml:run_id><?php echo $source->rid; ?></oml:run_id>
  <oml:uploader><?php echo $source->uploader; ?></oml:uploader>
  <oml:task_id><?php echo $source->task_id; ?></oml:task_id>
  <oml:implementation_id><?php echo $source->setup->implementation_id; ?></oml:implementation_id>
  <oml:setup_id><?php echo $source->setup->sid; ?></oml:setup_id>
  <?php if($source->error !== null):?> <oml:error_message><?php echo $source->error; ?></oml:error_message> <?php endif; ?>
  <oml:setup_string><?php echo $source->setup->setup_string; ?></oml:setup_string>
  <?php if(is_array($source->inputSetting)) foreach( $source->inputSetting as $parameter ): ?>
    <oml:parameter_setting>
      <oml:name><?php echo $parameter->name;?></oml:name>
      <oml:value><?php echo $parameter->value;?></oml:value>
    </oml:parameter_setting>
  <?php endforeach; ?>
  <?php if(is_array($source->inputData)): ?>
    <oml:input_data>
    <?php foreach( $source->inputData as $d ): ?>
      <oml:dataset>
        <oml:did><?php echo $d->did; ?></oml:did>
        <oml:name><?php echo $d->name; ?></oml:name>
        <oml:url><?php echo $d->url; ?></oml:url>
      </oml:dataset>
    <?php endforeach; ?>
    </oml:input_data>  
  <?php endif; ?>
  <?php if(is_array($source->outputData) ): ?>
    <oml:output_data>
    <?php if(array_key_exists('dataset',$source->outputData) ): ?>
      <?php foreach( $source->outputData['dataset'] as $d ): ?>
      <oml:dataset>
        <oml:did><?php echo $d->did; ?></oml:did>
        <oml:name><?php echo $d->name; ?></oml:name>
        <oml:url><?php echo $d->url; ?></oml:url>
      </oml:dataset>
    <?php endforeach; ?>
    <?php endif; if(array_key_exists('runfile',$source->outputData) ): ?>
      <?php foreach( $source->outputData['runfile'] as $r ): ?>
      <oml:file>
        <oml:did><?php echo $r->did; ?></oml:did>
        <oml:name><?php echo $r->field; ?></oml:name>
        <oml:url><?php $f = $this->File->getById($r->file_id); echo fileRecordToUrl( $f ); ?></oml:url>
      </oml:file>
      <?php endforeach; ?>
    <?php endif; if(array_key_exists('evaluations', $source->outputData) ): ?>
      <?php foreach( $source->outputData['evaluations'] as $e ): ?>
        <oml:evaluation>
          <oml:name><?php echo $e->{'function'}; ?></oml:name>
          <oml:implementation><?php echo $e->{'implementation_id'}; ?></oml:implementation>
          <?php if ($e->value != null): ?><oml:value><?php echo $e->value; ?></oml:value><?php endif; ?>
          <?php if ($e->array_data != null): ?><oml:array_data><?php echo $e->array_data; ?></oml:array_data><?php endif; ?>
        </oml:evaluation>
      <?php endforeach; ?>
    <?php endif; ?>
  </oml:output_data>
  <?php endif; ?>
</oml:run>
