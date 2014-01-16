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
        <meta name="description" content="OpenML is an open science platform for machine learning. Browse and compare previous research. Share experiments, algorithms and data. Get noticed and let others run with your results.">
        <meta name="author" content="Joaquin Vanschoren">
        <meta property="og:title" content="OpenML"/>
        <meta property="og:url" content="http://www.openml.org"/>
        <meta property="og:image" content="http://www.openml.org/img/openmllogo.png"/>
        <meta property="og:site_name" content="OpenML: Open Machine Learning"/>
        <meta property="og:description" content="OpenML is an open science platform for machine learning. Browse and compare previous research. Share experiments, algorithms and data. Get noticed and let others run with your results."/>
        <meta property="og:type" content="Science"/>
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/expdb.css">
        <link rel="stylesheet" href="css/share.css">
        <link rel="stylesheet" href="css/docs.css">
        <link rel="stylesheet" href="css/pygments-manni.css">
        <link rel="stylesheet" href="css/prettify.css">
        <link rel="stylesheet" href="css/codemirror.css">
        <link rel="stylesheet" href="css/eclipse.css">
        <link rel="stylesheet" href="css/jquery-ui.css" type="text/css"/>
        <link rel="stylesheet" href="css/datatables_custom.css" type="text/css"/>
        <link rel="stylesheet" href="css/TableTools.css" type="text/css"/>
        <link rel="stylesheet" href="css/datatables.bootstrap.css" type="text/css"/>
        <link rel="stylesheet" href="css/MyFontsWebfontsKit.css">
        <link rel="shortcut icon" href="img/favicon.ico">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
            <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.2.min.js"><\/script>')</script>
            -->
        <script type="text/javascript" src="js/libs/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/libs/jquery.validate.js"></script>
        <script type="text/javascript" src="js/libs/jquery-ui.js"></script>
        <script type="text/javascript" src="js/libs/modernizr-2.5.3-respond-1.1.0.min.js" ></script>
        <script type="text/javascript" src="js/libs/processing.js" ></script>
        <script type="text/javascript" src="js/libs/dat.gui.min.js" ></script>
        <script type="text/javascript" src="js/libs/codemirror.js" ></script>
        <script type="text/javascript" src="js/libs/mysql.js" ></script>
        <script type="text/javascript" src="js/libs/highcharts.js"></script>
        <script type="text/javascript" src="js/libs/modules/exporting.js"></script>
        <script type="text/javascript" src="js/libs/jquery.dataTables.js"></script>
        <script type="text/javascript" src="js/libs/jquery.dataTables.TableTools.min.js"></script>
        <script type="text/javascript" src="js/libs/jquery.dataTables.bootstrap.js"></script>
        <script type="text/javascript" src="js/libs/jquery.form.js"></script>
        <script type="text/javascript" src="js/libs/jquery.sharrre.js"></script>
        <script type="text/javascript" src="js/openml.js"></script>
        <?php if( isset( $this->load_javascript ) ): foreach( $this->load_javascript as $j ): ?>
        <script type="text/javascript" src="<?php echo $j; ?>"></script>
        <?php endforeach; endif; ?>     

        <!-- page dependent javascript code -->
        <script type="text/javascript"><?php echo script();?></script>
    </head>
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <!--[if lt IE 7]>
        <p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
        <![endif]-->
        <div class="navbar navbar-default navbar-static-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="socialshare navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse" style="background:none">
                     <i class="fa fa-bars fa-2x"></i>
                    </a>
                    <a class="nav pull-right socialshare" data-toggle="modal" href="#sociallinks">
                     <i class="fa fa-share fa-2x"></i>
                    </a>
                    <a class="nav pull-right openmlmenu">
                     <i class="fa fa-th fa-2x"></i>
                    </a>
		    <script>
			$('.openmlmenu').each(function() {
			  var $this = $(this);
			  $this.popover({
			    trigger: 'hover',
			    placement: 'bottom',
			    html: true,
			    content: $this.find('#sociallinks').html()  
			  });
			});
		    </script>
                    <a class="navbar-brand" href="" style="float:left">OpenML</a>
                    <div class="navbar-collapse collapse navbar-responsive-collapse" style="width:900px">
                        <ul class="nav navbar-nav">
                            <li <?php if($this->active=='search') echo 'class="active"'; ?>><a href="search">Search</a></li>
                            <li <?php if($this->active=='share') echo 'class="active"'; ?>><a href="share">Share</a></li>
                            <li <?php if($this->active=='plugins') echo 'class="active"'; ?>><a href="plugins">Plugins</a></li>
                            <li <?php if($this->active=='developers') echo 'class="active"'; ?>><a href="developers">Developers</a></li>
                            <li <?php if($this->active=='community') echo 'class="active"'; ?>><a href="community">Community</a></li>
                            <li class="dropdown <?php if($this->active=='profile') echo 'active'; ?>" id="menu1" >
                                <a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo $_SERVER['REQUEST_URI'];?>#menu1">
                                <i class="fa fa-user"></i><span class="userprofile"><?php if ($this->ion_auth->logged_in()) echo user_display_text(); else echo 'Sign in' ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if (!$this->ion_auth->logged_in()): ?>
                                    <li><a href="register">Register</a></li>
                                    <li class="divider"></li>
                                    <li><a href="login">Sign in</a></li>
                                    <?php else: ?>
		                                <?php if ($this->ion_auth->user()->row()->external_source == false ): ?>
		                                <li><a href="overview_runs">My runs</a></li>
		                                <li><a href="profile">Profile</a></li>
		                                <li class="divider"></li>
		                                <?php endif; ?>
                                    <li><a href="frontend/logout">Sign off</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
	<div class="modal fade" id="sociallinks" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-body">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<div class="socialcontainer">
		<div class="sharetitle">Share</div>
		<div id="social-bar">
		  <div id="twitter" data-url="http://openml.org" data-text="Check out #OpenML at openml.org" data-title="twitter"></div>
		  <div id="facebook" data-url="http://openml.org" data-text="Check out OpenML at openml.org" data-title="facebook"></div>
		  <div id="googleplus" data-url="http://openml.org" data-text="Check out OpenML at openml.org" data-title="google-plus"></div>
		  <div id="linkedin" data-url="http://openml.org" data-text="Check out OpenML at openml.org" data-title="linkedin"></div>
		  <div id="pinterest" data-url="http://openml.org" data-text="Check out OpenML at openml.org" data-title="pinterest"></div>
		</div>
		  <script type="text/javascript" src="js/share.js"></script>
		</div>
		<div class="socialcontainer">
		<div class="sharetitle">Follow</div>
		<div id="social-bar">
                <a href="https://twitter.com/open_ml">
                    <i class="fa fa-twitter"></i>
                </a>
                <a href="https://www.facebook.com/openml">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="https://plus.google.com/communities/105075769838900568763">
                    <i class="fa fa-google-plus"></i>
                </a>
                <a href="https://github.com/openml">
                    <i class="fa fa-github"></i>
                </a>
            	</div>
		</div>
              </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
        <script>
            $(document).ready(function(){ 
            	$("#loginForm").validate({ }); 
            	$('#loginModal').on('shown', function () {
            		$("#inputEmail").focus();
            	})
            });
        </script>
        <div id="wrap">
            <!-- USER MESSAGE -->
            <noscript>
                <div class="alert alert-error" style="text-align:center;">
                    JavaScript is required to properly view the contents of this page!
                </div>
            </noscript>
            <?php if($this->message!==false): ?>
            <div class="alert alert-info" style="text-align:center;margin-bottom:0px">
                <?php echo $this->message; ?>
            </div>
            <?php endif; ?>
            <?php echo body(); ?>
        </div>
        <hr class="softennarrow" style="margin: 10px 0 0 0">
        <div class="navbar navbar-default navbar-bottom openmlfooter">
            <div class="navbar-inner">
                <div class="container">
                    <ul class="nav navbar-nav pull-left visible-lg">
                        <li><a href="http://dtai.cs.kuleuven.be" target="_blank"><img src="img/logo_kuleuven.png" alt="kuleuven" /></a></li>
                        <li><a href="http://datamining.liacs.nl" target="_blank"><img src="img/logo_uleiden.png" alt="uleiden" /></a></li>
                        <li><a href="http://www.tue.nl/universiteit/faculteiten/faculteit-w-i/onderzoek/de-onderzoeksinstituten/data-science-center-eindhoven-dsce/" target="_blank"><img src="img/logo_tue.gif" alt="tue" /></a></li>
                    </ul>
                    <ul class="nav navbar-nav pull-right visible-lg">
                        <li><a href="http://www.nwo.nl/" target="_blank"><img src="img/partners/nwo.png" alt="nwo" /></a></li>
                        <li><a href="http://www.pascal-network.org/" target="_blank"><img src="img/partners/PASCAL2.png" alt="pascal2" /></a></li>
                    </ul>
                    <ul class="nav openml-contact">
                        <li><a href="mailto:openmachinelearning@gmail.com" target="_blank"><i class="fa fa-edit fa-2x"></i><br />email</a></li>
                        <li><a href="https://twitter.com/intent/tweet?screen_name=joavanschoren&text=%23openml.org" data-related="joavanschoren"><i class="fa fa-twitter fa-2x"></i><br />tweet</a></li>
                        <li><a href="community"><i class="fa fa-comments-o fa-2x"></i><br />discuss</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <script src="js/libs/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/application.js"></script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            
            ga('create', 'UA-40902346-1', 'openml.org');
            ga('send', 'pageview');
        </script>
    </body>
</html>
