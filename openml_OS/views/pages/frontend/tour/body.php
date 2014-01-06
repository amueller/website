<div class="marketing" style="margin-top:30px">


<div class="row">
<div class="col-md-12">

<script type="text/javascript">
  $(document).ready(function() {
    $('.carousel').carousel({
      interval: false
    });
    $('.tourlink').popover();
  });

$('body').on('click', function (e) {
    $('.tourlink').each(function () {
        //the 'is' for buttons that triggers popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

</script>

<div id="myCarousel" class="carousel slide pause">

  <ol class="carousel-indicators-black carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
    <li data-target="#myCarousel" data-slide-to="4"></li>

  </ol>

  <div class="carousel-inner" style="min-height:320px">

    <div class="active item">
      <div class="tour">
        <div class="container">
        
 <div class="col-md-5 col-offset-1">
 <img src="img/openml-up.png" style="display: block;margin-left:auto;margin-right:auto;">
 </div>

 <div class="col-md-5 pull-left" style="text-align:left">
      <h2><i class="icon-group"></i>  Open Science</h2>
      <p>OpenML is an open ecosystem for machine learning. By organizing all resources <i>and results</i> online, research becomes more efficient, useful and fun.</p><br />

      <h2><i class="icon-heart"></i>  Get noticed</h2>
      <p>Share 
        <a class="tourlink" data-toggle="popover" data-container="body" data-html="true"  data-html="true" data-placement="bottom" data-content="Share datasets <a href='share'>manually</a>, or automatically through a <a href='plugins'>plugin</a> or the <a href='developers'>API</a>. Store them on OpenML, or reference them from another data repository or your website." title="Sharing datasets">
         <code>datasets</code>
        </a>,
        <a class="tourlink" data-toggle="popover" data-container="body" data-html="true" data-html="true" data-placement="bottom" data-content="Share algorithms (or workflows) <a href='share'>manually</a>, or automatically through a <a href='plugins'>plugin</a> or the <a href='developers'>API</a>. Store them on OpenML, or reference them from another repository or your website." title="Sharing algorithms">
	<code>algorithms</code></a> and
        <a class="tourlink" data-toggle="popover" data-container="body" data-html="true" data-html="true" data-placement="bottom" data-content="Experiments are shared as <i>runs</i> that solve a given <i>task</i> (read on). They can be uploaded <a href='share'>manually</a>, or automatically through a <a href='plugins'>plugin</a> or the <a href='developers'>API</a>." title="Sharing runs">
	<code>experiments</code></a>
	so that others can run with them. Follow how they are used, and get credit for all your work.</p>
	</div>
	</div>
      </div>
    </div>


    <div class="item">
      <div class="tour">
        <div class="container">
        
 <div class="col-md-5 col-offset-1">
 <img src="img/openml-down.png" style="display: block;margin-left:auto;margin-right:auto;">
 </div>

 <div class="col-md-5 pull-left" style="text-align:left">
      <h2><i class="icon-bolt"></i> Jump-start your research</h2>
        <p>Dive into millions of results on hundreds of datasets, algorithms and workflows.<p>

      <h2><i class="icon-search"></i> Search</h2>
      <p>Find datasets, implementations and more with simple <a class="tourlink" data-toggle="popover" data-container="body" data-html="true" data-placement="bottom" data-content="Enter your search terms on the <a href='home'>home</a> or <a href='search'>search page</a>. OpenML combines all that's known about them (including runs and statistics) in a single page." title="Keyword searches"><code>keyword searches</code></a>. Or, combine many results in quick <a class="tourlink" data-toggle="popover" data-container="body" data-html="true" data-placement="bottom" data-content="Choose data sets, implementations and/or evaluation metrics in the <a href='search/tab/wizardtab'>run search</a> and OpenML will return all matching results." title="Quick comparisons"><code>comparisons</code></a>.</p>

      <h2><i class="icon-beaker"></i> Advanced queries</h2>
      <p>Dive even deeper with <a class="tourlink" data-toggle="popover" data-container="body" data-html="true" data-placement="bottom" data-content="See the <a href='search/tab/exampletab'>advanced search</a> for examples of advanced queries. Run them directly or adapt them to your liking in the <a href='search/tab/sqltab'>SQL editor</a>." title="Advanced queries"><code>advanced queries</code></a>, including parameters, dataset properties and learning curves, <a class="tourlink" data-toggle="popover" data-container="body" data-html="true" data-placement="bottom" data-content="Write your own queries in the <a href='search/tab/sqltab'>SQL editor</a>, or compose them graphically in <a href='search/tab/querygraphtab'>Graph Search</a>." title="Composing queries"><code>compose</code></a> your own queries, and <a class="tourlink" data-toggle="popover" data-container="body" data-html="true" data-placement="bottom" data-content="Running a query returns a result table, but you can visualize results in scatterplots or lineplots, with more to come." title="Visualizations"><code>visualize</code></a> all results.</p>
    </div>

	</div>
      </div>
    </div>






    <div class="item">
      <div class="tour">
        <div class="container">

 <div class="col-md-5 col-offset-1">
 <img src="img/openml-plugins.png" style="display: block;margin-left:auto;margin-right:auto;">
 </div>

 <div class="col-md-5 pull-left" style="text-align:left">
      <h2><i class="icon-magic"></i> Automatic sharing</h2>
      <p>Sharing your discoveries should be as easy as possible. OpenML offers <a class="tourlink" data-toggle="popover" data-container="body" data-html="true" data-placement="bottom" data-content="<a href='plugins'>Plugins</a> download tasks and datasets into your favorite environment, and upload all your results (and the algorithms or workflows) to be organized online." title="OpenML plugins">
         <code>plugins</code>
        </a>
      for popular machine learning environments to automatically run experiments and save all results. Or, use the  
<a class="tourlink" data-toggle="popover" data-container="body" data-html="true" data-placement="bottom" data-content="Through the <a href='developers'>RESTful API</a>, you can automatically download and upload datasets, algorithms, tasks and runs. Integrate it into your own environments to run large amounts of experiments and keep track of all results." title="OpenML API">
         <code>OpenML API</code>
        </a>
to integrate OpenML in your tools or build your own plugins.</p>
    </div>

        </div>
      </div>
    </div>



    <div class="item">
      <div class="tour">
        <div class="container">

 <div class="col-md-5 col-offset-1">
 <img src="img/openml-task.png" style="display: block;margin-left:auto;margin-right:auto;">
 </div>

 <div class="col-md-5 pull-left" style="text-align:left">
      <h2><i class="icon-check"></i> Tasks</h2>
      <p>With tasks, you can share experiments on OpenML. Similar to data mining challenges, they contain data and all details that fully define an experiment, e.g., training- and test splits for cross-validation. They are downloaded from OpenML, and answered by uploading the requested results together with the algorithm or workflow used. OpenML then organizes everything online.</p> 
      <p>OpenML supports various types of tasks, sometimes with additional server-side support, but new types can be defined by users. The tasks themselves are automatically generated for new datasets, and can be <a href="http://openml.org/search/tab/tasktab">searched online</a>.</p>
    </div>
        </div>
      </div>
    </div>


    <div class="item">
      <div class="tour">
        <div class="container">
        
 <div class="col-md-5 col-offset-1">
 <img src="img/openml-log.png" style="display: block;margin-left:auto;margin-right:auto;">
 </div>

 <div class="col-md-5 pull-left" style="text-align:left">

      <h2><i class="icon-cloud"></i> Anytime, Anywhere</h2>
      <p>All your data is organized and linked online, so you can access everything anytime, from anywhere.</p>

      <h2><i class="icon-sun"></i> Transparency</h2>
      <p>All pertinent experiment details are saved for future reference and reproducibility. Results are linked to precise implementations, versions, and parameter settings for clear analysis.</p>

      <h2><i class="icon-book"></i> Beyond journals</h2>
	<p>In journals, experiments are static, summarized, and scattered. Here, they are linked together, up to date, and stored in full detail.</p></div>


        </div>
      </div>
    </div>
	</div>
  	<a class="left carousel-control" href="#myCarousel" data-slide="prev" style="background-image:none;color:#666"><i class="icon-chevron-left"></i></span></a>
	<a class="right carousel-control" href="#myCarousel" data-slide="next" style="background-image:none;color:#666"><i class="icon-chevron-right"></i></span></a>
</div></div>
</div>

<p style="margin-top:30px">
<a href="home" class="btn btn-small btn-bs">Got it, let's go!</a>
</p>


</div>
</div>
</div>




