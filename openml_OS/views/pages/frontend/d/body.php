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


<div class="sectionheader">
<div class="sectionlogo"><a href="">OpenML</a></div>
<div class="sectiontitlegreen"><a href="d">Data</a></div>
</div>
<div class="bs-docs-container topborder">
    <div class="col-xs-12 col-sm-3 col-md-2 searchbar">
        <!-- Upload stuff -->
	<div class="upload">
        <button type="button" data-toggle="tab" data-target="#datashare" class="btn btn-success" style="width:100%; text-align:left;"><i class="fa fa-cloud-upload fa-lg" style="padding-right:5px;"></i> Add data</button>
        </div><!-- upload -->

	<!-- Search -->
	<form class="form" method="post" action="d">
	<div class="input-group" style="margin-bottom:7px;">
	  <span class="input-group-addon" style="background-color:#5cb85c; color:#FFFFFF; border-color:#5cb85c"><i class="fa fa-search fa-fw"></i></span>
	  <input type="text" class="form-control" style="width: 100%; height: 30px; font-size: 11pt;" id="openmlsearch" name="searchterms" placeholder="Search datasets" value="<?php if( $this->terms != false ) echo $this->terms; ?>" />
	</div>
	Filters:
	<div class="row">

  	  <div class="col-sm-12">
	    <div class="option-heading">
		<a data-toggle="collapse" href="#collapseCodeInput">
		  <i class="fa fa-caret-down fa-fw"></i> Format
		</a>
	    </div>
	    <div id="collapseCodeInput" class="panel-collapse collapse">
	      <div class="option-body">
		<div class="checkbox">
			<label><input type="checkbox" value="check-classification" checked disabled>ARFF (Tabular)</label>
                </div>
              </div>
	    </div>
          </div>

  	  <div class="col-sm-12">
	    <div class="option-heading">
		<a data-toggle="collapse" href="#collapseChars">
		   <i class="fa fa-caret-down fa-fw"></i> Characteristics
		</a>
	    </div>
	    <div id="collapseChars" class="panel-collapse collapse">
	      <div class="option-body">
		<div class="form-group optgroup">
		  <div class="optslidertitle">Instances</div>
		  <div class="optslider col-xs-12"><input type="text" name="numberinstances" value="" data-slider-min="<?php echo $this->dqrange['NumberOfInstances']['min']; ?>" data-slider-max="<?php echo $this->dqrange['NumberOfInstances']['max']; ?>" data-slider-step="1" data-slider-value="[<?php echo $this->nrinstances_min; ?>,<?php echo $this->nrinstances_max; ?>]" id="sl1" ></div> 
		</div>
		<div class="form-group optgroup">
		  <div class="optslidertitle">Features</div>
		  <div class="optslider col-xs-12"><input type="text" value="" name="numberfeatures" data-slider-min="<?php echo $this->dqrange['NumberOfFeatures']['min']; ?>" data-slider-max="<?php echo $this->dqrange['NumberOfFeatures']['max']; ?>" data-slider-step="1" data-slider-value="[<?php echo $this->nrfeatures_min; ?>,<?php echo $this->nrfeatures_max; ?>]" id="sl2" ></div> 
		</div>
		<div class="form-group optgroup">
		  <div class="optslidertitle">Classes</div>
		  <div class="optslider col-xs-12"><input type="text" value="" name="numberclasses" data-slider-min="<?php echo $this->dqrange['NumberOfClasses']['min']; ?>" data-slider-max="<?php echo $this->dqrange['NumberOfClasses']['max']; ?>" data-slider-step="1" data-slider-value="[<?php echo $this->nrclasses_min; ?>,<?php echo $this->nrclasses_max; ?>]" id="sl3" ></div> 
		</div>
		<div class="form-group optgroup">
		  <div class="optslidertitle">Missing vals</div>
		  <div class="optslider col-xs-12"><input type="text" value=""  name="numbermissing" data-slider-min="<?php echo $this->dqrange['NumberOfMissingValues']['min']; ?>" data-slider-max="<?php echo $this->dqrange['NumberOfMissingValues']['max']; ?>" data-slider-step="1" data-slider-value="[<?php echo $this->nrmissing_min; ?>,<?php echo $this->nrmissing_max; ?>]" id="sl4"></div> 
		</div>

		<script> $('#sl1').slider(); $('#sl2').slider(); $('#sl3').slider(); $('#sl4').slider();  </script>
	      </div>
	    </div>
          </div>
        </div>		  
	<button class="btn btn-default btn-small" style="width:100%; margin-top:10px;" type="submit">Search</button>
	</form>

    </div> <!-- end col-2 -->

    <div class="col-xs-12 col-sm-9 col-md-10 openmlsectioninfo">
     <div class="tab-content">
      <div class="tab-pane <?php if(false === strpos($_SERVER['REQUEST_URI'],'/d/')) { echo 'active'; } ?>" id="intro">
      <?php 
	if( $this->terms == false) { ?>
      <div class="greenheader">
      <h1>Data</h1>
      <p>Input data for machine learning applications, challenging the community to find the best performing algorithms. They are either uploaded or referenced by url. OpenML indexes all data sets and keeps tracks of versions, citations and reuse. Moreover, for selected data formats, OpenML also computes <a href="a">data characteristics</a>, generates <a href="t">tasks</a>, collects all results from all users, and organizes everything online.</p>
      </div>
      <h2>Popular</h2>
      <?php } ?> 
	<?php
	if($this->dataset_count>0) {
		echo '<div class="searchstats">Searched ' . $this->dataset_total . ' datasets and found ' . $this->dataset_count . ' matches (' . $this->time . ' seconds)</div>';	
		
		foreach( $this->results_all as $r ): if($r['type'] != 'dataset') continue;?>
			<div class="searchresult">
				<i class="<?php echo $r['icon'] ?>"></i>
				<a href="d/<?php echo urlencode($r['id']); ?>"><?php echo $r['name']; ?></a><br />
				<div class="teaser"><?php echo teaser($r['description'], 150); ?></div>
				<div class="runStats"><?php echo $r['runs'];?> runs - <?php echo $r['instances'];?> instances - <?php echo $r['features'];?> features - <?php echo $r['classes'];?> classes - <?php echo $r['missing'];?> missing values</div>
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
	<form class="form" method="post" action="d">
	<input type="hidden" name="searchterms" value="all">
	<button type="submit" class="btn btn-primary"></i> Show all</button>	
	</form>
        <?php } ?> 
     </div> <!-- end intro tab -->
     <div class="tab-pane sharing" id="datashare">
	      <h1 class="modal-title" id="myModalLabel">Add datasets</h1>
              <div id="responseImplementationTxt" class="<?php echo $this->initialMsgClass;?>"><?php echo $this->initialMsg; ?></div>
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
		  <label class="control-label" for="input_dataset_licence">Licence</label> - <a href="http://creativecommons.org/licenses/" target="_blank">Learn more</a>
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
	</div>
     </div> <!-- end tab share -->
     <div class="tab-pane <?php if(false !== strpos($_SERVER['REQUEST_URI'],'/d/')) { echo 'active'; } ?>" id="codedetail">
     	<?php 
	 if(false !== strpos($_SERVER['REQUEST_URI'],'/d/')) {
		subpage('dataset'); 
	}?>
     </div>
     </div> <!-- end tabs content -->
    </div> <!-- end col-9 -->
</div> <!-- end container -->
