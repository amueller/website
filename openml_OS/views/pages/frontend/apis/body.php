<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1">
    <div class="col-sm-12 col-md-3 searchbar">

      <div class="bs-sidebar affix">
        <ul class="nav bs-sidenav">
	  <li><a href="#java">Java API</a>
	  <ul class="nav">
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
	  </li>
	  
	  <li><a href="#r">R API</a>
	  <ul class="nav">
	    <li><a href="#r-download">Download</a></li>
	    <li><a href="#r-start">Quick Start</a></li>
	  </ul>
	  </li>
	  <li>
            <a href="#dev-tutorial">REST tutorial</a>
            <ul class="nav">
              <li><a href="#dev-getdata">Download a dataset</a></li>
              <li><a href="#dev-getimpl">Download an implementation</a></li>
              <li><a href="#dev-gettask">Download a task</a></li>
              <li><a href="#dev-setdata">Upload a dataset</a></li>
              <li><a href="#dev-setimpl">Upload an implementation</a></li>
              <li><a href="#dev-setrun">Upload a run</a></li>
            </ul>
          </li>
          <li>
            <a href="#dev-docs">REST services</a>
            <ul class="nav">
              <li><a href="#openml_authenticate">openml.authenticate</a></li>
              <li><a href="#openml_authenticate_check">openml.authenticate.check</a></li>
              <li><a href="#openml_data">openml.data</a></li>
              <li><a href="#openml_data_description">openml.data.description</a></li>
              <li><a href="#openml_data_upload">openml.data.upload</a></li>
              <li><a href="#openml_data_delete">openml.data.delete</a></li>
              <li><a href="#openml_data_licences">openml.data.licences</a></li>
              <li><a href="#openml_data_features">openml.data.features</a></li>
              <li><a href="#openml_data_qualities">openml.data.qualities</a></li>
              <li><a href="#openml_data_qualities_list">openml.data.qualities.list</a></li>

              <li><a href="#openml_task_search">openml.task.search</a></li>
              <li><a href="#openml_task_evaluations">openml.task.evaluations</a></li>
              <li><a href="#openml_task_types">openml.task.types</a></li>
              <li><a href="#openml_task_types_search">openml.task.types.search</a></li>

              <li><a href="#openml_estimationprocedure_get">openml.estimationprocedure.get</a></li>

              <li><a href="#openml_implementation_get">openml.implementation.get</a></li>
              <li><a href="#openml_implementation_exists">openml.implementation.exists</a></li>
              <li><a href="#openml_implementation_upload">openml.implementation.upload</a></li>
              <li><a href="#openml_implementation_owned">openml.implementation.owned</a></li>
              <li><a href="#openml_implementation_delete">openml.implementation.delete</a></li>
              <li><a href="#openml_implementation_licences">openml.implementation.licences</a></li>

              <li><a href="#openml_evaluation_measures">openml.evaluation.measures</a></li>

              <li><a href="#openml_run_get">openml.run.get</a></li>
              <li><a href="#openml_run_upload">openml.run.upload</a></li>
              <li><a href="#openml_run_delete">openml.run.delete</a></li>

              <li><a href="#openml_job_get">openml.job.get</a></li>

              <li><a href="#openml_setup_delete">openml.setup.delete</a></li>
            </ul>
          </li>
          <li>
            <a href="#json-docs">JSON endpoints</a>
	    <ul class="nav">
              <li><a href="#json_data">Get data</a></li>
              <li><a href="#json_flow">Get flow</a></li>
              <li><a href="#json_task">Get task</a></li>
              <li><a href="#json_run">Get run</a></li>
              <li><a href="#json_sql">Free SQL query</a></li>
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
	<p>Stable releases of the Java API are available from <a href="http://search.maven.org/#search%7Cga%7C1%7Copenml">Maven central</a>. Or, you can check out the developer version from <a href="https://github.com/openml/java"> GitHub</a>. Include the jar file in your projects as usual, or <a href="http://maven.apache.org/guides/getting-started/maven-in-five-minutes.html">install via Maven</a>. You can also separately download <a href="downloads/apiconnector-dependencies.zip">all dependencies</a> and a <a href="downloads/apiconnector-fat.jar">fat jar</a> with all dependencies included.</p>

	<h2 id="java-start">Quick Start</h2>
	<p>Create an <code>OpenmlConnector</code> instance with your username and password. This will create a client with all OpenML functionalities.</p>
	<pre>OpenmlConnector client = new OpenmlConnector(username, password);</pre>
	<p>All functions are described in the <a href="docs" target="_blank">Java Docs</a>, and they mirror the functions from the Web API functions described below. For instance, the API function <a href="api#openml_data_description"><code>openml.data.description</code></a> has an equivalent Java function <code>openmlDataDescription(String data_id)</code>.</p>

	<h4>Downloading things</h4>
	<p>To download data, flows, tasks, runs, etc. you need the unique <b>id</b> of that resource. The id is shown on each item's webpage and in the corresponding url. For instance, let's download <a href="d/1">Data set 1</a>. The following returns a DataSetDescription object that contains all information about that data set.</p>
	<pre>DataSetDescription data = client.openmlDataDescription(1);</pre>
        <p>You can also <a href="search">search</a> for the items you need online, and click the <i class="fa fa-list-ol" style="margin-left:0px;"></i> icon to get all id's that match a search.</p>

	<h4>Uploading things</h4>
	<p>To upload data, flows, runs, etc. you need to provide a description of the object. We provide wrapper classes to provide this information, e.g. <code>DataSetDescription</code>, as well as to capture the server response, e.g. <code>UploadDataSet</code>, which always includes the generated id for reference:</p>
	<pre>
DataSetDescription description = new DataSetDescription( "iris", "The famous iris dataset", "arff", "class");
UploadDataSet result = client.openmlDataUpload( description, datasetFile );
int data_id = result.getId();</pre>
	<p>More details are given in the corresponding functions below. Also see the <a href="docs" target="_blank">Java Docs</a> for all possible inputs and return values.</p>

	<h2 id="java-data-download">Data download</h2>
	<br><code>openmlDataGet(int data_id)</code><br>
	<p>Retrieves the description of a specified data set.</p>
	<pre>DataSetDescription data = client.openmlDataGet(1);
String name = data.getName();
String version = data.getVersion();
String description = data.getDescription();
String url = data.getUrl();
</pre>

	<br><code>openmlDataFeatures(int data_id)</code><br>
	<p>Retrieves the description of the features of a specified data set.</p>
	<pre>DataFeature reponse = client.openmlDataFeatures(1);
DataFeature.Feature[] features = reponse.getFeatures();
String name = features[0].getName();
String type = features[0].getDataType();
boolean	isTarget = features[0].getIs_target();
</pre>

	<br><code>openmlDataQuality(int data_id)</code><br>
	<p>Retrieves the description of the qualities (meta-features) of a specified data set.</p>
	<pre>DataQuality response = client.openmlDataQuality(1);
DataQuality.Quality[] qualities = reponse.getQualities();
String name = qualities[0].getName();
String value = qualities[0].getValue();
</pre>

	<br><code>openmlDataQuality(int data_id, int interval_start, int interval_end, int interval_size)</code><br>
	<p>For data streams. Retrieves the description of the qualities (meta-features) of a specified portion of a data stream.</p>
	<pre>DataQuality qualities = client.openmlDataQuality(1,0,10000,null);</pre>

	<br><code>openmlData()</code><br>
	<p>Retrieves an array of id's of all valid public data sets on OpenML.</p>
	<pre>Data response = client.openmlData();
Integer[] ids = response.getDid();</pre>

	<br><code>openmlDataQualityList()</code><br>
	<p>Retrieves a list of all data qualities known to OpenML.</p>
	<pre>DataQualityList response = client.openmlDataQualityList();
String[] qualities = response.getQualities();</pre>

	<h2 id="java-data-upload">Data upload</h2>
	<br><code>openmlDataUpload(DataSetDescription description, File dataset)</code><br>
	<p>Uploads a data set file to OpenML given a description. Throws an exception if the upload failed, see <a href="#openml_data_upload">openml.data.upload</a> for error codes.</p>
	<pre>
DataSetDescription dataset = new DataSetDescription( "iris", "The iris dataset", "arff", "class");
UploadDataSet data = client.openmlDataUpload( dataset, new File("data/path"));
int data_id = result.getId();
</pre>

	<br><code>openmlDataUpload(DataSetDescription description)</code><br>
	<p>Registers an existing dataset (hosted elsewhere). The description needs to include the url of the data set. Throws an exception if the upload failed, see <a href="#openml_data_upload">openml.data.upload</a> for error codes.</p>
	<pre>
DataSetDescription description = new DataSetDescription( "iris", "The iris dataset", "arff", "class");
description.setUrl("http://datarepository.org/mydataset");
UploadDataSet data = client.openmlDataUpload( description );
int data_id = result.getId();
</pre>

	<h2 id="java-flow-download">Flow download</h2>
	<br><code>openmlImplementationGet(int flow_id)</code><br>
	<p>Retrieves the description of the flow/implementation with the given id.</p>
	<pre>Implementation flow = client.openmlImplementationGet(100);
String name = flow.getName();
String version = flow.getVersion();
String description = flow.getDescription();
String binary_url = flow.getBinary_url();
String source_url = flow.getSource_url();
Parameter[] parameters = flow.getParameter();
</pre>

	<h2 id="java-flow-mgm">Flow management</h2>
	<br><code>openmlImplementationOwned()</code><br>
	<p>Retrieves an array of id's of all flows/implementations owned by you.</p>
	<pre>ImplementationOwned response = client.openmlImplementationOwned();
Integer[] ids = response.getIds();</pre>

	<br><code>openmlImplementationExists(String name, String version)</code><br>
	<p>Checks whether an implementation with the given name and version is already registered on OpenML.</p>
	<pre>ImplementationExists check = client.openmlImplementationExists("weka.j48", "3.7.12");
boolean exists = check.exists();
int flow_id = check.getId();
</pre>

	<br><code>openmlImplementationDelete(int id)</code><br>
	<p>Removes the flow with the given id (if you are its owner).</p>
	<pre>ImplementationDelete response = client.openmlImplementationDelete(100);</pre>

	<h2 id="java-flow-upload">Flow upload</h2>
	<br><code>openmlImplementationUpload(Implementation description, File binary, File source)</code><br>
	<p>Uploads implementation files (binary and/or source) to OpenML given a description.</p>
	<pre>Implementation flow = new Implementation("weka.J48", "3.7.12", "description", "Java", "WEKA 3.7.12") 
UploadImplementation response = client.openmlImplementationUpload( flow, new File("code.jar"), new File("source.zip"));
int flow_id = response.getId();
</pre>

	<h2 id="java-task-download">Task download</h2>
	<br><code>openmlTaskGet(int task_id)</code><br>
	<p>Retrieves the description of the task with the given id.</p>
	<pre>Task task = client.openmlTaskGet(1);
String task_type = task.getTask_type();
Input[] inputs = task.getInputs();
Output[] outputs = task.getOutputs();
</pre>

	<br><code>openmlTaskEvaluations(int task_id)</code><br>
	<p>Retrieves all evaluations for the task with the given id.</p>
	<pre>TaskEvaluations response = client.openmlTaskEvaluations(1);
Evaluation[] evaluations = response.getEvaluation();
</pre>

	<br><code>openmlTaskEvaluations(int task_id, int start, int end, int interval_size)</code><br>
	<p>For data streams. Retrieves all evaluations for the task over the specified window of the stream.</p>
	<pre>TaskEvaluations response = client.openmlTaskEvaluations(1);
Evaluation[] evaluations = response.getEvaluation();
</pre>

	<h2 id="java-run-download">Run download</h2>
	<br><code>openmlRunGet(int run_id)</code><br>
	<p>Retrieves the description of the run with the given id.</p>
	<pre>Run run = client.openmlRunGet(1);
