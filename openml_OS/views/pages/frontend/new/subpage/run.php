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
	      <h1><a href="r"><i class="fa fa-star"></i></a> Add runs</h1>
	      <form method="post" id="datasetForm" action="api/?f=openml.data.upload" enctype="multipart/form-data">
		  <input type="hidden" id="generated_input_dataset_description" name="description" value="" />
	      <div class="row">
	 	  <p>Manual run upload is under development.</p>
		  <p>Psst... It is much easier to upload runs using the <a href="plugins">OpenML plugins</a>, or programmatically <a href="developers">using the API</a>.</p>
	      </div>
	      </form>
</div> <!-- end container -->

