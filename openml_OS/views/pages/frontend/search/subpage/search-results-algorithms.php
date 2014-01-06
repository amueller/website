<?php
if($this->implementation_count>0) {
	echo '<div class="searchstats">Showing ' . $this->implementation_count . ' of ' . $this->implementation_total . ' results (' . $this->time . ' seconds)</div>';	
	
	foreach( $this->results_all as $r ): if($r['type'] != 'implementation') continue;?>
		<div class="searchresult">
			<a href="detail/type/<?php echo urlencode($r['type']); ?>/name/<?php echo urlencode($r['name']); ?>"><i class="<?php echo $r['icon']; ?>"></i>  <?php echo $r['name']; ?></a><br />
			<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
			<div class="runStats"><?php echo $r['runs'] . ' runs'; ?></div>
		</div><?php 
	endforeach;
} else {
	if( $this->terms != false ) {
		o('no-search-results');
	}
}
?>
