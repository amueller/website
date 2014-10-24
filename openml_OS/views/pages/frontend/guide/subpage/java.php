   <div class="col-sm-12 col-md-3 searchbar"> 

      <div class="bs-sidebar affix">
        <ul class="nav bs-sidenav">
	    <li><a href="#java-download">Download</a></li>
	    <li><a href="#java-start">Quick Start</a></li>
	    <li><a href="#java-data-download">Data download</a></li>
	    <li><a href="#java-data-upload">Data upload</a></li>
	    <li><a href="#java-flow-download">Flow download</a></li>
	    <li><a href="#java-flow-mgm">Flow management</a></li>
	    <li><a href="#java-flow-upload">Flow upload</a></li>
	    <li><a href="#java-task-download">Task download</a></li>
	    <li><a href="#java-run-download">Run download</a></li>
	    <li><a href="#java-run-mgm">Run management</a></li>
	    <li><a href="#java-run-upload">Run upload</a></li>
	    <li><a href="#java-sql">Free SQL query</a></li>
	    <li><a href="#java-issues">Issues and requests</a></li>
	</ul>
      </div>
     </div> <!-- end col-2 -->
    
<div class="col-sm-12 col-md-9 openmlsectioninfo">
  <div class="bs-docs-section">
          <div class="page-header">
            <h1>Java API</h1>
          </div>
        The Java API allows you connect to OpenML from Java applications.
	<h2 id="java-download">Download</h2>
	<p>Stable releases of the Java API are available from <a href="http://search.maven.org/#search%7Cga%7C1%7Copenml">Maven central</a>. Or, you can check out the developer version from <a href="https://github.com/openml/java"> GitHub</a>. Include the jar file in your projects as usual, or <a href="http://maven.apache.org/guides/getting-started/maven-in-five-minutes.html">install via Maven</a>. You can also separately download <a href="downloads/apiconnector-dependencies.zip">all dependencies</a> and a <a href="downloads/apiconnector-fat.jar">fat jar</a> with all dependencies included.</p>

	<h3 id="java-start">Quick Start</h3>
	<p>Create an <code>OpenmlConnector</code> instance with your username and password. This will create a client with all OpenML functionalities.</p>
	<div class="codehighlight"><pre><code class="java">OpenmlConnector client = new OpenmlConnector("username", "password");</code></pre></div>
	<p>All functions are described in the <a href="docs" target="_blank">Java Docs</a>, and they mirror the functions from the Web API functions described below. For instance, the API function <a href="api#openml_data_description"><code>openml.data.description</code></a> has an equivalent Java function <code>openmlDataDescription(String data_id)</code>.</p>

	<h4>Downloading</h4>
	<p>To download data, flows, tasks, runs, etc. you need the unique <b>id</b> of that resource. The id is shown on each item's webpage and in the corresponding url. For instance, let's download <a href="d/1">Data set 1</a>. The following returns a DataSetDescription object that contains all information about that data set.</p>
	<div class="codehighlight"><pre><code class="java">DataSetDescription data = client.openmlDataDescription(1);</code></pre></div>
        <p>You can also <a href="search">search</a> for the items you need online, and click the <i class="fa fa-list-ol" style="margin-left:0px;"></i> icon to get all id's that match a search.</p>

	<h4>Uploading</h4>
	<p>To upload data, flows, runs, etc. you need to provide a description of the object. We provide wrapper classes to provide this information, e.g. <code>DataSetDescription</code>, as well as to capture the server response, e.g. <code>UploadDataSet</code>, which always includes the generated id for reference:</p>
	<div class="codehighlight"><pre><code class="java">DataSetDescription description = new DataSetDescription( "iris", "The famous iris dataset", "arff", "class");
UploadDataSet result = client.openmlDataUpload( description, datasetFile );
int data_id = result.getId();</code></pre></div>
	<p>More details are given in the corresponding functions below. Also see the <a href="docs" target="_blank">Java Docs</a> for all possible inputs and return values.</p>

	<h3 id="java-data-download">Data download</h3>
	<h5><code>openmlDataGet(int data_id)</code></h5>
	<p>Retrieves the description of a specified data set.</p>
	<div class="codehighlight"><pre><code class="java">DataSetDescription data = client.openmlDataGet(1);
