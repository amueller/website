
<style>
table.table tr.odd.runTableRow_error {
	background-color: #ffdddd;
}

table.table tr.odd.runTableRow_error td.sorting_1 {
	background-color: #ffdddd;
}

table.table tr.even.runTableRow_error {
	background-color: #ffeeee;
}

table.table tr.even.runTableRow_error td.sorting_1 {
	background-color: #ffeeee;
}

table.table tr.odd.runTableRow_OK {
	background-color: #ddffdd;
}

table.table tr.odd.runTableRow_OK td.sorting_1 {
	background-color: #ddffdd;
}

table.table tr.even.runTableRow_OK {
	background-color: #eeffee;
}

table.table tr.even.runTableRow_OK td.sorting_1 {
	background-color: #eeffee;
}
</style>
<div class="container">
  <h1>My Runs</h1> 
	<table id="my_runs" class="table table-bordered table-condensed">
		<?php echo generate_table( 
				array(	'start_time' => 'Start Time',
						'rid' => 'Run',
						'task_id' => 'Task',
						'status' => 'status', 
						'error' => 'Error message', ) ); ?>
	</table>
</div>
