<div class="panel">
    <?php
    //var_dump($this);
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
      if ($this->ion_auth->user()->row()->gamification_visibility == 'show' && $this->userinfo['gamification_visibility'] == 'show') {?>
    <div class="col-sm-3 score">
        <div class="well" style="font-size:120%" title="Gamification scores and number of uploads">
            <div class="row">
                <div class="col-sm-1"><i class="fa fa-bolt activity"></i></div>
                <div class="col-sm-4"><?php if(in_array('activity', $this->userinfo)){ echo $this->userinfo['activity']; }else{echo 0;}?></div>
                <div class="col-sm-1"><i class="fa fa-database dataset"></i></div>
                <div class="col-sm-4"> <?php if(in_array('datasets_uploaded', $this->userinfo)){ echo $this->userinfo['datasets_uploaded']; }else{echo 0;} ?></div>
            </div>
            <div class="row">
                <div class="col-sm-1"><i class="fa fa-rss reach"></i></div>
                <div class="col-sm-4"> <?php if(in_array('reach', $this->userinfo)){ echo $this->userinfo['reach']; }else{echo 0;} ?></div>
                <div class="col-sm-1"><i class="fa fa-cogs flow"></i></div>
                <div class="col-sm-4"> <?php if(in_array('flows_uploaded', $this->userinfo)){ echo $this->userinfo['flows_uploaded']; }else{echo 0;} ?></div>
            </div>
            <div class="row">
                <div class="col-sm-1"><i class="material-icons impact" style="font-size: 16px;">flare</i></div>
                <div class="col-sm-4"> <?php if(in_array('impact', $this->userinfo)){ echo $this->userinfo['impact']; }else{echo 0;} ?></div>
                <div class="col-sm-1"><i class="fa fa-trophy task"></i></div>
                <div class="col-sm-4"> <?php if(in_array('tasks_uploaded', $this->userinfo)){ echo $this->userinfo['tasks_uploaded']; }else{echo 0;} ?></div>
            </div>
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-4"></div>
                <div class="col-sm-1"><i class="fa fa-star run"></i></div>
                <div class="col-sm-4"> <?php if(in_array('runs_uploaded', $this->userinfo)){ echo $this->userinfo['runs_uploaded'];}else{echo 0;} ?></div>
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
                    <div class="col-sm-7"> <?php if(in_array('datas_uploaded', $this->userinfo)){ echo $this->userinfo['datasets_uploaded'];}else{echo 0;} ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-5"><i class="fa fa-cogs flow"></i></div>
                    <div class="col-sm-7"> <?php if(in_array('flows_uploaded', $this->userinfo)){ echo $this->userinfo['flows_uploaded'];}else{echo 0;} ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-5"><i class="fa fa-trophy task"></i></div>
                    <div class="col-sm-7"> <?php if(in_array('tasks_uploaded', $this->userinfo)){ echo $this->userinfo['tasks_uploaded'];}else{echo 0;} ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-5"><i class="fa fa-star run"></i></div>
                    <div class="col-sm-7"> <?php if(in_array('runs_uploaded', $this->userinfo)){ echo $this->userinfo['runs_uploaded'];}else{echo 0;} ?></div>
                </div>
            </div>
    </div>
<?php }} ?>
</div>

<table class="table usertable">
    <tbody>
        
