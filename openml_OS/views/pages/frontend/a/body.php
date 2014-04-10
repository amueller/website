<div class="sectionheader">
<div class="sectionlogo"><a href="">OpenML</a></div>
<div class="sectiontitlepurple"><a href="a">Analytics</a></div>
</div>
<div class="bs-docs-container topborder">
    <div class="col-xs-12 col-sm-3 col-md-2 searchbar">
	<!-- Search -->
	<form class="form" method="post" action="r">
	<div class="input-group" style="margin-bottom:7px;">
	  <span class="input-group-addon" style="background-color:#854AB8; color:#FFFFFF; border-color:#854AB8"><i class="fa fa-search fa-fw"></i></span>
	  <input type="text" class="form-control" style="width: 100%; height: 30px; font-size: 11pt;" id="openmlsearch" name="searchterms" placeholder="Search" value="<?php if( $this->terms != false ) echo $this->terms; ?>" />
	</div>
	<h4>Evaluation</h4>
	<ul class="runmenu">		
		<li class="<?php if(false !== strpos($_SERVER['REQUEST_URI'],'a/evaluation-measures')) echo 'active';?>"><a href="a/evaluation-measures">Evaluation measures</a></li>
		<li class="<?php if(false !== strpos($_SERVER['REQUEST_URI'],'a/estimation-procedures')) echo 'active';?>"><a href="a/estimation-procedures">Estimation procedures</a></li>

	<h4>Qualities</h4>
		<li class="<?php if(false !== strpos($_SERVER['REQUEST_URI'],'a/data-qualities')) echo 'active';?>"><a href="a/data-qualities">Data qualities</a></li>
		<li class="<?php if(false !== strpos($_SERVER['REQUEST_URI'],'a/flow-qualities')) echo 'active';?>"><a href="a/flow-qualities">Flow qualities</a></li>
	</ul>

	</div>


    </div> <!-- end col-2 -->

    <div class="col-xs-12 col-sm-9 col-md-10 openmlsectioninfo">
     <div class="tab-content">
      <div class="tab-pane fade in <?php if(false === strpos($_SERVER['REQUEST_URI'],'/a/')) { echo 'active'; } ?>" id="intro">
      <?php 
	if( $this->terms == false) { ?>
      <div class="redheader">
      <h1>Analytics</h1>
      <p>Functions and methods used by OpenML to evaluate flows and measure data properties.</p>
      </div>
      <?php } ?> 
      <h2>Evaluation</h2>
        <div class="searchresult">
        <a href="a/evaluation-measures">Evaluation measures</a><br>
         <div class="teaser">OpenML performs server-side evaluations of model performance, e.g. precision and recall, for all uploaded runs with predictions. This makes sure that all results are evaluated in exactly the same way.</div>
	 <div class="runStats"><?php echo count($this->evals); ?> measures</div>
	</div>
        <div class="searchresult">
	<a href="a/estimation-procedures">Performance estimation procedures</a><br>
	 <div class="teaser">For predictive models, OpenML will automatically generate train-test splits based on input datasets. This makes sure that the evaluations run by different people are directly comparable.</div>
	 <div class="runStats"><?php echo count($this->procs); ?> procedures</div>
        </div>

      <h2>Qualities</h2>
        <div class="searchresult">
        <a href="a/data-qualities">Data qualities</a><br>
         <div class="teaser">OpenML automatically computes a range of characteristics about each new dataset (for known data formats). This helps to study and understand under which conditions algorithms perform well (or badly).</div>
	 <div class="runStats"><?php echo count($this->dataqs); ?> qualities</div>
	</div>
        <div class="searchresult">
	<a href="a/flow-qualities">Flow qualities</a><br>
	 <div class="teaser">OpenML keeps or computes a range of characteristics about flows which are useful to understand whether they are applicable to certain tasks, or to otherwise study which techniques may be useful in which situations.</div>
	 <div class="runStats"><?php echo count($this->algoqs); ?> qualities</div>
        </div>


     </div> <!-- end intro tab -->
      
        <!-- Eval measures -->     
	<div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/evaluation-measures')) echo 'active';?>">
  		<?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/evaluation-measures')) subpage('evaluation-measures'); ?>
	</div>
        <!-- Perf estimators -->     
	<div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/estimation-procedures')) echo 'active';?>">
  		<?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/estimation-procedures')) subpage('estimation-procedures'); ?>
	</div>
        <!-- Data qualities -->     
	<div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/data-qualities')) echo 'active';?>">
  		<?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/data-qualities')) subpage('data-qualities'); ?>
	</div>
        <!-- Flow qualities -->     	
	<div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/flow-qualities')) echo 'active';?>">
  		<?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/flow-qualities')) subpage('flow-qualities'); ?>
	</div>

     </div> <!-- end tabs content -->


    </div> <!-- end col-9 -->
</div> <!-- end container -->
