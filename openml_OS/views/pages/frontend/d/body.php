<div class="container-fluid topborder endless openmlsectioninfo">
  <div class="col-xs-12 col-md-10 col-md-offset-1" id="mainpanel">

     <div class="tab-content">

     <div class="tab-pane <?php if($this->activetab == 'overview') echo 'active'; ?>" id="data_overview">
       <?php if($this->activetab == 'overview') subpage('dataset'); ?>
     </div>
     <div class="tab-pane <?php if($this->activetab == 'update') echo 'active'; ?>" id="data_update">
       <?php if($this->activetab == 'update') subpage('update'); ?>
     <div>

     </div> <!-- end tabs content -->
    </div> <!-- end col-10 -->

    <div class="submenu">
      <ul class="sidenav nav" id="accordeon">
        <li class="panel guidechapter">
          <a data-toggle="collapse" data-parent="#accordeon"  data-target="#pagelist"><i class="fa fa-info-circle fa-fw fa-lg"></i> <b>Details</b></a>
          <ul class="sidenav nav collapse in" id="pagelist">
            <li class="active"><a href="#data_overview" data-toggle="tab">Overview</a></li>
            <li><a class="loginfirst" href="<?php echo $this->record->{'url'}; ?>">Download data</a></li>
            <li><a href="new/data">Submit new data</a></li>
            <li><a href="new/task">Create a task with this data set</a></li>
          </ul>
        </li>
        <li class="panel guidechapter">
          <a data-toggle="collapse" data-parent="#accordeon"  data-target="#taglist"><i class="fa fa-tag fa-fw fa-lg"></i> <b>Tags</b></a>
          <form method="post" action="" enctype="multipart/form-data">
          <input type="hidden" name="deletetag" id="deletetag"/>
          <ul class="sidenav nav collapse in" id="taglist">
            <li class="tags">
              <?php if(array_key_exists('tags', $this->data)){
                    foreach( $this->data['tags'] as $t) { ?>
                  <span class="label label-material-<?php echo $this->materialcolor; ?> tag"><?php echo $t['tag']; if($t['uploader']==$this->user_id){ ?> <button class="deltag" type="submit" onclick="$('#deletetag').val('<?php echo $t['tag'];?>');" name="<?php echo $t['tag'];?>"><i class="fa fa-times"></i></button><?php } ?></span>
              <?php }} ?>
            </li>
            <li>
                <input type="text" class="form-control floating-label loginfirst" id="newtags" name="newtags" data-hint="Add a single new tag. Use underscores for spaces. Press enter when done."
                 placeholder="Add tag">
            </li>
          </ul>
        </form>
        </li>
      </ul>
    </div>

</div> <!-- end container -->
