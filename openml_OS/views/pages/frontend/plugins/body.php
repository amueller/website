<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1">
    <div class="col-sm-12 col-md-3 searchbar">

 <div class="bs-sidebar">
 <ul class="nav bs-sidenav">
      
  <li><a href="#java">Java API</a>
  <ul class="nav">
    <li><a href="#java-plugin">Download Plugin</a></li>
    <li><a href="#java-start">Quick Start</a></li>
  </ul>
  </li>
  
  <li><a href="#r">R API</a>
  <ul class="nav">
    <li><a href="#r-plugin">Download Plugin</a></li>
    <li><a href="#r-start">Quick Start</a></li>
  </ul>
  </li>
        
  <li><a href="#weka">WEKA</a>
  <ul class="nav">
    <li><a href="#weka-plugin">Download Plugin</a></li>
    <li><a href="#weka-start-exp">Quick Start</a></li>
    <li><a href="#weka-start-cli">Quick Start CLI</a></li>
  </ul>
  </li>
  
  <li><a href="#moa">MOA</a>
  <ul class="nav">
    <li><a href="#moa-plugin">Download Plugin</a></li>
    <li><a href="#moa-start">Quick Start</a></li>
  </ul>
  </li>

  <li><a href="#knime">KNIME</a>
  <ul class="nav">
    <li><a href="#knime-plugin">Download Plugin</a></li>
    <li><a href="#knime-start">Quick Start</a></li>
  </ul>
  </li>

  <li><a href="#rapidminer">RapidMiner</a>
  <ul class="nav">
    <li><a href="#rm-plugin">Download Plugin</a></li>
    <li><a href="#rm-start">Quick Start</a></li>
  </ul>
  </li>              
            </ul>
          </div>

    </div> <!-- end col-2 -->
    <div class="col-sm-12 col-md-9 openmlsectioninfo">

  <div class="bs-docs-section">
          <div class="page-header">
            <h1 id="java">Java API</h1>
          </div>
        The Java API allows you connect to OpenML from Java applications.
	<h2 id="java-download">Download</h2>
	The Java API is available from <a href="http://search.maven.org/#artifactdetails%7Corg.openml%7Capiconnector%7C0.9.17%7Cjar">Maven central</a>. Or, you can check it out from <a href="https://github.com/openml/r"> GitHub</a>.
	<h2 id="java-maven">Maven Installation</h2>
	How to include the Java API.
	<h2 id="java-start">Quick Start</h2>
	<p>Create an ApiConnector instance. All its functions are described in the <a href="docs">Java Docs.</a></p>
	<pre>ApiConnector apiconnector = new ApiConnector();</pre>
	<p>For instance, authenticate by sending your username and password. You'll get an Authenticate object (token) for uploading data to OpenML.</p>
	<pre>Authenticate auth = apiconnector.openmlAuthenticate(username, password);</pre>
			
	<h2 id="java-issues">Issues</h2>
	Having questions? Did you run into an issue? Let us know via the <a href="https://github.com/openml/java/issues"> OpenML Java issue tracker</a>.
	</div>


  <div class="bs-docs-section">
          <div class="page-header">
            <h1 id="r">R API</h1>
          </div>
	The R package openML allows you to connect to the OpenML server from R scrips. Users can download and upload files, run their implementations on specific tasks, get predictions in the correct form, make SQL queries, etc. directly via R commands.
	<h2 id="r-plugin">Download Plugin</h2>
	The openML package can be downloaded from <a href="https://github.com/openml/r"> GitHub</a>.
	<h2 id="r-start">Quick Start</h2>
	In <a href="https://github.com/openml/r/blob/master/doc/knitted/1-Introduction.md">this tutorial</a>, we will show you the most important functions of this package and give you examples on standard workflows.
	<h2 id="java-issues">Issues</h2>
	Having questions? Did you run into an issue? Let us know via the <a href="https://github.com/openml/r/issues"> OpenML R issue tracker</a>.
	</div>

    <div class="bs-docs-section">
     <div class="page-header">
            <h1 id="weka">WEKA</h1>
          </div>
