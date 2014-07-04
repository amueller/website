<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1">
    <div class="col-sm-12 col-md-3 searchbar">

      <div class="bs-sidebar">
        <ul class="nav bs-sidenav">
          <li>
            <a href="#dev-start">Get started</a>
            <ul class="nav">
              <li><a href="#dev-code">Latest source code</a></li>
              <li><a href="#dev-clone">Clone or fork via GitHub</a></li>
              <li><a href="#dev-database">Database snapshots</a></li>
              <li><a href="#dev-feature">Feature requests</a></li>
            </ul>
          </li>
          <li>
            <a href="#dev-tutorial">API Tutorial</a>
            <ul class="nav">
              <li><a href="#dev-searchdata">Search datasets</a></li>
              <li><a href="#dev-searchimpl">Search implementations</a></li>
              <li><a href="#dev-searchtask">Search tasks</a></li>
              <li><a href="#dev-searchresult">Search results</a></li>
              <li><a href="#dev-getdata">Download a dataset</a></li>
              <li><a href="#dev-getimpl">Download an implementation</a></li>
              <li><a href="#dev-gettask">Download a task</a></li>
              <li><a href="#dev-setdata">Upload a dataset</a></li>
              <li><a href="#dev-setimpl">Upload an implementation</a></li>
              <li><a href="#dev-setrun">Upload a run</a></li>
            </ul>
          </li>
          <li>
            <a href="#dev-docs">API Documentation</a>
            <ul class="nav">
              <li><a href="#openml_authenticate">openml.authenticate</a></li>
              <li><a href="#openml_data_description">openml.data.description</a></li>
              <li><a href="#openml_data_features">openml.data.features</a></li>
              <li><a href="#openml_data_licences">openml.data.licences</a></li>
              <li><a href="#openml_data_upload">openml.data.upload</a></li>
              <li><a href="#openml_tasks_types">openml.tasks.types</a></li>
              <li><a href="#openml_tasks_type_search">openml.tasks.type.search</a></li>
              <li><a href="#openml_tasks_search">openml.tasks.search</a></li>
              <li><a href="#openml_implementation_licences">openml.implementation.licences</a></li>
              <li><a href="#openml_implementation_upload">openml.implementation.upload</a></li>
              <li><a href="#openml_implementation_get">openml.implementation.get</a></li>
              <li><a href="#openml_evaluation_measures">openml.evaluation.measures</a></li>
              <li><a href="#openml_evaluation_methods">openml.evaluation.methods</a></li>
              <li><a href="#openml_run_upload">openml.run.upload</a></li>
              <li><a href="#openml_run_get">openml.run.get</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div> <!-- end col-2 -->

    <div class="col-sm-12 col-md-9 openmlsectioninfo">
      <div class="bs-docs-section">
        <div class="page-header">
          <h1 id="dev-start">Get started</h1>
        </div>
	OpenML is an open source project, <a href="https://github.com/organizations/openml">hosted on GitHub</a>. We welcome everybody to help improve OpenML, and make it more useful for everyone. OpenML is divided into several modules, each run by a <a href="https://github.com/organizations/openml/teams">team of enthousiastic and wonderful people</a>. Join us.

        <h2 id="dev-code">OpenML Core</h2>
        <p>The Core contains everything done by the OpenML server. This includes the API services, but also functions such as model evaluation and dataset characterisation. Join the team or fork us on GitHub and improve OpenML with great new features.</p>
        <a href="https://github.com/openml/OpenML" class="btn btn-primary"><i class="fa fa-github fa-lg"></i> OpenML Core</a>

        <h2 id="dev-code">Client APIs</h2>
        <p>Several APIs are (being) built to connect to OpenML directly from your code. They talk to the server and make all services available as language-specific functions. Several programming language are already supported, such as <a href="plugins/#java">Java</a> and <a href="plugins/#r">R</a>, but more are needed. Join a team or fork us to work on an existing API, or start your own.</p>
        <a href="https://github.com/openml/java" class="btn btn-primary"><i class="fa fa-github fa-lg"></i> Java API</a>
        <a href="https://github.com/openml/r" class="btn btn-primary"><i class="fa fa-github fa-lg"></i> R API</a>

        <h2 id="dev-code">OpenML Plugins</h2>
        <p>OpenML is even directly integrated in several machine learning environments, so you can use it from your favourite tools.</p>

        <a href="https://github.com/openml/weka" class="btn btn-primary"><i class="fa fa-github fa-lg"></i> Weka plugin</a>
        <a href="https://github.com/openml/java" class="btn btn-primary"><i class="fa fa-github fa-lg"></i> MOA plugin</a>
        <a href="https://github.com/openml/r" class="btn btn-primary"><i class="fa fa-github fa-lg"></i> mlr plugin</a>

        <h3 id="dev-database">Database snapshots</h3>
        <p>Everything uploaded to OpenML is available to the community. The snapshot of the public database contains all experiment runs, evaluations and links to datasets, implementations and result files. In SQL format (gzipped).</p>

        <a href="downloads/ExpDB_SNAPSHOT.sql.gz" class="btn btn-primary"><i class="fa fa-cloud-download fa-lg"></i> Download public database</a>

        <h3 id="dev-database">Your own OpenML instance</h3>
	If, for any reason, you want to set up your own instance of OpenML, you will need some additional resources, such as a second (private) database which 
	contains all user data. This database contains the table structure and important records, like usergroups. More details on setting up your own instance are available in the <a href="https://github.com/openml/OpenML/wiki"> GitHub Wiki</a>.</p>

        <a href="downloads/openml.sql.gz" class="btn btn-primary"><i class="fa fa-cloud-download fa-lg"></i> Download private database</a>

        <h3 id="dev-feature">Feature requests</h3>
        <p>Feature request, as well as issues, can be posted in the <a href="community">community discussions</a>, or by directly opening an issue in our <a href="https://github.com/openml/OpenML/issues?state=open">GitHub project</a>.</p>
      </div>
      <div class="bs-docs-section">
        <div class="page-header">
          <h1 id="dev-tutorial">API Tutorial</h1>
        </div>
        <p class="lead">An overview of the most common use cases with working examples and links to the full documentation of the services involved.</p>
        <h2 id="dev-getdata">Download a dataset</h2>
        <img src="img/api_get_dataset.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User asks for a dataset using the <a href="developers#openml_data_description">openml.data.description</a> service and a <code>dataset id</code>. The <code>dataset id</code> is typically part of a task, or returned when <a href="developers#dev-searchdata">searching for datasets</a>.</li>
          <li>OpenML returns a description of the dataset as an XML file. <a href="http://www.openml.org/api/?f=openml.data.description&amp;data_id=1" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>The dataset description contains the URL where the dataset can be downloaded. The user calls that URL to download the dataset.</li>
          <li>The dataset is returned by the server hosting the dataset. This can be OpenML, but also any other data repository. <a href="http://expdb.cs.kuleuven.be/expdb/data/uci/nominal/anneal.arff" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="developers#openml_data_description">openml.data.description</a></li>
        </ul>
        <h3 id="dev-getimpl">Download an implementation</h3>
        <img src="img/api_get_implementation.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User asks for an implementation using the <a href="developers#openml_implementation_get">openml.implementation.get</a> service and a <code>implementation id</code>. The <code>implementation id</code> is typically returned when <a href="developers#dev-searchimpl">searching for implementations</a>.</li>
          <li>OpenML returns a description of the implementation as an XML file. <a href="http://www.openml.org/api/?f=openml.implementation.get&amp;implementation_id=weka.J48(1.2)" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>The implementation description contains the URL where the implementation can be downloaded, either as source, binary or both, as well as additional information on history, dependencies and licence. The user calls the right URL to download it.</li>
          <li>The implementation is returned by the server hosting it. This can be OpenML, but also any other code repository. <a href="http://sourceforge.net/projects/weka/files/weka-3-4/3.4.8/weka-3-4-8a.zip/download" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="developers#openml_implementation_get">openml.implementation.get</a></li>
        </ul>
        <h3 id="dev-gettask">Download a task</h3>
        <img src="img/api_get_task.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User asks for a task using the <a href="developers#openml_tasks_search">openml.tasks.search</a> service and a <code>task id</code>. The <code>task id</code> is typically returned when <a href="developers#dev-searchtask">searching for tasks</a>.</li>
          <li>OpenML returns a description of the task as an XML file. <a href="http://www.openml.org/api/?f=openml.tasks.search&amp;task_id=1" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>The task description contains the <code>dataset id</code>(s) of the datasets involved in this task. The user asks for the dataset using the <a href="developers#openml_data_description">openml.data.description</a> service and the <code>dataset id</code>.</li>
          <li>OpenML returns a description of the dataset as an XML file. <a href="http://www.openml.org/api/?f=openml.data.description&amp;data_id=61" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>The dataset description contains the URL where the dataset can be downloaded. The user calls that URL to download the dataset.</li>
          <li>The dataset is returned by the server hosting it. This can be OpenML, but also any other data repository. <a href="http://expdb.cs.kuleuven.be/expdb/data/uci/nominal/iris.arff" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>(Optional) The task description may also contain links to other resources, such as the train-test splits to be used in cross-validation. The user calls that URL to download the train-test splits.</li>
          <li>(Optional) The train-test splits are returned by OpenML. <a href="http://expdb.cs.kuleuven.be/expdb/data/splits/iris_splits_CV_10_2.arff" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="developers#openml_tasks_search">openml.tasks.search</a></li>
          <li><a href="developers#openml_data_description">openml.data.description</a></li>
        </ul>
        <h3 id="dev-setdata">Upload a dataset</h3>
        <img src="img/api_upload_data.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User authenticates herself by calling <a href="developers#openml_authenticate">openml.authenticate</a> with her <code>username</code> and (hashed) <code>password</code>. OpenML will return an authentication <code>session token</code>.</li>
          <li>The user uploads the <code>dataset</code> together a <code>dataset description</code> and her <code>session token</code> to <a href="developers#openml_data_upload">openml.data.upload</a>. The dataset description is an XML file that contains at least the dataset name and a textual description. For now, the only truly supported dataset format is ARFF.</li>
          <li>OpenML stores the uploaded dataset and returns the registered <code>dataset id</code>.</li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="developers#openml_authenticate">openml.authenticate</a></li>
          <li><a href="developers#openml_data_upload">openml.data.upload</a></li>
        </ul>
        <h3 id="dev-setimpl">Upload an implementation</h3>
        <img src="img/api_upload_implementation.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User authenticates herself by calling <a href="developers#openml_authenticate">openml.authenticate</a> with her <code>username</code> and (hashed) <code>password</code>. OpenML will return an authentication <code>session token</code>.</li>
          <li>The user uploads her <code>session token</code>, <code>implementation description</code>, the <code>implementation binary</code> and/or the <code>implementation source</code> to <a href="developers#openml_implementation_upload">openml.implementation.upload</a>. The implementation description is an XML file that contains at least the implementation name and a textual description. The implementation binary and source will typically be a ZIP file. An implementation can be a single algorithm or a composed workflow.</li>
          <li>OpenML stores the uploaded implementation and returns the registered <code>implementation id</code>.</li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="developers#openml_authenticate">openml.authenticate</a></li>
          <li><a href="developers#openml_implementation_upload">openml.implementation.upload</a></li>
        </ul>
        <h3 id="dev-setrun">Upload a run</h3>
        <img src="img/api_upload_run.png" style="display: block;margin-left:auto;margin-right:auto;width:480px;padding:10px">
        <ol>
          <li>User authenticates herself by calling <a href="developers#openml_authenticate">openml.authenticate</a> with her <code>username</code> and (hashed) <code>password</code>. OpenML will return an authentication <code>session token</code>.</li>
          <li>The user uploads a <code>run description</code> and any <code>run result</code> files together with her <code>session token</code> to <a href="developers#openml_run_upload">openml.run.upload</a>. The run description is an XML file that contains the <code>task id</code> of the task it addresses and (optionally) a list of parameter settings if these differ from the default settings in the used implementation. The run result files contain the results of the run as detailed in the corresponding task description.</li>
          <li>OpenML stores the uploaded run and its results and returns a task-specific response. This can include, for instance, evaluations computed by the server based on uploaded predictions.</li>
        </ol>
        <h5>Services:</h5>
        <ul>
          <li><a href="developers#openml_authenticate">openml.authenticate</a></li>
          <li><a href="developers#openml_run_upload">openml.run.upload</a></li>
        </ul>
      </div>
      <div class="bs-docs-section">
        <div class="page-header">
          <h1 id="dev-docs">API Documentation</h1>
        </div>
        <p class="lead">Details of all OpenML services, with their expected arguments, file formats, responses and error codes.</p>
        <div class="bs-callout bs-callout-info" style="padding-top:20px;padding-bottom:20px">
          <h4>Using REST services</h4>
          <p>REST is the simplest request format to use - it's a simple HTTP GET or POST action.</p>
          <p>The REST Endpoint URL is 
          <div class="highlight">
            <pre class="pre-scrollable"><code class="html">http://www.openml.org/api/</code></pre>
          </div>
          </p>
          <p>For instance, to request the <code>openml.data.description</code> service, invoke like this:
          <div class="highlight">
            <pre class="pre-scrollable"><code class="html">http://www.openml.org/api/?f=openml.data.description&data_id=1</code></pre>
          </div>
          </p>
          <p>Responses are always in XML format, also when an error is returned. Error messages will look like this:
          <div class="highlight">
            <pre class="pre-scrollable"><code class="html">&lt;oml:error xmlns:oml="http://openml.org/error"&gt;
  &lt;oml:code&gt;100&lt;/oml:code&gt;
  &lt;oml:message&gt;Please invoke legal function&lt;/oml:message&gt;
  &lt;oml:additional_information&gt;Additional information, not always available. &lt;/oml:additional_information&gt;
