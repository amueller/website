<?php
     foreach( $this->taskio as $r ):
	if($r['category'] != 'input') continue;
	if($r['type'] == 'Dataset'){
		$dataset = $r['dataset'];
		$dataset_id = $r['value'];
	}
     endforeach; ?>

		<?php if (!isset($this->record['task_id'])){
             echo "Sorry, this task is unknown.";
             die();
    } ?>


		<ul class="hotlinks">
		 <li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>/json"><i class="fa fa-file-code-o fa-2x"></i></a><br>JSON</li>
		 <li><a href="api/?f=openml.task.get&task_id=<?php echo $this->task_id;?>"><i class="fa fa-file-code-o fa-2x"></i></a><br>XML</li>
		</ul>
		<h1><i class="fa fa-trophy"></i> <?php echo $this->record['type_name']; ?> on <?php echo $dataset; ?></h1>
		<div class="datainfo">
<i class="fa fa-trophy"></i> Task <?php echo $this->task_id; ?> <i class="fa fa-flag"></i> <a href="t/type/<?php echo $this->record['type_id'];?>"><?php echo $this->record['type_name']; ?></a> <i class="fa fa-database"></i> <a href="d/<?php echo $dataset_id;?>"><?php echo $dataset; ?></a> <i class="fa fa-star"></i> <?php echo $this->record['runcount']; ?> runs submitted
</div>

		<?php if($this->record['type_name'] != 'Learning Curve'){ ?>
		        Order runs by score:
				<select class="selectpicker" data-width="auto" onchange="evaluation_measure = this.value; oTableRuns.fnDraw(true); updateTableHeader(); redrawtimechart(); redrawchart();">
					<?php foreach($this->allmeasures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
				</select>

      <h3>Timeline</h3>

			<div class="col-sm-12 panel reflow-chart" id="data_result_time">Plotting contribution timeline <i class="fa fa-spinner fa-spin"></i></div>

      <h3>Leaderboard</h3>

      <div class='table-responsive panel reflow-table'><table id="leaderboard" class='table table-striped'>
        <thead>
          <tr>
            <th>Rank</th>
            <th>Name</th>
            <th>Top Score</th>
            <th>Entries</th>
            <th>Highest rank</th>
          </tr>
        </thead>
      </table>
      <p>Note: The leaderboard ignores resubmissions of previous solutions</p>
    </div>
<?php } ?>
