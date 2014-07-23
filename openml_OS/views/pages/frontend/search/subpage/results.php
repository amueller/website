<?php
function formatTeaser($r){
	if(array_key_exists('highlight',$r))
		return trim(preg_replace('/\s+/', ' ', $r['highlight']['_all'][0]));
	elseif(array_key_exists('description',$r['_source']))
		return truncate(trim(preg_replace('/\s+/', ' ', $r['_source']['description'])));
	return '';
}

function truncate($string,$length=100,$append="&hellip;") {
  $string = trim($string);

  if(strlen($string) > $length) {
    $string = wordwrap($string, $length);
    $string = explode("\n",$string);
    $string = array_shift($string) . $append;
  }

  return $string;
}

?>
<div class="dropdown pull-right"> 
  <a data-toggle="dropdown" class="btn btn-default" href="#">Sort: <b><?php echo $this->curr_sort; ?></b> <i class="fa fa-caret-down"></i></a>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
    <?php if($this->filtertype and in_array($this->filtertype, array("task", "data", "flow", "task_type"))){ ?>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo basename($_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'match', 'order' => 'desc')); ?>">Best match</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo basename($_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'runs', 'order' => 'desc')); ?>">Most runs</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo basename($_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'runs', 'order' => 'asc')); ?>">Fewest runs</a></li> 
    <?php } ?>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo basename($_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'date', 'order' => 'desc')); ?>">Most recent</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo basename($_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'date', 'order' => 'asc')); ?>">Least recent</a></li>
  </ul>
</div>

