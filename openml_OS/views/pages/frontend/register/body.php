<div class="container bs-docs-container">
  <div class="col-md-6">
    <div class="bs-header">
        <div class="row">
          <h2>Join OpenML</h2>
          <p> Collaborate more effectively, build more reputation, and access more resources</p>
          <p style="font-size:14px">We handle your data with respect, that also means no spam.</a></p>
        </div>
    </div>
  </div>
  <div class="col-md-6" style="margin-top:30px">
    <?php echo form_open_multipart("frontend/page/register");?>
    <fieldset>
      <div class="form-group">
        <label for="email">Email adress:</label>
        <?php echo form_input($this->emailField);?>
      </div>
      <div class="form-group">
        <label for="password">Password (min 8 characters):</label>
        <?php echo form_input($this->password);?>
      </div>
      <div class="form-group">
        <label for="password_confirm">Confirm password:</label>
        <?php echo form_input($this->password_confirm);?>
      </div>
      <div class="form-group">
        <label for="first_name">First name:</label>
        <?php echo form_input($this->first_name);?>
      </div>
      <div class="form-group">
        <label for="last_name">Last name:</label>
        <?php echo form_input($this->last_name);?>
      </div>
      <div class="form-group">
        <label for="affiliation">Affiliation:</label>
        <?php echo form_input($this->affiliation);?>
      </div>
      <div class="form-group">
        <label for="country">Country:</label>
        <?php echo form_input($this->country);?>
      </div>
      <div class="form-group">
        <label for="image">Image:</label>
        <?php echo form_input_nostyle($this->image);?>
      </div>
      <div class="form-group"><?php echo form_submit('submit', 'Register');?></div>
    </fieldset>
    <?php echo form_close();?>
  </div>
</div>