String name = data.getName();
String version = data.getVersion();
String description = data.getDescription();
String url = data.getUrl();
</code></pre></div>

	<br><h5><code>openmlDataFeatures(int data_id)</code></h5>
	<p>Retrieves the description of the features of a specified data set.</p>
	<div class="codehighlight"><pre><code class="java">DataFeature reponse = client.openmlDataFeatures(1);
DataFeature.Feature[] features = reponse.getFeatures();
String name = features[0].getName();
String type = features[0].getDataType();
boolean	isTarget = features[0].getIs_target();
</code></pre></div>

	<br><h5><code>openmlDataQuality(int data_id)</code></h5>
	<p>Retrieves the description of the qualities (meta-features) of a specified data set.</p>
	<div class="codehighlight"><pre><code class="java">DataQuality response = client.openmlDataQuality(1);
DataQuality.Quality[] qualities = reponse.getQualities();
String name = qualities[0].getName();
String value = qualities[0].getValue();
</code></pre></div>

	<br><h5><code>openmlDataQuality(int data_id, int start, int end, int interval_size)</code></h5>
	<p>For data streams. Retrieves the description of the qualities (meta-features) of a specified portion of a data stream.</p>
	<div class="codehighlight"><pre><code class="java">DataQuality qualities = client.openmlDataQuality(1,0,10000,null);</code></pre></div>

	<br><h5><code>openmlData()</code></h5>
	<p>Retrieves an array of id's of all valid public data sets on OpenML.</p>
	<div class="codehighlight"><pre><code class="java">Data response = client.openmlData();
Integer[] ids = response.getDid();</code></pre></div>

	<br><h5><code>openmlDataQualityList()</code></h5>
	<p>Retrieves a list of all data qualities known to OpenML.</p>
	<div class="codehighlight"><pre><code class="java">DataQualityList response = client.openmlDataQualityList();
String[] qualities = response.getQualities();</code></pre></div>

	<h3 id="java-data-upload">Data upload</h3>
	<h5><code>openmlDataUpload(DataSetDescription description, File dataset)</code></h5>
	<p>Uploads a data set file to OpenML given a description. Throws an exception if the upload failed, see <a href="#openml_data_upload">openml.data.upload</a> for error codes.</p>
	<div class="codehighlight"><pre><code class="java">DataSetDescription dataset = new DataSetDescription( "iris", "The iris dataset", "arff", "class");
UploadDataSet data = client.openmlDataUpload( dataset, new File("data/path"));
int data_id = result.getId();
</code></pre></div>

	<br><h5><code>openmlDataUpload(DataSetDescription description)</code></h5>
	<p>Registers an existing dataset (hosted elsewhere). The description needs to include the url of the data set. Throws an exception if the upload failed, see <a href="#openml_data_upload">openml.data.upload</a> for error codes.</p>
	<div class="codehighlight"><pre><code class="java">DataSetDescription description = new DataSetDescription( "iris", "The iris dataset", "arff", "class");
description.setUrl("http://datarepository.org/mydataset");
UploadDataSet data = client.openmlDataUpload( description );
int data_id = result.getId();
</code></pre></div>

	<h3 id="java-flow-download">Flow download</h3>
	<h5><code>openmlImplementationGet(int flow_id)</code></h5>
	<p>Retrieves the description of the flow/implementation with the given id.</p>
	<div class="codehighlight"><pre><code class="java">Implementation flow = client.openmlImplementationGet(100);
String name = flow.getName();
String version = flow.getVersion();
String description = flow.getDescription();
String binary_url = flow.getBinary_url();
String source_url = flow.getSource_url();
Parameter[] parameters = flow.getParameter();
</code></pre></div>

	<h3 id="java-flow-mgm">Flow management</h3>
	<h5><code>openmlImplementationOwned()</code></h5>
	<p>Retrieves an array of id's of all flows/implementations owned by you.</p>
	<div class="codehighlight"><pre><code class="java">ImplementationOwned response = client.openmlImplementationOwned();
Integer[] ids = response.getIds();</code></pre></div>

	<br><h5><code>openmlImplementationExists(String name, String version)</code></h5>
	<p>Checks whether an implementation with the given name and version is already registered on OpenML.</p>
	<div class="codehighlight"><pre><code class="java">ImplementationExists check = client.openmlImplementationExists("weka.j48", "3.7.12");
