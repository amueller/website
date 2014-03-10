<div class="sectionheader">
<div class="sectionlogo"><a href="">OpenML</a></div>
<div class="sectiontitlepurple"><a href="plugins">Plugins</a></div>
</div>
<div class="bs-docs-container topborder">
    <div class="col-xs-12 col-sm-3 col-md-2 searchbar">
 <div class="bs-sidebar">
 <ul class="nav bs-sidenav">
              
  <li><a href="#weka">WEKA</a>
  <ul class="nav">
    <li><a href="#weka-plugin">Download Plugin</a></li>
    <li><a href="#weka-start-exp">Quick Start</a></li>
    <li><a href="#weka-start-cli">Quick Start CLI</a></li>
  </ul>
  </li>

  <li><a href="#r">R</a>
  <ul class="nav">
    <li><a href="#r-plugin">Download Plugin</a></li>
    <li><a href="#r-start">Quick Start</a></li>
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

    <div class="col-xs-12 col-sm-9 col-md-10 openmlsectioninfo">
    <div class="bs-docs-section">
     <div class="page-header">
            <h1 id="weka">WEKA</h1>
          </div>
	  	  <h3 id="weka-plugin">Download Plugin (Last major update: 07-02-2014)</h3> 
		  OpenML is integrated in the Weka (Waikato Environment for Knowledge Analysis) Experimenter and the Command Line Interface. 
      The current beta integration is available as a stand alone WEKA version which can be downloaded here:<br/>
		  <br/>
		  <a href="downloads/OpenWeka.beta.jar"><button class="btn btn-large btn-primary" type="button">Download Weka OpenML</button></a>
		  <br/><br/>
		  <img src="img/partners/Weka_logo.png" /><br/>

			<h3 id="weka-start-exp">Quick Start Experimenter</h3>
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
      
      <h3 id="weka-start-cli">Quick Start CommandLine interface</h3>
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
			
		  Please note that this is a beta version, which is under active development. Please report any bugs that you may encounter to <a href="mailto:jvrijn@liacs.nl">jvrijn@liacs.nl</a>. </div>

  <div class="bs-docs-section">
          <div class="page-header">
            <h1 id="r">R</h1>
          </div>
	<h3 id="r-plugin">Download Plugin</h3>
	The R plugin is under development. It is best checked out from <a href="https://github.com/openml/r"> GitHub</a>.
	<h3 id="r-start">Quick Start (for mlr package)</h3>
	The R package openML is an interface to make interactions with the openML server as comfortable as possible. Users can download and upload files, run their implementations on specific tasks, get predictions in the correct form, make SQL queries, etc. directly via R commands. In <a href="https://github.com/openml/r/blob/master/doc/knitted/1-Introduction.md">this tutorial</a>, we will show you the most important functions of this package and give you examples on standard workflows.
	<ul>
	<li><a href="https://github.com/openml/r/blob/master/doc/knitted/2-Download-a-task.md">Download a task</a></li>
	<li><a href="https://github.com/openml/r/blob/master/doc/knitted/3-Upload-an-implementation.md">Upload an implementation</a></li>
	<li><a href="https://github.com/openml/r/blob/master/doc/knitted/4-Upload-predictions.md">Upload predictions</a></li>
	<li><a href="https://github.com/openml/r/blob/master/doc/knitted/5-Download-performance-measures.md">Download performance measures</a></li>
	<li><a href="https://github.com/openml/r/blob/master/doc/knitted/6-Browse-the-database.md">Browse the database</a></li>
	</div>

  <div class="bs-docs-section">
          <div class="page-header">
            <h1 id="knime">KNIME</h1>
          </div>
	<h3 id="knime-plugin">Download Plugin</h3>
	You can design OpenML workflows in KNIME to directly interact with OpenML. The KNIME plugin is currently <a href="https://github.com/joaquinvanschoren/OpenML"> under development</a>.
	<h3 id="knime-start">Quick Start</h3>
	Stay tuned.

	</div>

  <div class="bs-docs-section">

          <div class="page-header">
            <h1 id="rapidminer">RapidMiner</h1>
          </div>
	<h3 id="rm-plugin">Download Plugin</h3>
	You can design OpenML workflows in RapidMiner to directly interact with OpenML. The RapidMiner plugin is currently <a href="https://github.com/joaquinvanschoren/OpenML"> under development</a>.
	<h3 id="rm-start">Quick Start</h3>
	Stay tuned.

	</div>
      </div> <!-- end col-md-9 -->
</div> <!-- end row -->
</div> <!-- end container -->
