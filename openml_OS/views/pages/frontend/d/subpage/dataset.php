<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<div class="row openmlsectioninfo">
  <div class="col-xs-12">
    <?php if($this->blocked){
		o('no-access');
	  } else {
    $fgraphs = '';
    $fgraphs_all = '';

    ?>

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
       <i class="fa fa-table"></i> <?php echo (strtolower($this->record->{'format'}) == 'arff' ? '<a href="http://weka.wikispaces.com/ARFF+%28developer+version%29" target="_blank">ARFF</a>' : $this->record->{'format'}); ?>
       <i class="fa fa-cc"></i> <?php $l = $this->licences[$this->record->{'licence'}]; echo '<a href="'.$l['url'].'">'.$l['name'].'</a>'; ?> 	    
       <i class="fa fa-eye-slash"></i> Visibility: <?php echo strtolower($this->record->{'visibility'}); ?> 
       <i class="fa fa-cloud-upload"></i> Uploaded <?php echo explode(" ",$this->record->{'upload_date'})[0];?> by <a href="u/<?php echo $this->uploader_id; ?>"><?php echo $this->record->{'uploader'} ?></a>
       <?php if($this->is_owner and $this->features != false)
		echo '<i class="fa fa-pencil-square-o"></i> <a href="d/'.$this->id.'/update">Edit</a>';
	?>
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
		<?php
			if ($this->features != false){ ?>

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
		<?php } else {

			if($this->record->{'error'} == 'true')
			    echo '<p>Could not calculate features.</p>'; 
			else
			    echo '<p>Data properties are not analyzed yet. Refresh the page in a few minutes.</p>'; 
	      	} ?>


	</div>

	<div class="col-xs-12">
			<h3>Features</h3>
		<?php
			if ($this->features != false){ ?>
			<div class="features hideFeatures">
			<div class="table-responsive">
				<table class="table">
				<?php
				//get target values
				$featCount = 0;
				foreach( $this->features as $r ) {
					$newGraph = ''; 
			                if($r->{'data_type'} == "numeric"){
						$newGraph = '$("#feat'.$r->{'index'}.'").highcharts({chart:{type:\'boxplot\',inverted:true,backgroundColor:null},exporting:false,credits:false,title: null,legend:false,tooltip:false,xAxis:{title:null,labels:{enabled:false},tickLength:0},yAxis:{title:null,labels:{style:{fontSize:\'8px\'}}},series: [{data: [['.$r->{'MinimumValue'}.','.($r->{'MeanValue'}-$r->{'StandardDeviation'}).','.$r->{'MeanValue'}.','.($r->{'MeanValue'}+$r->{'StandardDeviation'}).','.$r->{'MaximumValue'}.']]}]});';
					} else if (strlen($r->{'ClassDistribution'})>0) {
						$distro = json_decode($r->{'ClassDistribution'});
						$newGraph = '$("#feat'.$r->{'index'}.'").highcharts({chart:{type:\'column\',backgroundColor:null},exporting:false,credits:false,title:false,xAxis:{title:false,labels:{'.(count($distro[0])>10 ? 'enabled:false' : 'style:{fontSize:\'9px\'}').'},tickLength:0,categories:[\''.implode("','", $distro[0]).'\']},yAxis:{min:0,title:false,gridLineWidth:0,minorGridLineWidth:0,labels:{enabled:false},stackLabels:{enabled:true,useHTML:true,style:{fontSize:\'9px\'}}},legend:false,tooltip:{useHTML:true,shared:true},plotOptions:{column:{stacking:\'normal\'}},series:[';

					for($i=0; $i<count($this->classvalues); $i++){
						$newGraph .= '{name:\''.$this->classvalues[$i].'\',data:['.implode(",",array_column($distro[1], $i)).']}';
						if($i!=count($this->classvalues)-1)
							$newGraph .= ',';
					}
					if(count($this->classvalues)==0){
						$newGraph .= '{name:"count",data:['.implode(",",array_column($distro[1], 0)).']}';				
					}
					$newGraph .= ']});';
					}
					if($featCount<3)
						$fgraphs = $newGraph . PHP_EOL . $fgraphs;
					else
						$fgraphs_all = $newGraph . PHP_EOL . $fgraphs_all;

					
					echo "<tr><td>" . $r->{'name'} . ( $r->{'is_target'} == 'true' ? ' <b>(target)</b>': '').( $r->{'is_row_identifier'} == 'true' ? ' <b>(row identifier)</b>': '').( $r->{'is_ignore'} == 'true' ? ' <b>(ignore)</b>': ''). "</td><td>" . $r->{'data_type'} . "</td><td>" . $r->{'NumberOfDistinctValues'} . " values, " . $r->{'NumberOfMissingValues'} . " missing</td><td class='feat-distribution'><div id='feat".$r->{'index'}."' style='height: 90px; margin: auto; min-width: 300px; max-width: 200px;'></div></td></tr>";


					$featCount = $featCount + 1;
				}  
					?>
				</table>
			</div>
			</div>
        </div> <!-- end col-md-12 -->
        <div class="col-xs-12">
	  <div class="show-more-features">
		<a type="button" class="btn btn-primary btn-sm" onclick="showmorefeats()">Show all <?php echo count($this->features); ?> features</a></div>
	<?php } else {
			if($this->record->{'error'} == 'true')
			    echo '<p>Could not calculate features.</p>'; 
			else
			    echo '<p>Data features are not analyzed yet. Refresh the page in a few minutes.</p>'; 
	      } ?>
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

	<?php } ?>		
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
<?php
	$this->endjs = '<script>$(function(){'.$fgraphs.'});</script>';
	$this->endjs .= '<script>function visualize_all(){'.$fgraphs_all.'}</script>';

?>