int task_id = run.getTask_id();
int flow_id = run.getImplementation_id();
Parameter_setting[] settings = run.getParameter_settings() 
EvaluationScore[] scores = run.getOutputEvaluation();
</pre>

	<h2 id="java-run-mgm">Run management</h2>
	<br><code>openmlRunDelete(int run_id)</code><br>
	<p>Deletes the run with the given id (if you are its owner).</p>
	<pre>RunDelete response = client.openmlRunDelete(1);</pre>

	<h2 id="java-run-upload">Run upload</h2>
	<br><code>openmlRunUpload(Run description, Map&lt;String,File&gt; output_files)</code><br>
	<p>Uploads a run to OpenML, including a description and a set of output files depending on the task type.</p>
	<pre>Run.Parameter_setting[] parameter_settings = new Run.Parameter_setting[1];
parameter_settings[0] = Run.Parameter_setting(null, "M", "2");
Run run = new Run("1", null, "100", "setup_string", parameter_settings);
Map<String,File> outputs = new HashMap&lt;String,File&gt;();
outputs.add("predictions",new File("predictions.arff"));
UploadRun response = client.openmlRunUpload( run, outputs);
int run_id = response.getRun_id();
</pre>


	<h2 id="java-sql">Free SQL Query</h2>
	<br><code>openmlFreeQuery(String sql)</code><br>
	<p>Executes the given SQL query and returns the result in JSON format.</p>
	<pre>org.json.JSONObject json = client.openmlFreeQuery("SELECT name FROM dataset");</pre>

	<h2 id="java-issues">Issues</h2>
	Having questions? Did you run into an issue? Let us know via the <a href="https://github.com/openml/java/issues"> OpenML Java issue tracker</a>.
	</div>


  <div class="bs-docs-section">
          <div class="page-header">
            <h1 id="r">R API</h1>
          </div>
	The R package openML allows you to connect to the OpenML server from R scrips. Users can download and upload files, run their implementations on specific tasks, get predictions in the correct form, make SQL queries, etc. directly via R commands.
	<h2 id="r-download">Download</h2>
	The openML package can be downloaded from <a href="https://github.com/openml/r"> GitHub</a>.
	<h2 id="r-start">Quick Start</h2>
	In <a href="https://github.com/openml/r/blob/master/doc/knitted/1-Introduction.md" target="_blank">this tutorial</a>, we will show you the most important functions of this package and give you examples of standard use cases.
	<h2 id="java-issues">Issues</h2>
	Having questions? Did you run into an issue? Let us know via the <a href="https://github.com/openml/r/issues"> OpenML R issue tracker</a>.
	</div>

 
      <div class="bs-docs-section">
        <div class="page-header">
          <h1 id="dev-tutorial">REST tutorial</h1>
        </div>
       <p>OpenML offers a RESTful Web API for uploading and downloading machine learning resources. Below is a list of common use cases.
       <div class="bs-callout bs-callout-info" style="padding-top:20px;padding-bottom:20px">
          <h4>Using REST services</h4>
          <p>REST services can be called using simple HTTP GET or POST actions.</p>
          <p>The REST Endpoint URL is 
          <div class="codehighlight">
            <pre class="pre-scrollable"><code class="html">http://www.openml.org/api/</code></pre>
          </div>
          </p>
          <p>For instance, to request the <code>openml.data.description</code> service, invoke like this (e.g., in your browser):
          <div class="codehighlight">
            <pre class="pre-scrollable"><code class="html">http://www.openml.org/api/?f=openml.data.description&data_id=1</code></pre>
          </div>
          </p>
	  <p>From your command-line, you can use curl:
	  <div class="codehighlight">
	   <pre class="pre-scrollable"><code class="html">curl -XGET 'http://www.openml.org/api/?f=openml.data.description&data_id=1'</code></pre>
	  </div>
	  </p>
          <p>Responses are always in XML format, also when an error is returned. Error messages will look like this:
          <div class="codehighlight">
            <pre class="pre-scrollable"><code class="html">&lt;oml:error xmlns:oml="http://openml.org/error"&gt;
  &lt;oml:code&gt;100&lt;/oml:code&gt;
  &lt;oml:message&gt;Please invoke legal function&lt;/oml:message&gt;
  &lt;oml:additional_information&gt;Additional information, not always available. &lt;/oml:additional_information&gt;
&lt;/oml:error&gt;
</code></pre>
          </div>
          <p>All services and the corresponding error messages are listed below.</p>
        </div>

        <h2 id="dev-getdata">Download a dataset</h2>
        <img src="img/api_get_dataset.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User asks for a dataset using the <a href="api#openml_data_description">openml.data.description</a> service and a <code>dataset id</code>. The <code>dataset id</code> is typically part of a task, or returned when searching for datasets.</li>
          <li>OpenML returns a description of the dataset as an XML file. <a href="http://www.openml.org/api/?f=openml.data.description&amp;data_id=1" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>The dataset description contains the URL where the dataset can be downloaded. The user calls that URL to download the dataset.</li>
          <li>The dataset is returned by the server hosting the dataset. This can be OpenML, but also any other data repository. <a href="http://expdb.cs.kuleuven.be/expdb/data/uci/nominal/anneal.arff" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="api#openml_data_description">openml.data.description</a></li>
        </ul>
        <h3 id="dev-getimpl">Download an implementation</h3>
        <img src="img/api_get_implementation.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User asks for an implementation using the <a href="api#openml_implementation_get">openml.implementation.get</a> service and a <code>implementation id</code>. The <code>implementation id</code> is typically returned when searching for implementations.</li>
          <li>OpenML returns a description of the implementation as an XML file. <a href="http://www.openml.org/api/?f=openml.implementation.get&amp;implementation_id=65" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>The implementation description contains the URL where the implementation can be downloaded, either as source, binary or both, as well as additional information on history, dependencies and licence. The user calls the right URL to download it.</li>
          <li>The implementation is returned by the server hosting it. This can be OpenML, but also any other code repository. <a href="http://sourceforge.net/projects/weka/files/weka-3-4/3.4.8/weka-3-4-8a.zip/download" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="api#openml_implementation_get">openml.implementation.get</a></li>
        </ul>
        <h3 id="dev-gettask">Download a task</h3>
        <img src="img/api_get_task.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User asks for a task using the <a href="api#openml_tasks_search">openml.tasks.search</a> service and a <code>task id</code>. The <code>task id</code> is typically returned when searching for tasks.</li>
          <li>OpenML returns a description of the task as an XML file. <a href="http://www.openml.org/api/?f=openml.tasks.search&amp;task_id=1" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>The task description contains the <code>dataset id</code>(s) of the datasets involved in this task. The user asks for the dataset using the <a href="api#openml_data_description">openml.data.description</a> service and the <code>dataset id</code>.</li>
          <li>OpenML returns a description of the dataset as an XML file. <a href="http://www.openml.org/api/?f=openml.data.description&amp;data_id=61" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>The dataset description contains the URL where the dataset can be downloaded. The user calls that URL to download the dataset.</li>
          <li>The dataset is returned by the server hosting it. This can be OpenML, but also any other data repository. <a href="http://openml.liacs.nl/files/download/61/dataset_61_iris.arff" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>(Optional) The task description may also contain links to other resources, such as the train-test splits to be used in cross-validation. The user calls that URL to download the train-test splits.</li>
          <li>(Optional) The train-test splits are returned by OpenML. <a href="http://www.openml.org/api_splits/get/1/Task_1_splits.arff" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="api#openml_tasks_search">openml.tasks.search</a></li>
          <li><a href="api#openml_data_description">openml.data.description</a></li>
        </ul>
        <h3 id="dev-setdata">Upload a dataset</h3>
        <img src="img/api_upload_data.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User authenticates herself by calling <a href="api#openml_authenticate">openml.authenticate</a> with her <code>username</code> and (hashed) <code>password</code>. OpenML will return an authentication <code>session token</code>.</li>
          <li>The user uploads the <code>dataset</code> together a <code>dataset description</code> and her <code>session token</code> to <a href="api#openml_data_upload">openml.data.upload</a>. The dataset description is an XML file that contains at least the dataset name and a textual description. For now, the only truly supported dataset format is ARFF.</li>
          <li>OpenML stores the uploaded dataset and returns the registered <code>dataset id</code>.</li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="api#openml_authenticate">openml.authenticate</a></li>
          <li><a href="api#openml_data_upload">openml.data.upload</a></li>
        </ul>
        <h3 id="dev-setimpl">Upload an implementation</h3>
        <img src="img/api_upload_implementation.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User authenticates herself by calling <a href="api#openml_authenticate">openml.authenticate</a> with her <code>username</code> and (hashed) <code>password</code>. OpenML will return an authentication <code>session token</code>.</li>
          <li>The user uploads her <code>session token</code>, <code>implementation description</code>, the <code>implementation binary</code> and/or the <code>implementation source</code> to <a href="api#openml_implementation_upload">openml.implementation.upload</a>. The implementation description is an XML file that contains at least the implementation name and a textual description. The implementation binary and source will typically be a ZIP file. An implementation can be a single algorithm or a composed workflow.</li>
          <li>OpenML stores the uploaded implementation and returns the registered <code>implementation id</code>.</li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="api#openml_authenticate">openml.authenticate</a></li>
          <li><a href="api#openml_implementation_upload">openml.implementation.upload</a></li>
        </ul>
        <h3 id="dev-setrun">Upload a run</h3>
        <img src="img/api_upload_run.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User authenticates herself by calling <a href="api#openml_authenticate">openml.authenticate</a> with her <code>username</code> and (hashed) <code>password</code>. OpenML will return an authentication <code>session token</code>.</li>
          <li>The user uploads a <code>run description</code> and any <code>run result</code> files together with her <code>session token</code> to <a href="api#openml_run_upload">openml.run.upload</a>. The run description is an XML file that contains the <code>task id</code> of the task it addresses and (optionally) a list of parameter settings if these differ from the default settings in the used implementation. The run result files contain the results of the run as detailed in the corresponding task description.</li>
          <li>OpenML stores the uploaded run and its results and returns a task-specific response. This can include, for instance, evaluations computed by the server based on uploaded predictions.</li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="api#openml_authenticate">openml.authenticate</a></li>
          <li><a href="api#openml_run_upload">openml.run.upload</a></li>
        </ul>

      </div>
      <div class="bs-docs-section">
        <div class="page-header">
          <h1 id="dev-docs">REST services</h1>
        </div>
        <p class="lead">Details of all OpenML services, with their expected arguments, file formats, responses and error codes.</p>
               
<!-- [START] Api function description: openml.authenticate --> 


<h3 id=openml_authenticate>openml.authenticate</h3>
<p><i>returns a session_hash, which can be used for writing to the API</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>POST username</code> (Required)</dt><dd>The username to be authenticated with</dd></dl>
<dl><dt><code>POST password</code> (Required)</dt><dd>An md5 hash of the password, corresponding to the username</dd></dl>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:authenticate xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:session_hash&gt;G9MPPN114ZCZNWW2VN3JE9VF1FMV8Y5FXHUDUL4P&lt;/oml:session_hash&gt;
  &lt;oml:valid_until&gt;2014-08-13 20:01:29&lt;/oml:valid_until&gt;
  &lt;oml:timezone&gt;Europe/Berlin&lt;/oml:timezone&gt;
&lt;/oml:authenticate&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>250: Please provide username</dt><dd>Please provide the username as a POST variable</dd></dl>
<dl><dt>251: Please provide password</dt><dd>Please provide the password (hashed as a MD5) as a POST variable</dd></dl>
<dl><dt>252: Authentication failed</dt><dd>The username and password did not match any record in the database. Please note that the password should be hashed using md5</dd></dl>
</div>

<!-- [END] Api function description: openml.authenticate -->  



<!-- [START] Api function description: openml.authenticate.check --> 


<h3 id=openml_authenticate_check>openml.authenticate.check</h3>
<p><i>checks the validity of the session hash</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>POST username</code> (Required)</dt><dd>The username to be authenticated with</dd></dl>
<dl><dt><code>POST session_hash</code> (Required)</dt><dd>The session hash to be checked</dd></dl>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:error xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:code&gt;292&lt;/oml:code&gt;
  &lt;oml:message&gt;Hash does not exist&lt;/oml:message&gt;
&lt;/oml:error&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>290: Username not provided</dt><dd>Please provide username</dd></dl>
<dl><dt>291: Hash not provided</dt><dd>Please provide hash to be checked</dd></dl>
<dl><dt>292: Hash does not exist</dt><dd>Hash does not exist, or is not owned by this user</dd></dl>
</div>

