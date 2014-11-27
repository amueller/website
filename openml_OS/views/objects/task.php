<?php
     foreach( $this->taskio as $r ):
	if($r['category'] != 'input') continue;
	if($r['type'] == 'Dataset'){
		$dataset = $r['dataset'];
		$dataset_id = $r['value'];
	}
     endforeach; ?>

<div class="row openmlsectioninfo">
	<div class="col-sm-12">
		<?php if (isset($this->record['task_id'])){ ?>
		<ul class="hotlinks">
		 <li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>/json"><i class="fa fa-file-code-o fa-2x"></i></a><br>JSON</li>
		 <li><a href="api/?f=openml.task.get&task_id=<?php echo $this->task_id;?>"><i class="fa fa-file-code-o fa-2x"></i></a><br>XML</li>
		</ul>
		<h1><i class="fa fa-trophy"></i> <?php echo $dataset; ?></h1>
		<div class="datainfo">
<i class="fa fa-trophy"></i> Task <?php echo $this->task_id; ?> <i class="fa fa-flag"></i> <a href="t/type/<?php echo $this->record['type_id'];?>"><?php echo $this->record['type_name']; ?></a> <i class="fa fa-database"></i> <a href="d/<?php echo $dataset_id;?>"><?php echo $dataset; ?></a> <i class="fa fa-star"></i> <?php echo $this->record['runcount']; ?> runs submitted
</div>

		<h2>Given inputs</h2>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'input' or !$r['value']) continue; ?>
		<tr><td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $r['description']; ?>"><?php echo $r['name']; ?></td>
		<td><?php if($r['type'] == 'Dataset') { echo '<a href="d/' . $r['value']. '">' . $r['dataset'] . '</a>';}
		elseif($r['type'] == 'Estimation Procedure') { echo '<a href="a/estimation-procedures/' . $r['value']. '">' . $r['evalproc'] . '</a>';}
		elseif(strpos($r['value'], "http") === 0 ) { echo '<a href="' .$r['value']. '">' . 'download' . '</a>';}
		else { echo $r['value']; } ?></td>
		<!--<td><a class="pop" data-html="true" data-toggle="popover" data-placement="left" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a> (<?php echo $r['requirement']; ?>)</td>-->
		</tr>
		<?php endforeach; ?>
		</table></div>
    		<!--
		<h3>Expected outputs</h3>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'output' || $r['requirement'] == 'hidden') continue; ?>
		<tr><td><?php echo $r['name']; ?></td>
		<td><?php echo $r['description']; ?></td>
		<td><a class="pop" data-html="true" data-toggle="popover" data-placement="left" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a> (<?php echo $r['requirement']; ?>)</td>
		</tr>
		<?php endforeach; ?>
		</table></div>-->

		<h3>How to submit runs</h3>
		<p>Follow the instructions for your favourite machine learning environment (e.g. <a href="guide/#!plugin_weka">WEKA</a>, <a href="guide/#!plugin_moa">MOA</a> or <a href="guide/#!plugin_mlr">mlr</a>) on how to download this task and execute runs. The id for this task is <b><?php echo $this->task_id; ?></b>. See the <a href="guide">OpenML guide</a> for all supported environments.</p>

		<h3>Results</h3>

		<?php if($this->record['type_name'] != 'Learning Curve'){ ?>
		        Order runs by score:
				<select class="selectpicker" data-width="auto" onchange="evaluation_measure = this.value; oTableRuns.fnDraw(true); updateTableHeader(); redrawtimechart(); redrawchart();">
					<?php foreach($this->allmeasures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
				</select>
			<div id="data_result_time" style="width: 100%">Plotting contribution timeline <i class="fa fa-spinner fa-spin"></i></div>

			<div id="data_result_visualize" style="width: 100%">Plotting chart <i class="fa fa-spinner fa-spin"></i></div>

			<div class="table-responsive">
				<table id="datatable_main" class="table table-bordered table-condensed table-responsive">
					<?php echo generate_table(
								array('img_open' => '',
										'rid' => 'Run',
										'sid' => 'setup id',
										'name' => 'Flow',
										'value' => str_replace('_',' ',$this->current_measure), ) ); ?>
				</table>
			</div>
			<div class="modal fade" id="runModal" role="dialog" tabindex="-1" aria-labelledby="Run detail" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			    </div>
			  </div>
			</div>
		<?php } else { ?>
		        Plot learning curves for score:
				<select class="selectpicker" data-width="auto" onchange="evaluation_measure = this.value; redrawCurves();">
					<?php foreach($this->allmeasures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
				</select>
				<div class="checkbox"><label>
				<input type="checkbox" name="latestOnly" checked onchange="latestOnly = this.checked; redrawCurves();"> Only newest flow versions</label></div>


			<div id="learning_curve_visualize" style="width: 100%">Plotting curves <i class="fa fa-spinner fa-spin"></i></div>

			<div>   <div class="table-responsive">
				<table id="datatable_main" class="table table-bordered table-condensed table-responsive">
					<?php echo generate_table(
								array('img_open' => '',
										'rid' => 'Run',
										'sid' => 'setup id',
										'name' => 'Flow',
										'value' => str_replace('_',' ',$this->current_measure), ) ); ?>
				</table></div>
			</div>

		<?php } ?>

		<?php } else { ?>Sorry, this task is unknown.<?php } ?>

    <div id="disqus_thread">Loading discussions...</div>
    <script type="text/javascript">
        var disqus_shortname = 'openml'; // forum name
	var disqus_category_id = '3353607'; // Data category
	var disqus_title = '<?php echo $this->record['type_name'].( $dataset ? ' on '.$dataset : '')?>'; // Data name
	var disqus_url = 'http://openml.org/t/<?php echo $this->task_id; ?>'; // Data url

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>

	</div> <!-- end col-md-12 -->

</div> <!-- end openmlsectioninfo -->
