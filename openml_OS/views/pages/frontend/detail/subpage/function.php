<div style="clear: both" />

<div class="row">
	<div class="col-md-2">
		<ul class="nav nav-list bs-docs-sidenav2" id="result-tabs">
			<li class="topchild active">
				<a href="#tab-general" data-toggle="tab"><i class="fa fa-info-circle"></i>&nbsp;General Information</a>
			</li>
			<li class="bottomchild">
				<a href="#tab-undefined" data-toggle="tab"><i class="fa fa-star"></i>&nbsp;Undefined content</a>
			</li>
		</ul>
	</div>
	
	<div class="tab-content col-md-10" style="overflow: visible">
		<div class="tab-pane active" id="tab-general">
			<table id="datatable_general" class="table table-bordered table-condensed">
				<?php echo generate_table_one_record( 
					array( 
						'name' => 'Name', 
						'description' => 'description', 
						'min' => 'Minimum',
						'max' => 'Maximum',
						'unit' => 'Unit',
						'source_code' => 'Source code', 
					), 
					$this->record ); ?>
			</table>
		</div>
		
		<div class="tab-pane" id="tab-undefined">
			<div class="alert alert-info">Undefined content, will be generated later on. </div>
		</div>
	</div>
</div>
