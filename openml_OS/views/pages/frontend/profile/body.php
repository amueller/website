<div class="header-panel">
  <div class="col-sm-3 hidden-xs" style="padding-top:20px;">
  </div>

<div class="pages col-sm-9">
  <div class="col-sm-10">
    <div class="well page" style="position: relative; z-index:1030 !important">
      <h2>Edit Profile</h2>
      <?php echo form_open_multipart("frontend/page/profile");?>
      <fieldset>
        <div class="inputs">
            <?php echo form_input($this->emailField);?>
            <?php echo form_input($this->password_old);?>
            <?php echo form_input($this->password_new);?>
            <?php echo form_input($this->password_confirm);?>
            <?php echo form_input($this->first_name);?>
            <?php echo form_input($this->last_name);?>
            <?php echo form_input($this->affiliation);?>
            <?php echo form_input($this->country);?>
            <?php echo form_textarea($this->bio);?>
            <img src="<?php echo htmlentities( authorImage( $this->user->image ) ); ?>" width="80" class="img-circle" style="padding: 10px;" alt="<?php echo $this->user->first_name . ' ' . $this->user->last_name; ?>" /><br/>
            <?php echo form_input_nostyle($this->image);?>
          </div>
          <div class="form-group"><?php echo form_submit('submit', 'Update');?></div>
        </fieldset>
        <?php echo form_close();?>
   </div>
 </div>
</div>
</div>
