<div class="container-fluid topborder">
  <div class="row">
   <div class="col-lg-10 col-sm-12 col-lg-offset-1 openmlsectioninfo">
     <div class="tab-content">
      <div class="tab-pane fade in <?php if(false === strpos($_SERVER['REQUEST_URI'],'/a/')) { echo 'active'; } ?>" id="intro">
      <?php 
	if( $this->terms == false) { ?>
      <div class="redheader">
      <h1><i class="fa fa-bar-chart-o"></i> Analytic measures</h1>
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
  
        <!-- Quality values -->     	
	<div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/quality-value')) echo 'active';?>">
  		<?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/quality-value')) subpage('quality-value'); ?>
	</div>
        <!-- Flow qualities -->     	
	<div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/flow-qualities')) echo 'active';?>">
  		<?php if(false !== strpos($_SERVER['REQUEST_URI'], '/a/flow-qualities')) subpage('flow-qualities'); ?>
	</div>

   </div> <!-- end tabs content -->
    </div> <!-- end col-10 -->
  </div> <!-- end row -->
</div> <!-- end container -->
