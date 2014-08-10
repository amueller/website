<div class="row openmlsectioninfo">
  <div class="col-sm-12">
	  <h1><a href="d"><i class="fa fa-database"></i></a> <?php echo $this->record->{'name'}; ?></h1>
  </div>
  <div class="col-sm-12">

     <p><?php
	$desc = $this->record->{'description'};
	$desc = (strlen($desc) > 1003) ? substr($desc,0,1000).'...' : $desc;
	echo $desc;  ?></p>
     <ul class="hotlinks">
	 <li><a href="<?php echo $this->record->{'url'}; ?>"><i class="fa fa-cloud-download fa-2x"></i></a><br>Download</li>
	 <li><a><i class="fa fa-book fa-2x"></i></a><br>Paper</li>
	 <li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>/json"><i class="fa fa-file-code-o fa-2x"></i></a><br>JSON</li>

	 <li>   <div class="version" style="margin-bottom: -10px;">
		        <select class="selectpicker" data-width="auto" onchange="location = this.options[this.selectedIndex].value;">
			  <?php foreach( $this->versions as $k => $v ) { ?>
				<option value="<?php echo 'd/'.$k;?>" <?php echo $v == $this->record->{'version'} ? 'selected' : '';?>><?php echo $v; ?></option>
			  <?php } ?>
			</select>		
	        </div><br>Version</li>
     </ul>

  </div>
    <div class="col-sm-6">
	    <h2>Attribution</h2>
            <div class="table-responsive">
	    <table class="table table-striped"><tbody>
	    <tr><td>Author(s)</td><td><?php echo $this->record->{'creator'} ?></td></tr>
	    <tr><td>Contributor(s)</td><td><?php echo $this->record->{'contributor'} ?></td></tr>
	    <tr><td>Uploader</td><td><?php echo $this->record->{'uploader'} ?></td></tr>	
	    <tr><td>Licence</td><td><?php echo $this->record->{'licence'} ?></td></tr>
	    <tr><td>Please cite</td><td><?php echo $this->record->{'citation'} ?></td></tr>    
	    </tbody></table></div>

    </div> <!-- end col-md-6-->
     <div class="col-sm-6">
			<h2>Features</h2>
			<div class="table-responsive">
				<table class="table table-striped">
				<?php $result = $this->Dataset->query("SELECT name, data_type, is_target, NumberOfDistinctValues, NumberOfMissingValues FROM `data_feature` WHERE did=" . $this->record->{'did'});
				if (is_array($result)){
				foreach( $result as $r ) {
					echo "<tr><td>" . $r->{'name'} . ($r->{'is_target'} == 'true' ? ' (target)': '') . "</td><td>" . $r->{'data_type'} . "</td><td>" . $r->{'NumberOfDistinctValues'} . " values, " . $r->{'NumberOfMissingValues'} . " missing</td></tr>";
				}}
				?>
				</table>
			</div>
      </div> <!-- end col-md-6 -->

	  <div class="qualities col-xs-12">
		<h3>Properties</h3>

		  <?php $result = $this->Implementation->query("SELECT aq.quality, q.description, aq.value, q.showonline from data_quality aq, quality q where aq.quality=q.name and data=" . $this->record->{'did'} . " order by quality asc");
			$qtable = "";
			if (is_array($result)){
			foreach( $result as $r ) {
				if ($r->{'showonline'}=='true'){
					if(is_numeric($r->{'value'})){
						echo "<div class='qualcell col-xs-2'><span class='qualitynumeric'>" . round($r->{'value'},2) . "</span><br><a class='dataprop' href='a/data-qualities/".cleanName($r->{'quality'})."'>" . $r->{'quality'} . "</a></div>";
					} elseif($r->{'value'}=='true'){
						echo "<div class='qualcell col-xs-2'><span class='qualitytrue'><i class='fa fa-check fa-lg'></i></span><br>" .  $r->{'quality'} . "</div>";
					} elseif($r->{'value'}=='false'){
						echo "<div class='qualcell col-xs-2'><span class='qualityfalse'><i class='fa fa-times fa-lg'></i></span><br>" .  $r->{'quality'} . "</div>";
					}
				} else {
				$qtable .= "<tr><td><a href='a/data-qualities/".cleanName($r->{'quality'})."'>" . $r->{'quality'} . "</a></td><td>";
 					if(is_numeric($r->{'value'})){ $qtable .= round($r->{'value'},2); }
					else{ $qtable .= $r->{'value'};}
				$qtable .= "</td></tr>";}
			}} ?>
    		 </div>
          <div class="col-xs-12">
		 <?php 
			if(strlen($qtable)>1){
				echo "<a data-toggle='collapse' href='#algoquals'><i class='fa fa-caret-right'></i> Show more</a><div id='algoquals' class='collapse'><div class='table-responsive'><table class='table table-striped'>" . $qtable . "</table></div></div>";}
		 ?>
	</div>

	        <div class="col-xs-12">
		<h3>Results (per task)</h3> 
				<select class="selectpicker" data-width="auto" onchange="current_task = this.value; oTableRuns.fnDraw(true); redrawchart();">
					<?php foreach($this->tasks_all as $t): ?>
					<option value="<?php echo $t['id'];?>" <?php echo ($t == $this->current_task) ? 'selected' : '';?>><?php echo 'Task ' . $t['id'] . ' (' . $t['name'] . ')';?></option>
					<?php endforeach; ?>
				</select>

		<a onclick="$('#taskModal').modal({remote: 't/' + current_task + '/html'}); $('#taskModal').modal('show');">view task details</a>
		<h2>Performance evaluation</h2>
		Evaluation measure:
				<select class="selectpicker" data-width="auto" onchange="evaluation_measure = this.value; oTableRuns.fnDraw(true); updateTableHeader(); redrawchart();">
					<?php foreach($this->allmeasures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
				</select>

						
			<div id="data_result_visualize" style="width: 100%">Plotting chart <i class="fa fa-spinner fa-spin"></i></div>

			<div>   <div class="table-responsive">
				<table id="datatable_main" class="table table-bordered table-condensed table-responsive">
					<?php echo generate_table( 
								array('img_open' => '', 
										'rid' => 'Run', 
										'sid' => 'setup id', 
										'name' => 'Flow', 
										'value' => str_replace('_',' ',$this->current_measure), ) ); ?>
				</table></div>
			</div>

<div class="modal fade" id="runModal" role="dialog" tabindex="-1" aria-labelledby="Run detail" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<div class="modal fade" id="taskModal" role="dialog" tabindex="-1" aria-labelledby="Task detail" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>



		</div> <!-- end tab-runs -->
		
	</div> <!-- end col-md-12 -->

</div> <!-- end openmlsectioninfo -->
