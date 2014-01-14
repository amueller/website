<?php
if($this->function_count>0) {
	echo '<div class="searchstats">Showing ' . $this->function_count . ' of ' . $this->function_total . ' results (' . $this->time . ' seconds)</div>';	
	
	foreach( $this->results_all as $r ): if($r['type'] != 'function') continue;?>
		<div class="searchresult">
			<a href="detail/type/<?php echo urlencode($r['type']); ?>/name/<?php echo urlencode($r['name']); ?>"><i class="<?php echo $r['icon']; ?>"></i>  <?php echo $r['name']; ?></a><br />
			<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
			<div class="stats"></div>
		</div><?php 
	endforeach;
} else {
	if( $this->terms != false ) {
		o('no-search-results');
	} else {
    o('no-results');
  }
}
?>
