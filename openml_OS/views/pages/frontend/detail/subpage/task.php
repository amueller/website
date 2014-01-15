<div style="clear: both" />

<div class="row">
	<div class="col-md-2">
		<ul class="nav nav-list bs-docs-sidenav2" id="result-tabs">
			<li class="topchild">
				<a href="#tab-general" data-toggle="tab"><i class="fa fa-info-circle"></i>&nbsp;General Information</a>
			</li>
			<li class="bottomchild active">
				<a href="#tab-runs" data-toggle="tab"><i class="fa fa-star"></i>&nbsp;Runs</a>
			</li>
		</ul>
	</div>
	
	<div class="tab-content col-md-10" style="overflow: visible">
		<div class="tab-pane" id="tab-general">
			<table id="datatable_general" class="table table-bordered table-condensed">
				<thead>
					<tr>
						<td><b>Name</b></td><td><b>Value</b></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>ID</td><td><?php echo $this->record->id; ?></td>
					</tr>
					<tr>
						<td>Task</td><td><?php echo $this->record->name; ?></td>
					</tr>
					<tr>
						<td>Target feature</td><td><?php echo $this->record->target_feature; ?></td>
					</tr>
					<tr>
						<td>Evaluation measure</td><td><?php echo $this->record->evaluation_measure; ?></td>
					</tr>
					<tr>
						<td>Estimation procedure</td><td><?php echo $this->record->type; ?></td>
					</tr>
					
				</tbody>
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
	</div>
</div> 
