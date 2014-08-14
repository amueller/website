<div class="container-fluid topborder">
  <div class="row">
   <div class="col-xs-12 col-sm-4 col-sm-offset-4 openmlsectioninfo">
   <h1>Log in</h1>
    <?php echo form_open("frontend/page/login");?>
    <div class="form-group">
      <label for="identity">Username or Email</label>
      <?php echo form_input($this->identity);?>
    </div>
    <div class="form-group">
      <label for="password">Password (<a href="password_forgot">forgot password</a>)</label>
      <?php echo form_input($this->password);?>
       
    </div>
    <div class="form-group">
      <?php echo form_submit('submit', 'Login');?>
    </div>
    <?php echo form_close();?>

    Not registered yet? <a href="register">Join OpenML now!</a><br />
  </div>
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
