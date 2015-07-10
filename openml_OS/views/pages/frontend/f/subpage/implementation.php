
<ul class="hotlinks">
<li><a class="loginfirst" href="<?php echo "#todo"; ?>"><i class="fa fa-cloud-download fa-2x"></i></a></li>
<li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>/json"><i class="fa fa-code fa-2x"></i></a></li>

<li>   <div class="version" style="margin-bottom: -17px;">
  <select class="selectpicker" data-width="auto" onchange="location = this.options[this.selectedIndex].value;">
    <?php foreach( $this->versions as $k => $v ) { ?>
    <option value="<?php echo 'f/'.$k;?>" <?php echo $v == $this->flow['version'] ? 'selected' : '';?>>v. <?php echo $v; ?></option>
    <?php } ?>
  </select>
      </div></li>
</ul>

<h1 class="pull-left"><a href="f"><i class="fa fa-cogs"></i></a> <?php echo $this->displayName; ?></h1>

<div class="datainfo">
   <?php if($this->flow['licence']): ?><i class="fa fa-cc"></i> <?php $l = $this->licences[$this->flow['licence']]; echo '<a href="'.$l['url'].'">'.$l['name'].'</a>'; endif; ?>
   <i class="fa fa-eye-slash"></i> Visibility: <?php echo strtolower($this->flow['visibility']); ?>
   <i class="fa fa-cloud-upload"></i> Uploaded <?php echo dateNeat( $this->flow['date']); ?> by <a href="u/<?php echo $this->flow['uploader']; ?>"><?php echo $this->flow['uploader'];?></a>
   <?php if($this->flow['dependencies']): ?><i class="fa fa-sitemap"></i> <?php echo $this->flow['dependencies']; endif; ?>
   <i class="fa fa-star"></i><?php echo $this->flow['runs']; ?> runs
</div>

<div class="col-xs-12 panel" onclick="showmore()">
  <div class="cardactions">
    <div class="wiki-buttons">
    <span style="font-size:10px;font-style:italic;color:#666">Help us complete this description <i class="fa fa-long-arrow-right"></i></span>
    <a class="pull-right greenheader loginfirst" href="f/<?php echo $this->id; ?>/edit"><i class="fa fa-edit fa-lg"></i> Edit</a>
    <?php if ($this->show_history) { ?>
    <a class="pull-right" href="d/<?php echo $this->id; ?>/history"><i class="fa fa-clock-o fa-lg"></i> History</a>
    <?php } ?>
    </div>
  </div>
  <div class="card-content">
   <div class="description <?php if($this->hidedescription) echo 'hideContent';?>">
    <?php echo $this->wikiwrapper; ?>
   </div>
  </div>
