<?php
$this->record = array();
$this->runsetup = array();
$this->runevaluations = array();

if(false !== strpos($_SERVER['REQUEST_URI'],'/r/')) { // DETAIL
  $info = explode('/', $_SERVER['REQUEST_URI']);
  $this->run_id = $info[array_search('r',$info)+1];
  $run = $this->Implementation->query('SELECT r.rid, r.uploader, d.did, d.name, d.version, r.setup, i.id, i.fullName, i.description, r.task_id, tt.name as taskname, r.start_time, r.status FROM run r left join task t on r.task_id=t.task_id left join task_type tt on t.ttid=tt.ttid left join task_inputs ti on (t.task_id=ti.task_id and ti.input=\'source_data\') left join dataset d on (ti.value = d.did), algorithm_setup s, implementation i WHERE rid='. $this->run_id .' and r.setup = s.sid and s.implementation_id = i.id');
     if( $run != false ) {
        $author = $this->Author->getById($run[0]->uploader);
  $this->record = array(
      'run_id' => $run[0]->rid,
      'uploader' => $author->first_name . ' ' . $author->last_name,
      'data_id' => $run[0]->did,
      'data_name' => $run[0]->name,
      'data_version' => $run[0]->version,
      'setup_id' => $run[0]->setup,
      'flow_id' => $run[0]->id,
      'flow_name' => $run[0]->fullName,
      'flow_description' => $run[0]->description,
      'task_id' => $run[0]->task_id,
      'task_name' => $run[0]->taskname,
      'start_time' => $run[0]->start_time,
      'status' => $run[0]->status
    );
  $setup = $this->Implementation->query('SELECT iss.input, i.description, iss.value FROM input_setting iss, input i WHERE iss.setup='.  $this->record['setup_id'] . ' and iss.input = concat(i.implementation_id,\'_\',i.name)');
  if( $setup != false ) {
     foreach( $setup as $i ) {
    $rsetup = array(
        'input' => $i->input,
        'description' => $i->description,
        'value' => $i->value
      );
          if($i->description == '') { $rsetup['description'] = 'No parameter description'; }
    $this->runsetup[] = $rsetup;
    }
  }
  $evals = $this->Implementation->query('select function, round(value,4) as value, round(stdev, 4) as stdev, array_data from evaluation where source = '. $this->run_id);
  if( $evals != false ) {
     foreach( $evals as $i ) {
    $revals = array(
        'function' => $i->function,
        'value' => $i->value, 
        'stdev' => $i->stdev, 
        'array_data' => $i->array_data
      );
    if(sizeof(preg_split("/[\s,]+/",$revals['array_data'])) < 2 and strlen($revals['array_data']) > 30)
      $revals['array_data'] = substr($revals['array_data'],0,30) . '...';
    $this->runevaluations[] = $revals;
    }
  }
     }
}
?>

<div class="row openmlsectioninfo">
  <div class="col-sm-12">
    <h1>Run <?php echo $this->run_id ?></h1>
    <?php if (isset($this->record['run_id'])){ ?>
  <ul class="hotlinks">
   <li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>/json"><i class="fa fa-file-code-o fa-2x"></i></a><br>JSON</li>
   <li><a href="http://openml.liacs.nl/api/?f=openml.run.get&run_id=<?php echo $this->run_id;?>"><i class="fa fa-file-code-o fa-2x"></i></a><br>XML</li>
        </ul>
  </div>
  <div class="col-sm-6">

    <h2>Task</h2>
    <div class='table-responsive'><table class='table table-striped'>
    <tr><td>Task</td><td><a href="t/<?php echo $this->record['task_id']; ?>">Task <?php echo $this->record['task_id']; ?> (<?php echo $this->record['task_name']; ?>)</a></td></tr>
    <tr><td>Input data</td><td><a href="d/<?php echo $this->record['data_id']; ?>"><?php echo $this->record['data_name']; ?> (<?php echo $this->record['data_version']; ?>)</a></td></tr>
    </table></div>
  </div>
  <div class="col-sm-6">

    <h2>Run Details</h2>
    <div class='table-responsive'><table class='table table-striped'>
    <tr><td>Uploader</td><td><?php echo $this->record['uploader']; ?></td></tr>
    <tr><td>Start time</td><td><?php echo $this->record['start_time']; ?></td></tr>
    <tr><td>Status</td><td><?php echo $this->record['status']; ?></td></tr>
    </table></div>

  </div>

  <div class="col-sm-12">

    <h3>Flow</h3>
    <div class='table-responsive'><table class='table table-striped fixedtable'>
    <tr><td><a href="f/<?php echo $this->record['flow_id']; ?>"><?php echo $this->record['flow_name']; ?></a></td><td><?php echo $this->record['flow_description']; ?></td></tr>
    <?php foreach( $this->runsetup as $r ): ?>
    <tr><td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $r['description']; ?>"><?php echo $r['input']; ?></td><td><?php echo $r['value']; ?></td></tr>
    <?php endforeach; ?>
    </table></div>

  </div>
  <div class="col-sm-12">
    <?php
    $getParams = array();
    $getParams['index'] = 'openml';
    $getParams['type']  = 'run';
    $getParams['id']    = $this->record['run_id'];
    $searchclient = $this->searchclient->get($getParams);
    $json_a = $searchclient['_source'];
    ?>
	
    <h3>Results</h3>
    <ul>
    <?php foreach( $json_a->output_files as $k => $v ): ?>
	<li><a href="<?php echo $v; ?>"><?php echo $k; ?></a></li>
    <?php endforeach; ?>
    </ul>

  </div>
  <div class="col-sm-12">

    <h3>Evaluations</h3>
    <div class='table-responsive'><table class='table table-striped'>
    <?php foreach( (array)$this->runevaluations as $r ): ?>
    <tr><td><?php echo $r['function']; ?></td><td><?php echo $r['value']; if(isset($r['stdev'])) echo ' &plusmn; '. $r['stdev']; ?></td>
    <td><?php echo $r['array_data']; ?></td>
    <?php endforeach; ?>
    </table></div>
    <?php } else { ?>Sorry, this run is unknown.<?php } ?>
  </div>

</div> <!-- end openmlsectioninfo -->
