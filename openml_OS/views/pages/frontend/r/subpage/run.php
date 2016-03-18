
  <ul class="hotlinks">
   <li><a class="loginfirst" href="<?php echo $_SERVER['REQUEST_URI']; ?>/json"><i class="fa fa-file-code-o fa-2x"></i></a><br>JSON</li>
   <li><a class="loginfirst" href="<?php echo BASE_URL; ?>api/v1/run/<?php echo $this->run_id;?>"><i class="fa fa-file-code-o fa-2x"></i></a><br>XML</li>
  </ul>
  <h1>Run <?php echo $this->run_id; ?></h1>

  <div class="datainfo">
     <i class="fa fa-trophy"></i> <a href="t/<?php echo $this->run['run_task']['task_id']; ?>">Task <?php echo $this->run['run_task']['task_id']; ?> (<?php echo $this->run['run_task']['tasktype']['name']; ?>)</a> <i class="fa fa-database"></i> <a href="d/<?php echo $this->run['run_task']['source_data']['data_id']; ?>"><?php echo $this->run['run_task']['source_data']['name']; ?></a>
     <i class="fa fa-cloud-upload"></i> Uploaded <?php echo dateNeat($this->run['date']); ?> by <a href="u/<?php echo $this->run['uploader_id']; ?>"><?php echo $this->run['uploader']; ?></a>
</div>

<?php
    //$this->elasticsearch->index('task',$this->run['run_task']['task_id']);
    //$this->elasticsearch->index('run',0);
 ?>

  <h3>Flow</h3>
  <div class="cardtable">
    <div class='table-responsive'><table class='table'>
    <tr class="cardrow"><td><a href="f/<?php echo $this->run['run_flow']['flow_id']; ?>"><?php echo $this->run['run_flow']['name']; ?></a></td><td><?php echo $this->flow['description']; ?></td></tr>
    <?php foreach( $this->run['run_flow']['parameters'] as $p ): ?>
    <tr class="cardrow"><td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php if(array_key_exists($p['parameter'],$this->flow_parameters)) echo $this->flow_parameters[$p['parameter']]['description']; ?>"><?php echo $p['parameter']; ?></td><td><?php echo $p['value']; ?></td></tr>
    <?php endforeach; ?>
  </table></div>

  </div>

    <h3>Result files</h3>
    <div class="list-group">
    <?php foreach( $this->run['output_files'] as $k => $v ): ?>
      <div class="list-group-item">
          <a class="btn btn-fab btn-raised btn-material-red resultfile" href="<?php echo $v['url']; ?>">
              <i class="fa fa-cloud-download"></i>
          </a>
          <div class="row-content">
              <div class="least-content"><?php echo $v['format']; ?></div>
              <div class="list-group-item-heading"><?php echo ucfirst(str_replace("_"," ",$k)); ?></div>
              <p class="list-group-item-text"><?php echo $this->file_descriptions[$k]; ?></p>
          </div>
      </div>
      <div class="list-group-separator"></div>
    <?php endforeach; ?>
  </div>

    <h3><?php echo count($this->run['evaluations']); ?> Evaluation measures</h3>
    <div class="cardtable">
    <div class='table-responsive'><table class='table' style="table-layout:fixed">
    <?php foreach( (array)$this->run['evaluations'] as $r ):
      if(count($r)<2)//if empty, skip
        continue;
      $perclass = false;
      if(in_array($r['evaluation_measure'], $this->binary_measures))
        $perclass = true;
      ?>
    <tr class="cardrow"><td><div class="col-md-3 evaltitle"><b><?php echo format_eval_name($r['evaluation_measure']); ?></b></div><div class="col-md-9">
      <div class="list-group"><div class="list-group-item">
      <?php
        if(array_key_exists('value',$r))
          echo '<span class="mainvalue">'.$r['value'].'</span>';
        if(array_key_exists('stdev',$r) and $r['evaluation_measure'] != 'number_of_instances')
          echo ' &#177; '.$r['stdev'];
        if(array_key_exists('value',$r) and array_key_exists('array_data',$r))
          echo '</div><div class="list-group-separator-full"></div><div class="list-group-item">';
        if(array_key_exists('array_data',$r)){
          if($perclass)
            echo '<div class="item-title">Per class</div>';
          ?>
          <table class="table table-bordered table-condensed" style="width: auto; overflow-x: scroll" id="table_<?php echo $r['evaluation_measure']; ?>"></table>
        <?php }
        if(array_key_exists('per_fold',$r) and !empty($r['per_fold'])  and !empty($r['per_fold'][0])){
          echo '</div><div class="list-group-separator-full"></div><div class="list-group-item">';
          echo '<div class="item-title">Cross-validation details ('.$this->run['run_task']['estimation_procedure']['name'].')</div>';
          if($r['evaluation_measure'] == 'number_of_instances'){ ?>
              <table class="table table-bordered table-condensed" style="width: auto;" id="cvtable_<?php echo $r['evaluation_measure']; ?>"></table>
          <?php } else { ?>
              <div id="folds_<?php echo $r['evaluation_measure']; ?>" style="width: 100%;height:<?php echo 70+30*count($r['per_fold']);?>px"></div>
      <?php }}
      if(array_key_exists('data',$r)){
        echo $r['data'];
      }
      if($r['evaluation_measure'] == "area_under_roc_curve"){
        $charts = $this->Vipercharts->getWhere( 'run_id = ' . $this->run['run_id'] );

        if( $charts ) {
          ?>
          <div>
            <ul class="nav nav-tabs" role="tablist">
            <?php for( $i = 0; $i < count($charts); ++$i ): ?>
              <li class="<?php if($i == 0) echo 'active';?>"><a href="#roc-chart-<?php echo $charts[$i]->class; ?>" role="tab" data-toggle="tab"><?php echo $charts[$i]->{'class'}; ?></a></li>
            <?php endfor;?>
            </ul>
            <div class="tab-content">
            <?php for( $i = 0; $i < count($charts); ++$i ): ?>
              <div class="tab-pane<?php if($i == 0) echo ' active';?>" id="roc-chart-<?php echo $charts[$i]->class; ?>">
                <iframe src="<?php echo $this->config->item('api_vipercharts') . $charts[$i]->viper_id . '/'; ?>" width="300" height="250"></iframe>
              </div>
            <?php endfor; ?>
            </div>
          </div><?php
        }
      }
      ?>
    </div></div></td></tr>
    <?php endforeach; ?>
  </table></div></div>

  <h3>Discussions</h3>
  <div class="panel disquspanel">

    <div id="disqus_thread">Loading discussions...</div>
    <script type="text/javascript">
        var disqus_shortname = 'openml'; // forum name
	      var disqus_category_id = '3353606'; // Data category
	      var disqus_title = '<?php echo 'Run '.$this->run_id; ?>'; // Data name
	      var disqus_url = 'http://www.openml.org/r/<?php echo $this->run_id; ?>'; // Data url

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
  </div>