</div>

  <?php
	  if (is_array($this->flow['components']) and sizeof($this->flow['components'])>0){
     ?>
			<h2>Components</h2>
      <div class="panel tablepanel">
			<div class="table-responsive">
				<table class="table">
				<?php
					foreach( $this->flow['components'] as $c ){
						echo "<tr><td>" . $c['identifier'] . "</td><td><a href='f/" . $c['id'] . "'>" . $c['name'] . "</a></td><td>".$c['description']."</td></tr>";
					}
				?>
				</table>
			</div>
      </div> <!-- end col-md-6 -->
      <?php } /*endif components*/ ?>

			<h2>Parameters</h2>
      <div class="panel tablepanel">
			<div class="table-responsive">
				<table class="table">
				<?php
        if (is_array($this->flow['parameters']) and sizeof($this->flow['parameters'])>0){
				foreach( $this->flow['parameters'] as $r ) {
					echo "<tr><td>" . $r['name'] . "</td><td>" . $r['description'] . "</td><td>".(strlen($r['default_value'])>0 ? "default: " . $r['default_value'] : "").(strlen($r['recommended_range'])>0 ? "<br><div class='tip recommendedrange' data-toggle='tooltip' data-placement='left' title='Recommended range'><i class='fa fa-thumbs-o-up'></i> ". $r['recommended_range'] . "</div>" : "")."</td></tr>";}
        }
				?>
				</table>
			</div>
      </div> <!-- end col-md-6 -->

	  <div class="qualities col-xs-12">
		  <?php
      $qtable = "";
			if (sizeof($this->flow['qualities'])>0){
			echo '<h3>'.sizeof($this->flow['qualities']).' properties</h3>';

			foreach( $this->flow['qualities'] as $k => $v ) {
				$qtable .= "<tr><td><a href='a/flow-qualities/".cleanName($k)."'>" . $k . "</a></td><td>";
 					if(is_numeric($v)){ $qtable .= round($v,2); }
					else{ $qtable .= $v;}
				$qtable .= "</td></tr>";
			}} ?>
    		 </div><div class="col-xs-12">
		 <?php
			if(strlen($qtable)>1){
				echo "<a data-toggle='collapse' href='#algoquals'><i class='fa fa-caret-right'></i> Show more</a><div id='algoquals' class='collapse'><div class='table-responsive'><table class='table table-striped'>" . $qtable . "</table></div></div>";}
		 ?>
		 </div>

		<h3><div id="runcount"></div> Runs</h3>
	    <?php
	      $taskparams['index'] = 'openml';
	      $taskparams['type']  = 'task_type';
	      $taskparams['body']['query']['match_all'] = array();
	      $alltasks = $this->searchclient->search($taskparams)['hits']['hits'];
	    ?>
      <div style="float:right">
      Parameter:
          <select class="selectpicker" data-width="auto" onchange="selected_parameter = this.value; oTableRuns.fnDraw(true); redrawchart();">
            <option value="none" selected>none</option>
            <?php foreach($this->flow['parameters'] as $r): ?>
            <option value="<?php echo $r['full_name'];?>"><?php echo str_replace('_', ' ', $r['name'] );?></option>
            <?php endforeach; ?>
          </select>
      </div>
		<select class="selectpicker" data-width="auto" onchange="current_task = this.value; oTableRuns.fnDraw(true); redrawchart();">
	    <?php foreach($alltasks as $h){?>
                <option value="<?php echo $h['_id']; ?>" <?php echo ($h['_id'] == $this->current_task) ? 'selected' : '';?>><?php echo $h['_source']['name']; ?></option>
	    <?php } ?>
		</select>
    <select class="selectpicker" data-width="auto" onchange="evaluation_measure = this.value; oTableRuns.fnDraw(true); updateTableHeader(); redrawchart();">
					<?php foreach($this->allmeasures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
		</select>

			<div id="code_result_visualize" class="panel-simple" style="width: 100%">Plotting chart <i class="fa fa-spinner fa-spin"></i></div>

			<div class="panel">   <div class="table-responsive">
				<table id="datatable_main" class="table table-bordered table-condensed table-responsive">
					<?php echo generate_table(
								array('img_open' => '',
										'rid' => 'run id',
										'sid' => 'setup id',
										'name' => 'Name',
										'value' => str_replace('_',' ',$this->current_measure), ) ); ?>
				</table></div>
			</div>

<div class="modal fade" id="runModal" role="dialog" tabindex="-1" aria-labelledby="Run detail" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
		</div> <!-- end tab-runs -->

<div class="panel">
    <div id="disqus_thread">Loading discussions...</div>
</div>
    <script type="text/javascript">
        var disqus_shortname = 'openml'; // forum name
	var disqus_category_id = '3353608'; // Data category
	var disqus_title = '<?php echo $this->displayName; ?>'; // Data name
	var disqus_url = 'http://openml.org/f/<?php echo $this->id; ?>'; // Data url

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>

    <!-- redirect communication to gollum -->
    <script>
    $("#gollum-editor-message-field").val("Write a small message explaining the change.");
    $("#gollum-editor-submit").addClass("btn btn-success pull-left");
    $("#gollum-editor-preview").removeClass("minibutton");
    $("#gollum-editor-preview").addClass("btn btn-default padded-button");
    $("#gollum-editor-preview").attr("href","preview");
    $("#version-form").attr('action', "f/<?php echo $this->id; ?>/compare/<?php echo $this->wikipage; ?>");
    $("a[title*='View commit']").each(function() {
       var _href = $(this).attr("href");
       $(this).attr('href', 'f/<?php echo $this->id; ?>/view' + _href);
    });

    $( "#gollum-editor-preview" ).click(function() {
    	var $form = $($('#gollum-editor form').get(0));
            $form.attr('action', '');
    });

    $("a[title*='View commit']").each(function() {
       var _href = $(this).attr("href");
       $(this).attr('href', 'f/<?php echo $this->id; ?>/view' + _href);
    });
    </script>
