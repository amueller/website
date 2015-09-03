<?php foreach( $source as $bib ): ?>
<oml:bibliographical_reference>
	<oml:citation><?php echo htmlentities($bib->citation); ?></oml:citation>
	<oml:url><?php echo htmlentities($bib->url); ?></oml:url>
</oml:bibliographical_reference>
<?php endforeach; ?>
