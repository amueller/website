<div class="searchresult panel">
  <h2>Ask new question</h2>
	<form method="post" action="frontend/page/discuss" id="createThreadForm">
			<?php echo form_input($this->title);?>
			<?php echo form_textarea($this->body);?>
			<?php echo form_submit('submit', 'Create');?>
	</form>
</div>
