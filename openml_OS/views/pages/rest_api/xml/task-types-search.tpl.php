<oml:task_type xmlns:oml="http://openml.org/openml">
	<oml:id><?php echo $task_type->ttid; ?></oml:id>
	<oml:name><?php echo $task_type->name; ?></oml:name>
	<oml:description><?php echo htmlspecialchars( $task_type->description ); ?></oml:description>
	<oml:creator><?php echo $task_type->creator; ?></oml:creator>
	<?php foreach( getcsv($task_type->contributors) as $c ): ?>
	<oml:contributor><?php echo $c; ?></oml:contributor>
	<?php endforeach;?>
   	<oml:date><?php echo dateNeat($task_type->date); ?></oml:date>
	<?php foreach( $io as $item ): if( $item->template_api != null ): ?>
		<oml:<?php echo $item->io; ?> name="<?php echo $item->name; ?>"><?php echo $item->template_api; ?></oml:<?php echo $item->io; ?>>
	<?php endif; endforeach; ?>
</oml:task_type>
