<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1">



      <div class="tab-pane">
        <ul class="nav nav-tabs" role="tablist">
          <li class="active"><a href="#missing" role="tab" data-toggle="tab">Missing</a></li>
          <li><a href="#size" role="tab" data-toggle="tab">Size</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="missing">
            <?php
              echo $this->dataoverview->generate_table_static( 
                $this->missing_name, 
                $this->missing_columns, 
                $this->missing_items, 
                $this->missing_api_delete_function );
              ?>
          </div>
          <div class="tab-pane" id="size">
            <?php
              echo $this->dataoverview->generate_table_static( 
                $this->size_name, 
                $this->size_columns, 
                $this->size_items, 
                $this->size_api_delete_function );
              ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
