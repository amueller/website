<div class="panel flushpanel">
    <?php
    //var_dump($this);
    $authimg = "img/community/misc/anonymousMan.png";
    if ($this->author)
        $authimg = htmlentities(authorImage($this->author->image));
    ?>
    <div class="col-sm-2">
        <img src="<?php echo $authimg; ?>" width="130" height="130" class="img-circle userimage" />
    </div>
    <div class="col-sm-10 userdata">
        <h1 class="username"><?php echo $this->userinfo['first_name'] . ' ' . $this->userinfo['last_name']; ?></h1>
        <div class="userbio"><?php echo $this->userinfo['bio']; ?></div>
        <div class="userdetails">
            <?php if ($this->userinfo['affiliation']) echo '<i class="fa fa-fw fa-institution"></i> ' . $this->userinfo['affiliation']; ?>
            <?php if ($this->userinfo['country']) echo '<i class="fa fa-fw fa-map-marker"></i> ' . $this->userinfo['country']; ?>
            <i class="fa fa-fw fa-clock-o"></i> Joined <?php echo date("Y-m-d", $this->userinfo['date']); ?>
        </div>
    </div>
</div>

<div class="panel">
  <?php if ($this->ion_auth->logged_in()) {?>
        <div class="gamestat-row">
        <?php if ($this->ion_auth->user()->row()->gamification_visibility == 'show' && $this->userinfo['gamification_visibility'] == 'show') {?>
            <div class="gamestat">
              <div class="gamestat-label">Activity</div>
              <div class="gamestat-value"><i class="fa fa-bolt activity"></i> <?php if(in_array('activity', $this->userinfo)){ echo $this->userinfo['activity']; }else{echo 0;}?></div>
            </div>
            <div class="gamestat">
              <div class="gamestat-label">Reach</div>
              <div class="gamestat-value"><i class="fa fa-rss reach"></i> <?php if(in_array('activity', $this->userinfo)){ echo $this->userinfo['activity']; }else{echo 0;}?></div>
            </div>
            <div class="gamestat">
              <div class="gamestat-label">Impact</div>
              <div class="gamestat-value"><i class="material-icons impact" style="font-size: 16px;">flare</i> <?php if(in_array('impact', $this->userinfo)){ echo $this->userinfo['impact']; }else{echo 0;} ?></div>
            </div>
        <?php }?>
            <div class="gamestat">
              <div class="gamestat-label">Uploads</div>
              <div class="gamestat-value">
                  <span><i class="fa fa-database dataset"></i> <?php if(in_array('datasets_uploaded', $this->userinfo)){ echo $this->userinfo['datasets_uploaded']; }else{echo 0;} ?></span>
                  <span><i class="fa fa-cogs flow"></i> <?php if(in_array('flows_uploaded', $this->userinfo)){ echo $this->userinfo['flows_uploaded']; }else{echo 0;} ?></span>
                  <span><i class="fa fa-trophy task"></i> <?php if(in_array('tasks_uploaded', $this->userinfo)){ echo $this->userinfo['tasks_uploaded']; }else{echo 0;} ?></span>
                  <span><i class="fa fa-star run"></i> <?php if(in_array('runs_uploaded', $this->userinfo)){ echo $this->userinfo['runs_uploaded'];}else{echo 0;} ?></span>
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
  <?php } ?>
  <?php if ($this->is_owner || $this->ion_auth->is_admin()) { ?>
      <a href="#edit" data-toggle="tab" class="btn btn-primary pull-right">Edit Profile</a><br />
  <?php } ?>
</div>

