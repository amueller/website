        <div class="page-header">
          <h1 id="dev-tutorial">REST tutorial</h1>
        </div>
       <p>OpenML offers a RESTful Web API for uploading and downloading machine learning resources. Below is a list of common use cases.

       <div class="alert alert-warning" role="alert">You need to be <a href="login">signed in</a> to use the examples below.</div>
       <div class="bs-callout bs-callout-info" style="padding-top:20px;padding-bottom:20px">
          <h4>Using REST services</h4>
          <p>REST services can be called using simple HTTP GET or POST actions.</p>
          <p>The REST Endpoint URL is
          <div class="codehighlight"><pre><code class="http"><?php echo BASE_URL;?>api/</code>
          </div>
          </p>
          <p>For instance, to request the <code>openml.data.description</code> service, invoke like this (e.g., in your browser):
          <div class="codehighlight">
            <pre class="pre-scrollable"><code class="http"><?php echo BASE_URL;?>api/?f=openml.data.description&data_id=1</code>
          </div>
          </p>
	  <p>From your command-line, you can use curl:
	  <div class="codehighlight">
	   <pre class="pre-scrollable"><code class="http"># First, we need to authenticate with the openml.authenticate service
USER=YOURACCOUNTNAME
PASS=$(echo -n YOURPASSWORD | md5)
RES=$(curl --data "username=$USER&password=$PASS" http://openml.org/api/?f=openml.authenticate)

# We now extract the session hash from the XML response
HASH=$(echo $RES | xmllint --xpath "string(//*[local-name()='authenticate']/*[local-name()='session_hash'])" -)

# now you can call any function you want
curl -XGET "<?php echo BASE_URL;?>api/?f=openml.data.description&data_id=1&session_hash=$HASH"</code></div>
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
          <li>OpenML returns a description of the dataset as an XML file. <a href="<?php echo BASE_URL;?>api/?f=openml.data.description&amp;data_id=1" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
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
          <li>OpenML returns a description of the implementation as an XML file. <a href="<?php echo BASE_URL;?>api/?f=openml.implementation.get&amp;implementation_id=65" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
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
          <li>User asks for a task using the <a href="api#openml_tasks_search">openml.task.get</a> service and a <code>task id</code>. The <code>task id</code> is typically returned when searching for tasks.</li>
          <li>OpenML returns a description of the task as an XML file. <a href="<?php echo BASE_URL;?>api/?f=openml.tasks.search&amp;task_id=1" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>The task description contains the <code>dataset id</code>(s) of the datasets involved in this task. The user asks for the dataset using the <a href="api#openml_data_description">openml.data.description</a> service and the <code>dataset id</code>.</li>
          <li>OpenML returns a description of the dataset as an XML file. <a href="<?php echo BASE_URL;?>api/?f=openml.data.description&amp;data_id=61" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>The dataset description contains the URL where the dataset can be downloaded. The user calls that URL to download the dataset.</li>
          <li>The dataset is returned by the server hosting it. This can be OpenML, but also any other data repository. <a href="http://openml.liacs.nl/data/download/61/dataset_61_iris.arff" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
          <li>(Optional) The task description may also contain links to other resources, such as the train-test splits to be used in cross-validation. The user calls that URL to download the train-test splits.</li>
          <li>(Optional) The train-test splits are returned by OpenML. <a href="<?php echo BASE_URL;?>api_splits/get/1/Task_1_splits.arff" type="button" class="btn btn-primary btn-xs">Try it now</a></li>
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
