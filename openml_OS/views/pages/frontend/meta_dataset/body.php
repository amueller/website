<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1 openmlsectioninfo">
      <h2>Meta-dataset</h2>
      <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#create" role="tab" data-toggle="tab">Create</a></li>
        <li><a href="#overview" role="tab" data-toggle="tab">Overview</a></li>
      </ul>
      
      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="create">
          <div class="form-group">
            <form method="post" action="">
              <div class="form-group">
                <label class="col-md-2 control-label" for="datasetDropdown">Datasets</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="datasetDropdown" name="datasets" placeholder="Include all datasets" value="" />
                  <span class="help-block">A comma separated list of datasets. Leave empty to include all datasets.</span>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label" for="taskDropdown">Tasks</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="taskDropdown" name="tasks" placeholder="Include all tasks" value="" />
                  <span class="help-block">A comma separated list of tasks. Leave empty to include all tasks on the specified datasets.</span>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label" for="flowDropdown">Flows</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="flowDropdown" name="flows" placeholder="Include all flows" value="">
                  <span class="help-block">A comma separated list of flows. Leave empty to include all flows.</span>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label" for="setupDropdown">Setups</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="setupDropdown" name="setups" placeholder="Include all setups" value="">
                  <span class="help-block">A comma separated list of setups. Leave empty to include all setups on the specified flows.</span>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label" for="functionSelect">Evaluation Measures</label>
                <div class="col-md-10">
                  <?php foreach( $this->measures as $m ): ?>
                  <input type="checkbox" id="functionSelect" name="functions[]" value="<?php echo $m; ?>" checked />&nbsp;<?php echo str_replace( '_', ' ', $m ); ?><br/>
                  <?php endforeach; ?>
                  <span class="help-block">Select at least one evaluation measure you&#39;re interested in </span>
                </div>
              </div>
              <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Submit"/>
              </div>
            </form>
          </div>
        </div>
        <div class="tab-pane" id="overview">
          <?php
            echo $this->dataoverview->generate_table_static( 
              $this->name, 
              $this->columns, 
              $this->items );
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