<?php
if( $this->results != false and $this->results['hits']['total'] > 0){ ?>
      <div class="searchstats">Found <?php echo $this->results['hits']['total'];?> results (<?php echo $this->results['took']/1000;?> seconds)</div>
      <?php
      if($this->listids){?>
      <!-- copy id list -->
        <div class="panel-collapse <?php if(!array_key_exists("size",$_GET)) echo 'collapse';?>" id="collapseAllIDs">
          <div class="panel panel-body panel-default">
            <?php echo implode(', ', object_array_get_value( $this->results['hits']['hits'], '_id' ) ); ?>
          </div>
        </div>

      <?php } else {
      $runparams['index'] = 'openml';
      $runparams['type']  = 'run';
      foreach( $this->results['hits']['hits'] as $r ) {
        $type = $r['_type'];
	$rs = $r['_source'];
        $runparams['body'] = false;

?>
	<div class="searchresult">
		<i class="<?php echo $this->icons[$type];?>"></i>
		   <?php if($type == 'run') { ?>

				<a href="r/<?php echo  $r['_id'] ?>">Run <?php echo  $r['_id'] ?></a>
				<div class="teaser"><?php echo formatTeaser($r); ?></div>
				<div class="runStats">flow <a href="<?php echo $rs['run_flow']['flow_id'];?>"><?php echo $rs['run_flow']['name'] ?></a> - task <a href="<?php echo $rs['run_task']['task_id'];?>"><?php echo $rs['run_task']['task_id'];?> - <?php echo $rs['run_task']['tasktype']['name'];?> on <?php echo $rs['run_task']['source_data']['name']; ?></a> - uploaded <?php echo str_replace('.000Z','',str_replace('T',' ',$rs['date']));?> by <?php echo $rs['uploader'] ?></div>

		   <?php } elseif($type == 'user') { ?>

		   		<a href="u/<?php echo $r['_id']; ?>"><?php echo $rs['first_name'].' '.$rs['last_name']; ?></a><br />
				<div class="teaser"><?php echo formatTeaser($r); ?></div>
				<div class="runStats"><?php echo $rs['affiliation'];?> - <?php echo $rs['country'];?></div>

		   <?php } elseif($type == 'data') { ?>

		   		<a href="d/<?php echo $r['_id']; ?>"><?php echo $rs['name'].' ('.$rs['version'].')'; ?></a><br />
				<div class="teaser"><?php echo formatTeaser($r); ?></div>
				<div class="runStats">
					<?php $runparams['body']['query']['match']['run_task.source_data.data_id'] = $r['_id'];
                $searchclient = $this->searchclient->search($runparams);
					      echo $searchclient['hits']['total'].' runs';
					      if(array_key_exists('NumberOfInstances', $rs))    echo ' - '.$rs['NumberOfInstances'].' instances'; 
					      if(array_key_exists('NumberOfFeatures', $rs))     echo ' - '.$rs['NumberOfFeatures'].' features'; 
					      if(array_key_exists('NumberOfClasses', $rs))      echo ' - '.$rs['NumberOfClasses'].' classes';
					      if(array_key_exists('NumberOfMissingValues', $rs))echo ' - '.$rs['NumberOfMissingValues'].' missing values';?></div>

		   <?php } elseif($type == 'task_type') { ?>

		   		<a href="t/type/<?php echo $r['_id']; ?>"><?php echo $rs['name']; ?></a><br />
				<div class="teaser"><?php echo formatTeaser($r); ?></div>
				<div class="runStats"><?php $runparams['body']['query']['match']['task.task_type_id'] = $r['_id'];
                $searchclient = $this->searchclient->search($runparams);
					      echo $searchclient['hits']['total'];
					?> runs</div>

		   <?php } elseif($type == 'measure') { ?>

		   		<a href="<?php echo $this->measures[$rs['type']].'/'.$r['_id']; ?>"><?php echo $rs['name']; ?></a><br />
				<div class="teaser"><?php echo formatTeaser($r); ?></div>
				<div class="runStats"><?php echo str_replace('_',' ',$rs['type']); ?></div>

		   <?php } elseif($type == 'task') { ?>

		   		<a href="t/<?php echo $r['_id']; ?>">Task <?php echo $r['_id']; ?></a><br />
				<div class="teaser"><?php echo formatTeaser($r); ?></div>
				<div class="runStats">
					<?php $runparams['body']['query']['match']['run_task.task_id'] = $r['_id'];
                $searchclient = $this->searchclient->search($runparams);
					      echo $searchclient['hits']['total'];
					?> runs - <?php echo $rs['tasktype']['name'];?>
					<?php foreach( $rs as $key => $value ) {
						if($key == 'id' or $key == 'tasktype' or $key == 'data_splits' or !$value) {}
						elseif(is_array($value)) { if(array_key_exists('name', $value)){ echo ' - '.$key.': '.$value['name'];}}
						else { echo ' - '.$key.': '.$value;}
					} ?> </div>

		   <?php } elseif($type == 'flow') { ?>
				
				<a href="f/<?php echo $r['_id']; ?>"><?php echo $rs['name'].' ('.$rs['version'].')'; ?></a><br />
				<div class="teaser"><?php echo formatTeaser($r); ?></div>
				<div class="runStats">
					<?php $runparams['body']['query']['match']['run_flow.flow_id'] = $r['_id'];
                $searchclient = $this->searchclient->search($runparams);
					      echo $searchclient['hits']['total'];
					?> runs</div>
		   <?php } ?>
			</div>
<?php }} ?>


<ul class="pagination" style="margin-bottom:50px">
  <li><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?" . addToGET(array( 'from' => max(0,$this->from-10))); ?>">&laquo;</a></li>
<?php for ($x=$this->from; $x<min($this->from+(10*$this->size),$this->results['hits']['total']); $x+=$this->size) { ?>
  <li><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?" . addToGET(array( 'from' => $x)); ?>"><?php echo floor($x/$this->size) +1; ?></a></li>
<?php } ?>
  <li><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?" . addToGET(array( 'from' => $this->from+10)); ?>">&raquo;</a></li>
</ul>

<?php	} else {
		if( $this->terms != false ) {
			o('no-search-results');
		} else {
	    o('no-results');
	  }
	}?> 