&lt;/oml:error&gt;
</code></pre>
          </div>
          <p>The error codes and messages for each service are listed below.</p>
        </div>
        <h3 id="openml_authenticate">openml.authenticate</h3>
        <p><i>Returns a session_hash, which can be used for writing to the API.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          <dl>
            <dt><code>POST username</code> (Required)</dt>
            <dd>The username to be authenticated with</dd>
          </dl>
          <dl>
            <dt><code>POST password</code> (Required)</dt>
            <dd>An md5 hash of the password, corresponding to the username</dd>
          </dl>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:authenticate xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:session_hash&gt;CYWJBLVYIPQ42IGB1NHSTGP181Y4TQIWE45GGQ4P&lt;/oml:session_hash&gt;
  &lt;oml:valid_until&gt;2020-01-01 00:00:00&lt;/oml:valid_until&gt;
&lt;/oml:authenticate&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          <dl>
            <dt>250: Please provide username</dt>
            <dd>Please provide the username as a POST variable</dd>
          </dl>
          <dl>
            <dt>251: Please provide password</dt>
            <dd>Please provide the password (hashed as a MD5) as a POST variable</dd>
          </dl>
          <dl>
            <dt>252: Authentication failed</dt>
            <dd>The username and password did not match any record in the database. Please note that the password should be hashed using md5</dd>
          </dl>
        </div>
        <h3 id="openml_data_description">openml.data.description</h3>
        <p><i>Returns dataset descriptions in XML</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          <dl>
            <dt><code>GET data_id</code> (Required)</dt>
            <dd>The dataset id</dd>
          </dl>
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Dataset description file (XML)</h5>
          <p>Contains a URL where the dataset can be downloaded, as well as additional information on history, format and licence.</p>
          <a type="button" class="btn btn-primary" href="rest_api/xsd/openml.data.upload">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:data_set_description xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:id&gt;1&lt;/oml:id&gt;
  &lt;oml:name&gt;anneal&lt;/oml:name&gt;
  &lt;oml:version&gt;1.0&lt;/oml:version&gt;
  &lt;oml:description&gt;...&lt;/oml:description&gt;
  &lt;oml:format&gt;ARFF&lt;/oml:format&gt;
  &lt;oml:upload_date&gt;2013-02-26 16:20:57&lt;/oml:upload_date&gt;
  &lt;oml:licence&gt;public domain&lt;/oml:licence&gt;
  &lt;oml:url&gt;http://expdb.cs.kuleuven.be/expdb/data/uci/nominal/anneal.arff&lt;/oml:url&gt;
  &lt;oml:md5_checksum&gt;08dc9d6bf8e5196de0d56bfc89631931&lt;/oml:md5_checksum&gt;