<!-- [END] Api function description: openml.authenticate.check -->  




<!-- [START] Api function description: openml.data --> 


<h3 id=openml_data>openml.data</h3>
<p><i>Returns a list with all dataset ids in OpenML that are ready to use</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
None
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:data xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:did&gt;1&lt;/oml:did&gt;
  &lt;oml:did&gt;2&lt;/oml:did&gt;
  &lt;oml:did&gt;3&lt;/oml:did&gt;
  &lt;oml:did&gt;4&lt;/oml:did&gt;
  &lt;oml:did&gt;5&lt;/oml:did&gt;
  &lt;oml:did&gt;6&lt;/oml:did&gt;
  &lt;oml:did&gt;7&lt;/oml:did&gt;
  &lt;oml:did&gt;8&lt;/oml:did&gt;
  &lt;oml:did&gt;9&lt;/oml:did&gt;
  &lt;oml:did&gt;10&lt;/oml:did&gt;
&lt;/oml:data&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>370: No datasets available</dt><dd>There are no valid datasets in the system. Please upload!</dd></dl>
</div>

<!-- [END] Api function description: openml.data -->  



<!-- [START] Api function description: openml.data.description --> 


<h3 id=openml_data_description>openml.data.description</h3>
<p><i>returns dataset descriptions in XML</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET data_id</code> (Required)</dt><dd>The dataset id</dd></dl>
</div>
<h5>Schema's</h5>
<div class="bs-callout bs-callout-info">
<h5>openml.data.description</h5>

This XSD schema is applicable for both uploading and downloading data. <br/>
<a type="button" class="btn btn-primary" href="https://github.com/openml/website/blob/master/openml_OS/views/pages/rest_api/xsd/openml.data.upload.xsd">XSD Schema</a>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:data_set_description xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:id&gt;1&lt;/oml:id&gt;
  &lt;oml:name&gt;anneal&lt;/oml:name&gt;
  &lt;oml:version&gt;1&lt;/oml:version&gt;
  &lt;oml:description&gt;This is a preprocessed version of the &lt;a href="d/2"&gt;anneal.ORIG&lt;/a&gt; dataset. All missing values are threated as a nominal value with label '?'. (Quotes for clarity). The original version of this dataset can be found with the name anneal.ORIG.

1. Title of Database: Annealing Data
 
 2. Source Information: donated by David Sterling and Wray Buntine.
 
 3. Past Usage: unknown
 
 4. Relevant Information:
    -- Explanation: I suspect this was left by Ross Quinlan in 1987 at the
       4th Machine Learning Workshop.  I'd have to check with Jeff Schlimmer
       to double check this.
 
 5. Number of Instances: 898
 
 6. Number of Attributes: 38
    -- 6 continuously-valued
    -- 3 integer-valued
    -- 29 nominal-valued
 
 7. Attribute Information:
     1. family:          --,GB,GK,GS,TN,ZA,ZF,ZH,ZM,ZS
     2. product-type:    C, H, G
     3. steel:           -,R,A,U,K,M,S,W,V
     4. carbon:          continuous
     5. hardness:        continuous
     6. temper_rolling:  -,T
     7. condition:       -,S,A,X
     8. formability:     -,1,2,3,4,5
     9. strength:        continuous
    10. non-ageing:      -,N
    11. surface-finish:  P,M,-
    12. surface-quality: -,D,E,F,G
    13. enamelability:   -,1,2,3,4,5
    14. bc:              Y,-
    15. bf:              Y,-
    16. bt:              Y,-
    17. bw/me:           B,M,-
    18. bl:              Y,-
    19. m:               Y,-
    20. chrom:           C,-
    21. phos:            P,-
    22. cbond:           Y,-
    23. marvi:           Y,-
    24. exptl:           Y,-
    25. ferro:           Y,-
    26. corr:            Y,-
    27. blue/bright/varn/clean:          B,R,V,C,-
    28. lustre:          Y,-
    29. jurofm:          Y,-
    30. s:               Y,-
    31. p:               Y,-
    32. shape:           COIL, SHEET
    33. thick:           continuous
    34. width:           continuous
    35. len:             continuous
    36. oil:             -,Y,N
    37. bore:            0000,0500,0600,0760
    38. packing: -,1,2,3
    classes:        1,2,3,4,5,U
  
    -- The '-' values are actually 'not_applicable' values rather than
       'missing_values' (and so can be treated as legal discrete
       values rather than as showing the absence of a discrete value).
 
 8. Missing Attribute Values: Signified with "?"
    Attribute:  Number of instances missing its value:
    1           0
    2           0
    3           70
    4           0
    5           0
    6           675
    7           271
    8           283
    9           0
   10           703
   11           790
   12           217
   13           785
   14           797
   15           680
   16           736
   17           609
   18           662
   19           798
   20           775
   21           791
   22           730
   23           798
   24           796
   25           772
   26           798
   27           793
   28           753
   29           798
   30           798
   31           798
   32           0
   33           0
   34           0
   35           0
   36           740
   37           0
   38           789
   39           0
 
 9. Distribution of Classes
      Class Name:   Number of Instances:
      1               8
      2              88
      3             608
      4               0
      5              60
      U              34
                    ---
                    798&lt;/oml:description&gt;
  &lt;oml:format&gt;ARFF&lt;/oml:format&gt;
  &lt;oml:upload_date&gt;2014-04-06 23:19:20&lt;/oml:upload_date&gt;
  &lt;oml:licence&gt;public domain&lt;/oml:licence&gt;
  &lt;oml:url&gt;http://openml.liacs.nl/files/download/1/dataset_1_anneal.arff&lt;/oml:url&gt;
  &lt;oml:md5_checksum&gt;08dc9d6bf8e5196de0d56bfc89631931&lt;/oml:md5_checksum&gt;
&lt;/oml:data_set_description&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>110: Please provide data_id</dt><dd>Please provide data_id</dd></dl>
<dl><dt>111: Unknown dataset</dt><dd>Data set description with data_id was not found in the database</dd></dl>
</div>

<!-- [END] Api function description: openml.data.description -->  



<!-- [START] Api function description: openml.data.upload --> 


<h3 id=openml_data_upload>openml.data.upload</h3>
<p><i>Uploads a dataset</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>POST description</code> (Required)</dt><dd>An XML file containing the data set description</dd></dl>
<dl><dt><code>POST dataset</code> (Required)</dt><dd>The dataset file to be stored on the server</dd></dl>
<dl><dt><code>POST session_hash</code> (Required)</dt><dd>The session hash, provided by the server on authentication (1 hour valid)</dd></dl>
</div>
<h5>Schema's</h5>
<div class="bs-callout bs-callout-info">
<h5>openml.data.upload</h5>

This XSD schema is applicable for both uploading and downloading data, hence some fields are not used.<br/>
<a type="button" class="btn btn-primary" href="https://github.com/openml/website/blob/master/openml_OS/views/pages/rest_api/xsd/openml.data.upload.xsd">XSD Schema</a>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>130: Problem with file uploading</dt><dd>There was a problem with the file upload</dd></dl>
<dl><dt>131: Problem validating uploaded description file</dt><dd>The XML description format does not meet the standards</dd></dl>
<dl><dt>132: Failed to move the files</dt><dd>Internal server error, please contact api administrators</dd></dl>
<dl><dt>133: Failed to make checksum of datafile</dt><dd>Internal server error, please contact api administrators</dd></dl>
<dl><dt>134: Failed to insert record in database</dt><dd>Internal server error, please contact api administrators</dd></dl>
<dl><dt>135: Please provide description xml</dt><dd>Please provide description xml</dd></dl>
<dl><dt>136: Error slot open</dt><dd>Error slot open, will be filled by not yet defined error</dd></dl>
<dl><dt>137: Please provide session_hash</dt><dd>In order to share content, please authenticate (openml.authenticate) and provide session_hash</dd></dl>
<dl><dt>138: Authentication failed</dt><dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd></dl>
<dl><dt>139: Combination name / version already exists</dt><dd>The combination of name and version of this dataset already exists. Leave version out for auto increment</dd></dl>
<dl><dt>140: Both dataset file and dataset url provided. Please provide only one</dt><dd>The system is confused since both a dataset file (post) and a dataset url (xml) are provided. Please remove one</dd></dl>
<dl><dt>141: Neither dataset file or dataset url are provided</dt><dd>Please provide either a dataset file as POST variable, xor a dataset url in the description XML</dd></dl>
<dl><dt>142: Error in processing arff file. Can be a syntax error, or the specified target feature does not exists</dt><dd>For now, we only check on arff files. If a dataset is claimed to be in such a format, and it can not be parsed, this error is returned.</dd></dl>
<dl><dt>143: Suggested target feature not legal</dt><dd>It is possible to suggest a default target feature (for predictive tasks). However, it should be provided in the data. </dd></dl>
</div>

<!-- [END] Api function description: openml.data.upload -->  



<!-- [START] Api function description: openml.data.delete --> 


<h3 id=openml_data_delete>openml.data.delete</h3>
<p><i>Deletes a dataset. Can only be done if the dataset is not used in tasks</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>POST session_hash</code> (Required)</dt><dd>The session hash to authenticate with</dd></dl>
<dl><dt><code>POST data_id</code> (Required)</dt><dd>The dataset to be deleted</dd></dl>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>350: Please provide session_hash</dt><dd>In order to remove your content, please authenticate (openml.authenticate) and provide session_hash</dd></dl>
<dl><dt>351: Authentication failed</dt><dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd></dl>
<dl><dt>352: Dataset does not exists</dt><dd>The data id could not be linked to an existing dataset.</dd></dl>
<dl><dt>353: Dataset is not owned by you</dt><dd>The dataset was owned by another user. Hence you cannot delete it.</dd></dl>
<dl><dt>354: Dataset is in use by other content. Can not be deleted</dt><dd>The data is used in runs. Delete this other content before deleting this dataset. </dd></dl>
<dl><dt>355: Deleting dataset failed.</dt><dd>Deleting the dataset failed. Please contact support team.</dd></dl>
</div>

<!-- [END] Api function description: openml.data.delete -->  



<!-- [START] Api function description: openml.data.licences --> 


<h3 id=openml_data_licences>openml.data.licences</h3>
<p><i>Gives a list of all data licences used in OpenML</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
None
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:data_licences xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:licences&gt;
    &lt;oml:licence&gt;public domain&lt;/oml:licence&gt;
    &lt;oml:licence&gt;UCI&lt;/oml:licence&gt;
  &lt;/oml:licences&gt;
&lt;/oml:data_licences&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
None
</div>

<!-- [END] Api function description: openml.data.licences -->  



<!-- [START] Api function description: openml.data.features --> 


<h3 id=openml_data_features>openml.data.features</h3>
<p><i>Returns the features (attributes) of a given dataset</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET data_id</code> (Required)</dt><dd>The dataset id</dd></dl>
</div>
<h5>Schema's</h5>
<div class="bs-callout bs-callout-info">
<h5>openml.data.features</h5>

-<br/>
<a type="button" class="btn btn-primary" href="https://github.com/openml/website/blob/master/openml_OS/views/pages/rest_api/xsd/openml.data.features.xsd">XSD Schema</a>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:data_features xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;family&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;0&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;product-type&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;1&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;steel&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;2&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;carbon&lt;/oml:name&gt;
    &lt;oml:data_type&gt;numeric&lt;/oml:data_type&gt;
    &lt;oml:index&gt;3&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;hardness&lt;/oml:name&gt;
    &lt;oml:data_type&gt;numeric&lt;/oml:data_type&gt;
    &lt;oml:index&gt;4&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;temper_rolling&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;5&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;condition&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;6&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;formability&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;7&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;strength&lt;/oml:name&gt;
    &lt;oml:data_type&gt;numeric&lt;/oml:data_type&gt;
    &lt;oml:index&gt;8&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;non-ageing&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;9&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;surface-finish&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;10&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;surface-quality&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;11&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;enamelability&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;12&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;bc&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;13&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;bf&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;14&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;bt&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;15&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;bw%2Fme&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;16&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;bl&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;17&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;m&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;18&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;chrom&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;19&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;phos&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;20&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;cbond&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;21&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;marvi&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;22&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;exptl&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;23&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;ferro&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;24&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;corr&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;25&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;blue%2Fbright%2Fvarn%2Fclean&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;26&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;lustre&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;27&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;jurofm&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;28&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;s&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;29&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;p&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;30&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;shape&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;31&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;thick&lt;/oml:name&gt;
    &lt;oml:data_type&gt;numeric&lt;/oml:data_type&gt;
    &lt;oml:index&gt;32&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;width&lt;/oml:name&gt;
    &lt;oml:data_type&gt;numeric&lt;/oml:data_type&gt;
    &lt;oml:index&gt;33&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;len&lt;/oml:name&gt;
    &lt;oml:data_type&gt;numeric&lt;/oml:data_type&gt;
    &lt;oml:index&gt;34&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;oil&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;35&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;bore&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;36&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;packing&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;37&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;class&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;38&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