boolean exists = check.exists();
int flow_id = check.getId();
</code></pre></div>

	<br><h5><code>openmlImplementationDelete(int id)</code></h5>
	<p>Removes the flow with the given id (if you are its owner).</p>
	<div class="codehighlight"><pre><code class="java">ImplementationDelete response = client.openmlImplementationDelete(100);</code></pre></div>

	<h3 id="java-flow-upload">Flow upload</h3>
	<h5><code>openmlImplementationUpload(Implementation description, File binary, File source)</code></h5>
	<p>Uploads implementation files (binary and/or source) to OpenML given a description.</p>
	<div class="codehighlight"><pre><code class="java">Implementation flow = new Implementation("weka.J48", "3.7.12", "description", "Java", "WEKA 3.7.12") 
UploadImplementation response = client.openmlImplementationUpload( flow, new File("code.jar"), new File("source.zip"));
int flow_id = response.getId();
</code></pre></div>

	<h3 id="java-task-download">Task download</h3>
	<h5><code>openmlTaskGet(int task_id)</code></h5>
	<p>Retrieves the description of the task with the given id.</p>
	<div class="codehighlight"><pre><code class="java">Task task = client.openmlTaskGet(1);
String task_type = task.getTask_type();
Input[] inputs = task.getInputs();
Output[] outputs = task.getOutputs();
</code></pre></div>

	<br><h5><code>openmlTaskEvaluations(int task_id)</code></h5>
	<p>Retrieves all evaluations for the task with the given id.</p>
	<div class="codehighlight"><pre><code class="java">TaskEvaluations response = client.openmlTaskEvaluations(1);
Evaluation[] evaluations = response.getEvaluation();
</code></pre></div>

	<br><h5><code>openmlTaskEvaluations(int task_id, int start, int end, int interval_size)</code></h5>
	<p>For data streams. Retrieves all evaluations for the task over the specified window of the stream.</p>
	<div class="codehighlight"><pre><code class="java">TaskEvaluations response = client.openmlTaskEvaluations(1);
Evaluation[] evaluations = response.getEvaluation();
</code></pre></div>

	<h3 id="java-run-download">Run download</h3>
	<h5><code>openmlRunGet(int run_id)</code></h5>
	<p>Retrieves the description of the run with the given id.</p>
	<div class="codehighlight"><pre><code class="java">Run run = client.openmlRunGet(1);
int task_id = run.getTask_id();
int flow_id = run.getImplementation_id();
Parameter_setting[] settings = run.getParameter_settings() 
EvaluationScore[] scores = run.getOutputEvaluation();
</code></pre></div>

	<h3 id="java-run-mgm">Run management</h3>
	<h5><code>openmlRunDelete(int run_id)</code></h5>
	<p>Deletes the run with the given id (if you are its owner).</p>
	<div class="codehighlight"><pre><code class="java">RunDelete response = client.openmlRunDelete(1);</code></pre></div>

	<h3 id="java-run-upload">Run upload</h3>
	<h5><code>openmlRunUpload(Run description, Map&lt;String,File&gt; output_files)</code></h5>
	<p>Uploads a run to OpenML, including a description and a set of output files depending on the task type.</p>
	<div class="codehighlight"><pre><code class="java">Run.Parameter_setting[] parameter_settings = new Run.Parameter_setting[1];
parameter_settings[0] = Run.Parameter_setting(null, "M", "2");
Run run = new Run("1", null, "100", "setup_string", parameter_settings);
Map<String,File> outputs = new HashMap&lt;String,File&gt;();
outputs.add("predictions",new File("predictions.arff"));
UploadRun response = client.openmlRunUpload( run, outputs);
int run_id = response.getRun_id();
</code></pre></div>


	<h3 id="java-sql">Free SQL Query</h3>
	<h5><code>openmlFreeQuery(String sql)</code></h5>
	<p>Executes the given SQL query and returns the result in JSON format.</p>
	<div class="codehighlight"><pre><code class="java">org.json.JSONObject json = client.openmlFreeQuery("SELECT name FROM dataset");</code></pre></div>

	<h3 id="java-issues">Issues</h3>
	Having questions? Did you run into an issue? Let us know via the <a href="https://github.com/openml/java/issues"> OpenML Java issue tracker</a>.

    </div> 
</div>

