<div class="row openmlsectioninfo">
  <div class="col-sm-12">
     <?php if(false === strpos($_SERVER['REQUEST_URI'], '/a/flow-qualities/')){ ?>
	<h1>Flow qualities</h1>
	<p>OpenML keeps or computes a range of characteristics about flows which are useful to understand whether they are applicable to certain tasks, or to otherwise study which techniques may be useful in which situations.</p>
	<h2>All qualities</h2>
	<?php	foreach( $this->algoqs as $r ):?>
			<div class="searchresult">
				<a href="a/flow-qualities/<?php echo cleanName($r['name']); ?>"><?php echo $r['name']; ?></a><br />
				<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
				<div class="runStats"><?php echo $r['count']; ?> datasets evaluated</div>
			</div><?php 
		endforeach;
	} 
        else { ?>
	<?php if(!isset( $this->record)) echo 'Sorry, this measure is not known.'; else { ?>
	<h1><?php echo $this->record['name']; ?></h1>
	<p><?php echo $this->record['description']; ?></p>
	<h2>Overview</h2>
		<div class='table-responsive'><table class='table table-striped'>
		<?php	foreach( $this->algoqvals as $r ):?>
			<tr><td><a href="f/<?php echo $r['id'];?>"><?php echo $r['flow_name']; ?></a></td><td><?php echo $r['value'];?></td></tr>
		<?php endforeach; ?> 
		</table></div>
	<?php }} ?>

  </div>
</div> <!-- end openmlsectioninfo -->
