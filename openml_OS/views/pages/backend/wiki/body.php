<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1 openmlsectioninfo">
	<?php if($this->messages) { ?>
	<div class="alert alert-success" role="alert">
	<?php foreach( $this->messages as $m ):
                  echo $m.' <br>';
              endforeach; ?><br />
	</div>
	<?php } ?>
<div class="col-lg-12">
	<h1>Wiki manager</h1>
</div>
<div class="col-sm-12">
	<h3>Export database to wiki</h2>
	<p>Warning. This will overwrite the wiki, possibly losing recent edits made by users.</p>
	<form method="post" action="">
		<input type="text" name="id" placeholder="Dataset id (or 'all' for all)"/>
		<input class="btn btn-primary" type="submit" value="Export to wiki"/>
        </form>
</div>

    </div>
  </div>
</div>