&lt;oml:data_set_description&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          <dl>
            <dt>110: Please provide data_id</dt>
            <dd>Please provide data_id</dd>
          </dl>
          <dl>
            <dt>111: Unknown dataset</dt>
            <dd>Data set description with data_id was not found in the database</dd>
          </dl>
        </div>
        <h3 id="openml_data_features">openml.data.features</h3>
        <p><i>Returns the features (attributes) of a given dataset</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          <dl>
            <dt><code>GET data_id</code> (Required)</dt>
            <dd>The dataset id</dd>
          </dl>
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Dataset features (XML)</h5>
          <p>Contains a list of the dataset features (attributes), including index (ordering) and data type.</p>
          <a type="button" class="btn btn-primary disabled" href="https://raw.github.com/joaquinvanschoren/OpenML/master/XML/Schemas/data_features.xsd">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:data_set_features xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:data_set&gt;
    &lt;oml:id&gt;61&lt;/oml:id&gt;
    &lt;oml:name&gt;iris&lt;/oml:name&gt;
  &lt;/oml:data_set&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;sepallength&lt;/oml:name&gt;
    &lt;oml:data_type&gt;numeric&lt;/oml:data_type&gt;
    &lt;oml:index&gt;0&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;sepalwidth&lt;/oml:name&gt;
    &lt;oml:data_type&gt;numeric&lt;/oml:data_type&gt;
    &lt;oml:index&gt;1&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;petallength&lt;/oml:name&gt;
    &lt;oml:data_type&gt;numeric&lt;/oml:data_type&gt;
    &lt;oml:index&gt;2&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;petalwidth&lt;/oml:name&gt;
    &lt;oml:data_type&gt;numeric&lt;/oml:data_type&gt;
    &lt;oml:index&gt;3&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
  &lt;oml:feature&gt;
    &lt;oml:name&gt;class&lt;/oml:name&gt;
    &lt;oml:data_type&gt;nominal&lt;/oml:data_type&gt;
    &lt;oml:index&gt;4&lt;/oml:index&gt;
  &lt;/oml:feature&gt;
