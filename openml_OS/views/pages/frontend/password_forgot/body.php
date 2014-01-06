<div class="container bs-docs-container">
  <div class="col-md-6">
    <div class="bs-header">
      <div class="container">
        <div class="row">
          <h2>Forgot password</h2>
          <p>We will send you an email with instructions. </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6" style="margin-top:30px">
    <?php echo form_open('frontend/page/password_forgot');?>
    <fieldset>
      <div class="form-group">
        <label for="email">Email adress:</label>
        <?php echo form_input($this->emailField);?>
      </div>
      <div class="form-group"><?php echo form_submit('submit', 'Submit');?></div>
    </fieldset>
    <?php echo form_close();?>
  </div>
</div>