&lt;/oml:data_features&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>270: Please provide data_id</dt><dd>Please provide data_id</dd></dl>
<dl><dt>271: Unknown dataset</dt><dd>Data set description with data_id was not found in the database</dd></dl>
<dl><dt>272: No features found</dt><dd>The registered dataset did not contain any features</dd></dl>
<dl><dt>273: Dataset not processed yet</dt><dd>The dataset was not processed yet, no features are available. Please wait for a few minutes. </dd></dl>
<dl><dt>274: Dataset processed with error</dt><dd>The feature extractor has run into an error while processing the dataset. Please check whether it is a valid supported file. </dd></dl>
</div>

<!-- [END] Api function description: openml.data.features -->  



<!-- [START] Api function description: openml.data.qualities --> 


<h3 id=openml_data_qualities>openml.data.qualities</h3>
<p><i>Returns the qualities (meta-features) of a given dataset</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET data_id</code> (Required)</dt><dd>The dataset id</dd></dl>
</div>
<h5>Schema's</h5>
<div class="bs-callout bs-callout-info">
<h5>openml.data.qualities</h5>

-<br/>
<a type="button" class="btn btn-primary" href="https://github.com/openml/website/blob/master/openml_OS/views/pages/rest_api/xsd/openml.data.qualities.xsd">XSD Schema</a>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:data_qualities xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;ClassCount&lt;/oml:name&gt;
    &lt;oml:value&gt;6.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;ClassEntropy&lt;/oml:name&gt;
    &lt;oml:value&gt;-1.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;DecisionStumpAUC&lt;/oml:name&gt;
    &lt;oml:value&gt;0.822828217876869&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;DecisionStumpErrRate&lt;/oml:name&gt;
    &lt;oml:value&gt;22.828507795100222&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;DecisionStumpKappa&lt;/oml:name&gt;
    &lt;oml:value&gt;0.4503332218612649&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;DefaultAccuracy&lt;/oml:name&gt;
    &lt;oml:value&gt;0.76169265033408&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;DefaultTargetNominal&lt;/oml:name&gt;
    &lt;oml:value&gt;1&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;DefaultTargetNumerical&lt;/oml:name&gt;
    &lt;oml:value&gt;0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;Dimensionality&lt;/oml:name&gt;
    &lt;oml:value&gt;0.043429844097995544&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;EquivalentNumberOfAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;-12.218452122298707&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;IncompleteInstanceCount&lt;/oml:name&gt;
    &lt;oml:value&gt;0.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;InstanceCount&lt;/oml:name&gt;
    &lt;oml:value&gt;898.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;J48.00001.AUC&lt;/oml:name&gt;
    &lt;oml:value&gt;0.7880182273644211&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;J48.00001.ErrRate&lt;/oml:name&gt;
    &lt;oml:value&gt;12.249443207126948&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;J48.00001.kappa&lt;/oml:name&gt;
    &lt;oml:value&gt;0.6371863763080279&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;J48.0001.AUC&lt;/oml:name&gt;
    &lt;oml:value&gt;0.9270456597451915&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;J48.0001.ErrRate&lt;/oml:name&gt;
    &lt;oml:value&gt;7.795100222717149&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;J48.0001.kappa&lt;/oml:name&gt;
    &lt;oml:value&gt;0.7894969492796818&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;J48.001.AUC&lt;/oml:name&gt;
    &lt;oml:value&gt;0.9270456597451915&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;J48.001.ErrRate&lt;/oml:name&gt;
    &lt;oml:value&gt;7.795100222717149&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;J48.001.kappa&lt;/oml:name&gt;
    &lt;oml:value&gt;0.7894969492796818&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MajorityClassSize&lt;/oml:name&gt;
    &lt;oml:value&gt;684&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MaxNominalAttDistinctValues&lt;/oml:name&gt;
    &lt;oml:value&gt;10.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MeanAttributeEntropy&lt;/oml:name&gt;
    &lt;oml:value&gt;-1.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MeanKurtosisOfNumericAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;4.6070302750191185&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MeanMeansOfNumericAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;348.50426818856744&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MeanMutualInformation&lt;/oml:name&gt;
    &lt;oml:value&gt;0.0818434274645147&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MeanNominalAttDistinctValues&lt;/oml:name&gt;
    &lt;oml:value&gt;3.21875&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MeanSkewnessOfNumericAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;2.022468153229902&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MeanStdDevOfNumericAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;405.17326983790934&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MinNominalAttDistinctValues&lt;/oml:name&gt;
    &lt;oml:value&gt;2.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;MinorityClassSize&lt;/oml:name&gt;
    &lt;oml:value&gt;0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NBAUC&lt;/oml:name&gt;
    &lt;oml:value&gt;0.9594224101963532&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NBErrRate&lt;/oml:name&gt;
    &lt;oml:value&gt;13.808463251670378&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NBKappa&lt;/oml:name&gt;
    &lt;oml:value&gt;0.7185564873649677&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NegativePercentage&lt;/oml:name&gt;
    &lt;oml:value&gt;0.7616926503340757&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NoiseToSignalRatio&lt;/oml:name&gt;
    &lt;oml:value&gt;-13.218452122298709&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumAttributes&lt;/oml:name&gt;
    &lt;oml:value&gt;39.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumBinaryAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;19.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumMissingValues&lt;/oml:name&gt;
    &lt;oml:value&gt;0.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumNominalAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;32.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumNumericAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;6.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumberOfClasses&lt;/oml:name&gt;
    &lt;oml:value&gt;6&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumberOfFeatures&lt;/oml:name&gt;
    &lt;oml:value&gt;39&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumberOfInstances&lt;/oml:name&gt;
    &lt;oml:value&gt;898&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumberOfInstancesWithMissingValues&lt;/oml:name&gt;
    &lt;oml:value&gt;0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumberOfMissingValues&lt;/oml:name&gt;
    &lt;oml:value&gt;0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;NumberOfNumericFeatures&lt;/oml:name&gt;
    &lt;oml:value&gt;6&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;PercentageOfBinaryAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;0.48717948717948717&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;PercentageOfMissingValues&lt;/oml:name&gt;
    &lt;oml:value&gt;0.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;PercentageOfNominalAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;0.8205128205128205&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;PercentageOfNumericAtts&lt;/oml:name&gt;
    &lt;oml:value&gt;0.15384615384615385&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;PositivePercentage&lt;/oml:name&gt;
    &lt;oml:value&gt;0.0&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;REPTreeDepth1AUC&lt;/oml:name&gt;
    &lt;oml:value&gt;0.7597968469351692&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;REPTreeDepth1ErrRate&lt;/oml:name&gt;
    &lt;oml:value&gt;23.2739420935412&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;REPTreeDepth1Kappa&lt;/oml:name&gt;
    &lt;oml:value&gt;0.2894251628951225&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;REPTreeDepth2AUC&lt;/oml:name&gt;
    &lt;oml:value&gt;0.9666861764236521&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;REPTreeDepth2ErrRate&lt;/oml:name&gt;
    &lt;oml:value&gt;6.7928730512249444&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;REPTreeDepth2Kappa&lt;/oml:name&gt;
    &lt;oml:value&gt;0.832482668142716&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;REPTreeDepth3AUC&lt;/oml:name&gt;
    &lt;oml:value&gt;0.9924792906738309&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;REPTreeDepth3ErrRate&lt;/oml:name&gt;
    &lt;oml:value&gt;2.5612472160356345&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;REPTreeDepth3Kappa&lt;/oml:name&gt;
    &lt;oml:value&gt;0.9353873971951361&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;RandomTreeDepth1AUC_K=0&lt;/oml:name&gt;
    &lt;oml:value&gt;0.813070621364688&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;RandomTreeDepth2AUC_K=0&lt;/oml:name&gt;
    &lt;oml:value&gt;0.8907193338317052&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;RandomTreeDepth3AUC_K=0&lt;/oml:name&gt;
    &lt;oml:value&gt;0.9701947883881082&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
  &lt;oml:quality&gt;
    &lt;oml:name&gt;StdvNominalAttDistinctValues&lt;/oml:name&gt;
    &lt;oml:value&gt;2.0593512132112965&lt;/oml:value&gt;
  &lt;/oml:quality&gt;
&lt;/oml:data_qualities&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>360: Please provide data_id</dt><dd>Please provide data_id</dd></dl>
<dl><dt>361: Unknown dataset</dt><dd>Data set description with data_id was not found in the database</dd></dl>
<dl><dt>362: No qualities found</dt><dd>The registered dataset did not contain any calculated qualities</dd></dl>
<dl><dt>363: Dataset not processed yet</dt><dd>The dataset was not processed yet, no qualities are available. Please wait for a few minutes.</dd></dl>
<dl><dt>364: Dataset processed with error</dt><dd>The quality calculator has run into an error while processing the dataset. Please check whether it is a valid supported file. </dd></dl>
<dl><dt>365: Interval start or end illegal</dt><dd>There was a problem with the interval start or end.</dd></dl>
</div>

<!-- [END] Api function description: openml.data.qualities -->  



<!-- [START] Api function description: openml.data.qualities.list --> 


