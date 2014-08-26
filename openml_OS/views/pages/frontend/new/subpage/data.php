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
        <?php if(strlen($this->response)>0){ echo '<div class="alert alert-success">'. $this->response . '</div>'; }?>
	<form method="post" action="" enctype="multipart/form-data">
	      <div class="row">
		<div class="col-sm-6">
		  <div class="form-group">
		    <label class="control-label" for="sourcefile">Data files</label>
		    <div class="input-group">
			<span class="input-group-btn">
				<a class="btn btn-primary btn-file">Upload&hellip;<input type="file" name="dataset" multiple></a>
			</span>
			<input type="text" class="form-control" readonly>
		    </div>
		    <div class="col-sm-12 input-info">Or (not both)</div>
		    <input type="text" class="form-control" name="url" placeholder="URL where the data is hosted (e.g. data repository)" value="" /> 
		  </div>
		  <div class="form-group">
		    <div class="row">
		    <div class="col-xs-6 has-error" id="field_name">
		    <label class="control-label" for="name">Name</label>
		    <input type="text" class="form-control" name="name" id="name" placeholder="A good name (no spaces)" value="<?php echo $this->input->post('name'); ?>"/>
		    </div>
		    <div class="col-xs-6">
		    <label class="control-label" for="version_label">Version</label>
		    <input type="text" class="form-control" name="version_label" placeholder="Version number, id, date,..." value="<?php echo $this->input->post('version'); ?>"/>
		    </div>
		    </div>
		  </div>
		  <div class="form-group has-error">
		    <label class="control-label" for="description">Description</label>
		    <textarea class="form-control" name="description" id="description" rows="5" placeholder="What is this data all about? Use #tags to label it. Include changes from previous versions." value=""><?php echo $this->input->post('description'); ?></textarea> 
		  </div>
		  <div class="form-group has-error">
	            <label class="control-label" for="format">Data format</label>
		    <input type="text" class="form-control" name="format" id="format" placeholder="The data format (e.g. ARFF)" value="<?php echo $this->input->post('format'); ?>" onblur=""/> 
	          </div>
                </div>
   		<div class="col-sm-6">
		  <div class="form-group">
		    <label class="control-label" for="creator">Author(s)</label>
		    <input type="text" class="form-control" name="creator" placeholder="Firstname Lastname, Firstname Lastname,..." value="<?php echo $this->input->post('creator'); ?>" />
		  </div>

		  <div class="form-group">
		  <label class="control-label" for="licence">Licence - <a href="http://creativecommons.org/licenses/?lang=en" target="_blank">Learn more</a></label>
			  <select class="form-control" name="licence">
			  <option value="Public">Publicly available</option>
			  <option value="CC_BY">Attribution (CC BY)</option>
			  <option value="CC_BY-SA">Attribution-ShareAlike (CC BY-SA)</option>
			  <option value="CC_BY-ND">Attribution-NoDerivs (CC BY-ND)</option>
			  <option value="CC_BY-NC">Attribution-NonCommercial (CC BY-NC)</option>
			  <option value="CC_BY-NC-SA">Attribution-NonCommercial-ShareAlike (CC BY-NC-SA)</option>
			  <option value="CC_BY-NC-ND">Attribution-NonCommercial-NoDerivs (CC BY-NC-ND)</option>
			  <option value="CC0">Public Domain (CC0)</option>
			</select>
			<div id="Public" class="licences" style="display:block;">Mark a work that is free of known copyright restrictions. <a href="https://creativecommons.org/choose/mark/">More info</a></div>
			<div id="CC_BY" class="licences">Lets others distribute, remix, tweak, and build upon your work, even commercially, as long as they credit you for the original creation. <a href="http://creativecommons.org/licenses/by/4.0/" target="_blank">More info</a></div>
			<div id="CC_BY-SA" class="licences">Lets others remix, tweak, and build upon your work even for commercial purposes, as long as they credit you and license their new creations under the identical terms. <a href="http://creativecommons.org/licenses/by-sa/4.0/" target="_blank">More info</a></div>
			<div id="CC_BY-ND" class="licences">Allows for redistribution, commercial and non-commercial, as long as it is passed along unchanged and in whole, with credit to you. <a href="http://creativecommons.org/licenses/by-nd/4.0/" target="_blank">More info</a></div>
			<div id="CC_BY-NC" class="licences">Lets others remix, tweak, and build upon your work non-commercially, and although their new works must also acknowledge you and be non-commercial, they don’t have to license their derivative works on the same terms. <a href="http://creativecommons.org/licenses/by-nc/4.0" target="_blank">More info</a></div>
			<div id="CC_BY-NC-SA" class="licences">Lets others remix, tweak, and build upon your work non-commercially, as long as they credit you and license their new creations under the identical terms. <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/" target="_blank">More info</a></div>
			<div id="CC_BY-NC-ND" class="licences">Allow others to download your works and share them with others as long as they credit you, but they can’t change them in any way or use them commercially. <a href="http://creativecommons.org/licenses/by-nc-nd/4.0" target="_blank">More info</a></div>
			<div id="CC0" class="licences">Waive all copyright and related rights. Others may freely build upon, enhance and reuse the works for any purposes without restriction under copyright or database law. <a href="http://creativecommons.org/about/cc0" target="_blank">More info</a></div>

