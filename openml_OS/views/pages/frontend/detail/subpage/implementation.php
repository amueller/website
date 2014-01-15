<div style="clear: both" />

<div class="row">
	<div class="col-md-2">
		<ul class="nav nav-list bs-docs-sidenav2" id="result-tabs">
			<li class="topchild">
				<a href="#tab-general" data-toggle="tab"><i class="fa fa-info-circle"></i>&nbsp;General Information</a>
			</li>
			<li class="active">
				<a href="#tab-runs" data-toggle="tab"><i class="fa fa-star"></i>&nbsp;Runs</a>
			</li>
			<li>
				<a href="#tab-params" data-toggle="tab"><i class="fa fa-tasks"></i>&nbsp;Algorithm Parameters</a>
			</li>
			<li class="bottomchild">
				<a href="#tab-qualities" data-toggle="tab"><i class="fa fa-tags"></i>&nbsp;Algorithm Properties</a>
			</li>
		</ul>
	</div>
	
	<div class="tab-content col-md-10" style="overflow: visible">
		<div class="tab-pane" id="tab-general">
			<table id="datatable_general" class="table table-bordered table-condensed">
				<?php echo generate_table_one_record( 
					array( 
						'name' => 'Name', 
						'version' => 'Version', 
						'description' => 'Description', 
						'creator' => 'Creator', 
						'contributor' => 'Contributors', 
						'uploadDate' => 'Date of upload', 
						'licence' => 'Licence', 
						'language' => 'Language', 
						'fullDescription' => 'Extended description', 
						'installationNotes' => 'Installation notes', 
						'dependencies' => 'Dependencies', 
						'implements' => 'Algorithm name', 
						'sourceUrl' => 'Download source code', 
						'binaryUrl' => 'Download executable'), 
					$this->record ); ?>
			</table>
		</div>
		
		<div class="tab-pane active" id="tab-runs">
			<div class="alert alert-info">Use the dropdown below to select which evluation measure should be used. </div>
			
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
										'name' => 'Name', 
										'value' => 'Evaluation', ) ); ?>
				</table>
			</div>
		</div>
		
		<div class="tab-pane" id="tab-params">
			<table id="datatable_implementationparams" class="table table-bordered table-condensed">
				<?php echo generate_table( 
							array(	'name' => 'Name', 
									'generalName' => 'General Name',
									'description' => 'Description',
									'dataType' => 'Data Type',
									'defaultValue' => 'Default Value',
									'min' => 'Minimum',
									'max' => 'Maximum' ) ); ?>
			</table>
		</div>
		
		<div class="tab-pane" id="tab-qualities">
			<table id="datatable_implementationqualities" class="table table-bordered table-condensed">
				<?php echo generate_table( 
							array(	'name' => 'Name', 
									'description' => 'Description', 
									'value' => 'Value') ); ?>
			</table>
		</div>
	</div>
</div>
