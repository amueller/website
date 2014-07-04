<?php
if( $this->terms != false ) {
	if($this->total_count>0) {
		echo '<div class="searchstats">Found ' . $this->total_count . ' results (' . $this->time . ' seconds)</div>';	
		
		foreach( $this->results_all as $r ):?>
			<div class="searchresult">
				<a href="detail/type/<?php echo urlencode($r['type']); ?>/name/<?php echo urlencode($r['name']); ?>"><i class="<?php echo $r['icon']; ?>"></i>  <?php echo $r['name']; ?></a><br />
				<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
				<div class="runStats"><?php echo $r['runs'] . ' runs'; ?></div>
			</div><?php 
		endforeach;
	} else {
		o('no-search-results');
	}
} else{?>
  <div style="text-align:center">
    <a href="detail">Need inspiration?</a>
  </div>
<?php
}
?>