OpenML is integrated in the Weka (Waikato Environment for Knowledge Analysis) Experimenter and the Command Line Interface. 
	  	  <h2 id="weka-plugin">Download Plugin</h2>
      The current beta integration is available as a stand alone WEKA version which can be downloaded here:<br/>
		  <br/>
		  <a href="downloads/OpenWeka.beta.jar"><button class="btn btn-large btn-primary" type="button">Download Weka OpenML</button></a>
		  <br/><br/>
		  <img src="img/partners/Weka_logo.png" /><br/>

			<h2 id="weka-start-exp">Quick Start Experimenter</h2>
			<div>
			Open WEKA allows you to run OpenML Tasks in the Weka Experimenter. You can solve OpenML tasks locally and/or automatically upload your experiments to OpenML.
			<ol>
				<li>Create an account on OpenML.org (click the user icon in the top bar). You need this only if you want to upload your results.</li>
				<li>Download the extended WEKA environment by clicking on the Download button above. Open the jar file.</li>
				<li>After starting Weka, choose the 'Experimenter' from the GUI Chooser. </li>
				<li>In the Weka Experimenter, click the "New" button. (For the moment this is the only option, a more dedicated GUI will be released in the near future.) </li>
				<li>If you want to upload experiments to  OpenML.org, choose 'OpenML.org' under 'Results Destination'. Connect to your OpenML account using the 'Login' button.</li>
				<li>The Experiment Type should now be "OpenML Task". All other experimenter inputs should be disabled (they are defined in OpenML tasks).</li>
				<li>In the "Tasks" panel, click the "Add New" button to add new Tasks. Insert the task id's as comma-separated values (e.g., '1,2,3,4,5'). Use <a href="search/tab/tasktab">this form</a> to search for interesting tasks. In the future this will also be integrated in WEKA.</li>
				<li>Add algorithms in the "Algorithm" panel.</li>
				<li>Go to the "Run" tab, and click on the "Start" button. </li>
				<li>The experiment will be executed, and if indicated, also sent to OpenML.org. When the experiment is finished, the results can be inspected in the "Analyse" tab. </li>
				<li>In your browser, log in to OpenML.org. Click on your name and choose 'My runs' to see a list of all submitted runs. They can now be queried together with all OpenML results. More overviews of your personal experiments will be added soon.</li>
			</ol> 
			</div>
      
      <h2 id="weka-start-cli">Quick Start CommandLine interface</h2>
      The Command Line interface is useful for running experiments automatically on a server, without the possibility of invoking a GUI.
      <ol>
        <li>Make sure a recent version of JRE is installed (version 1.6 or higher).</li>
        <li>Open a console and browse to the same directory as the Weka JAR. </li>
        <li>Create a config file called <code>openml.conf</code>. This config file should be in the same directory as the Weka jar. </li>
        <li>This config file should contain two lines: Line 1 contains a string in the format username = &lt;Your username&gt;. Line 2 contains a string in the format password = &lt;Your password&gt;</li>
        <li>Execute the following command: <pre>java -cp OpenWeka.beta.jar openml.experiment.TaskBasedExperiment -T &lt;task_id&gt; -C &lt;classifier_classpath&gt; -- &lt;parameter_settings&gt;</pre></li>
        <li>For example, the following command will run Weka's J48 algorithm on Task 1: <pre>java -cp OpenWeka.beta.jar openml.experiment.TaskBasedExperiment -T 1 -C weka.classifiers.trees.J48</pre> </li>
        <li>The following suffix will set some parameters of this classifier: <pre>-- -C 0.25 -M 2</pre></li>      
      </ol>
			
		  Please note that this is a beta version, which is under active development. Please report any bugs that you may encounter to <a href="mailto:j.n.van.rijn@liacs.leidenuniv.nl">j.n.van.rijn@liacs.leidenuniv.nl</a>. </div>
      
      <div class="bs-docs-section">
          <div class="page-header">
            <h1 id="moa">MOA </h1>
          </div>

          <h2 id="moa-plugin">Download Plugin</h2>
            <p>OpenML features extensive support for MOA. However currently this is implemented as a stand alone MOA compilation, using the latest version (as of May, 2014). 
            </p><br>
            <a href="downloads/openmlmoa.beta.jar">
              <button class="btn btn-large btn-primary" type="button">Download MOA for OpenML</button>
            </a>
            <br/>
            <br/>
          <img src="img/partners/moa.png" /><br/>
          <h2 id="moa-start">Quick Start</h2>
            Make sure a file called "openml.conf" (<a target="blank" href="downloads/openml.conf">example</a>) is present in the same directory. This file should contain two lines, indicating the username and password (server is optional).
            Launch the JAR file by double clicking on it, or use the following command:
            <pre>java -cp openmlmoa.beta.jar moa.gui.GUI</pre>
            
            Select the task <code>moa.tasks.openml.OpenmlDataStreamClassification</code> to evaluate a classifier on an OpenML task, and send the results to OpenML. Select the <code>moa.tasks.WriteStreamToArff</code> task, with <code>moa.streams.generators.BayesianNetworkGenerator</code> to create a stream using the Bayesian Network Generator.<br/><br/>
            
            Please note that this is a beta version, which is under active development. Please report any bugs that you may encounter to <a href="mailto:j.n.van.rijn@liacs.leidenuniv.nl">j.n.van.rijn@liacs.leidenuniv.nl</a>.
          </div>
      
         <div class="bs-docs-section">
          <div class="page-header">
            <h1 id="knime">KNIME</h1>
          </div>
	You can design OpenML workflows in KNIME to directly interact with OpenML. The KNIME plugin is currently <a href="https://github.com/openml/knime"> under development</a>.
	</div>

         <div class="bs-docs-section">
          <div class="page-header">
            <h1 id="rapidminer">RapidMiner</h1>
          </div>
	You can design OpenML workflows in RapidMiner to directly interact with OpenML. The RapidMiner plugin is currently <a href="https://github.com/openml/rapidminer"> under development</a>.
	</div>
      </div> <!-- end col-md-9 -->
      </div> <!-- end col-md-10 -->
</div> <!-- end row -->
</div> <!-- end container -->
