<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en">
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="en">
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en">
<![endif]-->
<!--[if gt IE 8]><!-->

<html class="no-js" lang="en" xmlns:og="http://ogp.me/ns#">
    <!--<![endif]-->
    <head>
        <base href="<?php echo BASE_URL; ?>" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width">
        <title>OpenML</title>
        <meta name="description" content="OpenML: exploring machine learning better, together. An open science platform for machine learning.">
	      <link href="http://www.openml.org/img/expdblogo2.png" rel="image_src" />
        <meta name="author" content="Joaquin Vanschoren">
        <meta property="og:title" content="OpenML"/>
        <meta property="og:url" content="http://www.openml.org"/>
        <meta property="og:image" content="http://www.openml.org/img/expdblogo2.png"/>
        <meta property="og:site_name" content="OpenML: exploring machine learning better, together."/>
        <meta property="og:description" content="OpenML: exploring machine learning better, together. An open science platform for machine learning."/>
        <meta property="og:type" content="Science"/>
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/pygments-manni.css">
        <link rel="stylesheet" href="css/gollum.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link href="css/material-fullpalette.min.css" rel="stylesheet">
        <link href="css/ripples.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/expdb.css">
        <link rel="stylesheet" href="css/docs.css">
        <link rel="stylesheet" href="css/prettify.css">
        <link rel="stylesheet" href="css/codemirror.css">
        <link rel="stylesheet" href="css/eclipse.css">
        <link rel="stylesheet" href="css/jquery-ui.css" type="text/css"/>
        <link rel="stylesheet" href="css/jquery.dataTables.min.css" type="text/css"/>
        <link rel="stylesheet" href="css/dataTables.colvis.min.css" type="text/css"/>
        <link rel="stylesheet" href="css/dataTables.colvis.jqueryui.css" type="text/css"/>
        <link rel="stylesheet" href="css/dataTables.responsive.min.css" type="text/css"/>
        <link rel="stylesheet" href="css/dataTables.scroller.min.css" type="text/css"/>
        <link rel="stylesheet" href="css/dataTables.tableTools.min.css" type="text/css"/>
        <link rel="stylesheet" href="css/MyFontsWebfontsKit.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="css/bootstrap-slider.css">
        <link rel="shortcut icon" href="img/favicon.ico">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=RobotoDraft:400,500,700,400italic" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/highlight.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.3/highlight.min.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/libs/jquery.validate.js"></script>
        <script type="text/javascript" src="js/libs/modernizr-2.5.3-respond-1.1.0.min.js" ></script>
        <script type="text/javascript" src="js/libs/processing.js" ></script>
        <script type="text/javascript" src="js/libs/dat.gui.min.js" ></script>
        <script type="text/javascript" src="js/libs/codemirror.js" ></script>
        <script type="text/javascript" src="js/libs/mysql.js" ></script>
        <script type="text/javascript" src="js/libs/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/libs/dataTables.tableTools.min.js"></script>
        <script type="text/javascript" src="js/libs/dataTables.scroller.min.js"></script>
        <script type="text/javascript" src="js/libs/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="js/libs/dataTables.colVis.min.js"></script>
        <script type="text/javascript" src="js/libs/jquery.form.js"></script>
        <script type="text/javascript" src="js/libs/jquery.sharrre.js"></script>
        <script type="text/javascript" src="js/libs/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/libs/bootstrap-slider.js" ></script>
        <script type="text/javascript" src="js/libs/rainbowvis.js"></script>
        <script type="text/javascript" src="js/libs/elasticsearch.jquery.min.js"></script>
        <script src="js/libs/mousetrap.min.js"></script>
        <script src="js/libs/gollum.js"></script>
        <script src="js/libs/gollum.dialog.js"></script>
        <script src="js/libs/gollum.placeholder.js"></script>
        <script src="js/libs/gollum.editor.js"></script>
        <script type="text/javascript" src="js/openml.js"></script>
        <?php if( isset( $this->load_javascript ) ): foreach( $this->load_javascript as $j ): ?>
        <script type="text/javascript" src="<?php echo $j; ?>"></script>
        <?php endforeach; endif;
	       $this->endjs = '';
	        ?>

        <!-- page dependent javascript code -->
        <script type="text/javascript"><?php echo script();?></script>
    </head>
    <body onresize="try{updateCanvasDimensions()}catch(err){}">
        <!--[if lt IE 7]>
        <p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
        <![endif]-->

  <?php
    $section = "OpenML";
    $materialcolor = "blue-600";
    $href = "";
    $url = explode('/', $_SERVER['REQUEST_URI']);
    if(sizeof($url)>2){
      if(strrpos($url[2], 'search') == 0 and strlen($url[2])>4){
        if(isset($this->filtertype) and $this->filtertype){
            $section = str_replace('_',' ',ucfirst($this->filtertype));
            $href = "search?type=".$this->filtertype;
          }
        else{
          $section = 'Search';
          $materialcolor = "blue-grey";
        }
      }
      if($url[2]=='r' or $section=='Run'){
            $section = 'Run';
            $href = 'search?type=run';
            $materialcolor = "red";
          }
      if($url[2]=='d' or $section=='Data'){
            $section = 'Data';
            $href = 'search?type=data';
            $materialcolor = "green";
          }
      if($url[2]=='f' or $section=='Flow'){
            $section = 'Flow';
            $href = 'search?type=flow';
            $materialcolor = "blue";
          }
      if($url[2]=='t' or $section=='Task'){
            $section = 'Task';
            $href = 'search?type=task';
            $materialcolor = "orange-600";
          }
      if($url[2]=='tt' or $section=='Task type'){
            $section = 'Task type';
            $href = 'search?type=tasktype';
            $materialcolor = "deep-orange";
          }
      if($url[2]=='u' or $section=='User'){
            $section = 'People';
            $materialcolor = "light-blue";
          }
      if($url[2]=='a' or $section=='Measure'){
            $section = 'Measure';
            $href = $url[2];
            $materialcolor = "deep-purple";
          }
      if(substr( $url[2], 0, 5 ) === "guide"){
            $section = 'Guide';
            $href = $url[2];
            $materialcolor = "green";
          }
      if($url[2]=='community'){
            $section = 'Forum';
            $href = $url[2];
            $materialcolor = "purple";
          }
      if($url[2]=='backend'){
            $section = 'Backend';
            $href = $url[2];
            $materialcolor = "red";
          }
      if($url[2]=='register' or $url[2]=='profile' or $url[2]=='frontend' or $url[2]=='login' or $url[2]=='password_forgot'){
            $section = 'OpenML';
            $href = $url[2];
            $materialcolor = "blue";
          }
    }

    $this->materialcolor = $materialcolor;
    $this->user = $this->ion_auth->user()->row();
    $this->image = array(
    	'name' => 'image',
    	'id' => 'image',
    	'type' => 'file',
    );
  ?>
        <div class="navbar navbar-static-top navbar-fixed-top navbar-material-<?php echo $materialcolor;?>" id="openmlheader" style="margin-bottom: 0px;">
            <div class="navbar-inner">
              <div class="col-xs-5 col-sm-3 col-md-3">
              <div class="nav pull-left">
                <a class="navbar-brand" id="menubutton"><i class="fa fa-bars fa-lg"></i></a>
              </div>
              <a class="navbar-brand" id="section-brand" href="<?php echo $href; ?>"><?php echo $section;?></a>
            </div>
            <a class="openmlsoc openmlsocicon col-xs-2 hidden-sm hidden-md hidden-lg pull-left searchicon" onclick="showsearch()"><i class="fa fa-search fa-2x"></i></a>

       <div class="menuicons">
			<?php if ($this->ion_auth->logged_in()) { ?>
        <div class="nav pull-right openmlsocicons">
          <a href="#" class="dropdown-toggle openmlsoc openmlsocicon" data-toggle="dropdown" style="padding-top:12px;">
            <img src="<?php echo htmlentities( authorImage( $this->user->image ) ); ?>" width="35" height="35" class="img-circle" alt="<?php echo $this->user->first_name . ' ' . $this->user->last_name; ?>" /></a>
          <ul class="dropdown-menu">
              <li><a href="u/<?php echo $this->user->id;?>"><?php echo user_display_text(); ?></a></li>
              <li class="divider"></li>
              <li><a href="frontend/logout">Sign off</a></li>
          </ul>
        </div>

  			<div class="nav pull-right openmlsocicons">
  			  <a href="#" class="dropdown-toggle openmlsoc openmlsocicon" data-toggle="dropdown"><i class="fa fa-plus fa-2x"></i></a>
  			  <ul class="dropdown-menu newmenu">
  			    <li><a href="new/data" class="icongreen"><i class="fa fa-fw fa-lg fa-database"></i> New data</a></li>
  		            <li class="divider"></li>
  			    <li><a href="new/task" class="iconyellow"><i class="fa fa-fw fa-lg fa-trophy"></i> New task</a></li>
  		            <li class="divider"></li>
  			    <li><a href="new/flow" class="iconblue"><i class="fa fa-fw fa-lg fa-cogs"></i> New flow</a></li>
  		            <li class="divider"></li>
  			    <li><a href="new/run" class="iconred"><i class="fa fa-fw fa-lg fa-star"></i> New run</a></li>
  			  </ul>
  			</div>

        <div class="nav pull-right openmlsocicons">
          <a href="guide" class="openmlsoc openmlsocicon"><i class="fa fa-leanpub fa-2x"></i></a>
        </div>
        <script>var logged_in = true;</script>
			<?php } else { ?>
        <script>var logged_in = false;</script>
			<div class="nav pull-right openmlsocicons">
                  <a href="guide" class="btn btn-material-<?php echo $materialcolor;?>">Guide</a>
                  <a class="btn btn-material-<?php echo $materialcolor;?>" data-toggle="modal" data-target="#login-dialog">Sign in</a>
      </div>
			<?php } ?>
      </div>


      <div class="hidden-xs col-sm-6 col-md-6" id="menusearchframe">
