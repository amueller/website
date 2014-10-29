<div class="col-sm-12 col-md-3 searchbar">
      <div class="bs-sidebar affix">
        <ul class="nav bs-sidenav">
	    <li><a href="#g_intro">Introduction</a></li>
	    <li><a href="#g_start">Data, tasks, flows, runs</a></li>
	    <li><a href="#g_plugins">Plugins</a></li>
	    <li><a href="#g_apis">Programming APIs</a></li>
	    <li><a href="#g_rest">REST APIs</a></li>
	    <li><a href="#g_devsest">Developers</a></li>
	</ul>
      </div>
</div>

<div class="col-sm-12 col-md-9 openmlsectioninfo">
  <div class="bs-docs-section">
    <h2>OpenML aims to create a frictionless, collaborative environment for exploring machine learning</h2>
    <p><i class="fa fa-globe fa-fw fa-lg"></i> <a href="d">Data sets</a> and <a href="f">workflows</a> from various sources <a href="search">analysed and organized</a> online for easy access</p>
    <p><i class="fa fa-cogs fa-fw fa-lg"></i> <a href="guide/#g_apis">Integrated</a> into <a href="guide/#g_plugins">machine learning environments</a> for automated experimentation, logging, and sharing</p>
    <p><i class="fa fa-flask fa-fw fa-lg"></i> <a href="r">Fully reproducible and organized results</a> (e.g. models, predictions) you can build on and compare against</p>
    <p><i class="fa fa-users fa-fw fa-lg"></i> Share your work with the world or within circles of trusted researchers</p>
    <p><i class="fa fa-graduation-cap fa-fw fa-lg"></i> Make your work more visible and <a href="guide/#g_citation">easily citable</a></p>
    <p><i class="fa fa-bolt fa-fw fa-lg"></i> Tools to help you design and optimize workflows</p>

 
    <h3 id="g_intro">Introduction</h3>
<p>OpenML is a place where data scientists can automatically share data in fine detail, build on the results of others, and collaborate on a global scale. It allows anyone to link new data sources, and everyone able to analyse that data to share their code and results (e.g., models, predictions, and evaluations). OpenML makes sure that all shared results are stored and organized online for easy access, reuse and discussion.</p>
<p>Moreover, OpenML is integrated in many great data mining platforms, so that anyone can easily import the data into these tools, pick any algorithm or workflow to run, and automatically keep track of all obtained results. The OpenML website provides easy access to all collected data and code, compares all results obtained on the same data or algorithms, builds data visualizations, and supports online discussions.</p>
<p>OpenML makes it easy to access data, connect to the right people, and automate experimentation, so that you can focus on the data science.</p>

<h3 id="g_start"><i class="fa fa-database fa-fw"></i> Data</h3>
<p>New data sets can be uploaded <a href="new/data">through the website</a>, <a href="guide/#g_apis">programmatically</a>, or using <a href="guide/#g_rest">web services</a>. Data hosted elsewhere can be referenced by a URL pointing to a landing page or web service. OpenML keeps track of versioning as data sets evolve.</p>

<p>To ensure data interoperability, we work with a limited number of data formats. For these formats, OpenML will automatically compute a large array of <a href="a">data characteristics</a>. These are used to visualize the data online, to make it easier to find data of interest, and to learn which data analysis methods are most suited on which types of data.</p>

<p>Every data set has a <a href="d/1">dedicated page on OpenML</a>, including links to every study it is used in, all obtained results, and room for discussions.</p>

<h3><i class="fa fa-trophy fa-fw"></i> Tasks</h3>
<p>To collaborate, we must also agree on expected outputs and scientific protocols. <a href="t/1">Tasks</a> express exactly which input data is given and which outputs should be returned. For instance, <a href="t/type/1">classification tasks</a> state cross-validation procedures and labeled input data as inputs, and require predictions as outputs.</p>

<p>Tasks are similar to data mining challenges, except that they are collaborative: scientists (and students) are free to build on the results of others. Tasks are also machine-readable so that tools can interpret them, download all data automatically and use the correct procedures to produce results.</p>

<p>Tasks are created by first defining <a href="t">task types</a> in community discussions. Next, tasks are <a href="new/task">created</a> once, and can then be downloaded and solved by anyone. When needed, OpenML provides additional support such as server-side evaluations to ensure that all submitted results are easily comparable.</p>
 
<p>Each tasks has a <a href="t/1">dedicated page on OpenML</a> including an overview of all shared results, visualisations, leaderboards, and community discussions.</p> 

