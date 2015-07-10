<!-- Somehow, putting this in the javascript file doesn't work :/ -->
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

<div class="panel">
	      <h1><a href="f"><i class="fa fa-cogs"></i></a> Add flows</h1>
	      <form method="post" id="implementationForm" action="api/?f=openml.implementation.upload" enctype="multipart/form-data">
		  <input type="hidden" id="generated_input_implementation_description" name="description" value="" />
	      <div class="row">
		<div class="col-md-6">
		  <h2>Required information</h2>
		  <div class="form-group">
		    <label class="control-label" for="input_implementation_name">Name</label>
		    <input type="text" class="form-control" id="input_implementation_name" placeholder="The name of the algorithm, workflow, script, program,..." value=""/>
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_implementation_description">Description</label>
		    <textarea class="form-control" id="input_implementation_description" placeholder="Short description of what is implemented. Changes from previous versions." value=""></textarea>
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_implementation_description">Instructions</label>
		    <textarea class="form-control" id="input_implementation_description" placeholder="If applicable, how to run OpenML tasks using this code." value=""></textarea>
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="sourcefile">Implementation</label>
		    <input type="text" class="form-control" id="source_url" placeholder="URL where code is hosted (e.g., GitHub)" value="" />
		    <div class="col-md-12 input-info">And/or, upload the code (source, executable, readme) as an archive.</div>
		    <div class="input-group">
			<span class="input-group-btn">
				<button class="btn btn-primary btn-file">Upload&hellip;<input type="file" multiple></button>
			</span>
			<input type="text" class="form-control" readonly>
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_implementation_version">Version</label>
		    <input type="text" class="form-control" id="input_implementation_version" placeholder="Version number, commit hash, ..." value=""/>
		  </div>

		</div>

	      <div class="col-md-6">
		  <h2>Attribution</h2>
		  <div class="form-group">
		    <label class="control-label" for="input_implementation_creator">Author(s)</label>
		    <input type="text" class="form-control" id="input_implementation_creator" placeholder="The author(s) of the implementation. Firstname Lastname, Firstname Lastname,..." value="" />
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_implementation_contributor">Contributor(s)</label>
		    <input type="text" class="form-control" id="input_implementation_contributor"
			placeholder="Other contributor(s) of the implementation" value="" />
		  </div>
		  <div class="form-group">
		  <label class="control-label" for="input_implementation_licence">Licence</label> - <a href="http://choosealicense.com/licenses/" target="_blank">Learn more</a>
			<select class="form-control">
			  <option>MIT License (most permissive)</option>
			  <option>Apache License</option>
			  <option>BSD 2-Clause License</option>
			  <option>BSD 3-Clause License</option>
			  <option>Mozilla Public License (MPL 2.0)</option>
			  <option>General Public License Version 2 (GPL v2) </option>
			  <option>General Public License Version 3 (GPL v3) </option>
			  <option>Lesser General Public License (LGPL v3)</option>
			  <option>Eclipse Public License</option>
			  <option>Public Domain (CC0)</option>
			  <option>No License (no distribution/ modification allowed)</option>
			</select>
	          </div>
		  <div class="form-group">
			    <label class="control-label" for="input_implementation_licence">Citation</label>
			    <textarea class="form-control" id="input_implementation_licence"  placeholder="How to reference this work in papers." value=""></textarea>			         		  </div>
		  <div class="form-group">
		    <label class="control-label" for="sourcefile">Paper/preprint</label>
		    <input type="text" class="form-control" id="source_url" placeholder="URL to paper or preprint describing the code." value="" />
		  </div>
		</div>
	      </div>
	      <div class="row">
	      <div class="col-md-12">
	      <h2>Further information</h2>
		<div class="form-group">
		  <label class="control-label">Parameters</label>
		  <div class="row" style="padding-left:13px;padding-right:13px">
		  <div id="addparameter">
		  <div class="form-group col-sm-2 stretch">
		    <label class="sr-only" for="parname">Name</label>
		    <input type="text" class="form-control parname" id="parname" placeholder="Name (required)">
		  </div>
		  <div class="form-group col-sm-5 stretch">
		    <label class="sr-only" for="parinfo">Description</label>
		    <input type="text" class="form-control parinfo" id="parinfo" placeholder="Description (required)">
		  </div>
		  <div class="form-group col-sm-1 stretch">
		    <label class="sr-only" for="pardefault">Default</label>
		    <input type="text" class="form-control pardefault" id="pardefault" placeholder="Default value">
		  </div>
		  <div class="form-group col-sm-2 stretch">
		    <label class="sr-only" for="parrange">Range</label>
		    <input type="text" class="form-control parrange" id="parrange" placeholder="Recommended range">
		  </div>
		  <div class="form-group col-sm-1 stretch">
		    <label class="sr-only" for="parinfo">Datatype</label>
		    <select type="text" class="form-control pardatatype" id="pardatatype" placeholder="Data type" style="height:30px">
  			<option>Integer</option><option>Real</option><option>Nominal</option><option>Boolean</option></select>
		  </div>
		</div>
 		<span class="btn btn-success btn-sm col-xs-1 addparam"><i class="fa fa-plus-circle fa-lg"></i> Add</span>
 		<div id="parameterbox" class="col-sm-12 stretch"></div>
	       </div>

		  <script>
		    var $input = $("#addparameter").children();

		    $(".addparam").on("click", function(){
		       var $newField = $input.clone();
		       // change what you need to do with the field here.
		       $("#parameterbox").append($newField);
		       $("#parname").attr({value: '', placeholder: 'Name (required)'});
		       $("#parinfo").attr({value: '', placeholder: 'Description (required)'});
		       $("#pardatatype").attr({value: 'Integer', placeholder: 'Data type'});
		       $("#pardefault").attr({value: '', placeholder: 'Default value'});
		       $("#parrange").attr({value: '', placeholder: 'Recommended range'});
		    });
		  </script>

		  <div class="form-group">
		    <label class="control-label" for="input_implementation_language">Programming Language</label>
		    <input type="text" class="form-control" id="input_implementation_language" placeholder="The programming language(s) used" value="" onblur=""/>
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_implementation_dependencies">Dependencies</label>
		    <input type="text" class="form-control" id="input_implementation_dependencies" placeholder="Dependencies, packages used" value="" onblur=""/>
		  </div>

		  <div class="form-group">
		    <input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
		  </div>
                </div>
		</div>
	</form>
</div> <!-- end container -->