&lt;/oml:data_set_features&gt;</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          <dl>
            <dt>270: Please provide data_id</dt>
            <dd>Please provide data_id</dd>
          </dl>
          <dl>
            <dt>271: Unknown dataset</dt>
            <dd>Data set description with data_id was not found in the database</dd>
          </dl>
          <dl>
            <dt>272: No features found</dt>
            <dd>The registered dataset did not contain any features</dd>
          </dl>
        </div>
        <h3 id="openml_data_licences">openml.data.licences</h3>
        <p><i>Returns a list of known data licences.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          None
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Dataset licences (XML)</h5>
          <p>List of known dataset licences.</p>
          <a type="button" class="btn btn-primary disabled" href="https://raw.github.com/joaquinvanschoren/OpenML/master/XML/Schemas/data_features.xsd">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:data_licences xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:licences&gt;
    &lt;oml:licence&gt;public domain&lt;/oml:licence&gt;
  &lt;/oml:licences&gt;
&lt;/oml:data_licences&gt;</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          None
        </div>
        <h3 id="openml_data_upload">openml.data.upload</h3>
        <p><i>Uploads and registers new datasets.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          <dl>
            <dt><code>POST description</code> (Required)</dt>
            <dd>An XML file containing the data set description</dd>
          </dl>
          <dl>
            <dt><code>POST dataset</code> (Required)</dt>
            <dd>The dataset file to be stored on the server</dd>
          </dl>
          <dl>
            <dt><code>POST session_hash</code> (Required)</dt>
            <dd>The session hash, provided by the server on authentication (1 hour valid)</dd>
          </dl>
        </div>
        <h5>Required file</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Dataset description (XML)</h5>
          <p>Description of the uploaded dataset. Should contain at least name and a textual description, but can also contain versioning, creator, format and licensing information.</p>
          <a type="button" class="btn btn-primary" href="rest_api/xsd/openml.data.upload">XSD Schema</a>
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Uploaded dataset (XML)</h5>
          <p>The id of the stored dataset.</p>
          <a type="button" class="btn btn-primary disabled" href="https://raw.github.com/joaquinvanschoren/OpenML/master/XML/Schemas/upload_data_set.xsd">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:upload_data_set xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:id&gt;719294&lt;/oml:id&gt;
&lt;/oml:upload_data_set&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          <dl>
            <dt>130: Problem with file uploading</dt>
            <dd>There was a problem with the file upload</dd>
          </dl>
          <dl>
            <dt>131: Problem validating uploaded description file</dt>
            <dd>The XML description format does not meet the standards</dd>
          </dl>
          <dl>
            <dt>132: Failed to move the files</dt>
            <dd>Internal server error, please contact api administrators</dd>
          </dl>
          <dl>
            <dt>133: Failed to make checksum of datafile</dt>
            <dd>Internal server error, please contact api administrators</dd>
          </dl>
          <dl>
            <dt>134: Failed to insert record in database</dt>
            <dd>Internal server error, please contact api administrators</dd>
          </dl>
          <dl>
            <dt>135: Please provide description xml</dt>
            <dd>Please provide description xml</dd>
          </dl>
          <dl>
            <dt>136: Error slot open</dt>
            <dd>Error slot open, will be filled by not yet defined error</dd>
          </dl>
          <dl>
            <dt>137: Please provide session_hash</dt>
            <dd>In order to share content, please authenticate (openml.authenticate) and provide session_hash</dd>
          </dl>
          <dl>
            <dt>138: Authentication failed</dt>
            <dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd>
          </dl>
          <dl>
            <dt>139: Combination name / version already exists</dt>
            <dd>The combination of name and version of this dataset already exists. Leave version out for auto increment</dd>
          </dl>
          <dl>
            <dt>140: Both dataset file and dataset url provided. Please provide only one</dt>
            <dd>The system is confused since both a dataset file (post) and a dataset url (xml) are provided. Please remove one</dd>
          </dl>
          <dl>
            <dt>141: Neither dataset file or dataset url are provided</dt>
            <dd>Please provide either a dataset file as POST variable, xor a dataset url in the description XML</dd>
          </dl>
        </div>
        <h3 id="openml_tasks_types">openml.tasks.types</h3>
        <p><i>Returns a list of known machine learning task types.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          None
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Task types (XML)</h5>
          <p>A list of available task types with name and description.</p>
          <a type="button" class="btn btn-primary disabled" href="https://raw.github.com/joaquinvanschoren/OpenML/master/XML/Schemas/task_types.xsd">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:task_types xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:task_type&gt;
    &lt;oml:id&gt;1&lt;/oml:id&gt;
    &lt;oml:name&gt;Supervised Classification&lt;/oml:name&gt;
    &lt;oml:description&gt;Given a dataset with a classification target and a set of train/test splits, e.g. generated by a cross-validation procedure, train a model and return the predictions of that model.&lt;/oml:description&gt;
    &lt;oml:creator&gt;Joaquin Vanschoren&lt;/oml:creator&gt;
  &lt;/oml:task_type&gt;
  &lt;oml:task_type&gt;
    &lt;oml:id&gt;2&lt;/oml:id&gt;
    &lt;oml:name&gt;Supervised Regression&lt;/oml:name&gt;
    &lt;oml:description&gt;Given a dataset with a numeric target and a set of train/test splits, e.g. generated by a cross-validation procedure, train a model and return the predictions of that model.&lt;/oml:description&gt;
    &lt;oml:creator&gt;Joaquin Vanschoren&lt;/oml:creator&gt;
  &lt;/oml:task_type&gt;
