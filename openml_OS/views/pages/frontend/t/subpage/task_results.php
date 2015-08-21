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

		<h1><i class="fa fa-trophy"></i> <?php echo $this->record['type_name']; ?> on <?php echo $dataset; ?></h1>
    <h2>Results overview</h2>
    <?php echo $this->record['runcount']; ?> Runs.
		<?php if($this->record['type_name'] != 'Learning Curve'){ ?>
		        Show results for:
				<select class="selectpicker" data-width="auto" onchange="evaluation_measure = this.value; oTableRuns.fnDraw(true); updateTableHeader(); redrawtimechart(); redrawchart();">
					<?php foreach($this->allmeasures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
				</select>

      <?php if($this->record['type_id'] != 6){ ?>

      <div class="col-xs-12 panel">

			<div id="data_result_visualize" class="reflow-chart">Plotting chart <i class="fa fa-spinner fa-spin"></i></div>

			<div class="table-responsive reflow-table">
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
		<?php }} else { ?>
		        Plot learning curves for score:
				<select class="selectpicker" data-width="auto" onchange="evaluation_measure = this.value; redrawCurves();">
					<?php foreach($this->allmeasures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
				</select>

      <h3>Curves</h3>
      <div class="col-xs-12 panel">
			<div class="checkbox"><label>
			<input type="checkbox" name="latestOnly" checked onchange="latestOnly = this.checked; redrawCurves();"> Only newest flow versions</label></div>

			<div id="learning_curve_visualize" style="width: 100%">Plotting curves <i class="fa fa-spinner fa-spin"></i></div>
      </div>

      <h3>Table</h3>
        <div class="panel table-responsive">
				<table id="datatable_main" class="table table-bordered table-condensed table-responsive">
					<?php echo generate_table(
								array('img_open' => '',
										'rid' => 'Run',
										'sid' => 'setup id',
										'name' => 'Flow',
										'value' => str_replace('_',' ',$this->current_measure), ) ); ?>
				</table></div>

		<?php } ?>

	</div> <!-- end col-md-12 -->
