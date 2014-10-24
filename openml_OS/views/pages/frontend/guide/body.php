<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1">
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#guide" role="tab" data-toggle="tab">Guide</a></li>
  <li><a href="#plugins" role="tab" data-toggle="tab">Plugins</a></li>
  <li><a href="#java" role="tab" data-toggle="tab">Java</a></li>
  <li><a href="#r" role="tab" data-toggle="tab">R</a></li>
  <li><a href="#python" role="tab" data-toggle="tab">Python</a></li>
  <li><a href="#rest" role="tab" data-toggle="tab">REST API</a></li>
  <li><a href="#json" role="tab" data-toggle="tab">JSON endpoints</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="guide">
	<?php subpage('guide'); ?>
  </div>
  <div class="tab-pane" id="plugins">
	<?php subpage('plugins'); ?>
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
  <div class="tab-pane" id="rest">
	<?php subpage('rest'); ?>
  </div>
  <div class="tab-pane" id="json">
	<?php subpage('json'); ?>
  </div>

</div>

    </div> <!-- end col-10 -->
  </div>
  <!-- end row -->
</div>
<!-- end container -->