&lt;/oml:task_types&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          None
        </div>
        <h3 id="openml_tasks_type_search">openml.tasks.type.search</h3>
        <p><i>Returns a definition (template) of a certain task type.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          <dl>
            <dt><code>GET task_type_id</code> (Required)</dt>
            <dd>The task type id</dd>
          </dl>
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Task types (XML)</h5>
          <p>A list of available task types with name and description.</p>
          <a type="button" class="btn btn-primary disabled" href="https://raw.github.com/joaquinvanschoren/OpenML/master/XML/Schemas/task_types.xsd">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:task_type xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:id&gt;1&lt;/oml:id&gt;
  &lt;oml:name&gt;Supervised Classification&lt;/oml:name&gt;
  &lt;oml:description&gt;Given a dataset with a classification target and a set of train/test splits, e.g. generated by a cross-validation procedure, train a model and return the predictions of that model.&lt;/oml:description&gt;
  &lt;oml:creator&gt;Joaquin Vanschoren&lt;/oml:creator&gt;
  &lt;oml:contributor&gt;Jan van Rijn&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt;Bo Gao&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt;Simon Fischer&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt;Venkatesh Umaashankar&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt;Luis Torgo&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt;Bernd Bischl&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt;Michael Berthold&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt;Bernd Wiswedel&lt;/oml:contributor&gt;
  &lt;oml:contributor&gt;Patrick Winter&lt;/oml:contributor&gt;
  &lt;oml:date&gt;21-01-2013&lt;/oml:date&gt;
  &lt;oml:input name="source_data"&gt;
    &lt;oml:description&gt;The source data used to evaluate the model&lt;/oml:description&gt;
    &lt;oml:data_set&gt;
      &lt;oml:data_set_id&gt;input:1&lt;/oml:data_set_id&gt;
      &lt;oml:target_feature&gt;input:2&lt;/oml:target_feature&gt;
    &lt;/oml:data_set&gt;
  &lt;/oml:input&gt;
  &lt;oml:input name="estimation_procedure"&gt;
    &lt;oml:description&gt;The evaluation procedure used to evaluate the model&lt;/oml:description&gt;
    &lt;oml:estimation_procedure&gt;
      &lt;oml:type&gt;input:3&lt;/oml:type&gt;
      &lt;oml:data_splits_url&gt;input:4&lt;/oml:data_splits_url&gt;
      &lt;oml:parameter name="number_folds"&gt;input:6&lt;/oml:parameter&gt;
      &lt;oml:parameter name="number_repeats"&gt;input:5&lt;/oml:parameter&gt;
      &lt;oml:parameter name="stratified_sampling"&gt;true&lt;/oml:parameter&gt;
    &lt;/oml:estimation_procedure&gt;
  &lt;/oml:input&gt;
  &lt;oml:input name="evaluation_measures"&gt;
    &lt;oml:description&gt;Optional. A list of evaluation measures to optimize for&lt;/oml:description&gt;
    &lt;oml:evaluation_measures&gt;input:8&lt;/oml:evaluation_measures&gt;
  &lt;/oml:input&gt;
  &lt;oml:output name="predictions"&gt;
    &lt;oml:description&gt;The predictions returned by your implementation.&lt;/oml:description&gt;
    &lt;oml:predictions&gt;
      &lt;oml:format&gt;ARFF&lt;/oml:format&gt;
      &lt;oml:feature name="confidence.classname" type="numeric"/&gt;
      &lt;oml:feature name="fold" type="integer"/&gt;
      &lt;oml:feature name="prediction" type="string"/&gt;
      &lt;oml:feature name="repeat" type="integer"/&gt;
      &lt;oml:feature name="row_id" type="integer"/&gt;
    &lt;/oml:predictions&gt;
  &lt;/oml:output&gt;
