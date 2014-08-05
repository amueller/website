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
	<h1>Elasticsearch indexer</h1>
	Status: <?php if($this->elasticsearch->test()) echo 'Connection successful. Happy indexing!'; else echo 'Connection failed. Likely, Elasticsearch is not running.'; ?>
	<h2>Build indexes</h2>
	<form method="post" action="">
	<?php foreach( $this->types as $t ): ?>
                  <input type="checkbox" class="check_setups" name="types[]" value="<?php echo $t; ?>" <?php if(in_array($t,$this->index_types)) echo 'checked="yes";'?>/>&nbsp;<?php echo $t; ?><br>
        <?php endforeach; ?><br />
	<input class="btn btn-primary" type="submit" value="Rebuild indexes"/>
        </form>
	<h2>Reinitialize indexes</h2>
	<form method="post" action="">
	<?php foreach( $this->default_types as $t ): ?>
                  <input type="checkbox" class="check_setups" name="inittypes[]" value="<?php echo $t; ?>" <?php if(in_array($t,$this->init_types)) echo 'checked="yes";'?>/>&nbsp;<?php echo $t; ?><br>
        <?php endforeach; ?><br />
	<input class="btn btn-primary" type="submit" value="Reinitialize indexes"/>
        </form>

    </div>
  </div>
</div>