<script>
    $(function() {
        $('#input_dataset_licence').change(function(){
            $('.licences').hide();
            $('#' + $(this).val()).show();
        });
    });
</script>
			
	          </div>
		  <div class="form-group">
			    <label class="control-label" for="citation">Citation requests</label>
			    <textarea class="form-control" rows="4" name="citation"  placeholder="How to reference this data in future work (e.g., publication, DOI)." value="<?php echo $this->input->post('citation'); ?>"></textarea>			         		  		
		  </div>
		  <div class="form-group">
		  <label class="control-label" for="visibility">Who can view this data <span class="label label-danger">Under development</span></label>
			  <select class="form-control" name="visibility">
			  <option value="Everyone">Everyone</option>
			  <option value="All my friends">All my friends</option>
			  <option value="Only me">Only me</option>
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
		    <label class="control-label" for="original_data_url">Original data URL</label>
		    <input type="text" class="form-control" name="original_data_url" placeholder="For derived data, the URL to the original data set. E.g., http://openml.org/d/1" value="<?php echo $this->input->post('original_data_url'); ?>"/>
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="default_target_attribute">Target attribute</label>
		    <input type="text" class="form-control" name="default_target_attribute" placeholder="For predictive problems: name of the attribute that is typically used as the target feature of this dataset." value="<?php echo $this->input->post('default_target_attribute'); ?>" onblur=""/> 
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="row_id_attribute">Row ID Attribute</label>
		    <input type="text" class="form-control" name="row_id_attribute" placeholder="If present, the name of the feature keeping row id's." value="<?php echo $this->input->post('row_id_attribute'); ?>" onblur=""/>		  </div>
		</div>
		<div class="col-sm-6">

		  <div class="form-group">
		    <label class="control-label" for="contributor">Acknowledgements, contributors</label>
		    <input type="text" class="form-control" name="contributor" 
			placeholder="Thanks to..." value="<?php echo $this->input->post('contributor'); ?>" />
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="paper_url">Paper/preprint</label>
		    <input type="text" class="form-control" name="paper_url" placeholder="URL to paper or preprint about this data." value="<?php echo $this->input->post('paper_url'); ?>" /> 
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="collection_date">Collection date</label>
		    <input type="text" class="form-control" name="collection_date" placeholder="When was this data collected?" value="<?php echo $this->input->post('collection_date'); ?>" /> 
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

<script>
	$('#name').bind('input', function() {
	    var cname = $(this).val();
	    if(cname.length > 0 && cname.split(" ").length == 1){
	       $(this).parent().removeClass('has-error');
	       $(this).parent().addClass('has-success');
	    } else {
	       $(this).parent().removeClass('has-success');
	       $(this).parent().addClass('has-error');
	    }
	});
	$('#description').bind('input', function() {
	    var cname = $(this).val();
	    if(cname.length > 0){
	       $(this).parent().removeClass('has-error');
	       $(this).parent().addClass('has-success');
	    } else {
	       $(this).parent().removeClass('has-success');
	       $(this).parent().addClass('has-error');
	    }
	});
	$('#format').bind('input', function() {
	    var cname = $(this).val();
	    if(cname.length > 0){
	       $(this).parent().removeClass('has-error');
	       $(this).parent().addClass('has-success');
	    } else {
	       $(this).parent().removeClass('has-success');
	       $(this).parent().addClass('has-error');
	    }
	});


</script>
