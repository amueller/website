<div class="row openmlsectioninfo">
  <div class="col-xs-12">
     <h1 class="pull-left"><a href="f"><i class="fa fa-cogs"></i></a> <?php echo $this->record->{'name'}; ?></h1>
     <ul class="hotlinks">
	 <li><a><i class="fa fa-cloud-download fa-2x"></i></a></li>
	 <li><a><i class="fa fa-book fa-2x"></i></a></li>
	 <li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>/json"><i class="fa fa-file-code-o fa-2x"></i></a></li>
	 <li>   <div class="version" style="margin-bottom: -17px;">
		        <select class="selectpicker" data-width="auto" onchange="location = this.options[this.selectedIndex].value;">
			  <?php foreach( $this->versions as $k => $v ) { ?>
				<option value="<?php echo 'f/'.$k;?>" <?php echo $v == $this->record->{'version'} ? 'selected' : '';?>>v. <?php echo $v; ?></option>
			  <?php } ?>
			</select>
	        </div></li>
     </ul>
  </div>
  <div class="col-xs-12">
     <p class="description <?php if(strlen($this->record->{'description'})>400) echo 'hideContent';?>"><?php
	echo $this->record->{'description'} ? $this->record->{'description'} : 'No description.';
	?></p>
  </div>
    <div class="col-sm-6">
	    <h2>Attribution</h2>
            <div class="table-responsive">
	    <table class="table table-striped"><tbody>
	    <tr><td>Author(s)</td><td><?php echo $this->record->{'creator'} ?></td></tr>
	    <tr><td>Contributor(s)</td><td><?php echo $this->record->{'contributor'} ?></td></tr>
	    <tr><td>Uploader</td><td><?php echo $this->record->{'uploader'} ?></td></tr>	
	    <tr><td>Licence</td><td><?php echo $this->record->{'licence'} ?></td></tr>
	    <tr><td>Citation</td><td><a>Show</a></td></tr>    
	    <tr><td>Dependencies</td><td><?php echo $this->record->{'dependencies'} ?></td></tr>
	    </tbody></table></div>

    </div> <!-- end col-md-6-->

    <?php
          $components = $this->Implementation->getComponents($this->record);
	  if (is_array($components) and sizeof($components)>0){
     ?>
     <div class="col-sm-6">
			<h2>Components</h2>
			<div class="table-responsive">
				<table class="table table-striped">
				<?php 
					foreach( $components as $c ){
						echo "<tr><td>" . $c->{'identifier'} . "</td><td><a href='f/" . $c->{'implementation'}->{'id'} . "'>" . $c->{'implementation'}->{'fullName'} . "</a></td></tr>";
					}
				?>
				</table>
			</div>
      </div> <!-- end col-md-6 -->
      <?php } /*endif components*/ ?> 

     <div class="col-sm-6">
			<h2>Parameters</h2>
			<div class="table-responsive">
				<table class="table table-striped">
				<?php $params = $this->Implementation->query("SELECT fullname, name, implementation_id, description, defaultValue, recommendedRange from input where implementation_id=" . $this->record->{'id'});
				if (is_array($params)){
				foreach( $params as $r ) {
					if (strlen($r->{'recommendedRange'})>0){
					echo "<tr><td>" . $r->{'name'} . "</td><td>" . $r->{'description'} . "</td><td><div class='tip default' data-toggle='tooltip' data-placement='left' title='Default value'><i class='fa fa-hand-o-right'></i> " . $r->{'defaultValue'} . "</div><br><div class='tip recommendedrange' data-toggle='tooltip' data-placement='left' title='Recommended range'><i class='fa fa-thumbs-o-up'></i> ". $r->{'recommendedRange'} . "</div></td></tr>";}
					else{
					echo "<tr><td>" . $r->{'name'} . "</td><td>" . $r->{'description'} . "</td><td><div class='tip default' data-toggle='tooltip' data-placement='left' title='Default value'><i class='fa fa-hand-o-right'></i> " . $r->{'defaultValue'} . "</div></td></tr>";}
				}}
				?>
				</table>
			</div>
      </div> <!-- end col-md-6 -->

	  <div class="qualities col-xs-12">
		  <?php $result = $this->Implementation->query("SELECT aq.quality, q.description, aq.value, q.showonline from algorithm_quality aq, quality q where aq.quality=q.name and implementation_id=" . $this->record->{'id'});
			$qtable = "";
			if (is_array($result)){
			echo '<h3>Properties</h3>';

			foreach( $result as $r ) {
				if ($r->{'showonline'}=='true'){
					if(is_numeric($r->{'value'})){
						echo "<div class='qualcell col-xs-2'><span class='qualitynumeric'>" . round($r->{'value'},2) . "</span><br><a class='dataprop' href='a/flow-qualities/".cleanName($r->{'quality'})."'>" .  $r->{'quality'} . "</a></div>";
					} elseif($r->{'value'}=='true'){
						echo "<div class='qualcell col-xs-2'><span class='qualitytrue'><i class='fa fa-check fa-lg'></i></span><br><a class='dataprop' href='a/flow-qualities/".cleanName($r->{'quality'})."'>" .  $r->{'quality'} . "</a></div>";
					} elseif($r->{'value'}=='false'){
						echo "<div class='qualcell col-xs-2'><span class='qualityfalse'><i class='fa fa-times fa-lg'></i></span><br><a class='dataprop' href='a/flow-qualities/".cleanName($r->{'quality'})."'>" .  $r->{'quality'} . "</a></div>";
					}
				} else {
				$qtable .= "<tr><td><a href='a/flow-qualities/".cleanName($r->{'quality'})."'>" . $r->{'quality'} . "</a></td><td>";
 					if(is_numeric($r->{'value'})){ $qtable .= round($r->{'value'},2); }
					else{ $qtable .= $r->{'value'};}
				$qtable .= "</td></tr>";}
			}} ?>
    		 </div><div class="col-xs-12">
		 <?php 
			if(strlen($qtable)>1){
				echo "<a data-toggle='collapse' href='#algoquals'><i class='fa fa-caret-right'></i> Show more</a><div id='algoquals' class='collapse'><div class='table-responsive'><table class='table table-striped'>" . $qtable . "</table></div></div>";}
		 ?>
		 </div>

	        <div class="col-xs-12">
		<h3>Results (per task type)</h3> 
	    <?php
	      $taskparams['index'] = 'openml';
	      $taskparams['type']  = 'task_type';
	      $taskparams['body']['query']['match_all'] = array();
	      $alltasks = $this->searchclient->search($taskparams)['hits']['hits'];
	    ?>
		<select class="selectpicker" data-width="auto" onchange="current_task = this.value; oTableRuns.fnDraw(true); redrawchart();">
	    <?php foreach($alltasks as $h){?>
                <option value="<?php echo $h['_id']; ?>"><?php echo $h['_source']['name']; ?></option>
	    <?php } ?>
		</select>

		<h2>Performance evaluation</h2>
		Evaluation measure:
				<select class="selectpicker" data-width="auto" onchange="evaluation_measure = this.value; oTableRuns.fnDraw(true); updateTableHeader(); redrawchart();">
					<?php foreach($this->allmeasures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
				</select>
		<div style="float:right">
		Parameter:
				<select class="selectpicker" data-width="auto" onchange="selected_parameter = this.value; oTableRuns.fnDraw(true); redrawchart();">
					<option value="none" selected>none</option>
					<?php foreach($params as $r): ?>
					<option value="<?php echo $r->{'implementation_id'}.'_'.$r->{'name'};?>"><?php echo str_replace('_', ' ', $r->{'name'} );?></option>
					<?php endforeach; ?>
				</select>
		</div>
				
			<div id="code_result_visualize" style="width: 100%">Plotting chart <i class="fa fa-spinner fa-spin"></i></div>

			<div>   <div class="table-responsive">
				<table id="datatable_main" class="table table-bordered table-condensed table-responsive">
					<?php echo generate_table( 
								array('img_open' => '', 
										'rid' => 'run id', 
										'sid' => 'setup id', 
										'name' => 'Name', 
										'value' => str_replace('_',' ',$this->current_measure), ) ); ?>
				</table></div>
			</div>

<div class="modal fade" id="runModal" role="dialog" tabindex="-1" aria-labelledby="Run detail" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
		</div> <!-- end tab-runs -->
		
	</div> <!-- end col-md-12 -->

    <div id="disqus_thread">Loading discussions...</div>
    <script type="text/javascript">
        var disqus_shortname = 'openml'; // forum name
	var disqus_category_id = '3353608'; // Data category
	var disqus_title = '<?php echo $this->record->{'name'}; ?>'; // Data name
	var disqus_url = 'http://openml.org/f/<?php echo $this->id; ?>'; // Data url

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
 


</div> <!-- end openmlsectioninfo -->
