<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-xs-12 col-lg-offset-1">
    <div class="col-xs-12 col-md-3 searchbar">

 <div class="bs-sidebar">
 <ul class="nav bs-sidenav">
      
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
    <div class="col-xs-12 col-md-9 openmlsectioninfo">

   <div class="bs-docs-section">
     <div class="page-header">
            <h1 id="weka">WEKA</h1>
          </div>
OpenML is integrated in the Weka (Waikato Environment for Knowledge Analysis) Experimenter and the Command Line Interface. It will
be included in WEKA (via the package manager) starting from the next version (3.7.12). Until then, you can download a standalone version below.
 
	  	  <h2 id="weka-plugin">Download Plugin</h2>
      		  The current integration is available as a standalone WEKA version which can be downloaded here:<br/>
		  <br/>
		  <a href="downloads/openmlweka.jar"><button class="btn btn-large btn-primary" type="button">Download Weka OpenML</button></a>
		  <br/><br/>
		  <img src="img/partners/Weka_logo.png" /><br/>

			<h2 id="weka-start-exp">Quick Start Experimenter (GUI)</h2>
			<div>
			<img src="img/openmlweka.png" alt="OpenML Weka Screenshot" class="img-rounded" style="width:100%">
			You can solve OpenML Tasks in the Weka Experimenter, and automatically upload your experiments to OpenML (or store them locally).
			<ol>
				<li>Download the standalone WEKA environment above. Open the jar file to open the GUI Chooser. </li>
				<li>Under 'Tools', select the 'OpenML Experimenter'. The WEKA Experimenter will open. Click New.
				<li>Under 'Results Destination', choose 'OpenML.org' to automatically upload results to OpenML. Click 'Login' to provide your username and password.</li>
				<li>The 'Experiment Type' should now be 'OpenML Task'. Several fields are greyed out (and ignored) because they are now controlled by OpenML tasks.</li>
				<li>In the 'Tasks' panel, click the 'Add New' button to add new tasks. Insert the task id's as comma-separated values (e.g., '1,2,3,4,5'). Use <a href="search">search</a> to search for interesting tasks and click the <i class="fa fa-list-ol"></i> icon to list the ID's. In the future this search will also be integrated in WEKA.</li>
				<li>Add algorithms in the "Algorithm" panel.</li>
				<li>Go to the "Run" tab, and click on the "Start" button. </li>
				<li>The experiment will be executed, and if 'OpenML.org' was selected, also sent to OpenML.org. When the experiment is finished, the results can be inspected in the "Analyse" tab. </li>
				<li>The runs will now appear on OpenML.org. You can follow their progress and check for errors under 'My runs'.</li>
			</ol> 
			</div>
      
      <h2 id="weka-start-cli">Quick Start CommandLine Interface</h2>
      The Command Line interface is useful for running experiments automatically on a server, without using a GUI.
      <ol>
        <li>Open a console and browse to the same directory as the Weka JAR. </li>
        <li>Create a config file called <code>openml.conf</code>. This config file should be in the same directory as the Weka jar, and contain the following lines:
	<pre>username = YOUR_USERNAME
password = YOUR_PASSWORD</pre>
</li>
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
	    <img src="img/openmlmoa.png" alt="OpenML Weka Screenshot" class="img-rounded" style="width:100%">
	    <ol>
		<li>Download the standalone MOA environment above.</li>
		<li>Create a config file called <code>openml.conf</code>. This config file should be in the same directory as the MOA jar, and contain the following lines:
	<pre>username = YOUR_USERNAME
password = YOUR_PASSWORD</pre></li>
		<li>Launch the JAR file by double clicking on it, or launch from command-line using the following command:
            	<pre>java -cp openmlmoa.beta.jar moa.gui.GUI</pre></li>
            	<li>Select the task <code>moa.tasks.openml.OpenmlDataStreamClassification</code> to evaluate a classifier on an OpenML task, and send the results to OpenML.</li>
		<li>Optionally, you can generate new streams using the Bayesian Network Generator: select the <code>moa.tasks.WriteStreamToArff</code> task, with <code>moa.streams.generators.BayesianNetworkGenerator</code>.</li>
	    </ol>
            
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
