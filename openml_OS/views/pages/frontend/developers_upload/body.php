
<div class="container bs-docs-container">
   <div class="col-md-12">
<h3>Sharing content through the OpenML REST API</h4>
Although OpenML is founded upon the promise of easy content sharing 
though various workbenches, in many cases it can be necessary to share
content through the REST API. It is possible that the preferred
workbench is not (yet) supported, or it does not support the task type
(e.g., clustering, graph mining) you are working on. In that case it
is possible to share content manually through the REST API. For that, 
three functions need to be implemented. First, the user must be able to
<a href="developers#openml_authenticate">authenticate</a> himself. 
After that, all <a href="developers#openml.implementation.upload">
algorithms</a> (i.e., implementations) should be registered. Finally, 
the <a href="developers#openml_run_upload">run</a> results can be 
submitted to the server. 

<h4>Authentication</h5>
Although OpenML is a platform that allows people to <i>search</i> 
through all content without an account, for sharing results login
credentials are needed. First, create an account by filling in 
<a href="register">this</a> form. Using this account you can login on
the website and browse your previous results. (Please note that this 
page is work in progress. We will extend its functionality in a short
while.) Using the email address and the password, you can also
authenticate yourself to the REST API. This is done in the following 
way: Make an HTTP POST request to the following URL: 
http://www.openml.org/api/?f=openml.authenticate and include the 
following fields:
- username, containing the email address with which you registered.
- password, containing an MD5-hash of your password. 

In PHP/HTML, the form would look like this:
<div class="highlight"><pre class="pre-scrollable"><code class="html">
&lt;form action="www.openml.org/api/?f=openml.authenticate" method="post"&gt;
  Username: &lt;input type="text" name="username" value="&lt;?php echo $email; ?&gt;" /&gt;
  Password: &lt;input type="text" name="password" value="&lt;?php echo md5($password); ?&gt;" /&gt;
  &lt;input type="submit" value="Send" /&gt;
&lt;/form&gt;
</code></pre></div>

When successfully submitted, the REST API will return an XML form in the
following format:
<div class="highlight"><pre class="pre-scrollable"><code class="html">
&lt;oml:authenticate&gt;<br/>
  &lt;oml:session_hash&gt;8XWLPJDTXFHHE9S4GEJBPDPSTW1UPDWN1JZGS2ZF&lt;/oml:session_hash&gt;
  &lt;oml:valid_until&gt;2013-11-22 16:51:33&lt;/oml:valid_until&gt;
&lt;/oml:authenticate&gt;
</code></pre></div>

The provided session hash should be used to authenticate content 
sharing API requests. Please note that the session hash is valid for
a limited amount of time (i.e., one hour). After that hour, a new
session hash is needed. You can request new session hashes, even when
the current session hash is still valid. 

<h4>Registering algorithms</h5>
Algorithms that you want to use on OpenML, should be registered first.
This is done using the function openml.implementation.upload. Indeed,
rather that uploading an algorithm (which is just an abstract idea), 
you will actually upload an implementation to OpenML, that can be 
executed --- although not on the OpenML servers. Hence we will refer 
to all uploaded algorithms as implementations. 

In order to upload an implementation to OpenML, a post request should
be executed to the following url:
http://www.openml.org/api/?f=openml.implementation.upload
Include the following fields:
- session_hash, containing the session hash obtained from the
  authentication process.
- description, an XML file containing meta information about the
  implementation. This XML has to comply to this 
  <a href="rest_api/xsd/openml.implementation.upload">XSD schema</a>. 
  See below for an example XML schema.
- source, a file upload containing the source of the implementation. 
  For RapidMiner implementations, this is the XML describing the
  workflow. 
- binary, a file upload containing the binary to execute the
  implementation. For RapidMiner implementations, no binary is required.
Note that either the binary file or the source file should be included.

An example XML schema:
<div class="highlight"><pre class="pre-scrollable"><code class="html">
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:implementation xmlns:oml="http://openml.org/openml"&gt;
	&lt;oml:name&gt;eu.janvanrijn.goodAlgorithm&lt;/oml:name&gt;
	&lt;oml:description&gt;An algorithm that was designed to show the power of OpenML&lt;/oml:description&gt;  
	&lt;oml:creator&gt;Jan N. van Rijn&lt;/oml:creator&gt;
	&lt;oml:creator&gt;Joaquin Vanschoren&lt;/oml:creator&gt;
	&lt;oml:contributor&gt;Colleague 1&lt;/oml:contributor&gt;
	&lt;oml:contributor&gt;...&lt;/oml:contributor&gt;
	&lt;oml:licence&gt;public domain&lt;/oml:licence&gt;
	&lt;oml:language&gt;English&lt;/oml:language&gt;
  &lt;oml:installation_notes&gt;Install RapidMiner 6.0, install these plugins: ..., and import this implementation&lt;/oml:installation_notes&gt;
	&lt;oml:dependencies&gt;RapidMiner 6.0. The following plugins&lt;/oml:dependencies&gt;
	&lt;oml:parameter&gt;
		&lt;oml:name&gt;C&lt;/oml:name&gt;
		&lt;oml:data_type&gt;int&lt;/oml:data_type&gt;
		&lt;oml:default_value&gt;1&lt;/oml:default_value&gt;
		&lt;oml:description&gt;Gamma parameter&lt;/oml:description&gt;
	&lt;/oml:parameter&gt;
	&lt;oml:parameter&gt;
		&lt;oml:name&gt;D&lt;/oml:name&gt;
		&lt;oml:data_type&gt;int&lt;/oml:data_type&gt;
		&lt;oml:default_value&gt;1&lt;/oml:default_value&gt;
		&lt;oml:description&gt;Delta&lt;/oml:description&gt;
	&lt;/oml:parameter&gt;
	&lt;oml:source_format&gt;xml&lt;/oml:source_format&gt;
