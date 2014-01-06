<oml:run xmlns:oml="http://openml.org/openml">
	<oml:run_id><?php echo $source->rid; ?></oml:run_id>
	<oml:uploader><?php echo $source->uploader; ?></oml:uploader>
	<oml:task_id><?php echo $source->task_id; ?></oml:task_id>
	<oml:implementation_id><?php echo $source->setup->implementation_id; ?></oml:implementation_id>
  <oml:setup_id><?php echo $source->setup->sid; ?></oml:setup_id>


		<?php if(is_array($source->inputSetting)) foreach( $source->inputSetting as $parameter ): ?>
	    <oml:parameter_setting>
        <oml:name><?php echo $parameter->input;?></oml:name>
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
	  <?php foreach( $source->outputData['dataset'] as $d ): ?>
		 <oml:dataset>
        <oml:did><?php echo $d->did; ?></oml:did>
        <oml:name><?php echo $d->name; ?></oml:name>
        <oml:url><?php echo $d->url; ?></oml:url>
      </oml:dataset>
	  <?php endforeach; ?>
	  <?php foreach( $source->outputData['evaluations'] as $e ): ?>
		  <oml:evaluation>
			  <oml:name><?php echo $e->{'function'}; ?></oml:name>
			  <oml:implementation><?php echo $e->{'implementation_id'}; ?></oml:implementation>
			  <oml:value><?php echo $e->value; ?></oml:value>
		  </oml:evaluation>
	  <?php endforeach; ?>
	</oml:output_data>
  <?php endif; ?>
</oml:run>