<form class="navbar-form" method="get" id="searchform" action="search">
  <input type="text" class="form-control col-lg-8" id="openmlsearch" name="q" placeholder="Search" onfocus="this.placeholder = 'Search datasets, flows, tasks, people,... (leave empty to see all)'" value="<?php if( isset( $this->terms ) ) echo htmlentities($this->terms); ?>" />
<input type="hidden" name="type" value="<?php if(array_key_exists("type",$_GET)) echo safe($_GET["type"]);
  elseif(false !== strpos($_SERVER['REQUEST_URI'],'/d')) echo 'data';
  elseif(false !== strpos($_SERVER['REQUEST_URI'],'/t')) echo 'task';
  elseif(false !== strpos($_SERVER['REQUEST_URI'],'/f')) echo 'flow';
  elseif(false !== strpos($_SERVER['REQUEST_URI'],'/r')) echo 'run';
  elseif(false !== strpos($_SERVER['REQUEST_URI'],'/a')) echo 'measure';
    ?>">
<!-- <button class="btn btn-primary btn-small" type="submit" style="height: 30px; vertical-align:top; font-size: 8pt;"><i class="fa fa-search fa-lg"></i></button>-->
</form>
 </div>


                    <!--/.nav-collapse -->
            </div>
        </div>

        <?php
          loadpage('login', true, 'pre');
          loadpage('login', true, 'body');
        ?>

        <div id="wrap">
          <div class="searchbar" id="mainmenu">
            <ul class="sidenav nav topchapter">
              <?php if (!$this->ion_auth->logged_in()){ ?>
                  <li <?php echo ($section == '' ?  'class="topactive"' : '');?>><a href="register" class="icongrayish"><i class="fa fa-fw fa-lg fa-child"></i> Join OpenML</a></li>
              <?php } else { ?>
                  <li <?php echo ($section == '' ?  'class="topactive"' : '');?>><a href="u/<?php echo $this->user->id; ?>"><img src="<?php echo htmlentities( authorImage( $this->user->image ) ); ?>" width="25" height="25" class="img-circle" alt="<?php echo $this->user->first_name . ' ' . $this->user->last_name; ?>" /> <?php echo user_display_text(); ?></a></li>
              <?php } ?>
                  <li <?php echo ($section == 'Data' ?  'class="topactive"' : '');?>><a href="search?type=data<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="icongreen"><i class="fa fa-fw fa-lg fa-database"></i> Data<span id="datacounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Task' ?  'class="topactive"' : '');?>><a href="search?type=task<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconyellow"><i class="fa fa-fw fa-lg fa-trophy"></i> Tasks<span id="taskcounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Flow' ?  'class="topactive"' : '');?>><a href="search?type=flow<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconblue"><i class="fa fa-fw fa-lg fa-cogs"></i> Flows<span id="flowcounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Run' ?  'class="topactive"' : '');?>><a href="search?type=run<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconred"><i class="fa fa-fw fa-lg fa-star"></i> Runs<span id="runcounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Task type' ?  'class="topactive"' : '');?>><a href="search?type=task_type<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconorange"><i class="fa fa-fw fa-lg fa-flask"></i> Task Types<span id="task_typecounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Measure' ?  'class="topactive"' : '');?>><a href="search?type=measure<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconpurple"><i class="fa fa-fw fa-lg fa-bar-chart-o"></i> Measures<span id="measurecounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'People' ?  'class="topactive"' : '');?>><a href="search?type=user<?php if(array_key_exists("q",$_GET)) echo '&q='.$_GET["q"];?>" class="iconblueacc"><i class="fa fa-fw fa-lg fa-users"></i> People<span id="usercounter" class="counter"></span></a></li>
                  <li <?php echo ($section == 'Guide' ?  'class="topactive"' : '');?>><a href="guide" class="icongreenacc"><i class="fa fa-fw fa-lg fa-leanpub"></i> Guide</a></li>
                  <li <?php echo ($section == 'Forum' ?  'class="topactive"' : '');?>><a href="community" class="iconpurple"><i class="fa fa-fw fa-lg fa-comments"></i> Discussions</a></li>
                  <li <?php echo ($section == 'Blog' ?  'class="topactive"' : '');?>><a href="https://medium.com/open-machine-learning" class="iconredacc"><i class="fa fa-fw fa-lg fa-heartbeat"></i> Blog</a></li>
                  <!--<li <?php echo ($section == 'Search' ?  'class="topactive"' : '');?>><a href="search" class="icongray"><i class="fa fa-fw fa-lg fa-search"></i> Search</a></li>-->
            </ul>
            <div class="menuaction"><i class="fa fa-lg fa-fw fa-angle-up" onclick="scrollMenuTop()"></i></div>
            <div id="submenucontainer"></div>
            <ul class="sidenav nav">
            <li class="guidechapter-contact">
             <a>Ask us a question...</a>
             <ul class="sidenav nav">
               <li><a href="mailto:openmachinelearning@gmail.com" target="_blank"><i class="fa fa-edit fa-fw fa-lg"></i>Email</a></li>
               <li><a href="https://plus.google.com/communities/105075769838900568763" target="_blank"><i class="fa fa-google-plus fa-fw fa-lg"></i>Google+</a></li>
               <li><a href="https://www.facebook.com/openml" target="_blank"><i class="fa fa-facebook fa-fw fa-lg"></i>Facebook</a></li>
               <li><a href="https://twitter.com/intent/tweet?screen_name=joavanschoren&text=%23openml.org" data-related="joavanschoren"><i class="fa fa-twitter fa-fw fa-lg"></i>Twitter</a></li>
               <li><a href="https://github.com/openml/OpenML/issues?q=is%3Aopen"><i class="fa fa-github fa-fw fa-lg"></i>Report issue</a></li>
             </ul>
            </li>
            </ul>
          </div>
            <!-- USER MESSAGE -->
            <noscript>
                <div class="alert alert-error" style="text-align:center;">
                    JavaScript is required to properly view the contents of this page!
                </div>
            </noscript>
            <?php if($this->message!==false and strlen($this->message) > 0): ?>
            <div class="alert alert-info" style="text-align:center;margin-bottom:0px">
                <?php echo $this->message; ?>
            </div>
          <?php endif; ?>
          <?php echo body(); ?>
        </div>

        <script src="js/libs/bootstrap.min.js"></script>
        <script src="js/ripples.min.js"></script>
        <script src="js/material.min.js"></script>
        <script>
            $(document).ready(function() {
                // This command is used to initialize some elements and make them work properly
                $.material.options.autofill = true;
                $.material.init();
            });
        </script>
        <script src="js/plugins.js"></script>
        <script src="js/application.js"></script>
	<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
	<script type="text/javascript" src="http://code.highcharts.com/highcharts-more.js"></script>
	<script type="text/javascript" src="http://code.highcharts.com/modules/exporting.js"></script>
	<script type="text/javascript">$('.tip').tooltip();</script>
        <script>
			$(document).ready(function(){
				$('#popover').popover({
				    trigger: 'click',
				    placement: 'bottom',
				    html: true,
				    container: 'body',
				    animation: 'false',
				    content: function() { return $('#openmllinks').html(); }
				});
				$('#popover2').popover({
				    trigger: 'click',
				    placement: 'bottom',
				    html: true,
				    container: 'body',
				    animation: 'false',
				    content: $('#sociallinks')
				});
				$('#popover').on('shown.bs.popover', function () {
 					 $('.popover').css('left','inherit')
 					 $('.popover').css('right','10px')
 					 $('.arrow').css('left','inherit')
 					 $('.arrow').css('right','10px')
				})
				$('#popover2').on('shown.bs.popover', function () {
 					 $('.popover').css('left','inherit')
 					 $('.popover').css('right','10px')
 					 $('.arrow').css('left','inherit')
 					 $('.arrow').css('right','55px')
					 $('#sociallinks').css('display','block')
				})
				$('#popover2').on('hide.bs.popover', function () {
					 $('body').append($('#sociallinks'))
					 $('#sociallinks').css('display','none')
				})
			});
			$(document).click(function (e) {
			    $('#popover').each(function () {
				if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				    if ($(this).data('bs.popover').tip().hasClass('in')) {
					$(this).popover('toggle');
				    }
				    return;
				}
			    });
			    $('#popover2').each(function () {
				if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				    if ($(this).data('bs.popover').tip().hasClass('in')) {
					$(this).popover('toggle');
				    }
				    return;
				}
			    });
			});
			$('body').on('hidden.bs.modal', '.modal', function () {
			  $(this).removeData('bs.modal');
			});
        </script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	    ga('require', 'linkid', 'linkid.js');
            ga('create', 'UA-40902346-1', 'openml.org');
            ga('send', 'pageview');
        </script>
	<?php echo $this->endjs; ?>

    </body>
</html>
