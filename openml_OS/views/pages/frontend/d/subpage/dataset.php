    <?php if($this->blocked){
		o('no-access');
	  } else {
    ?>

    <ul class="hotlinks">
	 <li><a class="loginfirst" href="<?php echo $this->data['url']; ?>"><i class="fa fa-cloud-download fa-2x"></i></a></li>
	 <li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>/json"><i class="fa fa-code fa-2x"></i></a></li>
	 <li>   <div class="version" style="margin-bottom: -17px;">
		  <select class="selectpicker" data-width="auto" onchange="location = this.options[this.selectedIndex].value;">
			  <?php foreach( $this->versions as $v ) { ?>
				<option value="<?php echo 'd/'.$v['data_id'];?>" <?php echo $v['version'] == $this->data['version'] ? 'selected' : '';?>>v. <?php echo $v['version']; ?></option>
			  <?php } ?>
			</select>
	        </div></li>
    </ul>
    <h1 class="pull-left"><a href="d"><i class="fa fa-database"></i></a>
	     <?php echo $this->data['name']; ?>
    </h1>

    <div class="datainfo">
       <span class="label label-<?php echo ($this->data['status'] == 'active' ? 'success' : ($this->data['status'] == 'in_preparation' ? 'warning' : 'danger'))?>"><?php echo $this->data['status'];?></span>
       <i class="fa fa-table"></i> <?php echo (strtolower($this->data['format']) == 'arff' ? '<a href="http://weka.wikispaces.com/ARFF+%28developer+version%29" target="_blank">ARFF</a>' : $this->data['format']); ?>
       <?php if($this->data['licence']):?><i class="fa fa-cc"></i>
         <?php if(!array_key_exists($this->data['licence'],$this->licences)): echo $this->data['licence'];
               else: $l = $this->licences[$this->data['licence']]; echo '<a href="'.$l['url'].'">'.$l['name'].'</a>';
             endif; endif;?>
       <i class="fa fa-eye-slash"></i> Visibility: <?php echo strtolower($this->data['visibility']); ?>
       <i class="fa fa-cloud-upload"></i> Uploaded <?php echo dateNeat( $this->data['date']); ?> by <a href="u/<?php echo $this->data['uploader_id'] ?>"><?php echo $this->data['uploader'] ?></a>
       <?php if($this->is_owner)
		      echo '<i class="fa fa-pencil-square-o"></i> <a href="d/'.$this->id.'/update">Edit</a>';
	      ?>


    </div>

  <div class="col-xs-12 panel" onclick="showmore()">
    <div class="cardactions">
      <div class="wiki-buttons">
        <div class="pull-right" id="wiki-waiting">
          <i class="fa fa-spinner fa-pulse"></i> Loading wiki
        </div>
        <div class="pull-right" id="wiki-ready">
          <?php if(!$this->editing){ ?>
            <span style="font-size:10px;font-style:italic;color:#666">Help us complete this description <i class="fa fa-long-arrow-right"></i></span>
          <?php } ?>
          <a class="pull-right greenheader loginfirst" href="d/<?php echo $this->id; ?>/edit"><i class="fa fa-edit fa-lg"></i> Edit</a>
          <?php if ($this->show_history) { ?>
          <a class="pull-right" href="d/<?php echo $this->id; ?>/history"><i class="fa fa-clock-o fa-lg"></i> History</a>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="card-content">
     <div class="description <?php if($this->hidedescription) echo 'hideContent';?>">
	    <?php
        echo $this->wikiwrapper;
      ?>
     </div>
    </div>
  </div>


  <h3><?php echo $this->data['qualities']['NumberOfFeatures']; ?> features</h3>
<?php
  if (!empty($this->data['features'])){ ?>
      <div class="cardtable">
			<div class="features <?php echo ($this->showallfeatures ? '' : 'hideFeatures'); ?>">
			<div class="table-responsive">
				<table class="table">
				<?php
        foreach( $this->data['features'] as $r ) {
				//get target values
					echo "<tr class='cardrow'><td>" . $r['name'] . ( array_key_exists('target',$r) ? ' <b>(target)</b>': '').( array_key_exists('identifier',$r) ? ' <b>(row identifier)</b>': '').( array_key_exists('ignore',$r) ? ' <b>(ignore)</b>': ''). "</td><td>" . $r['type'] . "</td><td>" . $r['distinct'] . " unique values<br> " . $r['missing'] . " missing</td><td class='feat-distribution'><div id='feat".$r['index']."' style='height: 90px; margin: auto; min-width: 300px; max-width: 50%;'></div></td></tr>";
				}
					?>
				</table>
			</div>
			</div>
    </div>

	<div class="show-more-features">
	<?php if(!$this->showallfeatures){ ?>
		<a class="cardaction" onclick="showmorefeats()"><i class="fa fa-chevron-down"></i> Show <?php echo ($this->data['qualities']['NumberOfFeatures']<100 ? 'all '.$this->data['qualities']['NumberOfFeatures'] : 'first 100'); ?> features</a>
	<?php } ?>
	</div>
        <div class="show-all-features">
	<?php if(isset($this->highFeatureCount) and $this->highFeatureCount){ ?>
		<a href="d/<?php echo $this->id; ?>?show=all">Show all <?php echo $this->data['qualities']['NumberOfFeatures']; ?> features.</a><br>This may take a while to load.
	<?php } ?>
	</div>

	<!-- features unavailable -->
	<?php } else {
			    echo '<p>Data features are not analyzed yet. Refresh the page in a few minutes.</p>';
	      } ?>



<?php
  echo '<h3>'.sizeof($this->data['qualities']).' properties</h3>';

  if (!empty($this->data['qualities'])){
  $qtable = ""; ?>
    <div class="properties <?php if($this->hidedescription) echo 'hideProperties'; ?>">
    <?php if($this->data['qualities']){
      foreach( $this->dataproperties as $dp ) {
        if(array_key_exists($dp['name'], $this->data['qualities'])){
        ?>
      <div class="searchresult panel">
      <div class="itemhead">
      <a href="a/data-qualities/<?php echo $dp['name']; ?>" class="iconpurple">
      <i class="fa fa-fw fa-bar-chart"></i> <?php echo $dp['name']; ?></a>
      </div>
      <div class="dataproperty"><?php
        $qval = $this->data['qualities'][$dp['name']];
        if(is_numeric($qval)){
          echo round($qval,2);
        } elseif($qval=='true'){
          echo "<i class='fa fa-check fa-lg'></i>";
        } elseif($qval=='false'){
          echo "<i class='fa fa-times fa-lg'></i>";
        } else{
          echo $qval;
        } ?>
      </div>
      <div class="datadescription"><?php echo $dp['description'].' '.$dp['function'];?></div>
      </div>
      <?php }}} ?> </div>
      <?php } else {
        echo '<p>Data properties are not analyzed yet. Refresh the page in a few minutes.</p>';
        } ?>

    <?php if (!empty($this->data['qualities'])){ ?>
    <div class="show-more-props">
      <a class="cardaction" onclick="showmoreprops()"><i class="fa fa-chevron-down"></i> Show all <?php echo sizeof($this->data['qualities']);?> properties</a>
    </div>
    <?php } ?>

		<h3><?php echo count($this->tasks); ?> tasks</h3>
		<?php foreach( $this->tasks as $q){?>
      <div class="searchresult panel">
        <div class="itemheadfull">
          <i class="fa fa-trophy fa-lg" style="color:#fb8c00;"></i>
          <a href="t/<?php echo $q['task_id']; ?>"><?php echo $q['tasktype']['name'].' on '.$q['source_data']['name']; ?></a>
        </div>
        <div class="runStats statLine">
          <?php
            echo '<b>'.$q['runs'].' runs</b>';
            echo ' - estimation_procedure: '.$q['estimation_procedure']['name'];
            if(array_key_exists('evaluation_measures',$q)) echo ' - evaluation_measure: '.$q['evaluation_measures'];
            if(array_key_exists('target_feature',$q)) echo ' - target_feature: '.$q['target_feature'];
            ?>
        </div>
      </div>
    <?php } ?>
  <a class="loginfirst btn btn-default btn-raised" href="new/task?data=<?php echo htmlentities($this->data['name'].'('.$this->data['version'].')');?>">Define a new task</a>

  <?php if($this->data['visibility'] != 'private'){ ?>
  <h3>Discussions</h3>
  <div class="panel disquspanel">
    <div id="disqus_thread">Loading discussions...</div>
  </div>

  <script type="text/javascript">
  var disqus_shortname = 'openml'; // forum name
	var disqus_category_id = '3353609'; // Data category
	var disqus_title = '<?php echo $this->data['name']; ?>'; // Data name
	var disqus_url = 'http://www.openml.org/d/<?php echo $this->id; ?>'; // Data url

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
  </script>
  <?php } ?>
  <?php } ?>