<h3 id=openml_data_qualities_list>openml.data.qualities.list</h3>
<p><i>Lists all data qualities that are used (i.e., are calculated for at least one dataset)</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
None
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:data_qualities_list xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:quality&gt;ClassCount&lt;/oml:quality&gt;
  &lt;oml:quality&gt;ClassEntropy&lt;/oml:quality&gt;
  &lt;oml:quality&gt;DecisionStumpAUC&lt;/oml:quality&gt;
  &lt;oml:quality&gt;DecisionStumpErrRate&lt;/oml:quality&gt;
  &lt;oml:quality&gt;DecisionStumpKappa&lt;/oml:quality&gt;
  &lt;oml:quality&gt;DefaultAccuracy&lt;/oml:quality&gt;
  &lt;oml:quality&gt;Dimensionality&lt;/oml:quality&gt;
  &lt;oml:quality&gt;EquivalentNumberOfAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;HoeffdingAdwin.changes&lt;/oml:quality&gt;
  &lt;oml:quality&gt;HoeffdingAdwin.warnings&lt;/oml:quality&gt;
  &lt;oml:quality&gt;HoeffdingDDM.changes&lt;/oml:quality&gt;
  &lt;oml:quality&gt;HoeffdingDDM.warnings&lt;/oml:quality&gt;
  &lt;oml:quality&gt;IncompleteInstanceCount&lt;/oml:quality&gt;
  &lt;oml:quality&gt;InstanceCount&lt;/oml:quality&gt;
  &lt;oml:quality&gt;J48.00001.AUC&lt;/oml:quality&gt;
  &lt;oml:quality&gt;J48.00001.ErrRate&lt;/oml:quality&gt;
  &lt;oml:quality&gt;J48.00001.kappa&lt;/oml:quality&gt;
  &lt;oml:quality&gt;J48.0001.AUC&lt;/oml:quality&gt;
  &lt;oml:quality&gt;J48.0001.ErrRate&lt;/oml:quality&gt;
  &lt;oml:quality&gt;J48.0001.kappa&lt;/oml:quality&gt;
  &lt;oml:quality&gt;J48.001.AUC&lt;/oml:quality&gt;
  &lt;oml:quality&gt;J48.001.ErrRate&lt;/oml:quality&gt;
  &lt;oml:quality&gt;J48.001.kappa&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MajorityClassSize&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MaxNominalAttDistinctValues&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MeanAttributeEntropy&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MeanKurtosisOfNumericAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MeanMeansOfNumericAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MeanMutualInformation&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MeanNominalAttDistinctValues&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MeanSkewnessOfNumericAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MeanStdDevOfNumericAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MinNominalAttDistinctValues&lt;/oml:quality&gt;
  &lt;oml:quality&gt;MinorityClassSize&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NBAUC&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NBErrRate&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NBKappa&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NaiveBayesAdwin.changes&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NaiveBayesAdwin.warnings&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NaiveBayesDdm.changes&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NaiveBayesDdm.warnings&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NegativePercentage&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NoiseToSignalRatio&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumAttributes&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumBinaryAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumMissingValues&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumNominalAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumNumericAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumberOfClasses&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumberOfFeatures&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumberOfInstances&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumberOfInstancesWithMissingValues&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumberOfMissingValues&lt;/oml:quality&gt;
  &lt;oml:quality&gt;NumberOfNumericFeatures&lt;/oml:quality&gt;
  &lt;oml:quality&gt;PercentageOfBinaryAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;PercentageOfMissingValues&lt;/oml:quality&gt;
  &lt;oml:quality&gt;PercentageOfNominalAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;PercentageOfNumericAtts&lt;/oml:quality&gt;
  &lt;oml:quality&gt;PositivePercentage&lt;/oml:quality&gt;
  &lt;oml:quality&gt;REPTreeDepth1AUC&lt;/oml:quality&gt;
  &lt;oml:quality&gt;REPTreeDepth1ErrRate&lt;/oml:quality&gt;
  &lt;oml:quality&gt;REPTreeDepth1Kappa&lt;/oml:quality&gt;
  &lt;oml:quality&gt;REPTreeDepth2AUC&lt;/oml:quality&gt;
  &lt;oml:quality&gt;REPTreeDepth2ErrRate&lt;/oml:quality&gt;
  &lt;oml:quality&gt;REPTreeDepth2Kappa&lt;/oml:quality&gt;
  &lt;oml:quality&gt;REPTreeDepth3AUC&lt;/oml:quality&gt;
  &lt;oml:quality&gt;REPTreeDepth3ErrRate&lt;/oml:quality&gt;
  &lt;oml:quality&gt;REPTreeDepth3Kappa&lt;/oml:quality&gt;
  &lt;oml:quality&gt;RandomTreeDepth1AUC_K=0&lt;/oml:quality&gt;
  &lt;oml:quality&gt;RandomTreeDepth2AUC_K=0&lt;/oml:quality&gt;
  &lt;oml:quality&gt;RandomTreeDepth3AUC_K=0&lt;/oml:quality&gt;
  &lt;oml:quality&gt;StdvNominalAttDistinctValues&lt;/oml:quality&gt;
&lt;/oml:data_qualities_list&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
None
</div>

<!-- [END] Api function description: openml.data.qualities.list -->  




<!-- [START] Api function description: openml.task.search --> 


<h3 id=openml_task_search>openml.task.search</h3>
<p><i>Returns the description of a task</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET task_id</code> (Required)</dt><dd>The task id</dd></dl>
</div>
<h5>Schema's</h5>
<div class="bs-callout bs-callout-info">
<h5>openml.task.search</h5>

A task description<br/>
<a type="button" class="btn btn-primary" href="https://github.com/openml/website/blob/master/openml_OS/views/pages/rest_api/xsd/openml.task.search.xsd">XSD Schema</a>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:task xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:task_id&gt;1&lt;/oml:task_id&gt;
  &lt;oml:task_type&gt;Supervised Classification&lt;/oml:task_type&gt;
  &lt;oml:input name="source_data"&gt;
    &lt;oml:data_set&gt;
      &lt;oml:data_set_id&gt;1&lt;/oml:data_set_id&gt;
      &lt;oml:target_feature&gt;class&lt;/oml:target_feature&gt;
    &lt;/oml:data_set&gt;
  &lt;/oml:input&gt;
  &lt;oml:input name="estimation_procedure"&gt;
    &lt;oml:estimation_procedure&gt;
      &lt;oml:type&gt;crossvalidation&lt;/oml:type&gt;
      &lt;oml:data_splits_url&gt;http://openml.liacs.nl/api_splits/get/1/Task_1_splits.arff&lt;/oml:data_splits_url&gt;
      &lt;oml:parameter name="number_repeats"&gt;1&lt;/oml:parameter&gt;
      &lt;oml:parameter name="number_folds"&gt;10&lt;/oml:parameter&gt;
      &lt;oml:parameter name="percentage"/&gt;
      &lt;oml:parameter name="stratified_sampling"&gt;true&lt;/oml:parameter&gt;
    &lt;/oml:estimation_procedure&gt;
  &lt;/oml:input&gt;
  &lt;oml:input name="evaluation_measures"&gt;
    &lt;oml:evaluation_measures&gt;
      &lt;oml:evaluation_measure/&gt;
    &lt;/oml:evaluation_measures&gt;
  &lt;/oml:input&gt;
  &lt;oml:output name="predictions"&gt;
    &lt;oml:predictions&gt;
      &lt;oml:format&gt;ARFF&lt;/oml:format&gt;
      &lt;oml:feature name="repeat" type="integer"/&gt;
      &lt;oml:feature name="fold" type="integer"/&gt;
      &lt;oml:feature name="row_id" type="integer"/&gt;
      &lt;oml:feature name="confidence.classname" type="numeric"/&gt;
      &lt;oml:feature name="prediction" type="string"/&gt;
    &lt;/oml:predictions&gt;
  &lt;/oml:output&gt;
&lt;/oml:task&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>150: Please provide task_id</dt><dd>Please provide task_id</dd></dl>
<dl><dt>151: Unknown task</dt><dd>The task with this id was not found in the database</dd></dl>
</div>

<!-- [END] Api function description: openml.task.search -->  



<!-- [START] Api function description: openml.task.evaluations --> 


<h3 id=openml_task_evaluations>openml.task.evaluations</h3>
<p><i>Returns the performance of flows on a given task</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET task_id</code> (Required)</dt><dd>the task id</dd></dl>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:task_evaluations xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:task_id/&gt;
  &lt;oml:task_name/&gt;
  &lt;oml:task_type_id/&gt;
  &lt;oml:input_data&gt;1&lt;/oml:input_data&gt;
  &lt;oml:estimation_procedure&gt;10-fold Crossvalidation&lt;/oml:estimation_procedure&gt;
  &lt;oml:evaluation&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>300: Please provide task_id</dt><dd>Please provide task_id</dd></dl>
<dl><dt>301: Unknown task</dt><dd>The task with this id was not found in the database</dd></dl>
</div>

<!-- [END] Api function description: openml.task.evaluations -->  



<!-- [START] Api function description: openml.task.types --> 


<h3 id=openml_task_types>openml.task.types</h3>
<p><i>Returns a list of all task types</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
None
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:task_types xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:task_type&gt;
    &lt;oml:id&gt;1&lt;/oml:id&gt;
    &lt;oml:name&gt;Supervised Classification&lt;/oml:name&gt;
    &lt;oml:description&gt;In supervised classification, you are given an input dataset in which instances are labeled with a certain class. The goal is to build a model that predicts the class for future unlabeled instances. The model is evaluated using a train-test procedure, e.g. cross-validation.&lt;br&gt;&lt;br&gt;

To make results by different users comparable, you are given the exact train-test folds to be used, and you need to return at least the predictions generated by your model for each of the test instances. OpenML will use these predictions to calculate a range of evaluation measures on the server.&lt;br&gt;&lt;br&gt;

You can also upload your own evaluation measures, provided that the code for doing so is available from the implementation used. For extremely large datasets, it may be infeasible to upload all predictions. In those cases, you need to compute and provide the evaluations yourself.&lt;br&gt;&lt;br&gt;

Optionally, you can upload the model trained on all the input data. There is no restriction on the file format, but please use a well-known format or PMML.&lt;/oml:description&gt;
    &lt;oml:creator&gt;Joaquin Vanschoren, Jan van Rijn, Luis Torgo, Bernd Bischl&lt;/oml:creator&gt;
  &lt;/oml:task_type&gt;
  &lt;oml:task_type&gt;
    &lt;oml:id&gt;2&lt;/oml:id&gt;
    &lt;oml:name&gt;Supervised Regression&lt;/oml:name&gt;
    &lt;oml:description&gt;Given a dataset with a numeric target and a set of train/test splits, e.g. generated by a cross-validation procedure, train a model and return the predictions of that model.&lt;/oml:description&gt;
    &lt;oml:creator&gt;Joaquin Vanschoren, Jan van Rijn, Luis Torgo, Bernd Bischl&lt;/oml:creator&gt;
  &lt;/oml:task_type&gt;
  &lt;oml:task_type&gt;
    &lt;oml:id&gt;3&lt;/oml:id&gt;
    &lt;oml:name&gt;Learning Curve&lt;/oml:name&gt;
    &lt;oml:description&gt;Given a dataset with a nominal target, various data samples of increasing size are defined. A model is build for each individual data sample; from this a learning curve can be drawn. &lt;/oml:description&gt;
    &lt;oml:creator&gt;Pavel Brazdil, Jan van Rijn, Joaquin Vanschoren&lt;/oml:creator&gt;
  &lt;/oml:task_type&gt;
  &lt;oml:task_type&gt;
    &lt;oml:id&gt;4&lt;/oml:id&gt;
    &lt;oml:name&gt;Supervised Data Stream Classification&lt;/oml:name&gt;
    &lt;oml:description&gt;Given a dataset with a nominal target, various data samples of increasing size are defined. A model is build for each individual data sample; from this a learning curve can be drawn.&lt;/oml:description&gt;
    &lt;oml:creator&gt;Geoffrey Holmes, Bernhard Pfahringer, Jan van Rijn, Joaquin Vanschoren&lt;/oml:creator&gt;
  &lt;/oml:task_type&gt;
&lt;/oml:task_types&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
None
</div>

<!-- [END] Api function description: openml.task.types -->  



<!-- [START] Api function description: openml.task.types.search --> 


<h3 id=openml_task_types_search>openml.task.types.search</h3>
<p><i>returns a definition (template) of a certain task type</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET task_type_id</code> (Required)</dt><dd>The task type id</dd></dl>
</div>
<h5>Schema's</h5>
<div class="bs-callout bs-callout-info">
<h5>openml.task.types.search</h5>

A description of a task type<br/>
<a type="button" class="btn btn-primary" href="https://github.com/openml/website/blob/master/openml_OS/views/pages/rest_api/xsd/openml.task.types.search.xsd">XSD Schema</a>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:task_type xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:id&gt;1&lt;/oml:id&gt;
  &lt;oml:name&gt;Supervised Classification&lt;/oml:name&gt;
  &lt;oml:description&gt;In supervised classification, you are given an input dataset in which instances are labeled with a certain class. The goal is to build a model that predicts the class for future unlabeled instances. The model is evaluated using a train-test procedure, e.g. cross-validation.&lt;br&gt;&lt;br&gt;

To make results by different users comparable, you are given the exact train-test folds to be used, and you need to return at least the predictions generated by your model for each of the test instances. OpenML will use these predictions to calculate a range of evaluation measures on the server.&lt;br&gt;&lt;br&gt;

You can also upload your own evaluation measures, provided that the code for doing so is available from the implementation used. For extremely large datasets, it may be infeasible to upload all predictions. In those cases, you need to compute and provide the evaluations yourself.&lt;br&gt;&lt;br&gt;

