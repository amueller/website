
      <div class="redheader">
      <h1>Compare flows</h1>
      <p>Compare how well different flows perform over several tasks.</p>
      </div>

<form class="form-horizontal">
	<div class="form-group">
		<label class="col-md-2 control-label" for="datasetDropdown">Task type</label>
		<div class="col-md-10">
			<select class="selectpicker">
			  <option>Supervised Classification</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label" for="algorithmDropdown">Flows</label>
		<div class="col-md-10">
			<input type="text" class="form-control" id="algorithmDropdown" placeholder="Include all algorithms" value="SVM, C4.5, " onblur="updateImplementations( '#implementationDropdown', '#algorithmDropdown' );">
			<span class="help-block">A comma separated list of flows. Leave empty to include all flows.</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label" for="datasetDropdown">Datasets</label>
		<div class="col-md-10">
			<input type="text" class="form-control" id="datasetDropdown" placeholder="Include all datasets" value="" />
			<span class="help-block">A comma separated list of datasets. Leave empty to include all datasets.</span>
		</div>
	</div>

<div id="accordion2" style="margin-bottom:15px">
    <div class="query-heading">
      <a data-toggle="collapse" href="#collapseOne">
      <i class="fa fa-caret-down fa-fw"></i>  Advanced options
      </a>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="query-body">
	<div class="form-group">
		<label class="col-md-2 control-label" for="implementationDropdown">Implementation versions</label>
		<div class="col-md-10">
			<input type="text" class="form-control input-small" id="implementationDropdown" placeholder="Include all implementations of selected algorithms" value="" />
			<span class="help-block">Further specify exactly which implementations you want. Leave empty to include all implementations of the selected algorithms.</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label" for="algorithmDefault">Default settings</label>
		<div class="col-md-10">
			<input type="checkbox" id="algorithmDefault" checked="checked" />
			<span class=" help-block2" >
				Only include default parameter settings. Deselect with caution: allowing all parameter settings may yield many results.
			</span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label" for="evaluationmetricDropdown">Evaluation metric</label>
		<div class="col-md-10">
			<input type="text" class="form-control input-small" id="evaluationmetricDropdown" value="predictive_accuracy" />
			<span class="help-block">Select the desired evaluation metric. </span>
		</div>
	</div>


	<div class="form-group">
		<label class="col-md-2 control-label" for="evaluationmethodDropdown">Evaluation method</label>
		<div class="col-md-10">
			<input type="text" class="form-control input-small" id="evaluationmethodDropdown" placeholder="" disabled="disabled" value="CrossValidation" />
			<span class="help-block">Currently, cross validation is the only evaluation method used.</span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label" for="inputCtAlgorithm">Crosstabulation</label>
		
		<div class="col-md-10">
			<label class="radio">
				<input type="radio" name="crosstabulate" value="none"  />
				None <small>(Columns are algorithm, dataset and evaluation, respectively)</small>
			</label>
			<label class="radio">
				<input type="radio" name="crosstabulate" value="algorithm" />
				Crosstabulate over algorithms <small>(rows contain algorithms, columns contains datasets)</small>
			</label>
			<label class="radio">
				<input type="radio" name="crosstabulate" value="dataset" checked />
				Crosstabulate over datasets <small>(rows contain datasets, columns contain algorithms)</small>
			</label>
		</div>
	</div>
      </div>
    </div>
</div>
	<div class="form-group">
		<button id="wizardquery-btn" data-loading-text="Querying..." autocomplete="off" type="button" onclick="wizardQuery( $('#algorithmDropdown').val(), $('#implementationDropdown').val(), $('#algorithmDefault').prop('checked'), $('#datasetDropdown').val(), $('#evaluationmethodDropdown').val(), $('#evaluationmetricDropdown').val(), $('input:radio[name=crosstabulate]:checked').val() );showResultTab();" class="btn btn-primary">
			Run Query
		</button>
	</div>
	
</form>
