<div class="panel">
    <?php
    $authimg = "img/community/misc/anonymousMan.png";
    if ($this->author)
        $authimg = htmlentities(authorImage($this->author->image));
    ?>
    <div class="col-sm-2">
        <img src="<?php echo $authimg; ?>" width="130" height="130" class="img-circle userimage" />
        <?php if ($this->is_owner || $this->ion_auth->is_admin()) { ?>
            <a href="#edit" data-toggle="tab" class="btn btn-primary">Edit Profile</a><br />
        <?php } ?>
    </div>
    <div class="col-sm-7 userdata">
        <h1 class="username"><?php echo $this->userinfo['first_name'] . ' ' . $this->userinfo['last_name']; ?></h1>
        <div class="userbio"><?php echo $this->userinfo['bio']; ?></div>
        <div class="userdetails">
            <?php if ($this->userinfo['affiliation']) echo '<i class="fa fa-fw fa-institution"></i> ' . $this->userinfo['affiliation']; ?>
            <?php if ($this->userinfo['country']) echo '<i class="fa fa-fw fa-map-marker"></i> ' . $this->userinfo['country']; ?>
            <i class="fa fa-fw fa-clock-o"></i> Joined <?php echo date("Y-m-d", $this->userinfo['date']); ?>
        </div>
    </div>
<?php if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->user()->row()->gamification_visibility == 'show') {?>
    <div class="col-sm-3 score">
        <div class="well" style="font-size:120%" title="Gamification scores and number of uploads">
            <div class="row">
                <div class="col-sm-1"><i class="fa fa-bolt activity"></i></div>
                <div class="col-sm-4"> <?php echo $this->userinfo['activity']; ?></div>
                <div class="col-sm-1"><i class="fa fa-database dataset"></i></div>
                <div class="col-sm-4"> <?php echo $this->userinfo['datasets_uploaded']; ?></div>
            </div>
            <div class="row">
                <div class="col-sm-1"><i class="fa fa-rss reach"></i></div>
                <div class="col-sm-4"> <?php echo $this->userinfo['reach']; ?></div>
                <div class="col-sm-1"><i class="fa fa-cogs flow"></i></div>
                <div class="col-sm-4"> <?php echo $this->userinfo['flows_uploaded']; ?></div>
            </div>
            <div class="row">
                <div class="col-sm-1"><i class="material-icons impact" style="font-size: 16px;">flare</i></div>
                <div class="col-sm-4"> <?php echo $this->userinfo['impact']; ?></div>
                <div class="col-sm-1"><i class="fa fa-trophy task"></i></div>
                <div class="col-sm-4"> <?php echo $this->userinfo['tasks_uploaded']; ?></div>
            </div>
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-4"></div>
                <div class="col-sm-1"><i class="fa fa-star run"></i></div>
                <div class="col-sm-4"> <?php echo $this->userinfo['runs_uploaded']; ?></div>
            </div>
        </div>
        <!--<div id="badges" class="well" style="visibility:visible; font-size:120%" title="Highlighted badges">
            <img src="img/testbadge_not_a_noob.svg" alt="nan" style="width:64px;height:64px;">
            <img src="img/testbadge_clockwork_scientist.svg" alt="cs" style="width:64px;height:64px;">
            <img src="img/testbadge_good_news_everyone.svg" alt="cs" style="width:64px;height:64px;">
            <img src="img/testbadge_meteor.svg" alt="cs" style="width:64px;height:64px;">
            <a href="/" style="position:absolute;bottom:15px;right:15px;margin:0;padding:5px 3px;" title="See all badges for this user">more...</a>
        </div>-->
    </div>
    <?php } else{ ?>
    <div class="col-sm-2 col-sm-offset-1 score">
            <div class="well" style="font-size:120%" title="Number of uploads">
                <div class="row">
                    <div class="col-sm-5"><i class="fa fa-database dataset"></i></div>
                    <div class="col-sm-7"> <?php echo $this->userinfo['datasets_uploaded']; ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-5"><i class="fa fa-cogs flow"></i></div>
                    <div class="col-sm-7"> <?php echo $this->userinfo['flows_uploaded']; ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-5"><i class="fa fa-trophy task"></i></div>
                    <div class="col-sm-7"> <?php echo $this->userinfo['tasks_uploaded']; ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-5"><i class="fa fa-star run"></i></div>
                    <div class="col-sm-7"> <?php echo $this->userinfo['runs_uploaded']; ?></div>
                </div>
            </div>
    </div>
<?php }} ?>
</div>

<table class="table usertable">
    <tbody>
        
