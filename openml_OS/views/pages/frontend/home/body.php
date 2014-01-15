<!-- <div class="alert alert-error" style="text-align:center;margin-bottom:0px">
  We're still under construction, check back soon! 
</div> -->
<!-- Main hero unit for a primary marketing message or call to action -->
<canvas id="c" width="400" height="400"></canvas>
<div class="marketing" style="margin-top:45px">
<div class="col-md-12">
<div id="logo">OpenML<div id="beta">beta</div></div>
</div>

<div class="col-md-12">
		<form class="form-inline" method="post" action="search">
		  <input type="text" class="form-control" style="width: 50%; height: 30px; font-size: 13pt;" id="openmlsearch" name="searchterms" placeholder="" value="<?php if( isset( $terms ) ) echo $terms; ?>" />
		  <button class="btn btn-primary btn-small" type="submit" style="height: 30px; vertical-align:top; font-size: 8pt;"><i class="fa fa-search fa-lg"></i></button>
		</form>
</div>

<script type="text/javascript">
document.getElementById('openmlsearch').focus()
</script>
<div class="col-md-12">
<div class="stats">
        Search <strong><?php $count = $this->Implementation->query('select count(rid) as count from run');
 echo($count[0]->count); ?></strong> machine learning experiments
        on <strong><?php $count = $this->Implementation->query('select count(did) as count from dataset where isOriginal="true"');
 echo($count[0]->count); ?></strong> datasets
        and <strong><?php $count = $this->Implementation->query('select count(fullName) as count from implementation');
 echo($count[0]->count); ?></strong> implementations
</div>
<p style="margin-top:20px">
<a href="tour" class="btn btn-small btn-bs">Get started</a>
</p>
</div>

</div>
<!-- <div style="margin-bottom:-60px;"></div>  make footer visible on main page -->