<table class="table panel usertable">
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
        <td class="mainvalue"><i class="fa fa-fw fa-database dataset" ></i> <a href="<?php echo BASE_URL .'u/' . $this->user_id . '/data';?>"> Data Sets</a></td>
        <td class="subvalue" ><?php if(in_array('datasets_uploaded', $this->userinfo)){echo $this->userinfo['datasets_uploaded'];}else{echo 0;}?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php if(in_array('downloads_received_data', $this->userinfo)){echo $this->userinfo['downloads_received_data'];}else{echo 0;}?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php if(in_array('likes_received_data', $this->userinfo)){echo $this->userinfo['likes_received_data'];}else{echo 0;}?> <i class="fa fa-heart"></i></td>
        <td class="subvalue" ><?php if(in_array('runs_on_datasets', $this->userinfo)){echo $this->userinfo['runs_on_datasets'];}else{echo 0;}?> <i class="fa fa-star"></i></td>
      </tr>
      <tr>
        <td class="mainvalue"><i class="fa fa-fw fa-cogs flow" ></i><a href="<?php echo BASE_URL .'u/' . $this->user_id . '/flows';?>"> Flows </a></td>
        <td class="subvalue" ><?php if(in_array('flows_uploaded', $this->userinfo)){echo $this->userinfo['flows_uploaded'];}else{echo 0;}?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php if(in_array('downloads_received_flow', $this->userinfo)){echo $this->userinfo['downloads_received_flow'];}else{echo 0;}?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php if(in_array('likes_received_flow', $this->userinfo)){echo $this->userinfo['likes_received_flow'];}else{echo 0;}?> <i class="fa fa-heart"></i></td>
        <td class="subvalue" ><?php if(in_array('runs_on_flows', $this->userinfo)){echo $this->userinfo['runs_on_flows'];}else{echo 0;}?> <i class="fa fa-star"></i></td>
      </tr>
      <tr>
        <td class="mainvalue"><i class="fa fa-fw fa-trophy task" ></i><a href="<?php echo BASE_URL .'u/' . $this->user_id . '/tasks';?>"> Tasks </a></td>
        <td class="subvalue" ><?php if(in_array('tasks_uploaded', $this->userinfo)){echo $this->userinfo['tasks_uploaded'];}else{echo 0;}?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php if(in_array('downloads_received_task', $this->userinfo)){echo $this->userinfo['downloads_received_task'];}else{echo 0;}?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php if(in_array('likes_received_task', $this->userinfo)){echo $this->userinfo['likes_received_task'];}else{echo 0;}?> <i class="fa fa-heart"></i></td>
        <td></td>
      </tr>
      <tr>
        <td class="mainvalue"><i class="fa fa-fw fa-star run" ></i><a href="<?php echo BASE_URL .'u/' . $this->user_id . '/runs';?>"> Runs </a></td>
        <td class="subvalue" ><?php if(in_array('runs_uploaded', $this->userinfo)){echo $this->userinfo['runs_uploaded'];}else{echo 0;}?> <i class="fa fa-cloud-upload"></i></td>
        <td class="subvalue" ><?php if(in_array('downloads_received_run', $this->userinfo)){echo $this->userinfo['downloads_received_run'];}else{echo 0;}?> <i class="fa fa-cloud-download"></i></td>
        <td class="subvalue" ><?php if(in_array('likes_received_run', $this->userinfo)){echo $this->userinfo['likes_received_run'];}else{echo 0;}?> <i class="fa fa-heart"></i></td>
        <td></td>
      </tr>
    </tbody>
  </table>


