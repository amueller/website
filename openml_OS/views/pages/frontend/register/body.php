<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1 openmlsectioninfo">
    <h1>Register</h1>
    <div class="col-xs-12 col-sm-4 searchbar">
	<ul class="menu">		
		<li><a style="font-size:17px;"><b>You'll love OpenML</b></a></li>
		<li><a><i class="fa fa-fw fa-check" style="color:green;"></i>Research different</a>
		    <a><i class="fa fa-fw fa-check" style="color:green;"></i>Scalable collaboration</a>
		    <a><i class="fa fa-fw fa-check" style="color:green;"></i>Share, find <u>detailed</u> results</a>
		    <a><i class="fa fa-fw fa-check" style="color:green;"></i>Automate experimentation</a>
		    <a><i class="fa fa-fw fa-check" style="color:green;"></i>Open science community</a>
		    <a><i class="fa fa-fw fa-wrench" style="color:orange;"></i>Connect to other scientists</a>
		    <a><i class="fa fa-fw fa-wrench" style="color:orange;"></i>Share data within teams</a>
		    <a><i class="fa fa-fw fa-wrench" style="color:orange;"></i>Organize your work online</a>
		    <a><i class="fa fa-fw fa-wrench" style="color:orange;"></i>Track your impact</a></li>
	</ul>
    </div> <!-- end col-3 -->

    <div class="col-xs-12 col-sm-8">
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
</div>
