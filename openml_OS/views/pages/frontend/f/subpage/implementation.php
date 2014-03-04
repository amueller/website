<div class="row openmlsectioninfo">
  <div class="col-sm-12">
	  <h1><?php echo $this->record->{'name'}; ?></h1>
  </div>
  <div class="row">
  <div class="col-sm-12">
  <div class="col-md-12">

     <p><?php echo $this->record->{'description'} ?></p>
     <ul class="hotlinks">
	 <li><a><i class="fa fa-cloud-download fa-2x"></i></a><br>Code</li>
	 <li><a><i class="fa fa-book fa-2x"></i></a><br>Paper/preprint</li>
	 <li>   <div class="version" style="margin-bottom: -10px;">
		        <select class="selectpicker" data-width="auto">
			  <option><?php echo $this->record->{'version'}; ?></option>
			</select>		
	        </div><br>Version</li>
     </ul>

  </div>
  </div>
  </div>
  <div class="row">
  <div class="col-sm-12">
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
     <div class="col-sm-6">
			<h2>Parameters</h2>
			<div class="table-responsive">
				<table class="table table-striped">
				<?php $result = $this->Implementation->query("SELECT name, generalName, defaultValue, suggestedValues from input where implementation_id=" . $this->record->{'id'});
				if (is_array($result)){
				foreach( $result as $r ) {
					if (strlen($r->{'suggestedValues'})>0){
					echo "<tr><td>" . $r->{'name'} . "</td><td>" . $r->{'generalName'} . "</td><td><div class='tip default' data-toggle='tooltip' data-placement='left' title='Default value'><i class='fa fa-hand-o-right'></i> " . $r->{'defaultValue'} . "</div><br><div class='tip recommendedrange' data-toggle='tooltip' data-placement='left' title='Recommended range'><i class='fa fa-thumbs-o-up'></i> ". $r->{'suggestedValues'} . "</div></td></tr>";}
					else{
					echo "<tr><td>" . $r->{'name'} . "</td><td>" . $r->{'generalName'} . "</td><td><div class='tip default' data-toggle='tooltip' data-placement='left' title='Default value'><i class='fa fa-hand-o-right'></i> " . $r->{'defaultValue'} . "</div></td></tr>";}
				}}
				?>
				</table>
			</div>
      </div> <!-- end col-md-6 -->
   </div>
   </div> <!-- end row -->

    	<div class="row">
	  <div class="col-xs-12">
	  <div class="qualities col-xs-12">
		<h3>Properties</h3>

		  <?php $result = $this->Implementation->query("SELECT aq.quality, q.description, aq.value, q.showonline from algorithm_quality aq, quality q where aq.quality=q.name and implementation_id=" . $this->record->{'id'});
			$qtable = "";
			if (is_array($result)){
			foreach( $result as $r ) {
				if ($r->{'showonline'}=='true'){
					if(is_numeric($r->{'value'})){
						echo "<div class='qualcell col-xs-2'><span class='qualitynumeric'>" . round($r->{'value'},2) . "</span><br>" . $r->{'quality'} . "</div>";
					} elseif($r->{'value'}=='true'){
						echo "<div class='qualcell col-xs-2'><span class='qualitytrue'><i class='fa fa-check fa-lg'></i></span><br>" .  $r->{'quality'} . "</div>";
					} elseif($r->{'value'}=='false'){
						echo "<div class='qualcell col-xs-2'><span class='qualityfalse'><i class='fa fa-times fa-lg'></i></span><br>" .  $r->{'quality'} . "</div>";
					}
				} else {
				$qtable .= "<tr><td><a class='pop' data-toggle='popover' data-placement='right' data-content='"  . $r->{'description'} . "'>" . $r->{'quality'} . "</a></td><td>";
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
	</div>
	</div>

	        <div class="col-xs-12">
		<h3>Results</h3> 
		Task type: 
				<select class="selectpicker" data-width="auto">
					<option>Supervised Classification</option>
				</select>
		<h2>Performance evaluation</h2>
		Evaluation measure:
				<select class="selectpicker" data-width="auto" onchange="evaluation_measure = this.value; oTableRuns.fnDraw(true); redrawchart();">
					<?php foreach($this->measures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
				</select>

						
			<div id="code_result_visualize" style="width: 100%">Plotting chart <i class="fa fa-spinner fa-spin"></i></div>

			<div>   <div class="table-responsive">
				<table id="datatable_main" class="table table-bordered table-condensed table-responsive">
					<?php echo generate_table( 
								array('img_open' => '', 
										'rid' => 'run id', 
										'sid' => 'setup id', 
										'name' => 'Name', 
										'value' => 'Evaluation', ) ); ?>
				</table></div>
			</div>
		</div> <!-- end tab-runs -->
		
	</div> <!-- end col-md-12 -->

</div> <!-- end openmlsectioninfo -->
