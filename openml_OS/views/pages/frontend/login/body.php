<div id="login-dialog" class="modal fade" tabindex="-1">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h2 class="modal-title">Sign in</h2>
  </div>
  <div class="modal-body">
    <?php echo form_open("frontend/page/login");?>
    <fieldset>
      <div class="inputs">
        <?php echo form_input($this->identity);?>
        <?php echo form_input($this->password);?>
      </div>
      <div class="form-group">
        <?php echo form_submit('submit', 'Sign in');?>
        <a href="register" class="btn pull-right">No account? Join OpenML</a>
        <a href="password_forgot" class="btn pull-right">Forgot password</a>
      </div>
    </fieldset>
    <?php echo form_close();?>
  </div>
 </div>
</div>
</div>
