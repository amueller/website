<div class="container bs-docs-container">
  <div class="bs-header">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h2>Share</h2>
          <p>Share datasets and implementations so that others can run with them. Follow how they are used, and get credit for all your work.</p>
          <p style="font-size:14px"><a href="developers#dev-tutorial">Or share stuff automatically using the OpenML API.</a></p>
        </div>
        <div class="col-md-4">
          <img src="img/openml-up.png" style="display: block;margin-left:auto;margin-right:auto;width:300px"><br />
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-3">
      <div class="bs-sidebar-fixed">
        <ul class="nav bs-sidenav-fixed" id="qtabs">
          <li class="active"><a href="#datasettab" data-toggle="tab"><i class="icon-th-list"></i>&nbsp; Datasets</a></li>
          <li><a href="#algorithmtab" data-toggle="tab"><i class="icon-cogs"></i>&nbsp; Implementations</a></li>
        </ul>
      </div>
    </div>
    <div class="tab-content col-md-9" id="qwindow">
      <!-- ****************** Dataset Tab ****************** -->
      <div class="tab-pane active" id="datasettab">
        <h2>Datasets</h2>
        <hr/>
        <form class="form-horizontal" method="post" id="datasetForm" action="api/?f=openml.data.upload" enctype="multipart/form-data">
          <input type="hidden" id="generated_input_dataset_description" name="description" value="" />
          <div class="form-group">
            <label class="col-md-2 control-label" for="input_dataset_name">Name</label>
            <div class="col-md-10">
              <input type="text" class="form-control col-md-12" id="input_dataset_name" placeholder="The name of the dataset" value="" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="input_dataset_description">Description</label>
            <div class="col-md-10">
              <textarea class="form-control" id="input_dataset_description" placeholder="The description of the dataset"></textarea> 
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="input_dataset_format">Format</label>
            <div class="col-md-10">
              <input type="text" class="form-control col-md-12" id="input_dataset_format" placeholder="arff, csv, etc." value="" /> 
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="input_dataset_default_target_attribute">Default Target Attribute</label>
            <div class="col-md-10">
              <input type="text" class="form-control col-md-12" id="input_dataset_default_target_attribute" placeholder="Attribute used as target by default. Leave empty if there is none" value="" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="input_dataset_dataset">Dataset File</label>
            <div class="col-md-10">
              <input type="file" class="col-md-12" id="input_dataset_dataset" name="dataset" style="padding:10px"/> 
            </div>
          </div>
          <div class="panel-group" id="accordion2" style="margin-bottom:15px">
            <div class="panel panel-default">
              <div class="panel-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="text-decoration:none;color:#999;">
                <i class="icon-sort-by-attributes-alt"></i>  More information
                </a>
              </div>
              <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                  <!--<div class="form-group">
                    <label class="col-md-2 control-label" for="input_dataset_version">Version</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_dataset_version" placeholder="The version of the dataset" value="1.0" />
                    </div>
                  </div>-->
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_dataset_creator">Creator</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_dataset_creator" placeholder="The creator of the dataset" value="" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_dataset_contributor">Contributor(s)</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_dataset_contributor"
                        placeholder="Other contributor(s) of the dataset, following the format: GivenName1 FamilyName1, GiveName2 FamilyName2, ..." value="" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_dataset_collection_date">Collection Date:</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_dataset_collection_date" placeholder="The date of collection" value="" /> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_dataset_row_id_attribute">Row ID Attribute</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_dataset_row_id_attribute" placeholder="The attribute used for identifying rows in the dataset" value="" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_dataset_language">Language</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_dataset_language" placeholder="The language of the dataset" value="" onblur=""/> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_dataset_collection">Collection</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_dataset_collection" placeholder="To which collection does this dataset belong, e.g. uci." value="" onblur="updateCollections();"/> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_dataset_licence">Licence</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_dataset_licence" placeholder="Under which licence is this dataset published." value="" /> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="responseDatasetTxt" class="<?php echo $this->initialMsgClass;?>"><?php echo $this->initialMsg; ?></div>
          <div class="form-group">
            <div class="col-md-10">
              <input class="btn btn-primary" type="submit" name="submit" value="Submit" /> 
            </div>
          </div>
        </form>
      </div>
      <!--  ****************** Implementation Tab ******************  -->
      <div class="tab-pane" id="algorithmtab">
        <h2>Implementation</h2>
        <hr/>
        <form class="form-horizontal" method="post" id="implementationForm" action="api/?f=openml.implementation.upload" enctype="multipart/form-data">
          <input type="hidden" id="generated_input_implementation_description" name="description" value="" />
          <div class="form-group">
            <label class="col-md-2 control-label" for="input_implementation_name">Name</label>
            <div class="col-md-10">
              <input type="text" class="form-control col-md-12" id="input_implementation_name" placeholder="The name of the algorithm or workflow" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="input_implementation_description">Description</label>
            <div class="col-md-10">
              <textarea class="form-control" id="input_implementation_description" placeholder="The description of the implementation" value=""></textarea> 
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="input_implementation_installation_notes">Readme</label>
            <div class="col-md-10">
              <textarea class="form-control" id="input_implementation_installation_notes" placeholder="Installation instructions" value=""></textarea> 
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="sourcefile">Source Code</label>
            <div class="col-md-10">
              <input type="file" class="col-md-12" id="sourcefile" name="source" style="padding:10px"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="exefile">Executable(s) </label>
            <div class="col-md-10">
              <input type="file" class="col-md-12" id="exefile" name="binary" style="padding:10px"/>
            </div>
          </div>
          <div class="panel-group" id="accordion2" style="margin-bottom:15px">
            <div class="panel panel-default">
              <div class="panel-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" style="text-decoration:none;color:#999;">
                <i class="icon-sort-by-attributes-alt"></i> More information </a>
              </div>
              <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                  <!--<div class="form-group">
                    <label class="col-md-2 control-label" for="input_implementation_version">Version</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_implementation_version" placeholder="The version of the implementation." value="" />
                    </div>
                  </div>-->
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_implementation_creator">Creator</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_implementation_creator" placeholder="The creator of the implementation." value="" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_implementation_contributor">Contributor(s)</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_implementation_contributor" 
                        placeholder="Other contributor(s) of the implementation, following the format: GivenName1 FamilyName1, GiveName2 FamilyName2, ..." value="" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_implementation_language">Programming Language</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_implementation_language" placeholder="The programming language(s) used" value="" onblur=""/> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_implementation_dependencies">Dependencies</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_implementation_dependencies" placeholder="Dependencies, packages used" value="" onblur=""/> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="input_implementation_licence">Licence</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control col-md-12" id="input_implementation_licence"  placeholder="Under which licence is this implementation published." value="" /> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="responseImplementationTxt" class="<?php echo $this->initialMsgClass;?>"><?php echo $this->initialMsg; ?></div>
          <div class="form-group">
            <div class="col-md-10">
              <input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
            </div>
          </div>
        </form>
      </div>
      <!-- div col-9 -->
    </div>
    <!-- div row -->	
  </div>
  <!-- div container-->	
</div>