&lt;/oml:task_type&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          <dl>
            <dt>240: Please provide task_type_id</dt>
            <dd>Please provide task_type_id</dd>
          </dl>
          <dl>
            <dt>241: Unknown task type</dt>
            <dd>The task type with this id was not found in the database</dd>
          </dl>
        </div>
        <h3 id="openml_tasks_search">openml.tasks.search</h3>
        <p><i>Returns tasks in XML.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          <dl>
            <dt><code>GET task_id</code> (Required)</dt>
            <dd>The task id</dd>
          </dl>
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Task description (XML)</h5>
          <p>A task description defines exactly the input data needed to solve the task, and what output data should be returned.</p>
          <a type="button" class="btn btn-primary" href="https://raw.github.com/joaquinvanschoren/OpenML/master/XML/Schemas/task.xsd">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:task xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:task_id&gt;1&lt;/oml:task_id&gt;
  &lt;oml:task_type&gt;Supervised Classification&lt;/oml:task_type&gt;
  &lt;oml:input name="source_data"&gt;
    &lt;oml:data_set&gt;
      &lt;oml:data_set_id&gt;61&lt;/oml:data_set_id&gt;
      &lt;oml:target_feature&gt;class&lt;/oml:target_feature&gt;
    &lt;/oml:data_set&gt;
  &lt;/oml:input&gt;
  &lt;oml:input name="estimation_procedure"&gt;
    &lt;oml:estimation_procedure&gt;
      &lt;oml:type&gt;cross_validation&lt;/oml:type&gt;
      &lt;oml:data_splits_url&gt;http://expdb.cs.kuleuven.be/expdb/data/splits/iris_splits_CV_10_2.arff&lt;/oml:data_splits_url&gt;
      &lt;oml:parameter name="number_folds"&gt;10&lt;/oml:parameter&gt;
      &lt;oml:parameter name="number_repeats"&gt;2&lt;/oml:parameter&gt;
      &lt;oml:parameter name="stratified_sampling"&gt;true&lt;/oml:parameter&gt;
    &lt;/oml:estimation_procedure&gt;
  &lt;/oml:input&gt;
  &lt;oml:input name="evaluation_measures"&gt;
    &lt;oml:evaluation_measures&gt;
      &lt;oml:evaluation_measure&gt;predictive_accuracy&lt;/oml:evaluation_measure&gt;
    &lt;/oml:evaluation_measures&gt;
  &lt;/oml:input&gt;
  &lt;oml:output name="predictions"&gt;
    &lt;oml:predictions&gt;
      &lt;oml:format&gt;ARFF&lt;/oml:format&gt;
      &lt;oml:feature name="confidence.classname" type="numeric"/&gt;
      &lt;oml:feature name="fold" type="integer"/&gt;
      &lt;oml:feature name="prediction" type="string"/&gt;
      &lt;oml:feature name="repeat" type="integer"/&gt;
      &lt;oml:feature name="row_id" type="integer"/&gt;
    &lt;/oml:predictions&gt;
  &lt;/oml:output&gt;
&lt;/oml:task&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          <dl>
            <dt>150: Please provide task_id</dt>
            <dd>Please provide task_id</dd>
          </dl>
          <dl>
            <dt>151: Unknown task</dt>
            <dd>The task with this id was not found in the database</dd>
          </dl>
        </div>
        <h3 id="openml_implementation_licences">openml.implementation.licences</h3>
        <p><i>Returns a list of known implementation licences.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          None
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:implementation_licences xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:licences/&gt;
&lt;/oml:implementation_licences&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          None
        </div>
        <h3 id="openml_implementation_upload">openml.implementation.upload</h3>
        <p><i>Uploads and registers new implementations.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          <dl>
            <dt><code>POST description</code> (Required)</dt>
            <dd>An XML file containing the implementation meta data</dd>
          </dl>
          <dl>
            <dt><code>POST source</code></dt>
            <dd>The source code of the implementation. If multiple files, please zip them. Either source or binary is required.</dd>
          </dl>
          <dl>
            <dt><code>POST binary</code></dt>
            <dd>The binary of the implementation. If multiple files, please zip them. Either source or binary is required.</dd>
          </dl>
          <dl>
            <dt><code>POST session_hash</code> (Required)</dt>
            <dd>The session hash, provided by the server on authentication (1 hour valid)</dd>
          </dl>
        </div>
        <h5>Required file</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Implementation description (XML)</h5>
          <p>Description of the implementation. Should at least contain a name and textual description, but can also contain versioning, creator, format and licensing information.</p>
          <a type="button" class="btn btn-primary" href="rest_api/xsd/openml.implementation.upload">XSD Schema</a>
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Uploaded implementation (XML)</h5>
          <p>The id of the registered implementation.</p>
          <a type="button" class="btn btn-primary disabled" href="https://raw.github.com/joaquinvanschoren/OpenML/master/XML/Schemas/implementation_id.xsd">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:upload_implementation xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:id&gt;knime.janvanrijn.solveTaskA_1.5.10&lt;/oml:id&gt;
&lt;/oml:upload_implementation&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          <dl>
            <dt>160: Error in file uploading</dt>
            <dd>There was a problem with the file upload</dd>
          </dl>
          <dl>
            <dt>161: Please provide description xml</dt>
            <dd>Please provide description xml</dd>
          </dl>
          <dl>
            <dt>162: Please provide source or binary file</dt>
            <dd>Please provide source or binary file. It is also allowed to upload both</dd>
          </dl>
          <dl>
            <dt>163: Problem validating uploaded description file</dt>
            <dd>The XML description format does not meet the standards</dd>
          </dl>
          <dl>
            <dt>164: Implementation already stored in database</dt>
            <dd>Please change name or version number</dd>
          </dl>
          <dl>
            <dt>165: Failed to move the files</dt>
            <dd>Internal server error, please contact api administrators</dd>
          </dl>
          <dl>
            <dt>166: Failed to add implementation to database</dt>
            <dd>Internal server error, please contact api administrators</dd>
          </dl>
          <dl>
            <dt>167: Illegal files uploaded</dt>
            <dd>An non required file was uploaded.</dd>
          </dl>
          <dl>
            <dt>168: The provided md5 hash equals not the server generated md5 hash of the file</dt>
            <dd>The provided md5 hash equals not the server generated md5 hash of the file</dd>
          </dl>
          <dl>
            <dt>169: Please provide session_hash</dt>
            <dd>In order to share content, please authenticate (openml.authenticate) and provide session_hash</dd>
          </dl>
          <dl>
            <dt>170: Authentication failed</dt>
            <dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd>
          </dl>
        </div>
        <h3 id="openml_implementation_get">openml.implementation.get</h3>
        <p><i>Returns the description file of an implementation.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          <dl>
            <dt><code>GET implementation_id</code> (Required)</dt>
            <dd>The implementation id (typically: name_version)</dd>
          </dl>
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Implementation description (XML)</h5>
          <p>An implementation has a URL where it can be downloaded, either as source, binary or both, as well as additional information on history, dependencies and licence.</p>
          <a type="button" class="btn btn-primary" href="rest_api/xsd/openml.implementation.upload">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:error xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:code&gt;181&lt;/oml:code&gt;
  &lt;oml:message&gt;Unknown implementation&lt;/oml:message&gt;
