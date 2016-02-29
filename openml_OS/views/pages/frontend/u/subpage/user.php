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
                <div class="col-sm-1"><i class="fa fa-star run"></i></div>
                <div class="col-sm-4"> <?php echo $this->userinfo['runs_uploaded']; ?></div>
            </div>
        </div>
        <div class="well" style="visibility: hidden; font-size:120%" title="Highlighted badges">
            
        </div>
    </div>
</div>

<div class ="row">
    <div class="col-sm-4">
        <div class="panel panel-simple panel-success">
            <div class="panel-heading activity-bg"  title="Activity is: 3x uploads done + 2x likes given + downloads done"><i class="fa fa-bolt fa-2x" style="color:white"></i> Activity: <?php echo $this->userinfo['activity']; ?></div>
            <div class="panel-body">
                <div class="row" title="Uploads done">
                    <div class="col-xs-12">
                        <div class="subvalue"><?php echo $this->userinfo['nr_of_uploads'];?> <i class="fa fa-cloud-upload activity"></i> done</div>
                    </div>
                </div>
                <div class="row" title="Number of likes given">
                    <div class="col-xs-12">
                        <div class="subvalue"><?php echo $this->userinfo['nr_of_likes'];?> <i class="fa fa-heart activity"></i> given</div>
                    </div>
                </div>
                <div class="row" title="Number of distinct downloads done">
                    <div class="col-xs-12">
                        <div class="subvalue"><?php echo $this->userinfo['nr_of_downloads'];?> knowledge pieces <i class="fa fa-cloud-download activity"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="panel panel-simple panel-danger">
            <div class="panel-heading reach-bg" title="Reach is: 2x likes received + downloads received"><i class="fa fa-rss fa-2x" style="color:white"></i> Reach: <?php echo $this->userinfo['reach']; ?></div>
            <div class="panel-body">
                <div class="row" title="Number of likes received">
                    <div class="col-xs-12">
                        <div class="subvalue"><?php echo $this->userinfo['likes_received'];?> <i class="fa fa-heart reach"></i> received on uploads</div>
                    </div>
                </div>
                <div class="row" title="Number of distinct downloads received">
                    <div class="col-xs-12">
                        <div class="subvalue"><?php echo $this->userinfo['downloads_received'];?> distinct <i class="fa fa-cloud-download reach"></i> received</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="panel panel-simple panel-info">
            <div class="panel-heading impact-bg" title="Impact is: 0.5*reach of reuse of knowledge + 0.5*impact of reuse of knowledge"><i class="material-icons" style="font-size: 28px; color:white">flare</i> Impact: <?php echo $this->userinfo['impact']; ?></div>
            <div class="panel-body">                
                <div class="row" title="Reach of runs/tasks using this person's data/flows">
                    <div class="col-xs-12">
                        <div class="subvalue"><?php echo $this->userinfo['reach_of_reuse'];?> <i class="fa fa-rss impact"></i> of reused knowledge</div>
                    </div>
                </div>                
                <div class="row" title="Impact of runs/tasks using this person's data/flows">
                    <div class="col-xs-12">
                        <div class="subvalue"><?php echo $this->userinfo['impact_of_reuse'];?> <i class="material-icons impact" style="font-size: 18px;">flare</i> of reused knowledge</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class ="row">
    <div class="col-sm-4">
        <div class="panel panel-simple panel-success">
            <div class="panel-heading"><i class="fa fa-2x fa-database" style="color:white"></i> Data Sets</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Datasets uploaded"><?php echo $this->userinfo['datasets_uploaded'];?> <i class="fa fa-cloud-upload activity"></i></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Used in runs"><?php echo $this->userinfo['runs_on_datasets']; ?> <i class="fa fa-star impact"></i></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Downloads done"><?php echo $this->userinfo['nr_of_downloads_data']; ?> <i class="fa fa-cloud-download activity"></i></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Downloads received"><?php echo $this->userinfo['downloads_received_data']; ?> <i class="fa fa-cloud-download reach"></i></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Likes done"><?php echo $this->userinfo['nr_of_likes_data']; ?> <i class="fa fa-heart activity"></i></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Likes received"><?php echo $this->userinfo['likes_received_data']; ?> <i class="fa fa-heart reach"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="panel panel-simple panel-info">
            <div class="panel-heading"><i class="fa fa-2x fa-cogs" style="color:white"></i> Flows</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Flows uploaded"><?php echo $this->userinfo['flows_uploaded'];?> <i class="fa fa-cloud-upload activity"></i></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Used in runs"><?php echo $this->userinfo['runs_on_flows']; ?> <i class="fa fa-star impact"></i></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Downloads done"><?php echo $this->userinfo['nr_of_downloads_flow']; ?> <i class="fa fa-cloud-download activity"></i></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Downloads received"><?php echo $this->userinfo['downloads_received_flow']; ?> <i class="fa fa-cloud-download reach"></i></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Likes done"><?php echo $this->userinfo['nr_of_likes_flow']; ?> <i class="fa fa-heart activity"></i></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Likes received"><?php echo $this->userinfo['likes_received_flow']; ?> <i class="fa fa-heart reach"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="panel panel-simple panel-danger">
            <div class="panel-heading"><i class="fa fa-2x fa-star" style="color:white"></i> Runs</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Runs uploaded"><?php echo $this->userinfo['runs_uploaded'];?> <i class="fa fa-cloud-upload activity"></i></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Downloads done"><?php echo $this->userinfo['nr_of_downloads_run']; ?> <i class="fa fa-cloud-download activity"></i></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Downloads received"><?php echo $this->userinfo['downloads_received_run']; ?> <i class="fa fa-cloud-download reach"></i></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Likes done"><?php echo $this->userinfo['nr_of_likes_run']; ?> <i class="fa fa-heart activity"></i></div>
                    </div>
                    <div class="col-xs-6">
                        <div class="mainvalue" title="Likes received"><?php echo $this->userinfo['likes_received_run']; ?> <i class="fa fa-heart reach"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


