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
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
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
        <script type="text/javascript" src="js/openml.js"></script>
        <!-- page dependent javascript code -->
        <script type="text/javascript"><?php echo script();?></script>
    </head>
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <!--[if lt IE 7]>
        <p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
        <![endif]-->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&status=0";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <script src="//platform.linkedin.com/in.js" type="text/javascript">
            lang: en_US
        </script>
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse" style="left:10px">
                    <span class="icon-bar" style="background-color: #333;"></span>
                    <span class="icon-bar" style="background-color: #333;"></span>
                    <span class="icon-bar" style="background-color: #333;"></span>
                    </button>
                    <ul class="nav pull-right">
                        <li class="dropdown">
                            <a class="socialshare dropdown-toggle" data-toggle="collapse" data-target="#sociallinks" style="margin-top:1px;background:none">
                            <i class="icon-twitter-sign icon-2x"></i>
                            <i class="icon-linkedin-sign icon-2x"></i>
                            <i class="icon-google-plus-sign icon-2x"></i>
                            <i class="icon-facebook-sign icon-2x"></i>
                            </a>
                        </li>
                    </ul>
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
                                <i class="icon-user"></i><span class="userprofile"><?php if ($this->ion_auth->logged_in()) echo user_display_text(); else echo 'Sign in' ?></span>
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
        <div id="sociallinks" class="collapse">
            <div class="social navbar-top">
                <div class="container">
                    <span class="twitter">
                        <a href="https://twitter.com/share" class="twitter-share-button" data-text="Check out #OpenML at openml.org" data-url="openml.org" data-count="horizontal" data-related="joavanschoren">Tweet</a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    </span>
                    <span class="linkedin">
                        <script type="IN/Share" data-counter="right"></script>
                    </span>
                    <span style="width:5px;"></span>
                    <span class="google">
                        <div class="g-plusone" data-size="medium" data-annotation="inline" data-width="165" data-href="http://openml.org"></div>
                    </span>
                    <span class="Facebook">
                        <div class="fb-like" data-href="http://openml.org" data-send="false" data-width="250" data-show-faces="false"></div>
                    </span>
                </div>
            </div>
        </div>
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
                    </ul>
                    <ul class="nav navbar-nav pull-right visible-lg">
                        <li><a href="http://www.nwo.nl/" target="_blank"><img src="img/partners/nwo.png" alt="nwo" /></a></li>
                        <li><a href="http://www.pascal-network.org/" target="_blank"><img src="img/partners/PASCAL2.png" alt="pascal2" /></a></li>
                    </ul>
                    <ul class="nav openml-contact">
                        <li><a href="mailto:openmachinelearning@gmail.com" target="_blank"><i class="icon-edit icon-2x"></i><br />email</a></li>
                        <li><a href="https://twitter.com/intent/tweet?screen_name=joavanschoren&text=%23openml.org" data-related="joavanschoren"><i class="icon-twitter icon-2x"></i><br />tweet</a></li>
                        <li><a href="community"><i class="icon-comments-alt icon-2x"></i><br />discuss</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <script src="js/libs/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/application.js"></script>
        <script type="text/javascript">
            (function() {
              var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
              po.src = 'https://apis.google.com/js/plusone.js';
              var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
            })();
        </script>
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