&lt;/oml:error&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          <dl>
            <dt>180: Please provide implementation_id</dt>
            <dd>Please provide implementation_id</dd>
          </dl>
          <dl>
            <dt>181: Unknown implementation</dt>
            <dd>The implementation with this ID was not found in the database</dd>
          </dl>
        </div>
        <h3 id="openml_evaluation_measures">openml.evaluation.measures</h3>
        <p><i>Returns a list of supported evaluation measures.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          None
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:evaluation_measures xmlns:oml="http://openml.org/openml"&gt;
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
    &lt;oml:measure&gt;mean_area_under_roc_curve&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_class_complexity&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_class_complexity_gain&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_f_measure&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_kononenko_bratko_information_score&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_precision&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_prior_absolute_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_prior_class_complexity&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_recall&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_weighted_f_measure&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_weighted_precision&lt;/oml:measure&gt;
    &lt;oml:measure&gt;mean_weighted_recall&lt;/oml:measure&gt;
    &lt;oml:measure&gt;precision&lt;/oml:measure&gt;
    &lt;oml:measure&gt;predictive_accuracy&lt;/oml:measure&gt;
    &lt;oml:measure&gt;prior_class_complexity&lt;/oml:measure&gt;
    &lt;oml:measure&gt;prior_entropy&lt;/oml:measure&gt;
    &lt;oml:measure&gt;recall&lt;/oml:measure&gt;
    &lt;oml:measure&gt;relative_absolute_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;root_mean_prior_squared_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;root_mean_squared_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;root_relative_squared_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;run_cpu_time&lt;/oml:measure&gt;
    &lt;oml:measure&gt;run_memory&lt;/oml:measure&gt;
    &lt;oml:measure&gt;run_virtual_memory&lt;/oml:measure&gt;
    &lt;oml:measure&gt;single_point_area_under_roc_curve&lt;/oml:measure&gt;
    &lt;oml:measure&gt;total_cost&lt;/oml:measure&gt;
    &lt;oml:measure&gt;unclassified_instance_count&lt;/oml:measure&gt;
    &lt;oml:measure&gt;webb_bias&lt;/oml:measure&gt;
    &lt;oml:measure&gt;webb_error&lt;/oml:measure&gt;
    &lt;oml:measure&gt;webb_variance&lt;/oml:measure&gt;
  &lt;/oml:measures&gt;
&lt;/oml:evaluation_measures&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          None
        </div>
        <h3 id="openml_evaluation_methods">openml.evaluation.methods</h3>
        <p><i>Returns a list of supported evaluation methods.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          None
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:evaluation_methods xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:methods&gt;
    &lt;oml:method&gt;
      &lt;oml:type&gt;cross_validation&lt;/oml:type&gt;
      &lt;oml:folds&gt;undefined&lt;/oml:folds&gt;
      &lt;oml:repeats&gt;undefined&lt;/oml:repeats&gt;
    &lt;/oml:method&gt;
  &lt;/oml:methods&gt;
&lt;/oml:evaluation_methods&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          None
        </div>
        <h3 id="openml_run_upload">openml.run.upload</h3>
        <p><i>Uploads new runs.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          <dl>
            <dt><code>POST description</code> (Required)</dt>
            <dd>An XML file describing the run</dd>
          </dl>
          <dl>
            <dt><code>POST &lt;output_files&gt;</code> (Required)</dt>
            <dd>All output files that should be generated by the run, as described in the task xml. For supervised classification tasks, this is typically a file containing predictions</dd>
          </dl>
          <dl>
            <dt><code>POST session_hash</code> (Required)</dt>
            <dd>The session hash, provided by the server on authentication (1 hour valid)</dd>
          </dl>
        </div>
        <h5>Required file</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Run description (XML)</h5>
          <p>Description of the run. Should contain at least <code>task_id</code> and <code>implementation_id</code>, and optionally any parameter setting that are specific for this run. Only set the field error_message in case of an error that prevented the algorithm from successfully executing. In this case, any predictions generated will <i>not</i> be evaluated, and the run is stored as unfinished. </p>
          <a type="button" class="btn btn-primary" href="rest_api/xsd/openml.run.upload">XSD Schema</a>
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Run response (XML)</h5>
          <p>The response file returned depending on the task type, containing at least the <code>run id</code> of the stored run. For some task types, it may contain additional information. For instance, for supervised classification, it will contain evaluation measures based on the uploaded predictions, computed on the server.</p>
          <a type="button" class="btn btn-primary disabled" href="https://raw.github.com/joaquinvanschoren/OpenML/master/XML/Schemas/response.xsd">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;oml:upload_run xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:run_id&gt;718193&lt;/oml:run_id&gt;
