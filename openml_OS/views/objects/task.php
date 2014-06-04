<?php 
if(false === strpos($_SERVER['REQUEST_URI'],'type') && false !== strpos($_SERVER['REQUEST_URI'],'/t/')) {

	$info = explode('/', $_SERVER['REQUEST_URI']);
	$this->task_id = $info[array_search('t',$info)+1];

	$task = $this->Implementation->query('SELECT t.task_id, t.ttid, tt.name, tt.description FROM task t, task_type tt WHERE t.ttid=tt.ttid and task_id=' . $this->task_id );
	if( $task != false ) {
		$this->record = array(
			  'task_id' => $task[0]->task_id,
			  'type_id' => $task[0]->ttid,
			  'type_name' => $task[0]->name,
			  'type_description' => $task[0]->description			
			);
	$count = $this->Implementation->query('SELECT group_concat(rid) as runs, count(rid) as count from run where task_id=' . $this->task_id );
	$this->record['runcount'] = $count[0]->count;
	$this->record['runs'] = $count[0]->runs;
	

	$io = $this->Implementation->query('SELECT io.name, io.type, io.description, tt.description as typedescription, io.io, io.requirement, ti.value FROM task_type_inout io left join task_inputs ti on (io.name = ti.input and ti.task_id=' . $this->task_id . ") left join task_io_types tt on io.type=tt.name WHERE io.ttid=" . $this->record['type_id'] );
	if( $io != false ) {
	  foreach( $io as $i ) {
		$inout = array(
			  'name' => $i->name,
			  'type' => $i->type,
			  'description' => $i->description,
			  'typedescription' => $i->typedescription,
			  'category' => $i->io,
			  'value' => $i->value,
			  'requirement' => $i->requirement
			);
		if($i->type == 'Dataset' && is_numeric($i->value)){
			$dataset = $this->Implementation->query('SELECT name, version FROM dataset where did=' . $i->value); 
			$inout['dataset'] = $dataset[0]->name . " (" . $dataset[0]->version . ")";
			$this->sourcedata_id = $i->value;
			$this->sourcedata_name = $inout['dataset'];
		}
		elseif($i->type == 'EstimationProcedure'){
			$ep = $this->Implementation->query('SELECT name FROM estimation_procedure where id=' . $i->value); 
			$inout['evalproc'] = $ep[0]->name;
		}

		$this->taskio[] = $inout;
	  }
	}
	}
}
?>

<div class="row openmlsectioninfo">
	<div class="col-sm-12">
		<h1>Task <?php echo $this->task_id; ?></h1>
		<?php if (isset($this->record['task_id'])){ ?>		
		<a href="http://openml.liacs.nl/api/?f=openml.task.search&task_id=<?php echo $this->task_id;?>">View XML</a>

		<h2><?php echo $this->record['type_name'] ?></h2>
		<p><?php echo $this->record['type_description'] ?></p>

		<h3>Given inputs</h3>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'input') continue; ?>
		<tr><td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $r['description']; ?>"><?php echo $r['name']; ?></td>
		<td><?php if($r['type'] == 'Dataset') { echo '<a href="d/' . $r['value']. '">' . $r['dataset'] . '</a>';}
		elseif($r['type'] == 'EstimationProcedure') { echo '<a href="a/evalproc/' . $r['value']. '">' . $r['value'] . ' - ' . $r['evalproc'] . '</a>';}
		elseif(strpos($r['value'], "http") === 0 ) { echo '<a href="' .$r['value']. '">' . 'download' . '</a>';}
		else { echo $r['value']; } ?></td>
		<td><a class="pop" data-html="true" data-toggle="popover" data-placement="left" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a> (<?php echo $r['requirement']; ?>)</td>
		</tr>
		<?php endforeach; ?>
		</table></div>

		<h3>Required outputs</h3>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'output' || $r['requirement'] == 'hidden') continue; ?>
		<tr><td><?php echo $r['name']; ?></td>
		<td><?php echo $r['description']; ?></td>
		<td><a class="pop" data-html="true" data-toggle="popover" data-placement="left" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a> (<?php echo $r['requirement']; ?>)</td>
		</tr>
		<?php endforeach; ?>
		</table></div>

		<h3>Runs</h3>
		<h4><?php echo $this->record['runcount']; ?> completed runs</h4>	
		<?php if(isset($this->sourcedata_id)) { ?>
		See results for <a href="d/<?php echo $this->sourcedata_id; ?>"><?php echo $this->sourcedata_name; ?></a>
		<?php } ?>		

		<h4>Run details</h4>		
		<?php 
			$prefix = '';
			foreach( explode(',', $this->record['runs']) as $r): echo $prefix; ?>
			<a href="r/<?php echo $r; ?>"><?php echo $r; ?></a> 
		<?php	$prefix = ', ';
			endforeach; ?>
		<?php } else { ?>Sorry, this task is unknown.<?php } ?>		
	</div> <!-- end col-md-12 -->

</div> <!-- end openmlsectioninfo -->
