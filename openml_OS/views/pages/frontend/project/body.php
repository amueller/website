<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1">



      <div class="tab-pane">
        <ul class="nav nav-tabs" role="tablist">
          <li class="active"><a href="#setup" role="tab" data-toggle="tab">Setups</a></li>
          <li><a href="#task" role="tab" data-toggle="tab">Tasks</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="setup">
            <?php
              echo $this->dataoverview->generate_table_static( 
                $this->setup_name, 
                $this->setup_columns, 
                $this->setup_items );
              ?>
          </div>
          <div class="tab-pane" id="task">
            <?php
             echo $this->dataoverview->generate_table_static( 
                $this->task_name, 
                $this->task_columns, 
                $this->task_items );
              ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
