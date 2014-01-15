    <div class="bs-callout bs-callout-info">
      <h4>Search run results</h4>
      Compare the results of multiple implementations run on multiple datasets. Results are shown in the results tab, queries can be edited in the SQL tab.
    </div>

<form class="form-horizontal">
	<div class="form-group">
		<label class="col-md-2 control-label" for="datasetDropdown">Task type</label>
		<div class="col-md-10">
			<select class="form-control input-small">
			  <option>Supervised Classification</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label" for="algorithmDropdown">Implementations</label>
		<div class="col-md-10">
			<input type="text" class="form-control" id="algorithmDropdown" placeholder="Include all algorithms" value="SVM, C4.5, " onblur="updateImplementations();">
			<span class="help-block">A comma separated list of implementations. Leave empty to include all algorithms.</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label" for="datasetDropdown">Datasets</label>
		<div class="col-md-10">
			<input type="text" class="form-control" id="datasetDropdown" placeholder="Include all datasets" value="" />
			<span class="help-block">A comma separated list of datasets. Leave empty to include all datasets.</span>
		</div>
	</div>

<div class="panel-group" id="accordion2" style="margin-bottom:15px">
  <div class="panel panel-default">
    <div class="panel-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="text-decoration:none;color:#999;">
      <i class="fa fa-sort-amount-desc"></i>  Advanced options
      </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse">
      <div class="panel-body">
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
</div>
	<div class="form-group">
		<button id="wizardquery-btn" data-loading-text="Querying..." autocomplete="off" type="button" onclick="wizardQuery( $('#algorithmDropdown').val(), $('#implementationDropdown').val(), $('#algorithmDefault').prop('checked'), $('#datasetDropdown').val(), $('#evaluationmethodDropdown').val(), $('#evaluationmetricDropdown').val(), $('input:radio[name=crosstabulate]:checked').val() );" class="btn btn-primary">
			Run Query
		</button>
	</div>
	
</form>
