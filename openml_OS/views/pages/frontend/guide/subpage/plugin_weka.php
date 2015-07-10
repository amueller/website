     <div class="page-header">
            <h1 id="weka">WEKA</h1>
          </div>
          <img src="img/partners/Weka_logo.png" /><br/>

OpenML is integrated in the Weka (Waikato Environment for Knowledge Analysis) Experimenter and the Command Line Interface.

	  	<h2 id="weka-plugin">Installation</h2>
      OpenML is available as a weka extension in the package manager starting from Weka 3.7.12:<br/>
      <ol>
				<li>Open the package manager (Under 'Tools')</li>
        <li>Select package <b>OpenmlWeka</b> and click install</li>
        <li>From the Tools menu, open the 'OpenML Experimenter'</li>
      </ol>

			<h2 id="weka-start-exp">Quick Start (Graphical Interface)</h2>
			<div>
			<img src="img/openmlweka.png" alt="OpenML Weka Screenshot" class="img-rounded" style="width:800px">
			<p>You can solve OpenML Tasks in the Weka Experimenter, and automatically upload your experiments to OpenML (or store them locally).</p>
			<ol>
        <li>From the Tools menu, open the 'OpenML Experimenter'. Click 'new'.</li>
				<li>Under 'Results Destination', choose 'OpenML.org' to automatically upload results to OpenML. Click 'Login' to provide your username and password.</li>
				<li>The 'Experiment Type' should now be 'OpenML Task'. Several fields are greyed out (and ignored) because they are now controlled by OpenML tasks.</li>
				<li>In the 'Tasks' panel, click the 'Add New' button to add new tasks. Insert the task id's as comma-separated values (e.g., '1,2,3,4,5'). Use <a href="search?type=task">search</a> to find interesting tasks and click the <i class="fa fa-list-ol"></i> icon to list the ID's. In the future this search will also be integrated in WEKA.</li>
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

		  Please note that this is a beta version, which is under active development. Please report any bugs that you may encounter to <a href="mailto:j.n.van.rijn@liacs.leidenuniv.nl">j.n.van.rijn@liacs.leidenuniv.nl</a>.
