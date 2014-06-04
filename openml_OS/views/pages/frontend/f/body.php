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


<div class="sectionheader">
<div class="sectionlogo"><a href="">OpenML</a></div>
<div class="sectiontitleblue"><a href="f">Flows</a></div>
</div>
<div class="bs-docs-container topborder">
    <div class="col-sm-12 col-md-2 searchbar">
        <!-- Upload stuff -->
	<div class="upload">
        <button type="button" data-toggle="tab" data-target="#codeshare" class="btn btn-primary" style="width:100%; text-align:left;"><i class="fa fa-cloud-upload fa-lg" style="padding-right:5px;"></i> Add flows</button>
        </div><!-- upload -->

	<!-- Search -->
	<form class="form" method="post" action="f">
	<div class="input-group" style="margin-bottom:7px;">
	  <span class="input-group-addon" style="background-color:#428bca; color:#FFFFFF; border-color:#428bca"><i class="fa fa-search fa-fw"></i></span>
	  <input type="text" class="form-control" style="width: 100%; height: 30px; font-size: 11pt;" id="openmlsearch" name="searchterms" placeholder="Search flows" value="<?php if( $this->terms != false ) echo $this->terms; ?>" />
	</div>
	Filters:
	<div class="row">
  	  <div class="col-xs-4 col-sm-12">
	    <div class="option-heading">
		<a data-toggle="collapse" href="#collapseCodeTasks">
		   <i class="fa fa-caret-down fa-fw"></i> Tasks
		</a>
	    </div>
	    <div id="collapseCodeTasks" class="panel-collapse collapse">
	      <div class="option-body">
		<div class="checkbox">
			<label><input type="checkbox" value="check-classification">Classification</label>
                </div>
		<div class="checkbox">
			<label><input type="checkbox" value="check-regression">Regression</label>
                </div>
	      </div>
	    </div>
          </div>
  	  <div class="col-xs-4 col-sm-12">
	    <div class="option-heading">
		<a data-toggle="collapse" href="#collapseCodeInput">
		  <i class="fa fa-caret-down fa-fw"></i> Input Format
		</a>
	    </div>
	    <div id="collapseCodeInput" class="panel-collapse collapse">
	      <div class="option-body">
		<div class="checkbox">
			<label><input type="checkbox" value="check-classification">ARFF (Tabular)</label>
                </div>
              </div>
	    </div>
          </div>
  	  <div class="col-xs-4 col-sm-12">
	    <div class="option-heading">
		<a data-toggle="collapse" href="#collapseCodeAttr">
		   <i class="fa fa-caret-down fa-fw"></i> Attribute types
		</a>
	    </div>
	    <div id="collapseCodeAttr" class="panel-collapse collapse">
	      <div class="option-body">
		<div class="checkbox">
			<label><input type="checkbox" value="check-classification">Numerical</label>
                </div>
		<div class="checkbox">
			<label><input type="checkbox" value="check-regression">Categorical</label>
                </div>
	      </div>
	    </div>
          </div>
        </div>		  
	<button class="btn btn-default btn-small" style="width:100%; margin-top:10px;" type="submit">Search</button>
	</form>

    </div> <!-- end col-2 -->

    <div class="col-sm-12 col-md-10 openmlsectioninfo">
     <div class="tab-content">
      <div class="tab-pane <?php if(false === strpos($_SERVER['REQUEST_URI'],'/f/')) { echo 'active'; } ?>" id="intro">
      <?php 
	if( $this->terms == false) { ?>
      <div class="blueheader">
      <h1>Flows</h1>
      <p>Flows are implementations (programs, scripts, workflows) that solve OpenML tasks. They are either uploaded or referenced by url, so that anyone can easily find and run them, often through a <a href="plugins">plugin</a>. OpenML indexes all flows, keeps track of versions, citations and reuse, collects all results from all users, and organizes everything online.</p>
      </div>
      <h2>Popular</h2>
      <?php } ?> 
	<?php
	if($this->implementation_count>0) {
		echo '<div class="searchstats">Showing ' . $this->implementation_count . ' of ' . $this->implementation_total . ' results (' . $this->time . ' seconds)</div>';	
		
		foreach( $this->results_all as $r ): if($r['type'] != 'implementation') continue;?>
			<div class="searchresult">
				<a href="f/<?php echo urlencode($r['id']); ?>"><?php echo $r['name']; ?></a><br />
				<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
				<div class="runStats"><?php echo $r['runs'] . ' runs'; ?></div>
			</div><?php 
		endforeach;
	} else {
		if( $this->terms != false ) {
			o('no-search-results');
		} else {
	    o('no-results');
	  }
	}
	if( $this->terms == false) { ?>
	<form class="form" method="post" action="f">
	<input type="hidden" name="searchterms" value="all">
	<button type="submit" class="btn btn-primary"></i> Show all</button>	
	</form>
        <?php } ?> 
     </div> <!-- end intro tab -->
     <div class="tab-pane sharing" id="codeshare">
	      <h1 class="modal-title" id="myModalLabel">Add flows</h1>
              <div id="responseImplementationTxt" class="<?php echo $this->initialMsgClass;?>"><?php echo $this->initialMsg; ?></div>
	      <form method="post" id="implementationForm" action="api/?f=openml.implementation.upload" enctype="multipart/form-data">
		  <input type="hidden" id="generated_input_implementation_description" name="description" value="" />
	      <div class="row">
		<div class="col-md-6">
		  <h2>Required information</h2>
		  <div class="form-group">
		    <label class="control-label" for="input_implementation_name">Name</label>
		    <input type="text" class="form-control" id="input_implementation_name" placeholder="The name of the algorithm or workflow" value=""/>
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_implementation_description">Description</label>
		    <textarea class="form-control" id="input_implementation_description" placeholder="Short description of what is implemented. Changes from previous versions." value=""></textarea> 
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="input_implementation_description">Instructions</label>
		    <textarea class="form-control" id="input_implementation_description" placeholder="How to run OpenML tasks." value=""></textarea> 
		  </div>
		  <div class="form-group">
		    <label class="control-label" for="sourcefile">Implementation</label>
		    <div class="col-md-12 input-info-first">For code hosted elsewhere (e.g., GitHub).</div> 
		    <input type="text" class="form-control" id="source_url" placeholder="URL where code is hosted." value="" /> 
		    <div class="col-md-12 input-info">Or, upload the code (source, executable, readme) as an archive.</div>
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
		  <label class="control-label" for="input_implementation_licence">License</label> - <a href="http://choosealicense.com/licenses/" target="_blank">Learn more</a>
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
			  <option>Other</option>
			</select>
	          </div>
		  <div class="form-group">
			    <label class="control-label" for="input_implementation_licence">Citation</label>
			    <textarea class="form-control" id="input_implementation_licence"  placeholder="How to reference this work in papers." value=""></textarea>			         		  </div>
		  <div class="form-group">
		    <label class="control-label" for="sourcefile">Paper/preprint</label>
		    <input type="text" class="form-control" id="source_url" placeholder="URL to paper or preprint." value="" /> 
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
	</div>
     </div> <!-- end tab share -->
     <div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'],'/f/')) { echo 'active'; } ?>" id="codedetail">
     	<?php
	 if(false !== strpos($_SERVER['REQUEST_URI'],'/f/')) {
		subpage('implementation');
	}?>
     </div>
     </div> <!-- end tabs content -->
    </div> <!-- end col-9 -->
</div> <!-- end container -->
