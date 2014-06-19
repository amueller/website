<!-- File upload. Somehow, putting this in the javascript file doesn't work :/ -->
<script>
	$(document)
		.on('change', '.btn-file :file', function() {
			var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
	});
	
	$(document).ready( function() {
		$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
			
			var input = $(this).parents('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;
			
			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}
			
		});
	});		
</script>

<div class="openmlsectioninfo">
	<h1><a href="d"><i class="fa fa-database"></i></a> Add data</h1>
	<form method="post" id="datasetForm" action="api/?f=openml.data.upload" enctype="multipart/form-data">
	      <input type="hidden" id="generated_input_dataset_description" name="description" value="" />
	      <div class="row">
		<div class="col-md-6">
		  <h2>Required information</h2>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_name">Name</label>
		    <input type="text" class="form-control" id="input_dataset_name" placeholder="The name of the dataset" value=""/>
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_description">Description</label>
		    <textarea class="form-control" id="input_dataset_description" placeholder="Short description of the dataset. Changes from previous versions." value=""></textarea> 
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="sourcefile">Data</label>
		    <div class="col-md-12 input-info-first">For data hosted elsewhere (data repositories).</div> 
		    <input type="text" class="form-control" id="source_url" placeholder="URL where data is hosted." value="" /> 
		    <div class="col-md-12 input-info">Or, upload the data, e.g. as an archive.</div>
		    <div class="input-group">
			<span class="input-group-btn">
				<button class="btn btn-primary btn-file">Upload&hellip;<input type="file" id="input_dataset_dataset" multiple></button>
			</span>
			<input type="text" class="form-control" readonly>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_version">Version</label>
		    <input type="text" class="form-control" id="input_dataset_version" placeholder="Version number, hash, ..." value=""/>
		  </div>

		</div>

	      <div class="col-md-6">
		  <h2>Attribution</h2>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_creator">Author(s)</label>
		    <input type="text" class="form-control" id="input_dataset_creator" placeholder="The author(s) of the dataset. Firstname Lastname, Firstname Lastname,..." value="" />
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_contributor">Contributor(s)</label>
		    <input type="text" class="form-control" id="input_dataset_contributor" 
			placeholder="Other contributor(s) of the dataset" value="" />
		  </div>
		  <div class="form-group">
		  <label class="control-label" for="input_dataset_licence">Licence</label> - <a href="http://creativecommons.org/licenses/?lang=en" target="_blank">Learn more</a>
			  <select class="form-control">
			  <option>Attribution (CC BY)</option>
			  <option>Attribution-ShareAlike (CC BY-SA)</option>
			  <option>Attribution-NoDerivs (CC BY-ND)</option>
			  <option>Attribution-NonCommercial (CC BY-NC)</option>
			  <option>Attribution-NonCommercial-ShareAlike (CC BY-NC-SA)</option>
			  <option>Attribution-NonCommercial-NoDerivs (CC BY-NC-ND)</option>
			  <option>Public Domain (CC0)</option>
			</select>
	          </div>
		  <div class="form-group">
			    <label class="control-label" for="input_dataset_citation">Citation</label>
			    <textarea class="form-control" id="input_dataset_citation"  placeholder="How to reference this data in papers." value=""></textarea>			         		  		</div>
		  <div class="form-group">
		    <label class="control-label" for="sourcefile">Paper/preprint</label>
		    <input type="text" class="form-control" id="source_url" placeholder="URL to paper or preprint about this data." value="" /> 
		  </div>
		</div>
	      </div>
	      <div class="row">
	      <div class="col-md-12">
	      <h2>Further information</h2>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_format">Format</label>
		    <input type="text" class="form-control" id="input_dataset_format" placeholder="The data format (e.g. ARFF)" value="" onblur=""/> 
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_default_target_attribute">Target attribute</label>
		    <input type="text" class="form-control" id="input_dataset_default_target_attribute" placeholder="For predictive problems: name of the attribute that is typically used as the target feature of this dataset." value="" onblur=""/> 
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_row_id_attribute">Row ID Attribute</label>
		    <input type="text" class="form-control" id="input_dataset_row_id_attribute" placeholder="If present, the name of the feature keeping row id's." value="" onblur=""/> 
		  </div>

		  <div class="form-group">
		    <input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
		  </div>
                </div>
		</div>
	</form> 
</div> <!-- end container -->