&lt;/oml:implementation&gt;
</code></pre></div>

In PHP/HTML, the form would look like this:
<div class="highlight"><pre class="pre-scrollable"><code class="html">
&lt;form action="www.openml.org/api/?f=openml.data.upload" method="post" enctype="multipart/form-data"&gt;
  session_hash: &lt;input type="text" name="session_hash" value="&lt;?php echo $session_hash; ?&gt;" /&gt;&lt;br/&gt;
  Description: &lt;input type="file" name="description" /&gt;&lt;br/&gt;
  Implementation: &lt;input type="file" name="source" /&gt;&lt;br/&gt;
  &lt;input type="submit" value="Send" /&gt;
&lt;/form&gt;
</code></pre></div>

When successfully submitted, the REST API will return an XML form in the
following format:
<div class="highlight"><pre class="pre-scrollable"><code class="html">
&lt;oml:upload_implementation&gt;
  &lt;oml:id&gt;eu.janvanrijn.goodAlgorithm(1.0)&lt;/oml:id&gt;
&lt;/oml:upload_implementation&gt;
</code></pre></div>
Please make sure that you or the program remembers this value: This is
to what the implementation can be referenced to. This is basically the name
of the implementation, and a version number.

<h4>Obtaining tasks</h5>
Before going to the next point, the uploading of a run, we must define
what a run is. A run is the execution of an implementation on a certain
dataset. There has to be determined what the target feature is,
i.e., the feature that needs to be predicted. Also an estimation 
procedure should be defined, e.g., cross validation. All this
information is stored in an object called a task. Tasks can be searched
using the task search form on OpenML. Typically, you select an 
estimation procedure and a range of datasets (or just all datasets)
and hit search. A comma separated list of task id's will be returned.
This should be the input of your run. 

A task can be downloaded programmatically using the following URL:
http://www.openml.org/api/?f=openml.task.search&task_id=<task_id>

This task contains some important information: The field dataset id, 
which can be used to download the data set (using the following url:
http://www.openml.org/api/?f=openml.data.description&data_id=<did>)
and the field data_splits_url, which contains a URL to an ARFF file 
specifying the various data splits. For each fold in each repeat, it
determines which instances from the dataset should be included in the
training set, and which instances should be included in the test set. 
Finally, the task XML describes the format in which the predictions 
should be returned. Note that this is the same for all classification
tasks, i.e., an ARFF file containing the described fields. This is an
example of such a file: 

<div class="highlight"><pre class="pre-scrollable"><code class="html">
@relation iris-predictions

@attribute repeat numeric
@attribute fold numeric
@attribute row_id numeric
@attribute prediction {Iris-setosa,Iris-versicolor,Iris-virginica}
@attribute confidence.Iris-setosa numeric
@attribute confidence.Iris-versicolor numeric
@attribute confidence.Iris-virginica numeric

@data
0,0,135,Iris-virginica,0,0.032258,0.967742
... all other predictions
</code></pre></div>

This description file should be uploaded to OpenML along with the run
information.

<h4>Uploading a Run</h5>
Having the dataset, the target attribute and the data splits arff, the
implementation can generate the requested predictions. This is done by
the following procedure:
1) For each defined split (in a repeat), sample the defined training
set and test set. 
2) Hide the target attribute in the test set.
3) Train a classifier on the training set. Generate the predictions 
for all instances in the test set. 
4) Print those predictions to an arff file. Include a column for the
repeat number, the fold number, the row number in the original dataset
and the prediction. Also, for classification tasks, include per class
a column containing the confidence for that class. If the classifier 
does not support stochastic predictions, just assign a confidence of 1
to the predicted class, and a confidence of 0 to all other classes. 
5) Upload this prediction file to OpenML, using a POST request. The URL
used for this is http://www.openml.org/api/?f=openml.run.upload. 
Include the following fields:
- session_hash, containing the session hash obtained from the
  authentication process.
- description, an XML file containing meta information about the
  run. This XML has to comply to this 
  <a href="rest_api/xsd/openml.run.upload">XSD schema</a>. 
  See below for an example XML schema.
- predictions, an ARFF file containing the predictions generated by 
  this run.

The description XML contains information about the implementation that
was used for this run, the task id and the parameter settings. 
<div class="highlight"><pre class="pre-scrollable"><code class="html">
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;oml:run xmlns:oml="http://openml.org/openml"&gt;
	&lt;oml:task_id&gt;1&lt;/oml:task_id&gt;
	&lt;oml:implementation_id&gt;J48(1.0)&lt;/oml:implementation_id&gt;
	&lt;oml:parameter_setting&gt;
		&lt;oml:name&gt;L&lt;/oml:name&gt;
		&lt;oml:value&gt;12&lt;/oml:value&gt;
	&lt;/oml:parameter_setting&gt;
	&lt;oml:parameter_setting&gt;
		&lt;oml:name&gt;U&lt;/oml:name&gt;
		&lt;oml:value&gt;0.1&lt;/oml:value&gt;
	&lt;/oml:parameter_setting&gt;
&lt;/oml:run&gt;
</code></pre></div>

</div></div>

