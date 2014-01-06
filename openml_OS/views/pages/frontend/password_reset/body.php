<div class="container bs-docs-container">
  <div class="col-md-6">
    <div class="bs-header">
      <div class="container">
        <div class="row">
          <h2>Reset password</h2>
          <p>Enter a new password. </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6" style="margin-top:30px">
    <?php echo form_open('frontend/page/password_reset?code='.$this->code);?>
    <fieldset>
      <div class="form-group">
        <label for="email">New password:</label>
        <?php echo form_input($this->new_password);?>
      </div>
      <div class="form-group">
        <label for="email">Confirm password:</label>
        <?php echo form_input($this->new_password_confirm);?>
      </div>
      
      <?php echo form_input($this->user_id);?>
	    <?php echo form_hidden($this->csrf); ?>
      
      <div class="form-group"><?php echo form_submit('submit', 'Submit');?></div>
    </fieldset>
    <?php echo form_close();?>
  </div>
</div>
