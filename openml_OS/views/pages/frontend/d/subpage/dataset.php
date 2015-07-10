    <?php if($this->blocked){
		o('no-access');
	  } else {
    $fgraphs = '';
    $fgraphs_all = '';

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
       <i class="fa fa-table"></i> <?php echo (strtolower($this->data['format']) == 'arff' ? '<a href="http://weka.wikispaces.com/ARFF+%28developer+version%29" target="_blank">ARFF</a>' : $this->data['format']); ?>
       <?php if($this->data['licence']): ?><i class="fa fa-cc"></i> <?php $l = $this->licences[$this->data['licence']]; echo '<a href="'.$l['url'].'">'.$l['name'].'</a>'; endif; ?>
       <i class="fa fa-eye-slash"></i> Visibility: <?php echo strtolower($this->data['visibility']); ?>
       <i class="fa fa-cloud-upload"></i> Uploaded <?php echo dateNeat( $this->data['date']); ?> by <a href="u/<?php echo $this->data['uploader_id'] ?>"><?php echo $this->data['uploader'] ?></a>
       <?php if($this->is_owner)
		      echo '<i class="fa fa-pencil-square-o"></i> <a href="d/'.$this->id.'/update">Edit</a>';
	      ?>
    </div>

  <div class="col-xs-12 panel" onclick="showmore()">
    <div class="cardactions">
      <div class="wiki-buttons">
      <span style="font-size:10px;font-style:italic;color:#666">Help us complete this description <i class="fa fa-long-arrow-right"></i></span>
      <a class="pull-right greenheader loginfirst" href="d/<?php echo $this->id; ?>/edit"><i class="fa fa-edit fa-lg"></i> Edit</a>
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


  <h3><?php echo sizeof($this->data['features']); ?> features</h3>
<?php
  if (!empty($this->data['features'])){ ?>
      <div class="cardtable">
			<div class="features <?php echo ($this->showallfeatures ? '' : 'hideFeatures'); ?>">
			<div class="table-responsive">
				<table class="table">
				<?php
				//get target values
				$featCount = 0;
				foreach( $this->features as $r ) {
					$newGraph = '';
			      if($r->{'data_type'} == "numeric"){
						$newGraph = '$("#feat'.$r->{'index'}.'").highcharts({chart:{type:\'boxplot\',inverted:true,backgroundColor:null},exporting:false,credits:false,title: null,legend:{enabled: false},tooltip:false,xAxis:{title:null,labels:{enabled:false},tickLength:0},yAxis:{title:null,labels:{style:{fontSize:\'8px\'}}},series: [{data: [['.$r->{'MinimumValue'}.','.($r->{'MeanValue'}-$r->{'StandardDeviation'}).','.$r->{'MeanValue'}.','.($r->{'MeanValue'}+$r->{'StandardDeviation'}).','.$r->{'MaximumValue'}.']]}]});';
					} else if (strlen($r->{'ClassDistribution'})>0) {
						$distro = json_decode($r->{'ClassDistribution'});
						$newGraph = '$("#feat'.$r->{'index'}.'").highcharts({chart:{type:\'column\',backgroundColor:null},exporting:false,credits:false,title:false,xAxis:{title:false,labels:{'.(count($distro[0])>10 ? 'enabled:false' : 'style:{fontSize:\'9px\'}').'},tickLength:0,categories:[\''.implode("','", str_replace("'", "", $distro[0])).'\']},yAxis:{min:0,title:false,gridLineWidth:0,minorGridLineWidth:0,labels:{enabled:false},stackLabels:{enabled:true,useHTML:true,style:{fontSize:\'9px\'}}},legend:{enabled: false},tooltip:{useHTML:true,shared:true},plotOptions:{column:{stacking:\'normal\'}},series:[';

					for($i=0; $i<count($this->classvalues); $i++){
						$newGraph .= '{name:\''.$this->classvalues[$i].'\',data:['.implode(",",array_column($distro[1], $i)).']}';
						if($i!=count($this->classvalues)-1)
							$newGraph .= ',';
					}
					if(count($this->classvalues)==0){
						$newGraph .= '{name:"count",data:['.implode(",",array_column($distro[1], 0)).']}';
					}
					$newGraph .= ']});';
					}
					if($featCount<3 or $this->showallfeatures){
						$fgraphs = $newGraph . PHP_EOL . $fgraphs;
						$featCount = $featCount + 1;
					}
					else
						$fgraphs_all = $newGraph . PHP_EOL . $fgraphs_all;


					echo "<tr class='cardrow'><td>" . $r->{'name'} . ( $r->{'is_target'} == 'true' ? ' <b>(target)</b>': '').( $r->{'is_row_identifier'} == 'true' ? ' <b>(row identifier)</b>': '').( $r->{'is_ignore'} == 'true' ? ' <b>(ignore)</b>': ''). "</td><td>" . $r->{'data_type'} . "</td><td>" . $r->{'NumberOfDistinctValues'} . " unique values<br> " . $r->{'NumberOfMissingValues'} . " missing</td><td class='feat-distribution'><div id='feat".$r->{'index'}."' style='height: 90px; margin: auto; min-width: 300px; max-width: 50%;'></div></td></tr>";

				}
					?>
				</table>
			</div>
			</div>
    </div>

	<div class="show-more-features">
	<?php if(!$this->showallfeatures){ ?>
		<a class="cardaction" onclick="showmorefeats()"><i class="fa fa-chevron-down"></i> Show <?php echo (count($this->features)<100 ? 'all '.count($this->features) : 'first 100'); ?> features</a>
	<?php } ?>
	</div>
        <div class="show-all-features">
	<?php if(isset($this->highFeatureCount) and $this->highFeatureCount){ ?>
		<a href="d/<?php echo $this->id; ?>?show=all">Show all <?php echo $this->nrfeatures; ?> features.</a><br>This may take a while to load.
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
    <?php foreach( $this->properties as $r ) { ?>
      <div class="searchresult panel">
      <div class="itemhead">
      <a href="a/data-qualities/<?php echo cleanName($r->{'quality'}); ?>" class="iconpurple">
      <i class="fa fa-fw fa-bar-chart"></i> <?php echo $r->{'quality'}; ?></a>
      </div>
      <div class="dataproperty"><?php
        if(is_numeric($r->{'value'})){
          echo round($r->{'value'},2);
        } elseif($r->{'value'}=='true'){
          echo "<i class='fa fa-check fa-lg'></i>";
        } elseif($r->{'value'}=='false'){
          echo "<i class='fa fa-times fa-lg'></i>";
        } else{
          echo $r->{'value'};
        } ?>
      </div>
      <div class="datadescription"><?php if(array_key_exists($r->{'quality'},$this->dataproperties)) echo $this->dataproperties[$r->{'quality'}]['description']; else echo 'No description.';?></div>
      </div>
      <?php } ?> </div>
      <?php } else {
        echo '<p>Data properties are not analyzed yet. Refresh the page in a few minutes.</p>';
        } ?>

    <div class="show-more-props">
      <a class="cardaction" onclick="showmoreprops()"><i class="fa fa-chevron-down"></i> Show all <?php echo sizeof($this->properties);?> properties</a>
    </div>


		<h3><?php echo count($this->tasks_all); ?> tasks</h3>
    <a class="loginfirst" href="new/task"><i class="fa fa-plus-circle"></i> Define a new task on this data set</a>
    <div class="searchframe">
		<?php if(count($this->tasks_all)==0){ ?>
				<p>There haven't been any tasks created on this dataset yet. <a href="new/task">Create a task on this data set.</a></p>
		<?php } else {
			$this->filtertype = 'task';
			$this->sort = 'runs';
			if($this->input->get('sort'))
			  $this->sort = safe($this->input->get('sort'));
			$this->specialterms = 'source_data.data_id:'.$this->id;
	    		loadpage('search', true, 'pre');
	    		loadpage('search/subpage', true, 'results'); ?>

		<?php } ?>
  </div>


	<?php } ?>

  <?php if(!$this->blocked){ ?>
  <div class="panel">
    <div id="disqus_thread">Loading discussions...</div>
  </div>
  <?php } ?>

    <script type="text/javascript">
        var disqus_shortname = 'openml'; // forum name
	var disqus_category_id = '3353609'; // Data category
	var disqus_title = '<?php echo $this->record->{'name'}; ?>'; // Data name
	var disqus_url = 'http://openml.org/d/<?php echo $this->id; ?>'; // Data url

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
$("#version-form").attr('action', "d/<?php echo $this->id; ?>/compare/<?php echo $this->wikipage; ?>");
$("a[title*='View commit']").each(function() {
   var _href = $(this).attr("href");
   $(this).attr('href', 'd/<?php echo $this->id; ?>/view' + _href);
});

$( "#gollum-editor-preview" ).click(function() {
	var $form = $($('#gollum-editor form').get(0));
        $form.attr('action', '');
});

$("a[title*='View commit']").each(function() {
   var _href = $(this).attr("href");
   $(this).attr('href', 'd/<?php echo $this->id; ?>/view' + _href);
});
</script>
<?php
  if(isset($fgraphs)){
	$this->endjs = '<script>$(function(){'.$fgraphs.'});</script>';
	$this->endjs .= '<script>function visualize_all(){'.$fgraphs_all.'}</script>';
  }

?>
