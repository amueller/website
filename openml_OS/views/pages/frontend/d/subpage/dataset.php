<div class="row openmlsectioninfo">
  <div class="col-xs-12">
    <ul class="hotlinks">
	 <li><a href="<?php echo $this->record->{'url'}; ?>"><i class="fa fa-cloud-download fa-2x"></i></a></li>
	 <li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>/json"><i class="fa fa-code fa-2x"></i></a></li>

	 <li>   <div class="version" style="margin-bottom: -17px;">
		        <select class="selectpicker" data-width="auto" onchange="location = this.options[this.selectedIndex].value;">
			  <?php foreach( $this->versions as $k => $v ) { ?>
				<option value="<?php echo 'd/'.$k;?>" <?php echo $v == $this->record->{'version'} ? 'selected' : '';?>>v. <?php echo $v; ?></option>
			  <?php } ?>
			</select>
	        </div></li>
    </ul>
    <h1 class="pull-left"><a href="d"><i class="fa fa-database"></i></a>
	<?php if($this->prev_id){ ?><div class="previd"><a href="d/<?php echo $this->prev_id;?>"><i class="fa fa-angle-left"></i></a></div><?php } ?>
	<a href="d/<?php echo $this->id; ?>"><?php echo $this->record->{'name'}; ?></a>
	<?php if($this->next_id){ ?><div class="nextid"><a href="d/<?php echo $this->next_id;?>"><i class="fa fa-angle-right"></i></a></div><?php } ?>
    </h1>

    <div class="datainfo">
       <i class="fa fa-cc"></i> <?php $l = $this->licences[$this->record->{'licence'}]; echo '<a href="'.$l['url'].'">'.$l['name'].'</a>'; ?> 	    
       <?php if($this->record->{'citation'}){ ?>
	    <i class="fa fa-book"></i> Please cite: <?php echo $this->record->{'citation'} ?>
       <?php } ?>
       <?php if($this->record->{'paper_url'}){ ?>
	    <i class="fa fa-book"></i> <a href="<?php echo $this->record->{'paper_url'} ?>">Original paper</a>
       <?php } ?>
       <i class="fa fa-eye-slash"></i> Viewable by <?php echo strtolower($this->record->{'visibility'}); ?> 
       <i class="fa fa-cloud-upload"></i> Uploaded by <a href="<?php echo $this->uploader_id; ?>"><?php echo $this->record->{'uploader'} ?></a> on <td><?php echo explode(" ",$this->record->{'upload_date'})[0];?>
    </div>
  </div>
  <div class="col-xs-12">
     <div class="wiki-buttons" <?php if (!$this->wiki_ok) { echo 'style="display: none"'; } ?>>
     <a class="btn btn-success btn-sm pull-right" href="d/<?php echo $this->id; ?>/edit"><i class="fa fa-edit fa-lg"></i> Edit</a>
     <?php if ($this->show_history) { ?>
     <a class="btn btn-success btn-sm pull-right" href="d/<?php echo $this->id; ?>/history"><i class="fa fa-clock-o fa-lg"></i> History</a>
     <?php } ?>
     </div>
     <div class="description <?php if($this->hidedescription) echo 'hideContent';?>">
	<?php echo $this->wikiwrapper; ?>  
      </div>
  </div>

	<?php if($this->hidedescription) { ?>
        <div class="col-xs-12">
	  <div class="show-more"><a onclick="showmore()"><i class="fa fa-caret-right"></i> Show more</a></div>
	</div>
	<?php } ?> 

  </div>  
  <div class="row">      

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
			<h3>Features</h3>
			<div class="features hideFeatures">
			<div class="table-responsive">
				<table class="table table-striped">
				<?php $result = $this->Dataset->query("SELECT name, data_type, is_target, NumberOfDistinctValues, NumberOfMissingValues FROM `data_feature` WHERE did=" . $this->record->{'did'});
				if (is_array($result)){
				foreach( $result as $r ) {
					echo "<tr><td>" . $r->{'name'} . ( $this->record->{'default_target_attribute'} == $r->{'name'} ? ' <b>(target)</b>': '')
									.( $this->record->{'row_id_attribute'} == $r->{'name'} ? ' <b>(unique id)</b>': '') . "</td><td>" . $r->{'data_type'} . "</td><td>" . $r->{'NumberOfDistinctValues'} . " values, " . $r->{'NumberOfMissingValues'} . " missing</td></tr>";
				}}
				?>
				</table>
			</div>
			</div>
        </div> <!-- end col-md-12 -->
        <div class="col-xs-12">
	  <div class="show-more-features"><a onclick="showmorefeats()"><i class="fa fa-caret-right"></i> Show more</a></div>
	</div>


	        <div class="col-xs-12">
		<h3>Results (per task)</h3>
		<?php if(count($this->tasks_all)==0){ ?>
				<p>There haven't been any tasks created on this dataset yet. <a href="new/task">Create a task on this data set.</a></p>
		<?php } else { ?>
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
		<?php } ?>

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

<!-- redirect communication to gollum -->
<script>
$("#gollum-editor-message-field").val("Write a small message explaining the change.");
$("#gollum-editor-submit").addClass("btn btn-success pull-left");
$("#gollum-editor-preview").removeClass("minibutton");
$("#gollum-editor-preview").addClass("btn btn-default padded-button");
$("#gollum-editor-preview").attr("href","preview");
$("#version-form").attr('action', "d/<?php echo $this->id; ?>/compare/<?php echo $this->wikipage; ?>");
$("a[title*='View commit']").each(function() {
   var _href = $(this).attr("href"); 
   $(this).attr('href', 'd/<?php echo $this->id; ?>/view' + _href);
});

$( "#gollum-editor-preview" ).click(function() {
	var $form = $($('#gollum-editor form').get(0));
        $form.attr('action', '');
});

$("a[title*='View commit']").each(function() {
   var _href = $(this).attr("href"); 
   $(this).attr('href', 'd/<?php echo $this->id; ?>/view' + _href);
});
</script>
