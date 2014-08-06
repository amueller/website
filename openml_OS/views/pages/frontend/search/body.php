<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1">

    <div class="col-sm-12 col-md-3 searchbar">
        <!-- Upload stuff -->
      <ul class="menu">
	<li><a href="search?q=<?php echo $this->terms;?>" <?php if(!$this->filtertype) echo 'class="selected"';?>><i class="fa fa-fw fa-circle-thin"></i> Everything<span class="counter"><?php echo $this->results['facets']['type']['total'];?></span></a></li>
	<?php
	  $stack = array();
      	  foreach( $this->results['facets']['type']['terms'] as $f ) { array_push($stack,$f['term']); ?>
          	<li><a href="search?q=<?php echo $this->terms . '&type=' . $f['term']; ?>" <?php if($this->filtertype == $f['term']) echo 'class="selected"';?>><i class="fa-fw <?php echo $this->icons[$f['term']];?>"></i> <?php echo str_replace('_',' ', ucfirst($f['term']));?><span class="counter"><?php echo $f['count'];?></span></a></li>	
	<?php }
	  foreach( $this->icons as $f => $i ){
		if(!in_array($f, $stack)){ ?>
          		<li><a href="search?q=<?php echo $this->terms . '&type=' . $f; ?>" <?php if($this->filtertype == $f) echo 'class="selected"';?>><i class="fa-fw <?php echo $i;?>"></i> <?php echo str_replace('_',' ', ucfirst($f));?><span class="counter"></span></a></li>
			
	<?php }} ?>
       </ul>
       <ul class="menu">
       <li><a href="search?q=match_all<?php echo ($this->filtertype ? '&type='.$this->filtertype : ''); ?>"><i class="fa fa-fw fa-expand"></i> Show all</a></li>
       <li><a data-toggle="collapse" href="#filters"><i class="fa fa-search-plus fa-fw"></i> Filter results</a></li>
       </ul>
       <?php if($this->filtertype) subpage($this->filtertype);
             else subpage("everything"); ?>

    </div> <!-- end col-2 -->
    <div class="col-sm-12 col-md-9 openmlsectioninfo">
      <h1>Results for <b><?php echo str_replace('match_','',$this->coreterms); if($this->coreterms=='') echo '*'?></b></h1>

      <?php if($this->filtertype and in_array($this->filtertype, array("run", "task", "data", "flow"))){ ?>
        <a type="button" class="btn btn-default" style="float:right; margin-left:10px;" href="
	<?php
		if($this->listids) // toggle off
			$att = addToGET(array( 'listids' => false, 'size' => false));	
		else // toggle on
			$att = addToGET(array( 'listids' => '1', 'size' => $this->results['hits']['total']));		
		echo 'search?'.$att; ?>"><i class="fa fa-list-ol"></i></a><?php } ?>	


      <?php subpage('results');?> 
    </div>
  </div> 
</div>
</div>

