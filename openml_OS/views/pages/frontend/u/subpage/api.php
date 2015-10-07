<div class="col-sm-3 hidden-xs" style="padding-top:20px;">
</div>

<div class="col-sm-9">
<div class="col-sm-10">
  <div class="panel">
    <h2>API Authentication</h2>
    <h4>API key</h4>
    <p><?php echo ($this->author->session_hash ? $this->author->session_hash : 'No API key known.' );?></p>
    <form name="keyreset" method="post">
      <input type="submit" name="key-reset" class="btn btn-warning btn-raised" value="Reset API Key" />
    </form>
    <p style="color:#999"><i class="fa fa-fw fa-warning"></i>This key uniquely identifies you on OpenML. Keep it secret.</p>
 </div>
</div>
</div>