Optionally, you can upload the model trained on all the input data. There is no restriction on the file format, but please use a well-known format or PMML.&lt;/oml:description&gt;
  &lt;oml:creator&gt;Joaquin Vanschoren, Jan van Rijn, Luis Torgo, Bernd Bischl&lt;/oml:creator&gt;
  &lt;oml:contributor&gt;Bo Gao&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt; Simon Fischer&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt; Venkatesh Umaashankar&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt; Michael Berthold&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt; Bernd Wiswedel &lt;/oml:contributor&gt;
  &lt;oml:contributor&gt;Patrick Winter&lt;/oml:contributor&gt;
  &lt;oml:date&gt;24-01-2013&lt;/oml:date&gt;
  &lt;oml:input name="source_data"&gt;
    &lt;oml:data_set&gt;
      &lt;oml:data_set_id&gt;[INPUT:source_data]&lt;/oml:data_set_id&gt;
      &lt;oml:target_feature&gt;[INPUT:target_feature]&lt;/oml:target_feature&gt;
    &lt;/oml:data_set&gt;
  &lt;/oml:input&gt;
  &lt;oml:input name="estimation_procedure"&gt;
    &lt;oml:estimation_procedure&gt;
      &lt;oml:type&gt;[LOOKUP:estimation_procedure.type]&lt;/oml:type&gt;
      &lt;oml:data_splits_url&gt;[CONSTANT:base_url]api_splits/get/[TASK:id]/Task_[TASK:id]_splits.arff&lt;/oml:data_splits_url&gt;
      &lt;oml:parameter name="number_repeats"&gt;[LOOKUP:estimation_procedure.repeats]&lt;/oml:parameter&gt;
      &lt;oml:parameter name="number_folds"&gt;[LOOKUP:estimation_procedure.folds]&lt;/oml:parameter&gt;
      &lt;oml:parameter name="percentage"&gt;[LOOKUP:estimation_procedure.percentage]&lt;/oml:parameter&gt;
      &lt;oml:parameter name="stratified_sampling"&gt;[LOOKUP:estimation_procedure.stratified_sampling]&lt;/oml:parameter&gt;
    &lt;/oml:estimation_procedure&gt;
  &lt;/oml:input&gt;
  &lt;oml:input name="evaluation_measures"&gt;
    &lt;oml:evaluation_measures&gt;
      &lt;oml:evaluation_measure&gt;[INPUT:evaluation_measures]&lt;/oml:evaluation_measure&gt;
    &lt;/oml:evaluation_measures&gt;
  &lt;/oml:input&gt;
  &lt;oml:output name="predictions"&gt;
    &lt;oml:predictions&gt;
      &lt;oml:format&gt;ARFF&lt;/oml:format&gt;
      &lt;oml:feature name="repeat" type="integer"/&gt;
      &lt;oml:feature name="fold" type="integer"/&gt;
      &lt;oml:feature name="row_id" type="integer"/&gt;
      &lt;oml:feature name="confidence.classname" type="numeric"/&gt;
      &lt;oml:feature name="prediction" type="string"/&gt;
    &lt;/oml:predictions&gt;
  &lt;/oml:output&gt;
&lt;/oml:task_type&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>240: Please provide task_type_id</dt><dd>Please provide task_type_id</dd></dl>
<dl><dt>241: Unknown task type</dt><dd>The task type with this id was not found in the database</dd></dl>
</div>

<!-- [END] Api function description: openml.task.types.search -->  




<!-- [START] Api function description: openml.estimationprocedure.get --> 


<h3 id=openml_estimationprocedure_get>openml.estimationprocedure.get</h3>
<p><i>returns the details of an estimation procedure</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET estimationprocedure_id</code> (Required)</dt><dd>The id of the estimation procedure</dd></dl>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:estimationprocedure xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:ttid&gt;1&lt;/oml:ttid&gt;
  &lt;oml:name&gt;10-fold Crossvalidation&lt;/oml:name&gt;
  &lt;oml:type&gt;crossvalidation&lt;/oml:type&gt;
  &lt;oml:repeats&gt;1&lt;/oml:repeats&gt;
  &lt;oml:folds&gt;10&lt;/oml:folds&gt;
  &lt;oml:stratified_sampling&gt;true&lt;/oml:stratified_sampling&gt;
&lt;/oml:estimationprocedure&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>440: Please provide estimationprocedure_id</dt><dd>Please provide estimationprocedure_id</dd></dl>
<dl><dt>441: estimationprocedure_id not valid</dt><dd>Please provide a valid estimationprocedure_id</dd></dl>
</div>

<!-- [END] Api function description: openml.estimationprocedure.get -->  




<!-- [START] Api function description: openml.implementation.get --> 


<h3 id=openml_implementation_get>openml.implementation.get</h3>
<p><i>Returns the description of an implementation (flow)</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET implementation_id</code> (Required)</dt><dd>The id of the implementation</dd></dl>
</div>
<h5>Schema's</h5>
<div class="bs-callout bs-callout-info">
<h5>openml.implementation.get</h5>

This XSD schema is applicable for both uploading and downloading a implementation. <br/>
<a type="button" class="btn btn-primary" href="https://github.com/openml/website/blob/master/openml_OS/views/pages/rest_api/xsd/openml.implementation.upload.xsd">XSD Schema</a>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:implementation xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:id&gt;100&lt;/oml:id&gt;
  &lt;oml:uploader&gt;1&lt;/oml:uploader&gt;
  &lt;oml:name&gt;weka.J48&lt;/oml:name&gt;
  &lt;oml:version&gt;2&lt;/oml:version&gt;
  &lt;oml:external_version&gt;Weka_3.7.5_9117&lt;/oml:external_version&gt;
  &lt;oml:description&gt;Ross Quinlan (1993). C4.5: Programs for Machine Learning. Morgan Kaufmann Publishers, San Mateo, CA.&lt;/oml:description&gt;
  &lt;oml:upload_date&gt;2014-04-23 18:00:36&lt;/oml:upload_date&gt;
  &lt;oml:language&gt;English&lt;/oml:language&gt;
  &lt;oml:dependencies&gt;Weka_3.7.5&lt;/oml:dependencies&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;A&lt;/oml:name&gt;
    &lt;oml:data_type&gt;flag&lt;/oml:data_type&gt;
    &lt;oml:default_value/&gt;
    &lt;oml:description&gt;Laplace smoothing for predicted probabilities.&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;B&lt;/oml:name&gt;
    &lt;oml:data_type&gt;flag&lt;/oml:data_type&gt;
    &lt;oml:default_value/&gt;
    &lt;oml:description&gt;Use binary splits only.&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;C&lt;/oml:name&gt;
    &lt;oml:data_type&gt;option&lt;/oml:data_type&gt;
    &lt;oml:default_value&gt;0.25&lt;/oml:default_value&gt;
    &lt;oml:description&gt;Set confidence threshold for pruning.
	(default 0.25)&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;J&lt;/oml:name&gt;
    &lt;oml:data_type&gt;flag&lt;/oml:data_type&gt;
    &lt;oml:default_value/&gt;
    &lt;oml:description&gt;Do not use MDL correction for info gain on numeric attributes.&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;L&lt;/oml:name&gt;
    &lt;oml:data_type&gt;flag&lt;/oml:data_type&gt;
    &lt;oml:default_value/&gt;
    &lt;oml:description&gt;Do not clean up after the tree has been built.&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;M&lt;/oml:name&gt;
    &lt;oml:data_type&gt;option&lt;/oml:data_type&gt;
    &lt;oml:default_value&gt;2&lt;/oml:default_value&gt;
    &lt;oml:description&gt;Set minimum number of instances per leaf.
	(default 2)&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;N&lt;/oml:name&gt;
    &lt;oml:data_type&gt;option&lt;/oml:data_type&gt;
    &lt;oml:default_value/&gt;
    &lt;oml:description&gt;Set number of folds for reduced error
	pruning. One fold is used as pruning set.
	(default 3)&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;O&lt;/oml:name&gt;
    &lt;oml:data_type&gt;flag&lt;/oml:data_type&gt;
    &lt;oml:default_value/&gt;
    &lt;oml:description&gt;Do not collapse tree.&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;Q&lt;/oml:name&gt;
    &lt;oml:data_type&gt;option&lt;/oml:data_type&gt;
    &lt;oml:default_value/&gt;
    &lt;oml:description&gt;Seed for random data shuffling (default 1).&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;R&lt;/oml:name&gt;
    &lt;oml:data_type&gt;flag&lt;/oml:data_type&gt;
    &lt;oml:default_value/&gt;
    &lt;oml:description&gt;Use reduced error pruning.&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;S&lt;/oml:name&gt;
    &lt;oml:data_type&gt;flag&lt;/oml:data_type&gt;
    &lt;oml:default_value/&gt;
    &lt;oml:description&gt;Don't perform subtree raising.&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
  &lt;oml:parameter&gt;
    &lt;oml:name&gt;U&lt;/oml:name&gt;
    &lt;oml:data_type&gt;flag&lt;/oml:data_type&gt;
    &lt;oml:default_value/&gt;
    &lt;oml:description&gt;Use unpruned tree.&lt;/oml:description&gt;
  &lt;/oml:parameter&gt;
&lt;/oml:implementation&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>180: Please provide implementation_id</dt><dd>Please provide implementation_id</dd></dl>
<dl><dt>181: Unknown implementation</dt><dd>The implementation with this ID was not found in the database</dd></dl>
</div>

<!-- [END] Api function description: openml.implementation.get -->  



<!-- [START] Api function description: openml.implementation.exists --> 


<h3 id=openml_implementation_exists>openml.implementation.exists</h3>
<p><i>A utility function that checks whether an implementation already exists. Mainly used by workbenches</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET name</code> (Required)</dt><dd>The name of the implementation</dd></dl>
<dl><dt><code>GET external_version</code> (Required)</dt><dd>The (workbench) version of the implementation. This is generally based on conventions per workbench</dd></dl>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:error xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:code&gt;180&lt;/oml:code&gt;
  &lt;oml:message&gt;Please provide implementation_id&lt;/oml:message&gt;
&lt;/oml:error&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>330: Mandatory fields not present.</dt><dd>Please provide one of the following mandatory field combination: name and external_version.</dd></dl>
</div>

<!-- [END] Api function description: openml.implementation.exists -->  



<!-- [START] Api function description: openml.implementation.upload --> 


<h3 id=openml_implementation_upload>openml.implementation.upload</h3>
<p><i>Uploads an implementation to OpenML</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>POST description</code> (Required)</dt><dd>An XML file containing the implementation meta data</dd></dl>
<dl><dt><code>POST source</code></dt><dd>The source code of the implementation. If multiple files, please zip them. Either source or binary is required.</dd></dl>
<dl><dt><code>POST binary</code></dt><dd>The binary of the implementation. If multiple files, please zip them. Either source or binary is required.</dd></dl>
<dl><dt><code>POST session_hash</code> (Required)</dt><dd>The session hash, provided by the server on authentication (1 hour valid)</dd></dl>
</div>
<h5>Schema's</h5>
<div class="bs-callout bs-callout-info">
<h5>openml.implementation.upload</h5>

This XSD schema is applicable for both uploading and downloading a implementation. (Some fields are ignored)<br/>
<a type="button" class="btn btn-primary" href="https://github.com/openml/website/blob/master/openml_OS/views/pages/rest_api/xsd/openml.implementation.upload.xsd">XSD Schema</a>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>160: Error in file uploading</dt><dd>There was a problem with the file upload</dd></dl>
<dl><dt>161: Please provide description xml</dt><dd>Please provide description xml</dd></dl>
<dl><dt>162: Please provide source or binary file</dt><dd>Please provide source or binary file. It is also allowed to upload both</dd></dl>
<dl><dt>163: Problem validating uploaded description file</dt><dd>The XML description format does not meet the standards</dd></dl>
<dl><dt>164: Implementation already stored in database</dt><dd>Please change name or version number</dd></dl>
<dl><dt>165: Failed to move the files</dt><dd>Internal server error, please contact api administrators</dd></dl>
<dl><dt>166: Failed to add implementation to database</dt><dd>Internal server error, please contact api administrators</dd></dl>
<dl><dt>167: Illegal files uploaded</dt><dd>An non required file was uploaded.</dd></dl>
<dl><dt>168: The provided md5 hash equals not the server generated md5 hash of the file</dt><dd>The provided md5 hash equals not the server generated md5 hash of the file</dd></dl>
<dl><dt>169: Please provide session_hash</dt><dd>In order to share content, please authenticate (openml.authenticate) and provide session_hash</dd></dl>
<dl><dt>170: Authentication failed</dt><dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd></dl>
<dl><dt>171: Implementation already exists</dt><dd>This implementation is already in the database</dd></dl>
</div>

<!-- [END] Api function description: openml.implementation.upload -->  



<!-- [START] Api function description: openml.implementation.owned --> 


