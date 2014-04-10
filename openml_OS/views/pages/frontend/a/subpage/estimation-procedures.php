<div class="row openmlsectioninfo">
  <div class="col-sm-12">
     <?php if(false === strpos($_SERVER['REQUEST_URI'], '/a/estimation-procedures/')){ ?>
	<h1>Performance estimation procedures</h1>
	<p>For predictive models, OpenML will automatically generate train-test splits based on input datasets. This makes sure that the evaluations run by different people are directly comparable.</p>
	<h2>All procedures</h2>
	<?php	foreach( $this->procs as $r ):?>
			<div class="searchresult">
				<a href="a/estimation-procedures/<?php echo cleanName($r['name']); ?>"><?php echo $r['name'];?></a><br />
				<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
				<div class="runStats"><?php
					 if(strlen($r['folds'])) echo $r['folds'] . ' folds, ';
					 if(strlen($r['repeats'])) echo $r['repeats'] . ' repeats';
					 if(strlen($r['percentage'])) echo ', '.$r['percentage'] . '% holdout';
					 if($r['stratified']) echo ', stratified';?>
				</div>
			</div><?php 
		endforeach;
	} 
        else { ?>
	<?php if(!isset( $this->record)) echo 'Sorry, this procedure is not known.'; else { ?>
	<h1><?php echo $this->record['name']; ?></h1>
	<p><?php echo $this->record['description']; ?></p>
	<ul class="hotlinks">
		<li><a href="https://github.com/openml/OpenML/tree/master/Java/OpenmlWebapplication/src/org/openml/webapplication/generatefolds"><i class="fa fa-gears"></i> View code</a></li>
	</ul>
	<h2>Properties</h2>
		<div class='table-responsive'><table class='table table-striped'>
		<tr><td>Folds</td><td><?php echo $this->record['folds']; ?></td></tr>
		<tr><td>Repeats</td><td><?php echo $this->record['repeats']; ?></td></tr>
		<tr><td>Holdout percentage</td><td><?php echo $this->record['percentage']; ?></td></tr>
		<tr><td>Stratification</td><td><?php echo $this->record['stratified'];?></td></tr>
		</table></div>


	<?php }} ?>

  </div>
</div> <!-- end openmlsectioninfo -->
