<div class="row openmlsectioninfo">
  <div class="col-sm-12">
	  <?php if (isset($this->record['name'])){ ?>
	  <h1><a href="t"><i class="fa fa-flag"></i></a> <?php echo $this->record['name'] ?></h1>
          <p><?php echo $this->record['description']; ?></p>
  </div>
  <div class="col-sm-12">
		<h2>Inputs</h2>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'input' || $r['requirement'] == 'hidden') continue; ?>
			<tr><td><?php echo $r['name']; ?></td>
			    <td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a></td>
			    <td><?php echo $r['description']; ?></td>
			    <td><?php echo $r['requirement']; ?></td></tr>
		<?php endforeach; ?>
		</table></div>

		<h3>Outputs</h3>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'output' || $r['requirement'] == 'hidden') continue; ?>
			<tr><td><?php echo $r['name']; ?></td>
			    <td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a></td>
			    <td><?php echo $r['description']; ?></td>
			    <td><?php echo $r['requirement']; ?></td></tr>
		<?php endforeach; ?>
		</table></div>

		<h3>Attribution</h3>
		    <div class="table-responsive">
		    <table class="table table-striped"><tbody>
		    <tr><td width="40px">Author(s)</td><td><?php echo $this->record['authors'] ?></td></tr>
		    <tr><td width="40px">Contributor(s)</td><td><?php echo $this->record['contributors'] ?></td></tr>
		    </tbody></table></div>
		<?php } else { ?>Sorry, this task type is unknown.<?php } ?>

        <h2>Tasks</h2>
	<?php
	   if(false !== strpos($_SERVER['REQUEST_URI'],'/t/')) {
	    loadpage('search', true, 'pre'); 
	    loadpage('search/subpage', true, 'results');
	   } 
        ?> 
   </div> <!-- end col-md-12 -->
</div> <!-- end openmlsectioninfo -->
