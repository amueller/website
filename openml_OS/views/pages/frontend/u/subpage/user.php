  <div class="panel">
    <?php
      $authimg = "img/community/misc/anonymousMan.png";
      if ($this->author)
        $authimg = htmlentities( authorImage( $this->author->image ) );
    ?>
     <div class="col-sm-2">
       <img src="<?php echo $authimg; ?>" width="130" height="130" class="img-circle userimage" />
     </div>
     <div class="col-sm-10 userdata">
       <h1 class="username"><?php echo $this->userinfo['first_name'] . ' ' . $this->userinfo['last_name']; ?></h1>
       <div class="userbio"><?php echo $this->userinfo['bio']; ?></div>
       <div class="userdetails">
       <?php if($this->userinfo['affiliation']) echo '<i class="fa fa-fw fa-institution"></i> '.$this->userinfo['affiliation'];?>
       <?php if($this->userinfo['country']) echo '<i class="fa fa-fw fa-map-marker"></i> '.$this->userinfo['country'];?>
       <i class="fa fa-fw fa-clock-o"></i> Joined <?php echo date("Y-m-d", $this->userinfo['date']); ?>
       <br clear="all"/>
       </div>
       <?php if($this->is_owner || $this->ion_auth->is_admin()){?>
          <a href="#edit" data-toggle="tab" class="btn btn-primary">Edit Profile</a><br />
       <?php } ?>
     </div>
   </div>

  <div class="col-sm-4">
    <div class="panel panel-simple panel-success">
     <div class="panel-heading">Data Sets</div>
     <div class="panel-body">
       <div class="col-xs-6">
       <div class="mainvalue"><?php echo $this->userinfo['datasets_uploaded'];?></div> uploaded
       </div>
       <div class="col-xs-6">
       <div class="mainvalue"><?php echo $this->userinfo['runs_on_datasets'];?></div> used in runs
     </div>
    </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="panel panel-simple panel-info">
     <div class="panel-heading">Flows</div>
     <div class="panel-body">
       <div class="col-xs-6">
       <div class="mainvalue"><?php echo $this->userinfo['flows_uploaded'];?></div> uploaded
       </div>
       <div class="col-xs-6">
       <div class="mainvalue"><?php echo $this->userinfo['runs_on_flows'];?></div> used in runs
     </div>
    </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="panel panel-simple panel-danger">
     <div class="panel-heading">Runs</div>
     <div class="panel-body">
       <div class="col-xs-6">
       <div class="mainvalue"><?php echo $this->userinfo['runs_uploaded'];?></div> uploaded
       </div>
    </div>
    </div>
  </div>