<?php if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->user()->row()->gamification_visibility == 'show') {?>
        <tr>            
            <td class="borderless"></td>
            <td class="borderless">Activity</td>
            <td class="borderless">Reach</td>
            <td class="borderless"></td>
            <td class="borderless">Impact</td>
        </tr>
<?php }} ?>
      <tr>
         <td class="mainvalue"><div class="col-sm-1"><i class="fa fa-database dataset" ></i></div><div class="col-sm-11"> Data Sets </div></td>
        <td class="subvalue" ><?php echo $this->userinfo['datasets_uploaded'];?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php echo $this->userinfo['downloads_received_data'];?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php echo $this->userinfo['likes_received_data'];?> <i class="fa fa-heart"></i></td>
        <td class="subvalue" ><?php echo $this->userinfo['runs_on_datasets'];?> <i class="fa fa-star"></i></td>
      </tr>
      <tr>
        <td class="mainvalue"><div class="col-sm-1"><i class="fa fa-cogs flow" ></i></div><div class="col-sm-11"> Flows </div></td>
        <td class="subvalue" ><?php echo $this->userinfo['flows_uploaded'];?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php echo $this->userinfo['downloads_received_flow'];?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php echo $this->userinfo['likes_received_flow'];?> <i class="fa fa-heart"></i></td>
        <td class="subvalue" ><?php echo $this->userinfo['runs_on_flows'];?> <i class="fa fa-star"></i></td>
      </tr>
      <tr>
        <td class="mainvalue"><div class="col-sm-1"><i class="fa fa-trophy task" ></i></div><div class="col-sm-11"> Tasks </div></td>
        <td class="subvalue" ><?php echo $this->userinfo['tasks_uploaded'];?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php echo $this->userinfo['downloads_received_task'];?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php echo $this->userinfo['likes_received_task'];?> <i class="fa fa-heart"></i></td>
        <td></td>
      </tr>
      <tr>
        <td class="mainvalue"><div class="col-sm-1"><i class="fa fa-star run" ></i></div><div class="col-sm-11"> Runs </div></td>
        <td class="subvalue" ><?php echo $this->userinfo['runs_uploaded'];?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php echo $this->userinfo['downloads_received_run'];?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php echo $this->userinfo['likes_received_run'];?> <i class="fa fa-heart"></i></td>
        <td></td>
      </tr>
    </tbody>
  </table>


<?php if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->user()->row()->gamification_visibility == 'show') {?>
<div class="row">    
    <ul class="nav nav-pills activity">
        <li class="col-sm-4 mainvalue active" title="Activity is: 3x uploads done + 2x likes given + downloads done"><a data-toggle="tab" onclick=redrawActivityChart("Activity")> <i class="fa fa-bolt"></i> Activity: <?php echo $this->userinfo['activity']; ?></a></li>
        <li class="mainvalue" title="The number of uploads you have done"><a data-toggle="tab" onclick=redrawActivityChart("Uploads")><?php echo $this->userinfo['nr_of_uploads']; ?> <i class="fa fa-cloud-upload"></i></a></li>
        <li class="mainvalue" title="The number of likes you have done"><a data-toggle="tab" onclick=redrawActivityChart("Likes")><?php echo $this->userinfo['nr_of_likes']; ?> <i class="fa fa-heart"></i></a></li>
        <li class="mainvalue" title="The number of things you have downloaded"><a data-toggle="tab" onclick=redrawActivityChart("Downloads")><?php echo $this->userinfo['nr_of_downloads']; ?> <i class="fa fa-cloud-download"></i></a></li>
        <li> <a data-toggle="collapse" href="#Activity-chart"><i class="fa fa-2x fa-chevron-up" id="activitytoggle" style="visibility: hidden"></i></a></li>
    </ul>
    <div class="col-sm-12 collapse" id="Activity-chart">
        <div id="activityplot" class="row">
            Loading...
        </div>
    </div>
</div>
<div class="row">
   <ul class="nav nav-pills reach">
        <li class="col-sm-4 mainvalue active" title="Reach is: 2x likes received + downloads received"><a data-toggle="tab" onclick=redrawReachChart("Reach")> <i class="fa fa-rss"></i> Reach: <?php echo $this->userinfo['reach']; ?></a></li>
        <li class="mainvalue" title="The number of likes your uploads have gotten"><a data-toggle="tab" onclick=redrawReachChart("Likes")><?php echo $this->userinfo['likes_received']; ?> <i class="fa fa-heart"></i></a></li>
        <li class="mainvalue" title="The number of distinct downloads of your uploads"><a data-toggle="tab" onclick=redrawReachChart("Downloads")><?php echo $this->userinfo['downloads_received']; ?> <i class="fa fa-cloud-download"></i></a></li>
        <li> <a data-toggle="collapse" href="#Reach-chart"><i class="fa fa-2x fa-chevron-up" id="reachtoggle" style="visibility: hidden"></i></a></li>
    </ul>
    <div class="col-sm-12 collapse" id="Reach-chart">
        <div id="reachplot" class="row">
            Loading...
        </div>
    </div>
</div>
<div class="row">
    <ul class="nav nav-pills impact" title="Impact is: 0.5*reach of reuse of knowledge">
        <li class="col-sm-4 mainvalue active"><a data-toggle="tab" onclick=redrawImpactChart("Impact")> <i class="material-icons" style="font-size: 28px">flare</i> Impact: <?php echo $this->userinfo['impact']; ?></a></li>
        <!--<li class="mainvalue"><a data-toggle="tab" onclick=redrawImpactChart("Reach_re")><?php echo $this->userinfo['reach_of_reuse']; ?> <i class="fa fa-rss"></i></a></li>-->
        <!--<li class="mainvalue"><a data-toggle="tab" onclick=redrawImpactChart("Impact_re")><?php echo $this->userinfo['impact_of_reuse']; ?> <i class="material-icons" style="font-size: 28px">flare</i></i></a></li>-->
        <li> <a data-toggle="collapse" href="#Impact-chart"><i class="fa fa-2x fa-chevron-up" id="impacttoggle" style="visibility: hidden"></i></a></li>
    </ul>
    <div class="col-sm-12 collapse" id="Impact-chart">
        <div id="impactplot" class="row">
            Loading...
        </div>
    </div>
</div>
<?php }} ?>



