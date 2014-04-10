<div class="row openmlsectioninfo">
  <div class="col-sm-12">
     <?php if(false === strpos($_SERVER['REQUEST_URI'], '/a/data-qualities/')){ ?>
	<h1>Data qualities</h1>
	<p>OpenML automatically computes a range of characteristics about each new dataset (for known data formats). This helps to study and understand under which conditions algorithms perform well (or badly).</p>
	<h2>All qualities</h2>
	<?php	foreach( $this->dataqs as $r ):?>
			<div class="searchresult">
				<a href="a/data-qualities/<?php echo cleanName($r['name']); ?>"><?php echo $r['name']; ?></a><br />
				<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
				<div class="runStats"><?php echo $r['count']; ?> datasets evaluated</div>
			</div><?php 
		endforeach;
	} 
        else { ?>
	<?php if(!isset( $this->record)) echo 'Sorry, this measure is not known.'; else { ?>
	<h1><?php echo $this->record['name']; ?></h1>
	<p><?php echo $this->record['description']; ?></p>
	<ul class="hotlinks">
		<li><a href="https://github.com/openml/OpenML/tree/master/Java/OpenmlWebapplication/src/org/openml/webapplication/features"><i class="fa fa-gears"></i> View code</a></li>
	</ul>
	<h2>Overview</h2>
		<div class="table-responsive"><table class="table table-striped">
		<tbody>
		<?php	foreach( $this->dataqvals as $r ):?>
			<tr><td><a href="d/<?php echo $r['did'];?>"><?php echo $r['data_name'] . ' ('. $r['data_version'] . ')'; ?></a></td><td><?php echo $r['value'];?></td></tr>
		<?php endforeach; ?>
		</tbody> 
		</table></div>
	<?php }} ?>

  </div>
</div> <!-- end openmlsectioninfo -->
