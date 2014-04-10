<div class="row openmlsectioninfo">
  <div class="col-sm-12">
     <?php if(false === strpos($_SERVER['REQUEST_URI'], '/a/evaluation-measures/')){ ?>
	<h1>Evaluation measures</h1>
	<p>OpenML performs server-side evaluations of model performance, e.g. precision and recall, for all uploaded runs with predictions. This makes sure that all results are evaluated in exactly the same way.</p>
	<h2>All measures</h2>
	<?php	foreach( $this->evals as $r ):?>
			<div class="searchresult">
				<a href="a/evaluation-measures/<?php echo cleanName($r['name']); ?>"><?php echo $r['name']; ?></a><br />
				<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
				<div class="runStats">[<?php echo $r['min'];?>,<?php echo $r['max'];?>] <?php echo $r['unit'];?><?php if( 1 == $r['higherIsBetter']) echo ', higher is better'; elseif( 0 == $r['higherIsBetter']) echo ', lower is better'; ?></div>
			</div><?php 
		endforeach;
	} 
        else { ?>
	<h1><?php echo str_replace('-',' ',$this->name); ?></h1>
	<?php if(!isset( $this->record)) echo 'Sorry, this measure is not known.'; else { ?>
	<p><?php echo $this->record['description']; ?></p>
	<ul class="hotlinks">
		<li><a href="https://github.com/openml/OpenML/tree/master/Java/OpenmlWebapplication/src/org/openml/webapplication/evaluate"><i class="fa fa-gears"></i> View code</a></li>
	</ul>
	<h2>Properties</h2>
		<div class='table-responsive'><table class='table table-striped'>
		<tr><td>Minimum value</td><td><?php echo $this->record['min']; ?></td></tr>
		<tr><td>Maximum value</td><td><?php echo $this->record['max']; ?></td></tr>
		<tr><td>Unit</td><td><?php echo $this->record['unit']; ?></td></tr>
		<tr><td>Optimization</td><td><?php if( 1 == $this->record['higherIsBetter']) echo 'Higher is better'; elseif( 0 == $this->record['higherIsBetter']) echo 'Lower is better'; ?></td></tr>

		</table></div>


	<?php }} ?>

  </div>
</div> <!-- end openmlsectioninfo -->
