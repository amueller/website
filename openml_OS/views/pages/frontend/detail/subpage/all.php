<?php $count = 0; $icons = array( 'function' => 'icon-signal', 'implementation' => 'icon-cog', 'dataset' => 'icon-list-alt', 'task' => 'icon-check' ); ?>

<div class="alert alert-info">Displaying <?php echo count($this->results); ?> popular results. Please use the <a href="search">search page</a> to search through all available entries. </div>

<div class="row">
	<?php foreach( $this->results as $result ): ?>
		<?php if(!array_key_exists($result->type, $icons))$result->type = 'task'; // TODO: hack, fix ?>
        <div class="col-md-6">
			<i class="<?php echo $icons[$result->type]; ?>"></i>&nbsp;<a href="detail/type/<?php echo urlencode($result->type); ?>/name/<?php echo urlencode($result->id); ?>"><?php echo $result->name; ?></a>
		</div>

	<?php endforeach; ?>
</div>