<h3 id=openml_implementation_owned>openml.implementation.owned</h3>
<p><i>Returns a list of all implementations owned by the user</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>POST session_hash</code> (Required)</dt><dd>The session hash, provided by the server on authentication (1 hour valid)</dd></dl>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>310: Please provide session_hash</dt><dd>In order to view private content, please authenticate (openml.authenticate) and provide session_hash</dd></dl>
<dl><dt>311: Authentication failed</dt><dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd></dl>
<dl><dt>312: No implementations owned by this used</dt><dd>The user has no implementations linked to his account</dd></dl>
</div>

<!-- [END] Api function description: openml.implementation.owned -->  



<!-- [START] Api function description: openml.implementation.delete --> 


<h3 id=openml_implementation_delete>openml.implementation.delete</h3>
<p><i>Deletes an implementation (can only be done to owned implementations)</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>POST session_hash</code> (Required)</dt><dd>The session hash, provided by the server on authentication (1 hour valid)</dd></dl>
<dl><dt><code>POST implementation_id</code> (Required)</dt><dd>The id of the implementation to delete</dd></dl>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>320: Please provide session_hash</dt><dd>In order to remove your content, please authenticate (openml.authenticate) and provide session_hash</dd></dl>
<dl><dt>321: Authentication failed</dt><dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd></dl>
<dl><dt>322: Implementation does not exists</dt><dd>The implementation id could not be linked to an existing implementation.</dd></dl>
<dl><dt>323: Implementation is not owned by you</dt><dd>The implementation was owned by another user. Hence you cannot delete it.</dd></dl>
<dl><dt>324: Implementation is in use by other content. Can not be deleted</dt><dd>The implementation is used in runs, evaluations or as component of another implementation. Delete this other content before deleting this implementation. </dd></dl>
<dl><dt>325: Deleting implementation failed.</dt><dd>Deleting the implementation failed. Please contact support team. </dd></dl>
</div>

<!-- [END] Api function description: openml.implementation.delete -->  



<!-- [START] Api function description: openml.implementation.licences --> 


<h3 id=openml_implementation_licences>openml.implementation.licences</h3>
<p><i>Returns a list of all used licences in the implementations</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
None
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:implementation_licences xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:licences&gt;
    &lt;oml:licence&gt;public domain&lt;/oml:licence&gt;
    &lt;oml:licence&gt;NA&lt;/oml:licence&gt;
  &lt;/oml:licences&gt;
&lt;/oml:implementation_licences&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
None
</div>

<!-- [END] Api function description: openml.implementation.licences -->  




<!-- [START] Api function description: openml.evaluation.measures --> 


<h3 id=openml_evaluation_measures>openml.evaluation.measures</h3>
<p><i>Returns a list of all evaluation measures</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
None
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:evaluation_measures xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:measures&gt;
    &lt;oml:measure&gt;area_under_roc_curve&lt;/oml:measure&gt;
    &lt;oml:measure&gt;average_cost&lt;/oml:measure&gt;
    &lt;oml:measure&gt;build_cpu_time&lt;/oml:measure&gt;
    &lt;oml:measure&gt;build_memory&lt;/oml:measure&gt;
    &lt;oml:measure&gt;class_complexity&lt;/oml:measure&gt;
    &lt;oml:measure&gt;class_complexity_gain&lt;/oml:measure&gt;
    &lt;oml:measure&gt;confusion_matrix&lt;/oml:measure&gt;
    &lt;oml:measure&gt;correlation_coefficient&lt;/oml:measure&gt;
    &lt;oml:measure&gt;f_measure&lt;/oml:measure&gt;
    &lt;oml:measure&gt;kappa&lt;/oml:measure&gt;
    &lt;oml:measure&gt;kb_relative_information_score&lt;/oml:measure&gt;
    &lt;oml:measure&gt;kohavi_wolpert_bias_squared&lt;/oml:measure&gt;
    &lt;oml:measure&gt;kohavi_wolpert_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;kohavi_wolpert_sigma_squared&lt;/oml:measure&gt;
    &lt;oml:measure&gt;kohavi_wolpert_variance&lt;/oml:measure&gt;
    &lt;oml:measure&gt;kononenko_bratko_information_score&lt;/oml:measure&gt;
    &lt;oml:measure&gt;matthews_correlation_coefficient&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_absolute_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_class_complexity&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_class_complexity_gain&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_f_measure&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_kononenko_bratko_information_score&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_precision&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_prior_absolute_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_prior_class_complexity&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_recall&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_weighted_area_under_roc_curve&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_weighted_f_measure&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_weighted_precision&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_weighted_recall&lt;/oml:measure&gt;
    &lt;oml:measure&gt;number_of_instances&lt;/oml:measure&gt;
    &lt;oml:measure&gt;os_information&lt;/oml:measure&gt;
    &lt;oml:measure&gt;precision&lt;/oml:measure&gt;
    &lt;oml:measure&gt;predictive_accuracy&lt;/oml:measure&gt;
    &lt;oml:measure&gt;prior_class_complexity&lt;/oml:measure&gt;
    &lt;oml:measure&gt;prior_entropy&lt;/oml:measure&gt;
    &lt;oml:measure&gt;ram_hours&lt;/oml:measure&gt;
    &lt;oml:measure&gt;recall&lt;/oml:measure&gt;
    &lt;oml:measure&gt;relative_absolute_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;root_mean_prior_squared_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;root_mean_squared_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;root_relative_squared_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;run_cpu_time&lt;/oml:measure&gt;
    &lt;oml:measure&gt;run_memory&lt;/oml:measure&gt;
    &lt;oml:measure&gt;run_virtual_memory&lt;/oml:measure&gt;
    &lt;oml:measure&gt;scimark_benchmark&lt;/oml:measure&gt;
    &lt;oml:measure&gt;single_point_area_under_roc_curve&lt;/oml:measure&gt;
    &lt;oml:measure&gt;total_cost&lt;/oml:measure&gt;
    &lt;oml:measure&gt;unclassified_instance_count&lt;/oml:measure&gt;
    &lt;oml:measure&gt;webb_bias&lt;/oml:measure&gt;
    &lt;oml:measure&gt;webb_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;webb_variance&lt;/oml:measure&gt;
  &lt;/oml:measures&gt;
&lt;/oml:evaluation_measures&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
None
</div>

<!-- [END] Api function description: openml.evaluation.measures -->  




<!-- [START] Api function description: openml.run.get --> 


<h3 id=openml_run_get>openml.run.get</h3>
<p><i>Returns the details of a specific run</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET run_id</code> (Required)</dt><dd>The id of the run</dd></dl>
</div>
<h5>Schema's</h5>
<div class="bs-callout bs-callout-info">
<h5>openml.run.get</h5>

This XSD schema is applicable for both uploading and downloading run details. <br/>
<a type="button" class="btn btn-primary" href="https://github.com/openml/website/blob/master/openml_OS/views/pages/rest_api/xsd/openml.run.upload.xsd">XSD Schema</a>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:run xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:run_id&gt;1&lt;/oml:run_id&gt;
  &lt;oml:uploader&gt;1&lt;/oml:uploader&gt;
  &lt;oml:task_id&gt;68&lt;/oml:task_id&gt;
  &lt;oml:implementation_id&gt;61&lt;/oml:implementation_id&gt;
  &lt;oml:setup_id&gt;6&lt;/oml:setup_id&gt;
  &lt;oml:setup_string&gt;weka.classifiers.trees.REPTree -- -M 2 -V 0.001 -N 3 -S 1 -L -1 -I 0.0&lt;/oml:setup_string&gt;
  &lt;oml:parameter_setting&gt;
    &lt;oml:name&gt;61_I&lt;/oml:name&gt;
    &lt;oml:value&gt;0.0&lt;/oml:value&gt;
  &lt;/oml:parameter_setting&gt;
  &lt;oml:parameter_setting&gt;
    &lt;oml:name&gt;61_L&lt;/oml:name&gt;
    &lt;oml:value&gt;-1&lt;/oml:value&gt;
  &lt;/oml:parameter_setting&gt;
  &lt;oml:parameter_setting&gt;
    &lt;oml:name&gt;61_M&lt;/oml:name&gt;
    &lt;oml:value&gt;2&lt;/oml:value&gt;
  &lt;/oml:parameter_setting&gt;
  &lt;oml:parameter_setting&gt;
    &lt;oml:name&gt;61_N&lt;/oml:name&gt;
    &lt;oml:value&gt;3&lt;/oml:value&gt;
  &lt;/oml:parameter_setting&gt;
  &lt;oml:parameter_setting&gt;
    &lt;oml:name&gt;61_S&lt;/oml:name&gt;
    &lt;oml:value&gt;1&lt;/oml:value&gt;
  &lt;/oml:parameter_setting&gt;
  &lt;oml:parameter_setting&gt;
    &lt;oml:name&gt;61_V&lt;/oml:name&gt;
    &lt;oml:value&gt;0.001&lt;/oml:value&gt;
  &lt;/oml:parameter_setting&gt;
  &lt;oml:input_data&gt;
    &lt;oml:dataset&gt;
      &lt;oml:did&gt;9&lt;/oml:did&gt;
      &lt;oml:name&gt;autos&lt;/oml:name&gt;
      &lt;oml:url&gt;http://openml.liacs.nl/files/download/9/dataset_9_autos.arff&lt;/oml:url&gt;
    &lt;/oml:dataset&gt;
  &lt;/oml:input_data&gt;
  &lt;oml:output_data&gt;
    &lt;oml:file&gt;
      &lt;oml:did&gt;63&lt;/oml:did&gt;
      &lt;oml:name&gt;description&lt;/oml:name&gt;
      &lt;oml:url&gt;http://openml.liacs.nl/data/download/63/weka_generated_run5258986433356798974.xml&lt;/oml:url&gt;
    &lt;/oml:file&gt;
    &lt;oml:file&gt;
      &lt;oml:did&gt;64&lt;/oml:did&gt;
      &lt;oml:name&gt;predictions&lt;/oml:name&gt;
      &lt;oml:url&gt;http://openml.liacs.nl/data/download/64/weka_generated_predictions5823074444642592781.arff&lt;/oml:url&gt;
    &lt;/oml:file&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;area_under_roc_curve&lt;/oml:name&gt;
      &lt;oml:implementation&gt;4&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.786876&lt;/oml:value&gt;
      &lt;oml:array_data&gt;[�,0.976312,0.861162,0.815581,0.745833,0.756304,0.75239]&lt;/oml:array_data&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;confusion_matrix&lt;/oml:name&gt;
      &lt;oml:implementation&gt;10&lt;/oml:implementation&gt;
      &lt;oml:array_data&gt;[[0,0,0,0,0,0,0],[0,3,135,12,0,0,0],[0,31,698,178,161,18,14],[0,0,160,2464,510,198,18],[0,0,105,886,1398,127,184],[0,0,56,578,317,532,117],[0,0,68,237,440,267,338]]&lt;/oml:array_data&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;f_measure&lt;/oml:name&gt;
      &lt;oml:implementation&gt;12&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.511938&lt;/oml:value&gt;
      &lt;oml:array_data&gt;[0,0.032609,0.601206,0.639585,0.505972,0.388038,0.334488]&lt;/oml:array_data&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;kappa&lt;/oml:name&gt;
      &lt;oml:implementation&gt;13&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.373111&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;kb_relative_information_score&lt;/oml:name&gt;
      &lt;oml:implementation&gt;14&lt;/oml:implementation&gt;
      &lt;oml:value&gt;4242.098053&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;mean_absolute_error&lt;/oml:name&gt;
      &lt;oml:implementation&gt;21&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.149488&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;mean_prior_absolute_error&lt;/oml:name&gt;
      &lt;oml:implementation&gt;27&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.220919&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;number_of_instances&lt;/oml:name&gt;
      &lt;oml:implementation&gt;34&lt;/oml:implementation&gt;
      &lt;oml:value&gt;10250&lt;/oml:value&gt;
      &lt;oml:array_data&gt;[0,150,1100,3350,2700,1600,1350]&lt;/oml:array_data&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;os_information&lt;/oml:name&gt;
      &lt;oml:implementation&gt;53&lt;/oml:implementation&gt;
      &lt;oml:array_data&gt;[ Oracle Corporation, 1.7.0_51, amd64, Linux, 3.7.10-1.28-desktop ]&lt;/oml:array_data&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;precision&lt;/oml:name&gt;
      &lt;oml:implementation&gt;35&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.516877&lt;/oml:value&gt;
      &lt;oml:array_data&gt;[0,0.088235,0.571195,0.565786,0.494692,0.465849,0.503726]&lt;/oml:array_data&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;predictive_accuracy&lt;/oml:name&gt;
      &lt;oml:implementation&gt;36&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.530049&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;prior_entropy&lt;/oml:name&gt;
      &lt;oml:implementation&gt;38&lt;/oml:implementation&gt;
      &lt;oml:value&gt;2.326811&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;recall&lt;/oml:name&gt;
      &lt;oml:implementation&gt;39&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.530049&lt;/oml:value&gt;
      &lt;oml:array_data&gt;[0,0.02,0.634545,0.735522,0.517778,0.3325,0.25037]&lt;/oml:array_data&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;relative_absolute_error&lt;/oml:name&gt;
      &lt;oml:implementation&gt;40&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.676663&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;root_mean_prior_squared_error&lt;/oml:name&gt;
      &lt;oml:implementation&gt;41&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.331758&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;root_mean_squared_error&lt;/oml:name&gt;
      &lt;oml:implementation&gt;42&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.303746&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;root_relative_squared_error&lt;/oml:name&gt;
      &lt;oml:implementation&gt;43&lt;/oml:implementation&gt;
      &lt;oml:value&gt;0.915564&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;scimark_benchmark&lt;/oml:name&gt;
      &lt;oml:implementation&gt;55&lt;/oml:implementation&gt;
      &lt;oml:value&gt;1973.4091512218106&lt;/oml:value&gt;
      &lt;oml:array_data&gt;[ 1262.1133708514062, 1630.9393838458018, 932.0675956790141, 1719.5408190761134, 4322.384586656718 ]&lt;/oml:array_data&gt;
    &lt;/oml:evaluation&gt;
  &lt;/oml:output_data&gt;
