<!-- <div class="alert alert-error" style="text-align:center;margin-bottom:0px">
  We're still under construction, check back soon! 
</div> -->
<!-- Main hero unit for a primary marketing message or call to action -->
<canvas id="c" width="400" height="400"></canvas>
<div class="marketing" style="margin-top:45px">
<div class="col-md-12">
<div id="logo">OpenML<div id="beta">beta</div></div>
</div>


<div class="col-md-12">
		<form class="form-inline" method="post" action="r">
		  <input type="text" class="form-control" style="width: 50%; height: 30px; font-size: 11pt" id="openmlsearch" name="searchterms" placeholder="Search machine learning experiments" value="<?php if( isset( $terms ) ) echo $terms; ?>" />
		  <button class="btn btn-primary btn-small" type="submit" style="height: 30px; vertical-align:top; font-size: 8pt;"><i class="fa fa-search fa-lg"></i></button>
		</form>
</div>

<script type="text/javascript">
document.getElementById('openmlsearch').focus()
</script>
<div class="col-md-12">
<div class="col-lg-6 col-lg-offset-3">
<div class="stats">
 <div class="statrow">
	  <a href="d" class="col-sm-4"><div class="statcell icongreen"><i class="fa fa-table fa-lg"></i><div class="statvalue"><span><?php $count = $this->Implementation->query('select count(did) as count from dataset where isOriginal="true"'); echo($count[0]->count); ?></span>datasets</div></div></a>
	  <a href="f" class="col-sm-4"><div class="statcell iconblue"><i class="fa fa-cogs fa-lg"></i><div class="statvalue"><span><?php $count = $this->Implementation->query('select count(fullName) as count from implementation'); echo($count[0]->count); ?></span>workflows</div></div></a>
	  <a href="r" class="col-sm-4"><div class="statcell iconred"><i class="fa fa-star fa-lg"></i><div class="statvalue"><span><?php $count = $this->Implementation->query('select count(rid) as count from run'); echo($count[0]->count); ?></span>runs</div></div></a>
 </div>
</div>
</div>

</div>
<div class="col-md-12">

<div id="catchphrase">Machine learning. Connected.</div>
<div class="introsection">
  <a href="#green" class="circle greensection"><i class="fa fa-rocket fa-2x"></i></a>
  <a href="#blue" class="circle bluesection"><i class="fa fa-flask fa-2x"></i></a>
  <a href="#red" class="circle redsection"><i class="fa fa-heart fa-2x"></i></a>
</div>
 </div>

 <div id="green" class="introsection greensection"> 

      <h1><i class="fa fa-rocket fa-lg"></i><br>For the curious</h1>
<p>What if you could explore machine learning research as easily as exploring Wikipedia?</p>
<p>What if you could share new data, code and experiments as easily as sending a tweet?</p>
<!-- <p>What if all algorithms and experiments are organized online?</p> -->

<div class="row">
  <div class="col-md-4"><h1><i class="fa fa-globe"></i></h1><h2>Networked science</h2>
  <p>OpenML enables truly collaborative machine learning. Scientists can post important data, inviting anyone to help analyze it. OpenML structures and organizes all results online to show the state of the art and push progress.</p>
  </div>
  <div class="col-md-4"><h1><i class="fa fa-cloud-upload"></i></h1><h2>Sharing. No PhD required</h2>
  <p>OpenML is being integrated in most popular machine learning environments, so you can automatically upload all your data, code, and experiments. And if you develop new tools, there's an API for that, plus people to help you.</p>
  </div>
  <div class="col-md-4"><h1><i class="fa fa-search"></i></h1><h2>Easy access</h2>
  <p>OpenML allows you to search, compare, visualize, analyze and download all combined results online. Explore the state of the art, improve it, build on it, ask questions and start discussions.
  </p>
  </div>
</div>
<!-- Sharing like twitter, search like gmail, discuss like facebook -->
 </div>
        
 <div id="blue" class="introsection bluesection"> 
      <h1><i class="fa fa-flask fa-lg"></i><br>For Science</h1>
<p>What if you could collaborate on hard problems with hundreds of scientists at once?</p>
<p>What if you could easily access the latest data to answer questions or verify findings?</p>

<div class="row">
  <div class="col-md-4"><h1><i class="fa fa-sun-o"></i></h1><h2>Transparency</h2>
  <p>Science follows certain methods. On OpenML, these are expressed as <i>tasks</i> detailing what results must be uploaded, and requiring the information necessary to ensure that uploaded results are interpretable and verifiable.</p>
  </div>

  <div class="col-md-4"><h1><i class="fa fa-comments-o"></i></h1><h2>Collective intelligence</h2> <!--data driven intelligence -->
  <p>Tasks are solved collaboratively. Anyone can propose new tasks, and anyone can upload new results, augment the data, contribute new ideas, ask questions, or discuss issues and results online.</p>
 </div>

  <div class="col-md-4"><h1><i class="fa fa-book"></i></h1><h2>Beyond journals</h2>
  <p>OpenML enriches research output by making it freely accessible, organized, continuously updated, immensely detailed, and reproducible. It stimulates online discussion and diminishes publication bias.</p>
  </div>

</div>



 </div>


 <div id="red" class="introsection redsection"><a name="red"></a> 
      <h1><i class="fa fa-heart fa-lg"></i><br>For Scientists</h1>
<p>What if you could spend more time doing actual research?</p>
<p>What if you could get more credit for your work by making it more visible?</p>

<div class="row">
  <div class="col-md-4"><h1><i class="fa fa-clock-o"></i></h1><h2>More time</h2>
  <p>OpenML takes care of the routinizable work required for yielding insight. It helps you run large amounts of experiments using many datasets and techniques, organizes them online and relates them to the state-of-the-art.</p>
  </div>

  <div class="col-md-4"><h1><i class="fa fa-lightbulb-o"></i></h1><h2>More knowledge</h2>
  <p>OpenML organizes, links and annotates your results so that you can focus on discovery: interpreting the data, linking it to other data, formulating new hypotheses and designing new experiments to test them.</p>
  </div>

  <div class="col-md-4"><h1><i class="fa fa-trophy"></i></h1><h2>More credit</h2> <!-- creative commons -->
  <p>OpenML helps you share your results for optimal impact. Share with the world or with friends, freely or with attribution (citation). Follow how often your contributions are reused or liked and climb up the leaderboards.</p>
  </div>

</div>



</div>

</div> <!-- end  marketing -->






</div>
<!-- <div style="margin-bottom:-60px;"></div>  make footer visible on main page -->
