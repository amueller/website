<div class="modal fade" id="runModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Run</h4></div>
  <div class="modal-body">

    <img src="img/tutorial/sql_run.png" width="810" class="img-modal">
<h5>Overview</h5>

<p>A run may or may not be part of an <a href="#experimentModal" data-toggle="modal" onclick="$('#runModal').modal('hide');">experiment</a>.</p>

<h5>Use</h5>
<p>One typically queries for a specific setup, and then uses the Run table to get all executions of that setup and all generated data. In many cases, however, it is easier to use one of the run views:
<ul>
<li><a href="#cvrunModal" data-toggle="modal" onclick="$('#runModal').modal('hide');">CVRun</a> for cross-validation runs</li>
<li><a href="#pprunModal" data-toggle="modal" onclick="$('#runModal').modal('hide');">PPRun</a> for data preprocessing runs</li>
<li><a href="#bvrunModal" data-toggle="modal" onclick="$('#runModal').modal('hide');">BVRun</a> for bias-variance decomposition runs</li>
</ul>
</p>
<p>These tables have additional fields that link directly to certain input datasets, or specific components of the setup.</p>

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>rid</td><td>The run id. Unique identifier.</td></tr>
		<tr><td>parent</td><td>Runs can be hierarchical, this field points to the rid of the parent run.</td></tr>
		<tr><td>setup</td><td>The setup of this run: the plan of what should happen to the input data.</td></tr>
		<tr><td>experiment</td><td>The experiment, if any, for which this run is executed.</td></tr>
		<tr><td>machine</td><td>The machine (or cluster) on which this machine is executed.</td></tr>
		<tr><td>runner</td><td>Runs can be automatically started by a run engine. The runner is the specific engine used.</td></tr>
		<tr><td>start_time</td><td>The start time of the run.</td></tr>
		<tr><td>status</td><td>The status of the run. This is used for runs planned by the system. E.g. 'OK', 'in queue', 'error'.</td></tr>
		<tr><td>error</td><td>The error message, if any, generated while executing the run.</td></tr>
		<tr><td>priority</td><td>The priority of the run. This is used for runs planned by the system.</td></tr>
	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="dataModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Data (Abstract)</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_data.png" width="610" class="img-modal">
<h5>Overview</h5>
<b>Data</b> is an abstract term for everything that holds information. This can be a <a href="#datasetModal" data-toggle="modal" onclick="$('#dataModal').modal('hide');">dataset</a> describing observations/measurements of a certain phenomenon, <a href="#evaluationModal" data-toggle="modal" onclick="$('#dataModal').modal('hide');">evaluations</a> of a certain algorithm or process, <a href="#modelModal" data-toggle="modal" onclick="$('#dataModal').modal('hide');">models</a> built on a given dataset and <a href="#predictionModal" data-toggle="modal" onclick="$('#dataModal').modal('hide');">predictions</a> made by a model for a set of unlabeled data. Data can be input or output of a <a href="#runModal" data-toggle="modal" onclick="$('#dataModal').modal('hide');">run</a>. Unless the source process that generated the data is unknown (as is often the case with datasets), the run that generated the data is referenced as its <i>source</i>.

