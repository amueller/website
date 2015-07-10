<div class="container-fluid topborder endless guidecontainer openmlsectioninfo">
  <div class="col-xs-12 col-md-10 col-md-offset-1 guidesection" id="mainpanel">

<div class="tab-content">
  <div class="tab-pane active" id="intro">
  <?php subpage('guide'); ?>
  </div>
  <div class="tab-pane" id="devels">
  <?php subpage('developers'); ?>
  </div>
  <div class="tab-pane" id="terms">
  <?php subpage('terms'); ?>
  </div>
  <div class="tab-pane" id="cite">
  <?php subpage('citing'); ?>
  </div>
  <div class="tab-pane" id="team">r
  <?php subpage('team'); ?>
  </div>
  <div class="tab-pane" id="plugin_weka">
  <?php subpage('plugin_weka'); ?>
  </div>
  <div class="tab-pane" id="plugin_moa">
  <?php subpage('plugin_moa'); ?>
  </div>
  <div class="tab-pane" id="plugin_mlr">
  <?php subpage('plugin_mlr'); ?>
  </div>
  <div class="tab-pane" id="plugin_rm">
  <?php subpage('plugin_rm'); ?>
  </div>
  <div class="tab-pane" id="java">
  <?php subpage('java'); ?>
  </div>
  <div class="tab-pane" id="r">
  <?php subpage('r'); ?>
  </div>
  <div class="tab-pane" id="python">
  <?php subpage('python'); ?>
  </div>
  <div class="tab-pane" id="rest_tutorial">
  <?php subpage('rest_tutorial'); ?>
  </div>
  <?php subpage('rest_services'); ?>
  <div class="tab-pane" id="json">
  <?php subpage('json'); ?>
  </div>
</div>
    </div> <!-- end col-10 -->




    <div class="submenu">
    <ul class="sidenav nav" id="accordeon">
      <li class="panel guidechapter">
        <a data-toggle="collapse" data-parent="#accordeon"  data-target="#startlist"><i class="fa fa-graduation-cap fa-fw fa-lg"></i> <b>Getting Started</b></a>
        <ul class="sidenav nav collapse" id="startlist">
          <li class="active"><a href="#intro" data-toggle="tab">10 minute intro</a></li>
          <li><a href="#terms" data-toggle="tab">Honor Code</a></li>
          <li><a href="#team" data-toggle="tab">Our Team</a></li>
        </ul>
      </li>
      <li class="panel guidechapter">
       <a data-toggle="collapse" data-parent="#accordeon"  data-target="#pluginlist"><i class="fa fa-bolt fa-fw fa-lg"></i> <b>Using plugins</b></a>
       <ul class="sidenav nav collapse" id="pluginlist">
        <li><a href="#plugin_weka" data-toggle="tab">WEKA</a></li>
        <li><a href="#plugin_moa" data-toggle="tab">MOA</a></li>
        <li><a href="#plugin_mlr" data-toggle="tab">mlr</a></li>
        <li><a href="#plugin_rm" data-toggle="tab">RapidMiner</a></li>
       </ul>
      </li>
      <li class="panel guidechapter">
       <a  data-toggle="collapse" data-parent="#accordeon" data-target="#apilist"><i class="fa fa-wrench fa-fw fa-lg"></i> <b>Developers</b></a>
       <ul class="sidenav nav collapse" id="apilist">
        <li><a href="#devels" data-toggle="tab">Resources</a></li>
        <li><a href="#java" data-toggle="tab">Java API</a></li>
        <li><a href="#r" data-toggle="tab">R API</a></li>
        <li><a href="#python" data-toggle="tab">Python API</a></li>
        <li><a href="#rest_tutorial" data-toggle="tab">REST API Tutorial</a></li>
        <li><a data-toggle="collapse" data-target="#servicelist">REST API Services</a></li>
        <ul class="sidenav nav collapse" id="servicelist">
              <li><a data-toggle="tab" href="#openml_authenticate">openml.authenticate</a></li>
              <li><a data-toggle="tab" href="#openml_authenticate_check">openml.authenticate.check</a></li>
              <li><a data-toggle="tab" href="#openml_data">openml.data</a></li>
              <li><a data-toggle="tab" href="#openml_data_description">openml.data.description</a></li>
              <li><a data-toggle="tab" href="#openml_data_upload">openml.data.upload</a></li>
              <li><a data-toggle="tab" href="#openml_data_delete">openml.data.delete</a></li>
              <li><a data-toggle="tab" href="#openml_data_licences">openml.data.licences</a></li>
              <li><a data-toggle="tab" href="#openml_data_features">openml.data.features</a></li>
              <li><a data-toggle="tab" href="#openml_data_qualities">openml.data.qualities</a></li>
              <li><a data-toggle="tab" href="#openml_data_qualities_list">openml.data.qualities.list</a></li>
              <li><a data-toggle="tab" href="#openml_task_search">openml.task</a></li>
              <li><a data-toggle="tab" href="#openml_task_types_search">openml.task.types.search</a></li>
              <li><a data-toggle="tab" href="#openml_task_evaluations">openml.task.evaluations</a></li>
              <li><a data-toggle="tab" href="#openml_task_types">openml.task.types</a></li>
              <li><a data-toggle="tab" href="#openml_estimationprocedure_get">openml.estimationprocedure</a></li>
              <li><a data-toggle="tab" href="#openml_implementation_exists">openml.implementation.exists</a></li>
              <li><a data-toggle="tab" href="#openml_implementation_upload">openml.implementation.upload</a></li>
              <li><a data-toggle="tab" href="#openml_implementation_owned">openml.implementation.owned</a></li>
              <li><a data-toggle="tab" href="#openml_implementation_delete">openml.implementation.delete</a></li>
              <li><a data-toggle="tab" href="#openml_implementation_licences">openml.implementation.licences</a></li>
              <li><a data-toggle="tab" href="#openml_evaluation_measures">openml.evaluation.measures</a></li>
              <li><a data-toggle="tab" href="#openml_run_get">openml.run</a></li>
              <li><a data-toggle="tab" href="#openml_run_upload">openml.run.upload</a></li>
              <li><a data-toggle="tab" href="#openml_run_delete">openml.run.delete</a></li>
              <li><a data-toggle="tab" href="#openml_job_get">openml.job</a></li>
              <li><a data-toggle="tab" href="#openml_setup_delete">openml.setup</a></li>
        </ul>
        <li><a href="#json" data-toggle="tab">JSON endpoints</a></li>
       </ul>
      </li>
      <li style="margin:15px;"><a href="#cite" data-toggle="tab"><i class="fa fa-fw fa-heart"></i> Citing OpenML</a></li>
    </ul>
    </div> <!-- end submenu -->

</div>
<!-- end container -->
