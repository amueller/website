<div class="container bs-docs-container">
   <br/>
   <div class="col-md-12">
        <div class="row">
			<?php o( 'community-breadcrumbs.php' ); ?>
        </div>
   </div>
</div>
<div class="container bs-docs-container">
   <div class="col-md-6">
      <div class="bs-header">
         <div class="container">
            <div class="row">
               <h2>Ask new question</h2>
				<br/>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6" style="margin-top:30px">
		<form method="post" action="frontend/page/community_create" id="createThreadForm">
			<div class="form-group">
				<label for="title">Title</label><br/>
				<?php echo form_input($this->title);?>
			</div>
			<div class="form-group">
				<label for="category">Category</label><br/>
				<?php echo form_dropdown('category',$this->category,gu('cid'));?>
			</div>
			<div class="form-group">
				<label for="body">Question</label><br/>
				<?php echo form_textarea($this->body);?>
			</div><div class="form-group">
				<?php echo form_submit('submit', 'Create');?>
			</div>
		</form>
   </div>
</div>