<h5>Use</h5>
This table is abstract (it doesn't really exist). It simply shows that all types of data always have a unique id (unique over all types of data) and a source field referencing the run that generated the data (if known).
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="inputDataModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>InputData</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_inputdata.png" width="510" class="img-modal">
<h5>Overview</h5>
<p>Linking table that links the (possibly many) sets of input <a href="#dataModal" data-toggle="modal" onclick="$('#inputDataModal').modal('hide');">data</a> to the <a href="#runModal" data-toggle="modal" onclick="$('#inputDataModal').modal('hide');">run</a>. If more than one set of data is read, this will result in multiple rows per run, with the `name' field stating the name of the <a href="#inputModal" data-toggle="modal" onclick="$('#inputDataModal').modal('hide');">input</a> as defined by the <a href="#implementationModal" data-toggle="modal" onclick="$('#inputDataModal').modal('hide');">implementation</a> that is run.</p>

<h5>Use</h5>
<p>When querying a run, this table gives you all the input data fed to that run. Vice versa, it shows you which runs exist on a specific dataset. For common types of runs, there exist run views that link to one or more input data sets directly:
<ul>
<li><a href="#cvrunModal" data-toggle="modal" onclick="$('#runModal').modal('hide');">CVRun</a> for cross-validation runs</li>
<li><a href="#pprunModal" data-toggle="modal" onclick="$('#runModal').modal('hide');">PPRun</a> for data preprocessing runs</li>
<li><a href="#bvrunModal" data-toggle="modal" onclick="$('#runModal').modal('hide');">BVRun</a> for bias-variance decomposition runs</li>
</ul>
</p>

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>run</td><td>The run to which the input data is fed.</td></tr>
		<tr><td>data</td><td>The data which is fed to the run.</td></tr>
		<tr><td>name</td><td>The name of the input as defined by the implementation that is run.</td></tr>
	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="outputDataModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>OutputData</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_outputdata.png" width="510" class="img-modal">
<h5>Overview</h5>
<p>Linking table that lists the (possibly many) sets of <a href="#dataModal" data-toggle="modal" onclick="$('#outputDataModal').modal('hide');">data</a> generated by a <a href="#runModal" data-toggle="modal" onclick="$('#outputDataModal').modal('hide');">run</a>. If more than one set of data is generated, this will result in multiple rows per run, with the `name' field stating the name of the <a href="#outputModal" data-toggle="modal" onclick="$('#outputDataModal').modal('hide');">output</a> as defined by the <a href="#implementationModal" data-toggle="modal" onclick="$('#outputDataModal').modal('hide');">implementation</a> that is run.</p>

<h5>Use</h5>
<p>This table can be useful to retrieve the data generated by a run based on the output name. However, since data always references the run that generated it in its 'source' field, it is often easier to bypass this table and link output data and run directly.

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>run</td><td>The run that generates the data.</td></tr>
		<tr><td>data</td><td>The data generated by the run.</td></tr>
		<tr><td>name</td><td>The internal name for the output, or the name of the output as stated in the implementation that is run.</td></tr>
	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="datasetModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Dataset</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_dataset.png" width="510" class="img-modal">
<h5>Overview</h5>
<p>Table that lists all datasets. The data is expressed in the given format and downloadable from the given url. The table includes `original' datasets (which typically originate from a data repository such as the UCI repository), as well as datasets that are a processed version of another dataset in this database (in which case it should have a `source' run). Datasets can have <a href="#dataQualityModal" data-toggle="modal" onclick="$('#datasetModal').modal('hide');">data qualities</a>, e.g. the number of attributes in a tabular dataset.</p>
<h5>Use</h5>
<p>Datasets are connected to other datasets or other types of data (e.g., <a href="#evaluationModal" data-toggle="modal" onclick="$('#dataModal').modal('hide');">evaluations</a>, <a href="#modelModal" data-toggle="modal" onclick="$('#dataModal').modal('hide');">models</a> and <a href="#predictionModal" data-toggle="modal" onclick="$('#dataModal').modal('hide');">predictions</a>) through runs. For instance, in a cross-validation run, datasets are linked to evaluation results. Also including its data properties allows you to investigate their effect on algorithm performance.</p>

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>did</td><td>The data id. Unique identifier, even over different types of data (e.g., a dataset and an evaluation).</td></tr>
		<tr><td>source</td><td>The run that generated the data. It can be unknown. Especially for datasets, the process that generated them may be unknown.</td></tr>
		<tr><td>name</td><td>The name of the dataset. For reference, does not need to be unique.</td></tr>
		<tr><td>format</td><td>The format in which the data is expressed.</td></tr>
		<tr><td>version</td><td>The version of the dataset, for versioned datasets (optional).</td></tr>
		<tr><td>url</td><td>The url where this dataset can be downloaded.</td></tr>
		<tr><td>collection</td><td>The collection to which this dataset belongs, if any (e.g. UCI)</td></tr>
		<tr><td>license</td><td>The license under which the data is made available.</td></tr>
		<tr><td>isOriginal</td><td>True if the dataset is original, false if the dataset is a preprocessed version of another dataset in the database.</td></tr>
		<tr><td>task</td><td>The task this dataset was meant for. E.g., classification or regression.</td></tr>
		<tr><td>classIndex</td><td>Optional, the index of the target attribute. Only for tabular data.</td></tr>
		<tr><td>description</td><td>A description of the dataset (optional).</td></tr>
	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="evaluationModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Evaluation</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_evaluation.png" width="510" class="img-modal">
<h5>Overview</h5>
Evaluations are performance estimates of learning algorithms, generated by running an algorithm evaluation method such as cross-validation. The evaluation depends on the evaluation measure (e.g., predictive accuracy), which must be a known <a href="#functionModal" data-toggle="modal" onclick="$('#evaluationModal').modal('hide');">mathematical function</a>. It also includes the exact <a href="#implementationModal" data-toggle="modal" onclick="$('#evaluationModal').modal('hide');">implementation</a> of that function (the code that evaluates the function).
<h5>Use</h5>
<p>Evaluations are linked to the run that generated it through the 'source' field. That run contains the exact evaluation <a href="#setupModal" data-toggle="modal" onclick="$('#evaluationModal').modal('hide');">setup</a> and the input <a href="#datasetModal" data-toggle="modal" onclick="$('#evaluationModal').modal('hide');">dataset</a>.</p>
<p>Instead of linking it to the general Run table, it is often easier to link to a run view:
<ul>
<li><a href="#cvrunModal" data-toggle="modal" onclick="$('#runModal').modal('hide');">CVRun</a> for cross-validation runs</li>
<li><a href="#bvrunModal" data-toggle="modal" onclick="$('#runModal').modal('hide');">BVRun</a> for bias-variance decomposition runs</li>
</ul>
</p>
<p>
For instance, through CVRun, we can immediately link an evaluation to the evaluation setup (e.g., 10-fold cross-validation), the learning algorithm (learner) and the input dataset.
</p>
<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>did</td><td>The data id. Unique identifier.</td></tr>
		<tr><td>source</td><td>The run that generated the data.</td></tr>
		<tr><td>function</td><td>The evaluation function.</td></tr>
		<tr><td>implementation</td><td>The implementation of the evaluation function.</td></tr>
		<tr><td>label</td><td>Optional label for composite evaluations. E.g., for per-class evaluations, it can be the class name.</td></tr>
		<tr><td>value</td><td>The value of the evaluation. Must be numeric.</td></tr>
		<tr><td>stdev</td><td>The standard deviation of the evaluation. Must be numeric.</td></tr>
	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="modelModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Model</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_model.png" width="510" class="img-modal">
<h5>Overview</h5>
Stores generated models, as strings in a certain data format. Models can have <a href="#dataQualityModal" data-toggle="modal" onclick="$('#modelModal').modal('hide');">data qualities</a>, e.g. the number of nodes in a decision tree.
<h5>Use</h5>
Links to the run that generated it through the 'source' field. That run contains the learning algorithm's <a href="#setupModal" data-toggle="modal" onclick="$('#modelModal').modal('hide');">setup</a> and the input <a href="#datasetModal" data-toggle="modal" onclick="$('#modelModal').modal('hide');">dataset</a>.</p>
<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>did</td><td>The data id. Unique identifier.</td></tr>
		<tr><td>source</td><td>The run that generated the model.</td></tr>
		<tr><td>format</td><td>The format in which the model is stored. Should also include the specific version of the format.</td></tr>
		<tr><td>value</td><td>The model, represented as a string.</td></tr>
	</tbody>
</table>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="predictionModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Prediction</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_prediction.png" width="310" class="img-modal">
<h5>Overview</h5>
Stores generated prediction, as strings in a certain data format.
<h5>Use</h5>
<p>Links to the run that generated it through the 'source' field. That run contains the learning algorithm's train/test <a href="#setupModal" data-toggle="modal" onclick="$('#modelModal').modal('hide');">setup</a> and the input <a href="#datasetModal" data-toggle="modal" onclick="$('#modelModal').modal('hide');">datasets</a>.</p>
<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>did</td><td>The data id. Unique identifier.</td></tr>
		<tr><td>source</td><td>The run that generated the predictions</td></tr>
		<tr><td>format</td><td>The format in which the predictions are stored. Should also include the specific version of the format.</td></tr>
		<tr><td>value</td><td>The predictions, represented as a string.</td></tr>
	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="dataQualityModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>DataQuality</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_dataquality.png" width="610" class="img-modal">
<h5>Overview</h5>
A <b>data quality</b> is a (measureable) property of a set of <a href="#dataModal" data-toggle="modal" onclick="$('#dataQualityModal').modal('hide');">Data</a> (usually a dataset or model). They have unique, standardized names (e.g., NumberOfFeatures) and are described in more detail in the <a href="#qualityModal" data-toggle="modal" onclick="$('#dataQualityModal').modal('hide');">Quality</a> table. 

<h5>Use</h5>
To retrieve a quality of a specific dataset, link it to the dataset and state the name of the quality in the 'quality' field. Quality names are unique identifiers, so there is typically no need to include the <a href="#qualityModal" data-toggle="modal" onclick="$('#dataQualityModal').modal('hide');">Quality</a> table. 

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>data</td><td>The data. Can be any type of data (e.g., a dataset or model).</td></tr>
		<tr><td>quality</td><td>The data quality that is measured, e.g., the number of instances in a dataset.</td></tr>
		<tr><td>qualityImplementation</td><td>The implementation used to calculate the quality.</td></tr>
		<tr><td>label</td><td>A label for composite qualities with more than one value (optional). Can, for instance, be used to store a max, min and avg value.</td></tr>
		<tr><td>value</td><td>The calculated value of the data quality.</td></tr>
	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="qualityModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Quality</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_quality.png" width="610" class="img-modal">
<h5>Overview</h5>
A <b>quality</b> is a (measureable) property of a dataset or algorithm. They have unique, standardized names (e.g., NumberOfFeatures) and are described by a general description and optionally a specific formula.

<h5>Use</h5>
This table is used only to retrieve descriptions of the known dataset or algorithm qualities, or to list them. To retrieve a quality of a specific dataset or algorithm, simply state the name of the quality in the 'quality' field in either <a href="#dataQualityModal" data-toggle="modal" onclick="$('#qualityModal').modal('hide');">DataQuality</a> or <a href="#algorithmQualityModal" data-toggle="modal" onclick="$('#qualityModal').modal('hide');">AlgorithmQuality</a>. 
<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>name</td><td>The name of the quality. Unique identifier.</td></tr>
		<tr><td>type</td><td>Either AlgorithmQuality or DataQuality.</td></tr>
		<tr><td>description</td><td>Clear description of the quality.</td></tr>
		<tr><td>formula</td><td>The formula for computing the quality. This can be a precise description or even a formula described in LaTeX code.</td></tr>
		<tr><td>min</td><td>The minimal value for the quality, if appropriate.</td></tr>
		<tr><td>max</td><td>The maximal value for the quality, if appropriate.</td></tr>
	</tbody>
</table>


  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="algorithmQualityModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>AlgorithmQuality</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_algoquality.png" width="410" class="img-modal">
<h5>Overview</h5>
An <b>algorithm quality</b> is a (measureable) property of a set of an <a href="#implementationModal" data-toggle="modal" onclick="$('#algorithmQualityModal').modal('hide');">algorithm implementation</a>. They have unique, standardized names (e.g., BiasVarianceProfile, HandlesNumericFeatures) and are described in more detail in the <a href="#qualityModal" data-toggle="modal" onclick="$('#algorithmQualityModal').modal('hide');">Quality</a> table. 

<h5>Use</h5>
To retrieve a quality of a specific algorithm implementation, link it to the implementation and state the name of the quality in the 'quality' field. Quality names are unique identifiers, so there is typically no need to include the <a href="#qualityModal" data-toggle="modal" onclick="$('#dataQualityModal').modal('hide');">Quality</a> table. 

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>implementation</td><td>The algorithm implementation.</td></tr>
		<tr><td>quality</td><td>The algorithm quality that is measured, e.g., the bias-variance profile.</td></tr>
		<tr><td>qualityImplementation</td><td>The implementation used to calculate the quality.</td></tr>
		<tr><td>label</td><td>A label for composite qualities with more than one value (optional). Can, for instance, be used to store a max, min and avg value.</td></tr>
		<tr><td>value</td><td>The calculated value of the algorithm quality.</td></tr>
	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="pprunModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>PPRun (Preprocessing Run)</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_pprun.png" width="510" class="img-modal">
<h5>Overview</h5>
A view meant to make querying of preprocessing runs easier. It combines information from tables <a href="#runModal" data-toggle="modal" onclick="$('#pprunModal').modal('hide');">Run</a>, <a href="#inputDataModal" data-toggle="modal" onclick="$('#pprunModal').modal('hide');">InputData</a>, and <a href="#outputDataModal" data-toggle="modal" onclick="$('#pprunModal').modal('hide');">OutputData</a>, for those cases where the run is a preprocessing procedure.
<h5>Use</h5>
This table directly links an input dataset to a preprocessing setup and the resulting output dataset (or vice versa). It is only useful when there is a single input dataset and a single output dataset. For preprocessing runs with multiple inputs and outputs, use the Run table directly.

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>rid</td><td>The run id. Also exists in the Run table.</td></tr>
		<tr><td>setup</td><td>The data preprocessing algorithm setup.</td></tr>
		<tr><td>inputData</td><td>The input data for the preprocessing step.</td></tr>
		<tr><td>outputData</td><td>The data generated by the preprocessing step.</td></tr>
	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="bvrunModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>BVRun (Bias-Variance Decomposition Run)</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_bvrun.png" width="510" class="img-modal">
<h5>Overview</h5>
A view meant to make querying of bias-variance analysis runs easier. It combines information from tables <a href="#runModal" data-toggle="modal" onclick="$('#bvrunModal').modal('hide');">Run</a>, <a href="#inputDataModal" data-toggle="modal" onclick="$('#bvrunModal').modal('hide');">InputData</a>, and <a href="#outputDataModal" data-toggle="modal" onclick="$('#bvrunModal').modal('hide');">OutputData</a>.

<h5>Use</h5>
This table is useful to query the results of bias-variance analysis runs. It links directly to the <a href="#datasetModal" data-toggle="modal" onclick="$('#bvrunModal').modal('hide');">input dataset</a>, the <a href="#algorithmSetupModal" data-toggle="modal" onclick="$('#bvrunModal').modal('hide');">bias-variance estimation setup</a> and the <a href="#algorithmSetupModal" data-toggle="modal" onclick="$('#bvrunModal').modal('hide');">learning algorithm setup</a>. The results are included by linking the <a href="#evaluationModal" data-toggle="modal" onclick="$('#bvrunModal').modal('hide');">Evaluation</a> 'source' field to this run.

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>rid</td><td>The run id. Also exists in the Run table.</td></tr>
		<tr><td>BVSetup</td><td>The bias-variance estimation setup.</td></tr>
		<tr><td>learner</td><td>The learning algorithm setup.</td></tr>
		<tr><td>inputData</td><td>The input data on which the learning algorithm is evaluated.</td></tr>
	</tbody>
</table>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="cvrunModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>CVRun (Cross-Validation Run)</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_cvrun.png" width="510" class="img-modal">
<h5>Overview</h5>
A view meant to make querying of cross-validation runs easier. It combines information from tables <a href="#runModal" data-toggle="modal" onclick="$('#bvrunModal').modal('hide');">Run</a>, <a href="#inputDataModal" data-toggle="modal" onclick="$('#bvrunModal').modal('hide');">InputData</a>, and <a href="#outputDataModal" data-toggle="modal" onclick="$('#bvrunModal').modal('hide');">OutputData</a>.

<h5>Use</h5>
This table is useful to query the results of cross-validation runs. It links directly to the <a href="#datasetModal" data-toggle="modal" onclick="$('#cvrunModal').modal('hide');">input dataset</a>, the <a href="#algorithmSetupModal" data-toggle="modal" onclick="$('#cvrunModal').modal('hide');">cross-validation setup</a> and the <a href="#algorithmSetupModal" data-toggle="modal" onclick="$('#cvrunModal').modal('hide');">learning algorithm setup</a>. The results are included by linking the <a href="#evaluationModal" data-toggle="modal" onclick="$('#cvrunModal').modal('hide');">Evaluation</a> 'source' field to this run.

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>rid</td><td>The run id. Also exists in the Run table.</td></tr>
		<tr><td>CVSetup</td><td>The cross-validation procedure setup.</td></tr>
		<tr><td>learner</td><td>The learning algorithm setup.</td></tr>
		<tr><td>inputData</td><td>The input data on which the learning algorithm is evaluated.</td></tr>
		<tr><td>nrFolds</td><td>Convenience field that states the number of folds in the cross-validation procedure setup.</td></tr>
	</tbody>
</table>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="implementationModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Implementation</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_implementation.png" width="510" class="img-modal">
<h5>Overview</h5>
<p>Implementations are executable versions of general <a href="#algorithmModal" data-toggle="modal" onclick="$('#implementationModal').modal('hide');">algorithms</a>, <a href="#functionModal" data-toggle="modal" onclick="$('#implementationpModal').modal('hide');">functions</a>, or <a href="#workflowModal" data-toggle="modal" onclick="$('#implementationModal').modal('hide');">workflows</a>. They consist of source code or an executable written in the given programming language and downloadable from the given url. They are also <i>versioned</i>, and may belong to a larger <i>library</i>. Implementations will often require a set of <a href="#inputModal" data-toggle="modal" onclick="$('#implementationModal').modal('hide');">algorithms</a> it needs in order to run, and may have several <a href="#outputModal" data-toggle="modal" onclick="$('#implementationModal').modal('hide');">outputs</a>. Finally, implementations of workflows will contain <a href="#connectionModal" data-toggle="modal" onclick="$('#implementationModal').modal('hide');">connections</a> that link specific implementations (i.e., algorithm or subworkflow implementations) to each other.</p> 

<h5>Use</h5>
Although results can be queried based on the general algorithms that are involved, implementations allow you to focus specifically on a given implementation, and even specific versions of that implementations, thus linking results to the exact code used to generate them. They are an intricate part of an  <a href="#outputModal" data-toggle="modal" onclick="$('#implementationModal').modal('hide');">algorithm setup</a>. 


s are used when we are interested in results specific to a given implementation of an algorithm 

<h5>All fields</h5>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="setupModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Setup (Abstract)</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_setup.png" width="610" class="img-modal">
<h5>Overview</h5>
<p>A <b>setup</b> is a specific <i>configuration</i> of an <a href="#algorithmSetupModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">algorithm</a>, <a href="#functionSetupModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">function</a>, or <a href="#workflowSetupModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">workflow</a> implementation. It assigns specific values to the <a href="#inputModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">inputs</a> of that <a href="#implementationModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">implementation</a>. These are the <a href="#inputSettingModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">input settings</a>: they are typically parameter settings controlling some aspect of an implementation's behavior, or a specific fixed input dataset, in which case the value may be the dataset's URL. Setups can also have <a href="#componentModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">components</a>, which are the setups of sub-algorithms, sub-functions or sub-workflows.</p>

<h5>Use</h5>
<p>This table is abstract (it doesn't really exist). It simply shows that all setups configure a specific <a href="#implementationModal" data-toggle="modal" onclick="$('#dataModal').modal('hide');">implementation</a>, and that they can have a range of <a href="#inputSettingModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">input settings</a>. A setup without input settings is the same as the default configuration of the implementation. Before a setup is run, all input settings are deemed be fixed. Inputs that are not set are either set to their default values (in case of parameters), or need to be supplied as <a href="#inputDataModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">input data</a> to a run.</p>

<p>Setups can also have and <a href="#componentModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">components</a>: one setup can be part of another setup. The latter is often the case in complex <a href="#algorithmSetupModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">algorithms</a>, such as ensemble learners which include one or more base-learners, kernel methods which include kernel functions, or <a href="#workflowSetupModal" data-toggle="modal" onclick="$('#setupModal').modal('hide');">workflows</a> which may include setups for all underlying components. Components can be given a <i>role</i> in the larger setup.</p>
</div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>

<div class="modal fade" id="inputSettingModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>InputSetting</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_inputsetting.png" width="610" class="img-modal">
<h5>Overview</h5>
<p>An <b>input setting</b> assigns a specific value to an input (typically a parameter) of an implementation. Setups can have many input settings, one for each input. The value is stored as a string. For instance, it can be a parameter setting (e.g. '0.01') or a url for an input dataset.</p>

<h5>Use</h5>
Input settings are included as part of the setup when one queries for specific configurations of an algorithm or function implementation. If no input settings are attached to a setup, it is simply the default setup (with all parameters set to their default values).

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>setup</td><td>The setup to which this input setting belongs.</td></tr>
		<tr><td>input</td><td>The implementation input to which the given value is assigned.</td></tr>
		<tr><td>value</td><td>The value to be assigned. A string.</td></tr>
	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>

<div class="modal fade" id="componentModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Component</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_component.png" width="310" class="img-modal">
<h5>Overview</h5>
<p>Setups are hierarchical. For instance, a workflow setup can consist of multiple algorithm setups, which themselves may have sub-algorithm setups (e.g. base-learners) or function setups (e.g. kernel functions). Workflows can also have subworkflows, and even algorithms can have internal subworkflows. Setups can thus have one or more <b>component (settings)</b>, consisting of the parent setup, a child setup, and optionally a <i>role</i>. The latter are typical roles played by algorithms or functions as part of a larger algorithm, e.g. 'BaseLearner' or 'Kernel'. 
</p>

<h5>Use</h5>
<p>Components are included as part of the setup when one is interested in a particular subcomponentof a setup. It allows to connect the 'top' setup to specific subcomponents. This is a many-to-many relationship: e.g. an algorithm setup can occur as part of many workflow setups, and a workflow setup can include many algorithm setups.</p>
<p><a href="#algorithmsetupModal" data-toggle="modal" onclick="$('#componentModal').modal('hide');">Algorithm setups</a> can be part of other algorithm or workflow setups. <a href="#workflowsetupModal" data-toggle="modal" onclick="$('#componentModal').modal('hide');">Workflow setups</a>, too, can be part of other algorithm or workflow setups. However, <a href="#functionsetupModal" data-toggle="modal" onclick="$('#componentModal').modal('hide');">function setups</a> can only be part of algorithm setups, and can themselves not have any subcomponents.
</p>

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>parent</td><td>The parent setup.</td></tr>
		<tr><td>child</td><td>The child setup.</td></tr>
		<tr><td>role</td><td>(Optional) The role played by the child setup in the larger parent setup, e.g. 'BaseLearner' or 'Kernel'.</td></tr>
		<tr><td>canvasXY</td><td>(Optional) The position of the component on a canvas. This is useful to store workflow layouts.</td></tr>
		<tr><td>logRuns</td><td>Whether or not runs of this component must be logged. If true, the run of this setup, and the inputs and outputs, will be stored as an individual run (part of the larger run).</td></tr>

	</tbody>
</table>
  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>


<div class="modal fade" id="inputModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Input</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_input.png" width="510" class="img-modal">
<h5>Overview</h5>
<h5>Use</h5>
<h5>All fields</h5>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="algorithmSetupModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>AlgorithmSetup</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_algorithmsetup.png" width="610" class="img-modal">
<h5>Overview</h5>
<p>An <b>Algorithm Setup</b> is a specific <i>configuration</i> of an <a href="#implementation" data-toggle="modal" onclick="$('#algorithmSetupModal').modal('hide');">algorithm implementation</a>. It assigns specific values to the <a href="#inputModal" data-toggle="modal" onclick="$('#algorithmSetupModal').modal('hide');">inputs</a> of that <a href="#implementationModal" data-toggle="modal" onclick="$('#algorithSetupModal').modal('hide');">implementation</a>. These are the <a href="#inputSettingModal" data-toggle="modal" onclick="$('#algorithmSetupModal').modal('hide');">input settings</a>: they are typically parameter settings controlling some aspect of an implementation's behavior, or a specific fixed input dataset, in which case the value may be the dataset's URL. Algorithm setups can also have <a href="#componentModal" data-toggle="modal" onclick="$('#algorithmSetupModal').modal('hide');">components</a>, which are the setups of sub-algorithms (e.g., a base-learning in an ensemble learner), sub-functions (e.g., a kernel function in a kernel method) or sub-workflows (e.g., an internal workflow inside a cross-validation procedure).</p>

<h5>Use</h5>
<p>Algorithm setups are the core of any experiment run. They define which algorithm implementation should be run, but also, what values should be assigned to its inputs (e.g., parameter settings), or which specific subcomponents (e.g. functions) to use. As such, they completely define how the algorithm should be run. An algorithm setup without input settings is the same as the default configuration of the implementation.</p>
<p><a href="#runModal" data-toggle="modal" onclick="$('#algorithmSetupModal').modal('hide');">Runs</a> always reference which setup they run, thus all runs of this setups, and their results, can be queried by simply linking to the Run table.</p>
<p>Algorithms can be learning algorithms, but also evaluation algorithms (e.g. a cross-validation procedure) or preprocessing algorithms (e.g. feature selection algorithms). They typically play <i>roles</i> in a larger setup.</p>

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>sid</td><td>Unique id. Unique over all types of setups.</td></tr>
		<tr><td>implementation</td><td>The implementation configured by this setup.</td></tr>
		<tr><td>isDefault</td><td>Whether or not this setup is the default setup (has all parameters set to their default values).</td></tr>
		<tr><td>algorithm</td><td>The name of the general algorithm configured in this setup. This is the same as the general algorithm implemented by the implementation.</td></tr>
	</tbody>
</table>



  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="workflowSetupModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>WorkflowSetup</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_workflowsetup.png" width="810" class="img-modal">
<h5>Overview</h5>
<h5>Use</h5>
<h5>All fields</h5>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="functionModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>MathFunction (Mathematical Function)</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_function.png" width="410" class="img-modal">
<h5>Overview</h5>
<h5>Use</h5>
<h5>All fields</h5>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="workflowModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Workflow</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_workflow.png" width="410" class="img-modal">
<h5>Overview</h5>
<h5>Use</h5>
<h5>All fields</h5>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="experimentModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Experiment</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_experiment.png" width="610" class="img-modal">
<h5>Overview</h5>
<h5>Use</h5>
<h5>All fields</h5>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="algorithmModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Algorithm</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_algorithm.png" width="410" class="img-modal">
<h5>Overview</h5>
<h5>Use</h5>
<h5>All fields</h5>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="functionSetupModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>FunctionSetup</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_functionsetup.png" width="610" class="img-modal">
<h5>Overview</h5>
<p>A <b>Function Setup</b> is a specific <i>configuration</i> of an <a href="#implementation" data-toggle="modal" onclick="$('#functionSetupModal').modal('hide');">function implementation</a>. It assigns specific values to the <a href="#inputModal" data-toggle="modal" onclick="$('#functionSetupModal').modal('hide');">inputs</a> of that <a href="#implementationModal" data-toggle="modal" onclick="$('#functionSetupModal').modal('hide');">implementation</a>. These are the <a href="#inputSettingModal" data-toggle="modal" onclick="$('#functionSetupModal').modal('hide');">input settings</a>: parameter settings controlling some aspect of the function.</p>
<h5>Use</h5>
<p>Function setups are always part of some <a href="#algorithmSetupModal" data-toggle="modal" onclick="$('#functionSetupModal').modal('hide');">algorithm setup</a>. They define exactly which functions (e.g. kernel functions, distance functions, loss functions, evaluation metrics) will be used by the algorithm. As such, functions typically play certain <a href="#componentModal" data-toggle="modal" onclick="$('#functionSetupModal').modal('hide');"><i>roles</i></a> in the larger algorithm setup.</p>

<h5>All fields</h5>
<table class="table table-striped table-bordered table-condensed" id="simpledatatable">
	<thead>
		<tr><th>field name</th><th>description</th></tr>
	</thead>
	<tbody>
		<tr><td>sid</td><td>Unique id. Unique over all types of setups.</td></tr>
		<tr><td>implementation</td><td>The function implementation configured by this setup.</td></tr>
		<tr><td>isDefault</td><td>Whether or not this setup is the default setup (has all parameters set to their default values).</td></tr>
		<tr><td>function</tuetd><td>The general name of the function configured in this setup. This is the same as the general function implemented by the implementation.</td></tr>
	</tbody>
</table>



  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="connectionModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Connection</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_connection.png" width="610" class="img-modal">
<h5>Overview</h5>
<h5>Use</h5>
<h5>All fields</h5>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="experimentalVariableModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>ExperimentalVariable</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_experimentvariable.png" width="310" class="img-modal">
<h5>Overview</h5>
<h5>Use</h5>
<h5>All fields</h5>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>
<div class="modal fade" id="outputModal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4>Output</h4></div>
  <div class="modal-body">
    <img src="img/tutorial/sql_output.png" width="510" class="img-modal">
<h5>Overview</h5>
<h5>Use</h5>
<h5>All fields</h5>

  </div>
  <div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a></div></div></div>
</div>