&lt;/oml:run&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>220: Please provide run_id</dt><dd>In order to view run details, please provide run_id</dd></dl>
<dl><dt>221: Run not found</dt><dd>The run id was invalid, run not found</dd></dl>
</div>

<!-- [END] Api function description: openml.run.get -->  



<!-- [START] Api function description: openml.run.upload --> 


<h3 id=openml_run_upload>openml.run.upload</h3>
<p><i>Uploads the results of a run to OpenML</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>POST description</code> (Required)</dt><dd>An XML file describing the run</dd></dl>
<dl><dt><code>POST &lt;output_files&gt;</code> (Required)</dt><dd>All output files that should be generated by the run, as described in the task xml. For supervised classification tasks, this is typically a file containing predictions</dd></dl>
<dl><dt><code>POST session_hash</code> (Required)</dt><dd>The session hash, provided by the server on authentication (1 hour valid)</dd></dl>
</div>
<h5>Schema's</h5>
<div class="bs-callout bs-callout-info">
<h5>openml.run.upload</h5>

This XSD schema is applicable for both uploading and downloading run details. <br/>
<a type="button" class="btn btn-primary" href="https://github.com/openml/website/blob/master/openml_OS/views/pages/rest_api/xsd/openml.run.upload.xsd">XSD Schema</a>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>200: Please provide session_hash</dt><dd>In order to share content, please authenticate (openml.authenticate) and provide session_hash</dd></dl>
<dl><dt>201: Authentication failed</dt><dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd></dl>
<dl><dt>202: Please provide run xml</dt><dd>Please provide run xml</dd></dl>
<dl><dt>203: Could not validate run xml by xsd</dt><dd>Please double check that the xml is valid. </dd></dl>
<dl><dt>204: Unknown task</dt><dd>The task with this id was not found in the database</dd></dl>
<dl><dt>205: Unknown implementation</dt><dd>The implementation with this id was not found in the database</dd></dl>
<dl><dt>206: Invalid number of files</dt><dd>The number of uploaded files did not match the number of files expected for this task type</dd></dl>
<dl><dt>207: File upload failed</dt><dd>One of the files uploaded has a problem</dd></dl>
<dl><dt>208: Error inserting setup record</dt><dd>Internal server error, please contact api administrators</dd></dl>
<dl><dt>210: Unable to store run</dt><dd>Internal server error, please contact api administrators</dd></dl>
<dl><dt>211: Dataset not in databse</dt><dd>One of the datasets of this task was not included in database, please contact api administrators</dd></dl>
<dl><dt>212: Unable to store file</dt><dd>Internal server error, please contact api administrators</dd></dl>
<dl><dt>213: Parameter in run xml unknown</dt><dd>One of the parameters provided in the run xml is not registered as parameter for the implementation nor its components</dd></dl>
<dl><dt>214: Unable to store input setting</dt><dd>Internal server error, please contact API support team</dd></dl>
<dl><dt>215: Unable to evaluate predictions</dt><dd>Internal server error, please contact API support team</dd></dl>
<dl><dt>216: Error thrown by Java Application</dt><dd>The Java application has thrown an error. Additional information field is provided</dd></dl>
<dl><dt>217: Error processing output data: unknown or inconsistent evaluation measure</dt><dd>One of the provided evaluation measures could not be matched with a record in the math_function / implementation table.</dd></dl>
<dl><dt>218: Wrong implementation associated with run: this implements a math_function</dt><dd>The implementation implements a math_function, which is unable to generate predictions. Please select another implementation. </dd></dl>
<dl><dt>219: Error reading the XML document</dt><dd>The xml description file could not be verified. </dd></dl>
</div>

<!-- [END] Api function description: openml.run.upload -->  



<!-- [START] Api function description: openml.run.delete --> 


<h3 id=openml_run_delete>openml.run.delete</h3>
<p><i>Deletes a run from the database. </i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>POST run_id</code> (Required)</dt><dd>The id of the run to be deleted</dd></dl>
<dl><dt><code>POST session_hash</code> (Required)</dt><dd>The session hash to be checked</dd></dl>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>390: Please provide session_hash</dt><dd>In order to remove your content, please authenticate (openml.authenticate) and provide session_hash</dd></dl>
<dl><dt>391: Authentication failed</dt><dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd></dl>
<dl><dt>392: Run does not exists</dt><dd>The run id could not be linked to an existing run.</dd></dl>
<dl><dt>393: Run is not owned by you</dt><dd>The run was owned by another user. Hence you cannot delete it.</dd></dl>
<dl><dt>394: Deleting run failed.</dt><dd>Deleting the run failed. Please contact support team. </dd></dl>
</div>

<!-- [END] Api function description: openml.run.delete -->  




<!-- [START] Api function description: openml.job.get --> 


<h3 id=openml_job_get>openml.job.get</h3>
<p><i>Retrieves a job that is scheduled and not yet performed</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>GET workbench</code> (Required)</dt><dd>The name of the workbench that is performing the job</dd></dl>
<dl><dt><code>GET task_type_id</code> (Required)</dt><dd>The task type of which the job should be.</dd></dl>
</div>
<h5>Example Response</h5>
<div class='highlight'>
<pre class='pre-scrollable'>
<code class='html'>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:job xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:learner&gt;weka.classifiers.rules.Ridor -- -F 3 -S 1 -N 2.0&lt;/oml:learner&gt;
  &lt;oml:task_id&gt;1&lt;/oml:task_id&gt;
&lt;/oml:job&gt;

</code>
</pre>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>340: Please provide workbench and task type.</dt><dd>Please provide workbench and task type.</dd></dl>
<dl><dt>341: No jobs available.</dt><dd>There are no jobs that need to be executed.</dd></dl>
</div>

<!-- [END] Api function description: openml.job.get -->  




<!-- [START] Api function description: openml.setup.delete --> 


<h3 id=openml_setup_delete>openml.setup.delete</h3>
<p><i>Removes a setup from the database. Can only be done if no runs are performed on this setup.</i></p>

<h5>Arguments</h5>
<div class="bs-callout">
<dl><dt><code>POST setup_id</code> (Required)</dt><dd>The id of the setup that should be removed</dd></dl>
<dl><dt><code>POST session_hash</code> (Required)</dt><dd>The session hash to be checked</dd></dl>
</div>
<h5>Error codes</h5>
<div class='bs-callout bs-callout-danger'>
<dl><dt>400: Please provide session_hash</dt><dd>In order to remove your content, please authenticate (openml.authenticate) and provide session_hash</dd></dl>
<dl><dt>401: Authentication failed</dt><dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd></dl>
<dl><dt>402: Setup does not exists</dt><dd>The setup id could not be linked to an existing setup.</dd></dl>
<dl><dt>404: Setup is in use by other content (runs, schedules, etc). Can not be deleted</dt><dd>The setup is used in runs. Delete this other content before deleting this setup. </dd></dl>
<dl><dt>405: Deleting setup failed.</dt><dd>Deleting the setup failed. Please contact support team. </dd></dl>
</div>

<!-- [END] Api function description: openml.setup.delete -->  
      </div>
  <div class="bs-docs-section">
        <div class="page-header">
          <h1 id="json-docs">JSON Endpoints</h1>
        </div>
        <p class="lead">OpenML also allows you to retrieve most information in JSON format using a predictable URL scheme. It does not allow you to upload data (yet).</p>

	<h2 id="json_data">Get data</h2>
	<p>Get a JSON description of a dataset with <code>www.openml.org/d/id/json</code> (or add <code>/json</code> to the dataset page's url).</p>
	<p>Example: <a href="d/1/json"><code>www.openml.org/d/1/json</code></a></p>

	<h3 id="json_flow">Get flows</h3>
	<p>Get a JSON description of a flow with <code>www.openml.org/f/id/json</code> (or add <code>/json</code> to the flow page's url).</p>
	<p>Example: <a href="f/100/json"><code>www.openml.org/f/100/json</code></a></p>

	<h3 id="json_task">Get tasks</h3>
	<p>Get a JSON description of a task with <code>www.openml.org/t/id/json</code> (or add <code>/json</code> to the task page's url).</p>
	<p>Example: <a href="t/1/json"><code>www.openml.org/t/1/json</code></a></p>

	<h3 id="json_run">Get runs</h3>
	<p>Get a JSON description of a run with <code>www.openml.org/r/id/json</code> (or add <code>/json</code> to the run page's url).</p>
	<p>Example: <a href="r/1/json"><code>www.openml.org/r/1/json</code></a></p>

	<h3 id="json_sql">Free SQL Queries</h3>
        <div class="bs-callout bs-callout-info" style="padding-top:20px;padding-bottom:20px">
          <p>Whenever the existing API functions do not cover your needs, it is possible to use direct SQL SELECT queries. The result will be returned in JSON format. </p>
          <p>The URL is 
          <div class="codehighlight">
            <pre class="pre-scrollable"><code class="html">http://www.openml.org/api_query/?q=&lt;urlencode(QUERY)&gt;</code></pre>
          </div>
          </p>
          <p>For instance, to request the result of <code>SELECT name,did FROM dataset WHERE name LIKE "iris%"</code>, invoke like this:
          <div class="codehighlight">
            <pre class="pre-scrollable"><code class="html">http://openml.liacs.nl/api_query/?q=SELECT%20name,did%20FROM%20dataset%20WHERE%20name%20LIKE%20%22iris%%22</code></pre>
          </div>
          </p>
          <p>Responses are always in JSON format, also when an error is returned. A typical response would be: 
          <div class="codehighlight">
            <pre class="pre-scrollable"><code class="html">{"status": "SQL was processed: 2 rows selected. ","id": "","time": 0.0020740032196045,"columns": [{"title":"name","datatype":"undefined"},{"title":"did","datatype":"undefined"},{"title":"url","datatype":"undefined"}],"data": [["iris","61","http:\/\/openml.liacs.nl\/files\/download\/61\/dataset_61_iris.arff"],["iris","282","http:\/\/openml.liacs.nl\/files\/download\/49033\/iris.arff"]]}
</code></pre>
          </div>
          <p>Please first consider using regular API functions before using this function. The database structure will likely evolve over time, which may break your code. If you need further API functions, simply let us know, or <a href="https://github.com/openml/OpenML/issues">open a new issue</a>.</p>
        </div>
      </div>


    <!-- end col-md-9 -->
    </div> <!-- end col-10 -->
  </div>
  <!-- end row -->
</div>
<!-- end container -->
