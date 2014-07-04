<div class="bs-callout bs-callout-info">
  <h4>Learning Curves</h4>
  Compare the learning curves of various algorithms or implementations. Results are shown in the results tab, queries can be edited in the SQL tab.
</div>

<form class="form-horizontal">
  <div class="form-group">
    <label class="col-md-2 control-label" for="searchLearningcurvesImplementationDropdown">Implementations</label>
    <div class="col-md-10">
      <input type="text" class="form-control" id="searchLearningcurvesImplementationDropdown" placeholder="Include all implementations">
      <span class="help-block">A comma separated list of implementations. Leave empty to include all implementations.</span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label" for="searchLearningcurvesDatasetDropdown">Datasets</label>
    <div class="col-md-10">
      <input type="text" class="form-control" id="searchLearningcurvesDatasetDropdown" placeholder="Include all datasets" value="" />
      <span class="help-block">A comma separated list of datasets. Leave empty to include all datasets.</span>
    </div>
  </div>
  <div class="form-group">
    <button id="wizardquery-btn" data-loading-text="Querying..." autocomplete="off" type="button" onclick="learningCurveQuery( $('#searchLearningcurvesDatasetDropdown').val(), $('#searchLearningcurvesImplementationDropdown').val() );" class="btn btn-primary">
      Run Query
    </button>
  </div>
</form>
