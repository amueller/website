<div class="clearfix"></div>

<div class="row">
	<div class="col-md-2">
	    <div class="bs-sidebar-fixed">
		<ul class="nav bs-sidenav-fixed" id="result-tabs">
			<li><a href="#tabletab" data-toggle="tab"><i class="icon-th-list"></i>&nbsp; Table</a></li>
			<li><a href="#scatterplottab" data-toggle="tab" onclick="onclickScatterPlot();"><i class="icon-bar-chart"></i>&nbsp; Scatterplot</a></li>
			<li><a href="#linetab" data-toggle="tab" onclick="onclickLinePlot();"><i class="icon-bar-chart"></i>&nbsp; Line plot</a></li>
		</ul>
            </div>
	</div>

	<div class="tab-content col-md-10" id="resulstab_content" style="overflow: visible;">

		<div class="tab-pane" id="scatterplottab">
			<div id="topmenuScatter"></div>	    
			<p id="scattermain"><div class="bs-callout bs-callout-danger">
      <h4>No data</h4>
      <p>Do a query using the Run, Advanced, SQL or Graph Search.</p>
    </div></p>   
		</div>
		
		<div class="tab-pane active" id="tabletab">


			<div class='topmenu'>
 <div class="btn-toolbar" style="margin: 0;">

              <div class="btn-group" style="float:right;width:250px">
<form class="form-inline pull-right" id="exportResultForm" method="post" action="frontend/result_output" style="float:right">
					<input type="hidden" name="name" id="exportResultName" />
					<input type="hidden" name="type" id="exportResultType" />
					<input type="hidden" name="data" id="exportResultData" />
<div class="btn-group" style="float:right">
							
<input type="text" name="name" value="MyFile.csv" class="col-md-4 input" style="height: 33px;width:160px;margin-right:-2px">
							
<a type="submit" class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">Export <col-md-* class="caret"></col-md-*></a>
							<ul class="dropdown-menu">
								<li><a onclick="exportResult('csv');">CSV</a></li>
							</ul>
</div>
</form>
				<output></output>
              </div>
              <div class="btn-group" style="float:right">
				<button id="crosstabulateBtn" data-loading-text="Calculating..." autocomplete="off"  class="btn btn-default" onclick="toggleResultTables();" >
					Crosstabulate
				</button>
              </div>
            </div>
			</div>
			<div id='tableinfo'></div>
			<div style="clear: both;"></div>
			<div id="tablemain"><div class="bs-callout bs-callout-danger">
      <h4>No data</h4>
      <p>Do a query using the Run, Advanced, SQL or Graph Search.</p>
    </div></div>
		</div>
		
		<div class="tab-pane" id="linetab">
			<div id="topmenuLine"></div>	 
			<p id="linemain"><div class="bs-callout bs-callout-danger">
      <h4>No data</h4>
      <p>Do a query using the Run, Advanced, SQL or Graph Search.</p>
    </div></p>
		</div>
	</div>
</div>
