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
		<div class="col-sm-6">
		  <div class="form-group">
		    <label class="control-label" for="sourcefile">Data files</label>
		    <div class="input-group">
			<span class="input-group-btn">
				<button class="btn btn-primary btn-file">Upload&hellip;<input type="file" id="input_dataset_dataset" multiple></button>
			</span>
			<input type="text" class="form-control" readonly>
		    </div>
		    <div class="col-sm-12 input-info">And/or</div>
		    <input type="text" class="form-control" id="source_url" placeholder="URL where the data is hosted (e.g. data repository)" value="" /> 
		  </div>
		  <div class="form-group">
		    <div class="row">
		    <div class="col-xs-6">
		    <label class="control-label" for="input_dataset_name">Name</label>
		    <input type="text" class="form-control" id="input_dataset_name" placeholder="A good name for the data set" value=""/>
		    </div>
		    <div class="col-xs-6">
		    <label class="control-label" for="input_dataset_version">Version</label>
		    <input type="text" class="form-control" id="input_dataset_version" placeholder="Version number, id, date,..." value=""/>
		    </div>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_description">Description</label>
		    <textarea class="form-control" id="input_dataset_description" rows="5" placeholder="What is this data all about? Use #tags to label it. Include changes from previous versions." value=""></textarea> 
		  </div>
		  <div class="form-group">
	            <label class="control-label" for="input_dataset_format">Data format</label>
		    <input type="text" class="form-control" id="input_dataset_format" placeholder="The data format (e.g. ARFF)" value="" onblur=""/> 
	          </div>
                </div>
   		<div class="col-sm-6">
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_creator">Author(s)</label>
		    <input type="text" class="form-control" id="input_dataset_creator" placeholder="Firstname Lastname, Firstname Lastname,..." value="" />
		  </div>

		  <div class="form-group">
		  <label class="control-label" for="input_dataset_licence">Licence - <a href="http://creativecommons.org/licenses/?lang=en" target="_blank">Learn more</a></label>
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
			    <label class="control-label" for="input_dataset_citation">Citation requests</label>
			    <textarea class="form-control" rows="4" id="input_dataset_citation"  placeholder="How to reference this data in future work (e.g., publication, DOI)." value=""></textarea>			         		  		
		  </div>
		  <div class="form-group">
		  <label class="control-label" for="input_dataset_visibility">Who can view this data <span class="label label-danger">Under development</span></label>
			  <select class="form-control">
			  <option>Everyone</option>
			  <option>All my friends</option>
			  <option>Only me</option>
			</select>
	          </div>
		</div>


            </div>
	    <div class="row">
	      <div class="col-sm-12">
		  <h2>Additional information</h2>
	      <div class="row">
		<div class="col-sm-6">
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_default_target_attribute">Target attribute</label>
		    <input type="text" class="form-control" id="input_dataset_default_target_attribute" placeholder="For predictive problems: name of the attribute that is typically used as the target feature of this dataset." value="" onblur=""/> 
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_row_id_attribute">Row ID Attribute</label>
		    <input type="text" class="form-control" id="input_dataset_row_id_attribute" placeholder="If present, the name of the feature keeping row id's." value="" onblur=""/>		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_dataset_version">Original data</label>
		    <input type="text" class="form-control" id="input_dataset_version" placeholder="For derived data, the OpenML id of the original data set. Only upload data that is not trivially derived." value=""/>
		  </div>
		</div>
		<div class="col-sm-6">

		  <div class="form-group">
		    <label class="control-label" for="input_dataset_contributor">Acknowledgements</label>
		    <input type="text" class="form-control" id="input_dataset_contributor" 
			placeholder="Thanks to..." value="" />
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="sourcefile">Paper/preprint</label>
		    <input type="text" class="form-control" id="source_url" placeholder="URL to paper or preprint about this data." value="" /> 
		  </div>
		</div>
              </div>
		</div>
              </div>

            </div>
	    <div class="row">
	      <div class="col-sm-12">
		  <div class="form-group">
		    <input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
		  </div>


              </div>
           </div>
	</form> 
        <p><i>By submitting, you allow OpenML to index the data and link it to uploaded results. All rights remain with the original author(s) of the data.</i></p>
</div> <!-- end container -->
