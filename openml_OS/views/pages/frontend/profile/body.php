<div class="container bs-docs-container">
   <div class="col-md-6">
      <div class="bs-header">
         <div class="container">
            <div class="row">
               <h2>Profile</h2>
               <p>Edit your personal information</p>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6" style="margin-top:30px">
      <?php echo form_open_multipart("frontend/page/profile");?>
      <p>
         <label for="email">Email adress:</label>
         <?php echo $this->user->email;?>
      </p>
      <p>
         <label for="password">Current Password: (needed for changing password)</label>
         <?php echo form_input($this->password_old);?>
      </p>
      <p>
         <label for="password">Password:</label>
         <?php echo form_input($this->password);?>
      </p>
      <p>
         <label for="password_confirm">Confirm password:</label>
         <?php echo form_input($this->password_confirm);?>
      </p>
      <p>
         <label for="first_name">First name:</label>
         <?php echo form_input($this->first_name);?>
      </p>
      <p>
         <label for="last_name">Last name:</label>
         <?php echo form_input($this->last_name);?>
      </p>
      <p>
         <label for="affiliation">Affiliation:</label>
         <?php echo form_input($this->affiliation);?>
      </p>
      <p>
         <label for="country">Country:</label>
         <?php echo form_input($this->country);?>
      </p>
<hr>
      <p>
         <label for="country">Short bio:</label>
         <?php echo form_input($this->bio);?>
      </p>
      <p>
         <label for="country">Image:</label>
         <img src="<?php echo htmlentities( authorImage( $this->user->image ) ); ?>" width="80" class="img-circle" style="padding: 10px;" alt="<?php echo $this->user->first_name . ' ' . $this->user->last_name; ?>" /><br/>
         <?php echo form_input($this->image);?>
      </p>
      <p><?php echo form_submit('submit', 'Update');?></p>
      <?php echo form_close();?>
   </div>
</div>