<h3><i class="fa fa-cogs fa-fw"></i> Flows</h3>
<p><a href="f/60">Flows</a> are implementations of single algorithms, workflows, or scripts. Ideally, they can take a task ID as input to run experiments. Flows are uploaded to OpenML <a href="new/flow">through the website</a>, <a href="guide/#g_apis">programmatically</a>, or using <a href="guide/#g_rest">web services</a>. You can upload code or reference it by a URL to an open source platform such as GitHub. OpenML keeps track of versioning as code evolves.</p>

<p>Data scientists are encouraged to add descriptions for the (hyper)parameters of each flow. This will enable tools to automatically tune these parameters. Flows can also be annotated to explain capabilities and limitations, or to outline their structure.</p>

<p>Each flow has a <a href="f/60">dedicated page on OpenML</a> including an overview of its results over various tasks, and a discussion section.</p> 

<h3><i class="fa fa-star fa-fw"></i> Runs</h3>
<p><a href="r/1">Runs</a> are applications of flows on a specific task. They are submitted <a href="guide/#g_plugins">automatically by machine learning environments</a>, using <a href="guide/#g_rest">web services</a>, or <a href="new/run">through the website</a>. Runs are fully reproducible and OpenML organizes them into a coherent whole based on the underlying tasks, flows, and authors.</p>

<p>Each run has <a href="r/1">its own page</a>, listing all uploaded results as well as server-side evaluations and visualisations. Runtimes and machine benchmarks are typically also provided.</p>

<p>OpenML also allows you to <a href="r">compare, search and visualize</a> all combined results, and link them to all details of the underlying flows, tasks, and data sets. All data can also be downloaded from the website or <a href="guide/#g_apis">imported directly into machine learning environments</a> to visualise or analyse it further.</p>

	<h3 id="g_plugins">Plugins</h3>
<p>OpenML is deeply integrated in several popular machine learning environments, so that it can be used out of the box. This means you can just give the environment a list of task ids, and it will automatically download all data, use all required procedures to ensure the correctness of the results, and upload all details to make the result reproducible. You just need to design and run your workflows, and the environment will upload all results to OpenML in the background, which will organize all results online.</p>

<p>Currently, OpenML is integrated, or being integrated, into the following environments. Follow the links to detailed instructions.
<ul class="nav-tab">
<li><a href="#plugin_weka" class="switchtab" data-toggle="tab">WEKA, Waikato Environment for Knowledge Analysis</a></li>
<li><a href="#plugin_moa" class="switchtab" data-toggle="tab">MOA, Massive Online Analysis</a></li>
<li><a href="#plugin_mlr" class="switchtab" data-toggle="tab">mlr, Machine Learning in R</a></li>
<li><a href="#plugin_rm" class="switchtab" data-toggle="tab">RapidMiner</a></li>
</ul>

	<h3 id="g_apis">Programming APIs</h3>
<p>If you want to integrate OpenML into your own tools, we offer several language-specific API's, so you can easily interact with OpenML to list, download and upload data sets, tasks, flows and runs. For instance, downloading a task with the Java API will give you a Java object containing all data and information needed to execute that task. We are currently offering the following API's:</p>
<ul>
<li><a href="#java" class="switchtab" data-toggle="tab">Java</a></li>
<li><a href="#r" class="switchtab" data-toggle="tab">R</a></li>
<li><a href="#python" class="switchtab" data-toggle="tab">Python</a></li>
</ul>
</p>

	<h3 id="g_rest">REST APIs</h3>
<p>If the above solutions are not sufficient, OpenML also offers a <a href="#rest_services">RESTful Web API</a> which allows you to talk to OpenML directly. Most communication is done using XML, but we also offer JSON endpoints for convenience.
<ul>
<li><a href="#rest_tutorial" class="switchtab" data-toggle="tab">REST Tutorial</a></li>
<li><a href="#rest_services" class="switchtab" data-toggle="tab">List of REST services</a></li>
<li><a href="#json" class="switchtab" data-toggle="tab">JSON Endpoints</a></li>
</ul>
</p>

	<h3 id="g_devs">Developers</h3>
<p>OpenML is an open source project, <a href="https://github.com/openml">hosted on GitHub</a>, and maintained by a very active community of developers. We welcome everybody to contribute to OpenML, and are glad to help you make optimal use of OpenML in your research.
<ul>
<li><a href="#devels" class="switchtab" data-toggle="tab">Information for developers</a></li>
</ul>
</p>

   </div>
</div>