&lt;/oml:upload_run&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          <dl>
            <dt>200: Please provide session_hash</dt>
            <dd>In order to share content, please authenticate (openml.authenticate) and provide session_hash</dd>
          </dl>
          <dl>
            <dt>201: Authentication failed</dt>
            <dd>The session_hash was not valid. Please try to login again, or contact api administrators</dd>
          </dl>
          <dl>
            <dt>202: Please provide run xml</dt>
            <dd>Please provide run xml</dd>
          </dl>
          <dl>
            <dt>203: Could not validate run xml by xsd</dt>
            <dd>Please double check that the xml is valid. </dd>
          </dl>
          <dl>
            <dt>204: Unknown task</dt>
            <dd>The task with this id was not found in the database</dd>
          </dl>
          <dl>
            <dt>205: Unknown implementation</dt>
            <dd>The implementation with this id was not found in the database</dd>
          </dl>
          <dl>
            <dt>206: Invalid number of files</dt>
            <dd>The number of uploaded files did not match the number of files expected for this task type</dd>
          </dl>
          <dl>
            <dt>207: File upload failed</dt>
            <dd>One of the files uploaded has a problem</dd>
          </dl>
          <dl>
            <dt>208: Error inserting setup record</dt>
            <dd>Internal server error, please contact api administrators</dd>
          </dl>
          <dl>
            <dt>209: Unable to store cvrun</dt>
            <dd>Internal server error, please contact api administrators</dd>
          </dl>
          <dl>
            <dt>210: Unable to store run</dt>
            <dd>Internal server error, please contact api administrators</dd>
          </dl>
          <dl>
            <dt>211: Dataset not in databse</dt>
            <dd>One of the datasets of this task was not included in database, please contact api administrators</dd>
          </dl>
          <dl>
            <dt>212: Unable to store file</dt>
            <dd>Internal server error, please contact api administrators</dd>
          </dl>
          <dl>
            <dt>213: Parameter in run xml unknown</dt>
            <dd>One of the parameters provided in the run xml is not registered as parameter for the implementation nor its components</dd>
          </dl>
          <dl>
            <dt>214: Unable to store input setting</dt>
            <dd>Internal server error, please contact API support team</dd>
          </dl>
          <dl>
            <dt>215: Unable to evaluate predictions</dt>
            <dd>Internal server error, please contact API support team</dd>
          </dl>
          <dl>
            <dt>216: Error thrown by Java Application</dt>
            <dd>The Java application has thrown an error. Additional information field is provided</dd>
          </dl>
        </div>
        <h3 id="openml_run_get">openml.run.get</h3>
        <p><i>Returns all relevant information to the run, e.g., setup, input data and output data.</i></p>
        <h5>Arguments</h5>
        <div class="bs-callout">
          <dl>
            <dt><code>GET run_id</code> (Required)</dt>
            <dd>The run id</dd>
          </dl>
        </div>
        <h5>Response</h5>
        <div class="bs-callout bs-callout-info">
          <h5>Run response (XML)</h5>
          <p>The response file returns an XML file obaying the following XSD file:</p>
          <a type="button" class="btn btn-primary" href="rest_api/xsd/openml.run.upload">XSD Schema</a>
        </div>
        <h5>Example Response</h5>
        <div class="highlight">
          <pre class="pre-scrollable"><code class="html">&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:get_run xmlns:oml="http://openml.org/openml"&gt;
  &lt;oml:run_id&gt;718354&lt;/oml:run_id&gt;
  &lt;oml:task_id&gt;2&lt;/oml:task_id&gt;
  &lt;oml:user_id&gt;1&lt;/oml:user_id&gt;
  &lt;oml:implementation&gt;J48(1.0)&lt;/oml:implementation&gt;
  &lt;oml:setup_id&gt;635061&lt;/oml:setup_id&gt;
  &lt;oml:input_data&gt;
    &lt;oml:dataset&gt;
      &lt;oml:did&gt;61&lt;/oml:did&gt;
      &lt;oml:name&gt;iris&lt;/oml:name&gt;
      &lt;oml:url&gt;http://expdb.cs.kuleuven.be/expdb/data/uci/nominal/iris.arff&lt;/oml:url&gt;
    &lt;/oml:dataset&gt;
  &lt;/oml:input_data&gt;
  &lt;oml:output_data&gt;
    &lt;oml:dataset&gt;
      &lt;oml:did&gt;719987&lt;/oml:did&gt;
      &lt;oml:name&gt;run-718354-predictions_task2.arff&lt;/oml:name&gt;
      &lt;oml:url&gt;http://www.openml.org/files/download/138/predictions_task2.arff&lt;/oml:url&gt;
    &lt;/oml:dataset&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;mean_absolute_error&lt;/oml:name&gt;
      &lt;oml:value&gt;0.0354851786666666&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;mean_prior_absolute_error&lt;/oml:name&gt;
      &lt;oml:value&gt;0.444444444444454&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;root_mean_squared_error&lt;/oml:name&gt;
      &lt;oml:value&gt;0.157833805003545&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;root_mean_prior_squared_error&lt;/oml:name&gt;
      &lt;oml:value&gt;0.471404520791037&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;relative_absolute_error&lt;/oml:name&gt;
      &lt;oml:value&gt;0.0798416519999981&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;root_relative_squared_error&lt;/oml:name&gt;
      &lt;oml:value&gt;0.334816061455441&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;predictive_accuracy&lt;/oml:name&gt;
      &lt;oml:value&gt;0.955333333333333&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;kappa&lt;/oml:name&gt;
      &lt;oml:value&gt;0.933&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;prior_entropy&lt;/oml:name&gt;
      &lt;oml:value&gt;1.58496250072116&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
    &lt;oml:evaluation&gt;
      &lt;oml:name&gt;kb_relative_information_score&lt;/oml:name&gt;
      &lt;oml:value&gt;1396.29996987614&lt;/oml:value&gt;
    &lt;/oml:evaluation&gt;
  &lt;/oml:output_data&gt;
&lt;/oml:get_run&gt;
</code></pre>
        </div>
        <h5>Error codes</h5>
        <div class="bs-callout bs-callout-danger">
          <dl>
            <dt>220: Please provide run_id</dt>
            <dd>In order to view run details, please provide run_id</dd>
          </dl>
          <dl>
            <dt>221: Run not found</dt>
            <dd>The run id was not found</dd>
          </dl>
        </div>
      </div>
    </div>
    <!-- end col-md-9 -->
    </div> <!-- end col-10 -->
  </div>
  <!-- end row -->
</div>
<!-- end container -->