<?php if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->user()->row()->gamification_visibility == 'show'  && $this->userinfo['gamification_visibility'] == 'show') {?>
<div class="panel statpanel">
    <ul class="nav nav-pills activity">
        <li class="col-sm-4 mainvalue active" title="Activity is: 3x uploads done + 2x likes given + downloads done.
            Given as activty over the last year / total activity">
            <a data-toggle="tab" onclick=redrawActivityChart("Activity")>
                <i class="fa fa-fw fa-bolt"></i>
                Activity:
                <span id="ActivityThisYear">? /</span>
                <span><?php if(in_array('activity', $this->userinfo)){ echo $this->userinfo['activity'];}else{echo 0;} ?>
            </a>
        </li>
        <li class="col-sm-2 mainvalue" title="The number of uploads you have done over the last year / the total number of uploads you have done">
            <a data-toggle="tab" onclick=redrawActivityChart("Uploads")>
                <span id="UploadsThisYear">? /</span>
                <span><?php if(in_array('nr_of_uploads', $this->userinfo)){ echo $this->userinfo['nr_of_uploads'];}else{echo 0;} ?> </span>
                <i class="fa fa-cloud-upload"></i>
            </a>
        </li>
        <li class="col-sm-2 mainvalue" title="The number of likes you have done over the last year / the total number of likes you have done">
            <a data-toggle="tab" onclick=redrawActivityChart("Likes")>
                <span id="LikesThisYear">? /</span>
                <span><?php if(in_array('nr_of_likes', $this->userinfo)){ echo $this->userinfo['nr_of_likes'];}else{echo 0;} ?> </span>
                <i class="fa fa-heart"></i>
            </a>
        </li>
        <li class="col-sm-2 mainvalue" title="The number of things you have downloaded over the last year / the total number of things you have downloaded">
            <a data-toggle="tab" onclick=redrawActivityChart("Downloads")>
                <span id="DownloadsThisYear">? /</span>
                <span><?php if(in_array('nr_of_downloads', $this->userinfo)){ echo $this->userinfo['nr_of_downloads'];}else{echo 0;} ?> </span>
                <i class="fa fa-cloud-download"></i>
            </a>
        </li>
        <li class="col-sm-1 pull-right">
            <a data-toggle="collapse" href="#Activity-chart">
                <i class="fa fa-2x fa-minus" id="activitytoggle" style="visibility: hidden"></i>
            </a>
        </li>
    </ul>
    <div class="col-sm-12 collapse" id="Activity-chart">
        <div id="activityplot" class="row">
            <i class="fa fa-spinner fa-pulse"></i> Loading activity data
        </div>
    </div>
</div>
<div class="panel statpanel">
   <ul class="nav nav-pills reach">
       <li class="col-sm-4 mainvalue active" title="Reach is: 2x likes received + downloads received.
           Given as reach over the last month / total reach">
           <a data-toggle="tab" onclick=redrawReachChart("Reach")>
               <i class="fa fa-fw fa-rss"></i>
               Reach:
               <span id="ReachThisMonth">? /</span>
               <span><?php if(in_array('reach', $this->userinfo)){echo $this->userinfo['reach'];}else{echo 0;} ?></span>
           </a>
       </li>
        <li class="col-sm-2 mainvalue" title="The number of likes your uploads have gotten over the last month / the total number of likes you have gotten">
            <a data-toggle="tab" onclick=redrawReachChart("Likes")>
                <span id="LikesReceivedThisMonth">? /</span>
                <span><?php if(in_array('likes_received', $this->userinfo)){ echo $this->userinfo['likes_received'];}else{echo 0;} ?></span>
                <i class="fa fa-heart"></i>
            </a>
        </li>
        <li class="col-sm-2 mainvalue" title="The number of distinct downloads of your uploads over the last month / the total number of distinct downloads of your uploads">
            <a data-toggle="tab" onclick=redrawReachChart("Downloads")>
                <span id="DownloadsReceivedThisMonth">? /</span>
                <span><?php if(in_array('downloads_received', $this->userinfo)){ echo $this->userinfo['downloads_received'];}else{echo 0;} ?></span>
                <i class="fa fa-cloud-download"></i>
            </a>
        </li>
        <li class="col-sm-1 pull-right">
            <a data-toggle="collapse" href="#Reach-chart">
                <i class="fa fa-2x fa-minus" id="reachtoggle" style="visibility: hidden"></i>
            </a>
        </li>
    </ul>
    <div class="col-sm-12 collapse" id="Reach-chart">
        <div id="reachplot" class="row">
            <i class="fa fa-spinner fa-pulse"></i> Loading reach data
        </div>
    </div>
</div>
<div class="panel statpanel">
    <ul class="nav nav-pills impact" title="Impact is: 0.5*reach of reuse of knowledge.
        Given as your impact over the last month / your total impact">
        <li class="col-sm-4 mainvalue active">
            <a data-toggle="tab" onclick=redrawImpactChart("Impact")>
                <i class="material-icons" style="font-size: 28px">flare</i>
                Impact:
                <span id="ImpactThisMonth">?/</span>
                <span><?php if(in_array('impact', $this->userinfo)){echo $this->userinfo['impact'];}else{echo 0;} ?></span>
            </a>
        </li>
        <!--<li class="mainvalue"><a data-toggle="tab" onclick=redrawImpactChart("Reach_re")><?php/* if(in_array('reach_of_reuse', $this->userinfo)){echo $this->userinfo['reach_of_reuse'];}else{echo 0;} */?> <i class="fa fa-rss"></i></a></li>-->
        <!--<li class="mainvalue"><a data-toggle="tab" onclick=redrawImpactChart("Impact_re")><?php/* if(in_array('impact_of_reuse', $this->userinfo)){echo $this->userinfo['impact_of_reuse'];}else{echo 0;} */?> <i class="material-icons" style="font-size: 28px">flare</i></i></a></li>-->
        <li class="col-sm-1 pull-right">
            <a data-toggle="collapse" href="#Impact-chart">
                <i class="fa fa-2x fa-minus" id="impacttoggle" style="visibility: hidden"></i>
            </a>
        </li>
    </ul>
    <div class="col-sm-12 collapse" id="Impact-chart">
        <div id="impactplot" class="row">
            <i class="fa fa-spinner fa-pulse"></i> Loading impact data
        </div>
    </div>
</div>

<div class="col-sm-12">
    <h2>Badges</h2>
    <div id="badges"></div>
</div>
<?php }} ?>
