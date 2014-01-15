<div style="clear: both" ></div>

<div class="row">
	<div class="col-md-2">
		<ul class="nav nav-list bs-docs-sidenav2" id="result-tabs">
			<li class="topchild">
				<a href="#tab-general" data-toggle="tab"><i class="fa fa-info-cirle"></i>&nbsp;General Information</a>
			</li>
			<li class="active">
				<a href="#tab-runs" data-toggle="tab"><i class="fa fa-star"></i>&nbsp;Runs</a>
			</li>
			<li>
				<a href="#tab-features" data-toggle="tab"><i class="fa fa-file"></i>&nbsp;Data Features</a>
			</li>
			<li class="bottomchild">
				<a href="#tab-qualities" data-toggle="tab"><i class="fa fa-tags"></i>&nbsp;Data Properties</a>
			</li>
		</ul>
	</div>

	<div class="tab-content col-md-10" style="overflow: visible">
		<div class="tab-pane" id="tab-general">
			<table id="datatable_general" class="table table-bordered table-condensed">
				<?php echo generate_table_one_record( array( 'name' => 'Name', 'version' => 'Version', 'description' => 'Description', 'creator' => 'Creator', 'contributor' => 'Contributors', 'collection_date' => 'Date of collection', 'language' => 'Language', 'url' => 'Download url'), $this->record ); ?>
			</table>
		</div>
		
		<div class="tab-pane active" id="tab-runs">
			<div class="alert alert-info">By default only the results of the best parameter settings are shown. Press the "Show all/best results" button to include all results. Use the dropdown below to select which evaluation measure should be used. </div>
			
			<div>
				<select onchange="evaluation_measure = this.value; oTableRuns.fnDraw(true);">
					<?php foreach($this->measures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div>
				<table id="datatable_main" class="table table-bordered table-condensed">
					<?php echo generate_table( 
						array(	'img_open' => '', 
								'rid' => 'run id', 
								'sid' => 'setup id', 
								'implementation' => 'Implementation', 
								'algorithm' => 'Algorithm', 
								'value' => 'Evaluation' ), false, true ); ?>
				</table>
			</div>
		</div>
		
		<div class="tab-pane" id="tab-features">
			<table id="datatable_datafeatures" class="table table-bordered table-condensed">
				<?php echo generate_table( 
							array(	'index' => '', 'name' => 'Name','data_type' => 'Type','NumberOfDistinctValues' => 'Distinct Values','NumberOfUniqueValues' => 'Unique Values','NumberOfMissingValues' => 'Missing Values','MaximumValue' => 'Maximum Value','MinimumValue' => 'Minimum Value','MeanValue' => 'Mean','StandardDeviation' => 'Standard Deviation') ); ?>
			</table>
		</div>
		
		<div class="tab-pane" id="tab-qualities">
			<table id="datatable_dataqualities" class="table table-bordered table-condensed">
				<?php echo generate_table( 
							array(	'name' => 'Name', 
									'description' => 'Description', 
									'value' => 'Value') ); ?>
			</table>
		</div>
	</div>
</div>