<?php if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->user()->row()->gamification_visibility == 'show'  && $this->userinfo['gamification_visibility'] == 'show') {?>
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
        <td class="subvalue" ><?php if(in_array('datasets_uploaded', $this->userinfo)){echo $this->userinfo['datasets_uploaded'];}else{echo 0;}?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php if(in_array('downloads_received_data', $this->userinfo)){echo $this->userinfo['downloads_received_data'];}else{echo 0;}?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php if(in_array('likes_received_data', $this->userinfo)){echo $this->userinfo['likes_received_data'];}else{echo 0;}?> <i class="fa fa-heart"></i></td>
        <td class="subvalue" ><?php if(in_array('runs_on_datasets', $this->userinfo)){echo $this->userinfo['runs_on_datasets'];}else{echo 0;}?> <i class="fa fa-star"></i></td>
      </tr>
      <tr>
        <td class="mainvalue"><div class="col-sm-1"><i class="fa fa-cogs flow" ></i></div><div class="col-sm-11"> Flows </div></td>
        <td class="subvalue" ><?php if(in_array('flows_uploaded', $this->userinfo)){echo $this->userinfo['flows_uploaded'];}else{echo 0;}?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php if(in_array('downloads_received_flow', $this->userinfo)){echo $this->userinfo['downloads_received_flow'];}else{echo 0;}?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php if(in_array('likes_received_flow', $this->userinfo)){echo $this->userinfo['likes_received_flow'];}else{echo 0;}?> <i class="fa fa-heart"></i></td>
        <td class="subvalue" ><?php if(in_array('runs_on_flows', $this->userinfo)){echo $this->userinfo['runs_on_flows'];}else{echo 0;}?> <i class="fa fa-star"></i></td>
      </tr>
      <tr>
        <td class="mainvalue"><div class="col-sm-1"><i class="fa fa-trophy task" ></i></div><div class="col-sm-11"> Tasks </div></td>
        <td class="subvalue" ><?php if(in_array('tasks_uploaded', $this->userinfo)){echo $this->userinfo['tasks_uploaded'];}else{echo 0;}?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php if(in_array('downloads_received_task', $this->userinfo)){echo $this->userinfo['downloads_received_task'];}else{echo 0;}?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php if(in_array('likes_received_task', $this->userinfo)){echo $this->userinfo['likes_received_task'];}else{echo 0;}?> <i class="fa fa-heart"></i></td>
        <td></td>
      </tr>
      <tr>
        <td class="mainvalue"><div class="col-sm-1"><i class="fa fa-star run" ></i></div><div class="col-sm-11"> Runs </div></td>
        <td class="subvalue" ><?php if(in_array('runs_uploaded', $this->userinfo)){echo $this->userinfo['runs_uploaded'];}else{echo 0;}?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php if(in_array('downloads_received_run', $this->userinfo)){echo $this->userinfo['downloads_received_run'];}else{echo 0;}?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php if(in_array('likes_received_run', $this->userinfo)){echo $this->userinfo['likes_received_run'];}else{echo 0;}?> <i class="fa fa-heart"></i></td>
        <td></td>
      </tr>
    </tbody>
  </table>


<?php if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->user()->row()->gamification_visibility == 'show'  && $this->userinfo['gamification_visibility'] == 'show') {?>
<div class="row">    
    <ul class="nav nav-pills activity">
        <li class="col-sm-4 mainvalue active" title="Activity is: 3x uploads done + 2x likes given + downloads done"><a data-toggle="tab" onclick=redrawActivityChart("Activity")> <i class="fa fa-bolt"></i> Activity: <?php if(in_array('activity', $this->userinfo)){ echo $this->userinfo['activity'];}else{echo 0;} ?></a></li>
        <li class="col-sm-2 mainvalue" title="The number of uploads you have done"><a data-toggle="tab" onclick=redrawActivityChart("Uploads")><?php if(in_array('nr_of_uploads', $this->userinfo)){ echo $this->userinfo['nr_of_uploads'];}else{echo 0;} ?> <i class="fa fa-cloud-upload"></i></a></li>
        <li class="col-sm-2 mainvalue" title="The number of likes you have done"><a data-toggle="tab" onclick=redrawActivityChart("Likes")><?php if(in_array('nr_of_likes', $this->userinfo)){ echo $this->userinfo['nr_of_likes'];}else{echo 0;} ?> <i class="fa fa-heart"></i></a></li>
        <li class="col-sm-2 mainvalue" title="The number of things you have downloaded"><a data-toggle="tab" onclick=redrawActivityChart("Downloads")><?php if(in_array('nr_of_downloads', $this->userinfo)){ echo $this->userinfo['nr_of_downloads'];}else{echo 0;} ?> <i class="fa fa-cloud-download"></i></a></li>
        <li class="col-sm-1 pull-right"> <a data-toggle="collapse" href="#Activity-chart"><i class="fa fa-2x fa-minus" id="activitytoggle" style="visibility: hidden"></i></a></li>
    </ul>
    <div class="col-sm-12 collapse" id="Activity-chart">
        <div id="activityplot" class="row">
            <i class="fa fa-spinner fa-pulse"></i> Loading activity data
        </div>
    </div>
</div>
<div class="row">
   <ul class="nav nav-pills reach">
        <li class="col-sm-4 mainvalue active" title="Reach is: 2x likes received + downloads received"><a data-toggle="tab" onclick=redrawReachChart("Reach")> <i class="fa fa-rss"></i> Reach: <?php if(in_array('reach', $this->userinfo)){echo $this->userinfo['reach'];}else{echo 0;} ?></a></li>
        <li class="col-sm-2 mainvalue" title="The number of likes your uploads have gotten"><a data-toggle="tab" onclick=redrawReachChart("Likes")><?php if(in_array('likes_received', $this->userinfo)){ echo $this->userinfo['likes_received'];}else{echo 0;} ?> <i class="fa fa-heart"></i></a></li>
        <li class="col-sm-2 mainvalue" title="The number of distinct downloads of your uploads"><a data-toggle="tab" onclick=redrawReachChart("Downloads")><?php if(in_array('downloads_received', $this->userinfo)){ echo $this->userinfo['downloads_received'];}else{echo 0;} ?> <i class="fa fa-cloud-download"></i></a></li>
        <li class="col-sm-1 pull-right"> <a data-toggle="collapse" href="#Reach-chart"><i class="fa fa-2x fa-minus" id="reachtoggle" style="visibility: hidden"></i></a></li>
    </ul>
    <div class="col-sm-12 collapse" id="Reach-chart">
        <div id="reachplot" class="row">
            <i class="fa fa-spinner fa-pulse"></i> Loading reach data
        </div>
    </div>
</div>
<div class="row">
    <ul class="nav nav-pills impact" title="Impact is: 0.5*reach of reuse of knowledge">
        <li class="col-sm-4 mainvalue active"><a data-toggle="tab" onclick=redrawImpactChart("Impact")> <i class="material-icons" style="font-size: 28px">flare</i> Impact: <?php if(in_array('likes_received', $this->userinfo)){echo $this->userinfo['impact'];}else{echo 0;} ?></a></li>
        <!--<li class="mainvalue"><a data-toggle="tab" onclick=redrawImpactChart("Reach_re")><?php/* if(in_array('reach_of_reuse', $this->userinfo)){echo $this->userinfo['reach_of_reuse'];}else{echo 0;} */?> <i class="fa fa-rss"></i></a></li>-->
        <!--<li class="mainvalue"><a data-toggle="tab" onclick=redrawImpactChart("Impact_re")><?php/* if(in_array('impact_of_reuse', $this->userinfo)){echo $this->userinfo['impact_of_reuse'];}else{echo 0;} */?> <i class="material-icons" style="font-size: 28px">flare</i></i></a></li>-->
        <li class="col-sm-1 pull-right"> <a data-toggle="collapse" href="#Impact-chart"><i class="fa fa-2x fa-minus" id="impacttoggle" style="visibility: hidden"></i></a></li>
    </ul>
    <div class="col-sm-12 collapse" id="Impact-chart">
        <div id="impactplot" class="row">
            <i class="fa fa-spinner fa-pulse"></i> Loading impact data
        </div>
    </div>
</div>

<div class="row">
    <h2>Badges</h2>
    <div id="badges"></div>
</div>
<?php }} ?>



