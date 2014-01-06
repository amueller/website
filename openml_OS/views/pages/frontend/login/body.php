<div class="container bs-docs-container">
  <div class="col-md-6">
    <div class="bs-header">
      <div class="container">
        <div class="row">
          <h2>Login</h2>
          <p>Welcome back.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6" style="margin-top:30px">
    <?php echo form_open("frontend/page/login");?>
    <div class="form-group">
      <label for="identity">Email/Username:</label>
      <?php echo form_input($this->identity);?>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <?php echo form_input($this->password);?>
    </div>
    <div class="form-group">
      <?php echo form_submit('submit', 'Login');?>
    </div>
    <?php echo form_close();?>
    Password forgotten? <a href="password_forgot">Click here</a>. 
  </div>
</div>
<!--<div class="row">
  <div class="col-md-8">
  	<a href="frontend/oauth/twitter"><img src="img/community/icons/twitter.png" width="32" title="Twitter" /></a>
  	<a href="frontend/oauth/facebook"><img src="img/community/icons/facebook.png" width="32" title="Facebook" /></a>
  	<a href="frontend/oauth/google"><img src="img/community/icons/google.png" width="32" title="Google" /></a>
  </div>
  </div>
  <div class="row">
  <div class="col-md-8">
  	<small>
  		(*) Please login with your OpenML account, select a Social Network. 
  		When you choose to login with a Social Network, we will only use this for authentication purposes. 
  		We will not be able to post on your behalf at the concerning Social Media.
  	</small>
  </div>
  </div>-->
