<form method="post" action="" enctype="multipart/form-data">

<div class="panel">
	<h1><a href="d"><i class="fa fa-flask"></i></a> Create study</h1>
      <div id="responseDatasetTxt" class="<?php echo $this->responsetype; ?>"><?php echo $this->response; ?></div>
		  <div class="form-group has-error">
		    <label class="control-label" for="name">Name</label>
		    <input type="text" class="form-control" name="study_name" id="study_name" placeholder="A good name" value="<?php echo $this->input->post('name'); ?>"/>
		  </div>
			<div class="form-group has-error">
 	      <label class="control-label" for="tag">Short name</label>
 		    <input type="text" class="form-control" name="name" id="name" placeholder="A short name for tagging (no spaces)" value="<?php echo $this->input->post('tag'); ?>"/>
 	    </div>
		  <div class="form-group has-error">
		    <label class="control-label" for="description">Description</label>
		    <textarea class="form-control" name="description" id="description" rows="5" placeholder="Short description (can still be edited online)." value=""><?php echo $this->input->post('description'); ?></textarea>
		  </div>
  </div>

	  <div class="row">
	    <div class="col-sm-12">
			  <div class="form-group">
			    <input class="btn btn-primary" type="submit" name="create" value="Create"/>
			  </div>
      </div>
    </div>
	</form>

</div> <!-- end container -->
