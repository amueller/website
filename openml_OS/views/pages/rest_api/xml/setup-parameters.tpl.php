<oml:setup_parameters xmlns:oml="http://openml.org/openml">
	<oml:parameters>
		<?php foreach( $parameters as $p ): ?>
			<oml:parameter>
				<oml:full_name><?php echo $p->input; ?></oml:full_name>
				<oml:parameter_name><?php echo $p->name; ?></oml:parameter_name>
				<oml:general_name><?php echo $p->generalName; ?></oml:general_name>
				<oml:data_type><?php echo $p->dataType; ?></oml:data_type>
				<oml:default_value><?php echo $p->defaultValue; ?></oml:default_value>
				<oml:min><?php echo $p->min; ?></oml:min>
				<oml:max><?php echo $p->max; ?></oml:max>
				<oml:value><?php echo $p->value; ?></oml:value>
			</oml:parameter>
		<?php endforeach; ?>
	</oml:parameters>
</oml:setup_parameters>
