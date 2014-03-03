<?php $count = 0; $icons = array( 'function' => 'fa fa-signal', 'implementation' => 'fa fa-cog', 'dataset' => 'fa fa-list-alt', 'task' => 'fa fa-check' ); ?>

<div class="alert alert-info">Displaying <?php echo count($this->results); ?> popular results. Please use the <a href="search">search page</a> to search through all available entries. </div>

<div class="row">
  <?php if( is_array($this->results) ): foreach( $this->results as $result ): ?>
    <?php if(!property_exists($result, 'type')) $result->type = 'task'; // Only tasks do not natively contain a type field. ?>
        <div class="col-md-6">
      <i class="<?php echo $icons[$result->type]; ?>"></i>&nbsp;<a href="detail/type/<?php echo urlencode($result->type); ?>/name/<?php echo urlencode($result->id); ?>"><?php echo $result->name; ?></a>
    </div>

  <?php endforeach; endif; ?>
</div>
