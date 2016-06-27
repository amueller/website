<oml:setup_parameters xmlns:oml="http://openml.org/openml">
<?php foreach( $parameters as $p ): ?>
	<oml:parameter>
		<oml:full_name><?php echo $p->fullName; ?></oml:full_name>
		<oml:parameter_name><?php echo $p->name; ?></oml:parameter_name>
		<oml:data_type><?php echo $p->dataType; ?></oml:data_type>
		<oml:default_value><?php echo $p->defaultValue; ?></oml:default_value>
		<oml:value><?php echo $p->value; ?></oml:value>
	</oml:parameter>
<?php endforeach; ?>
</oml:setup_parameters>
