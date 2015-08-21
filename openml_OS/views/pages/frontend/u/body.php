<div class="container-fluid topborder endless openmlsectioninfo">
  <div class="col-xs-12 col-md-10 col-md-offset-1" id="mainpanel">

    <div class="tab-content">
      <div class="tab-pane  <?php if(in_array($this->subpage,$this->legal_subpages)) { echo 'active'; } ?>" id="data">
        <?php
        subpage('data');
        ?>
      </div> <!-- end intro tab -->

      <div class="tab-pane <?php if(!in_array($this->subpage,$this->legal_subpages) and false !== strpos($_SERVER['REQUEST_URI'],'/u/')) { echo 'active'; }?>" id="userdetail">
        <?php
        subpage('user');
        ?>
      </div> <!-- end task_type tab -->

    </div> <!-- end tabs content -->

    <div class="submenu">
      <ul class="sidenav nav" id="accordeon">
        <li class="panel guidechapter">
          <a data-toggle="collapse" data-parent="#accordeon"  data-target="#pagelist"><i class="fa fa-user fa-fw fa-lg"></i> <b>My account</b></a>
          <ul class="sidenav nav collapse in" id="pagelist">
            <li><a href="<?php echo $this->baseurl;?>">Profile page</a></li>
            <?php if($this->is_owner){?>
               <li><a href="profile">Edit Profile</a></li>
            <?php } ?>
          </ul>
        </li>
      </ul>
      <ul class="sidenav nav" id="accordeon">
        <li class="panel guidechapter">
          <a data-toggle="collapse" data-parent="#accordeon"  data-target="#pagelist"><i class="fa fa-cubes fa-fw fa-lg"></i> <b>My data</b></a>
          <ul class="sidenav nav collapse in" id="pagelist">
            <li><a href="<?php echo BASE_URL .'u/' . $this->user_id . '/data';?>">Data sets</a></li>
            <li><a href="<?php echo BASE_URL .'u/' . $this->user_id . '/flows';?>">Flows</a></li>
            <li><a href="<?php echo BASE_URL .'u/' . $this->user_id . '/runs';?>">Runs</a></li>
          </ul>
        </li>
      </ul>
    </div>

  </div> <!-- end panel -->
</div> <!-- end container -->
