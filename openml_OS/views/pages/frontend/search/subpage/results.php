<?php
function formatTeaser($r){
	$teaser = '';
	if(array_key_exists('highlight',$r))
		$teaser = trim(preg_replace('/\s+/', ' ', preg_replace('/^\*{2,}.*?\n/', '', $r['highlight']['description'][0])));
	elseif(array_key_exists('description',$r['_source']))
		$teaser = truncate(trim(preg_replace('/\s+/',' ',preg_replace('/^\*{2,}.*/m', '', $r['_source']['description']))));
	if($teaser == '')
		$teaser = 'No data.';
	return strip_tags($teaser);
}

function truncate($string,$length=200,$append="&hellip;") {
  $string = trim($string);
	$string = str_replace('<br>','',$string);

  if(strlen($string) > $length) {
    $string = wordwrap($string, $length);
    $string = explode("\n",$string);
    $string = array_shift($string) . $append;
  }

  return $string;
}

?>
<?php if(!$this->dataonly) {?>
<div class="topselectors">
<?php if($this->filtertype and in_array($this->filtertype, array("data"))){ ?>
	<a type="button" class="btn btn-default" style="float:right; margin-left:10px;" href="
<?php
if($this->table) // toggle off
$att = addToGET(array( 'table' => false, 'listids' => false, 'size' => false));
else // toggle on
$att = addToGET(array( 'table' => '1', 'listids' => false, 'size' => $this->results['hits']['total']));
echo 'search?'.$att; ?>"><i class="fa <?php echo ($this->table ? 'fa-align-justify' : 'fa-table');?>"></i><?php echo ($this->table ? ' List' : ' Table');?></a>
<?php } ?>

<?php if($this->filtertype and in_array($this->filtertype, array("run", "task", "data", "flow"))){ ?>
	<a type="button" class="btn btn-default" style="float:right; margin-left:10px;" href="
<?php
if($this->listids) // toggle off
$att = addToGET(array( 'listids' => false, 'table' => false, 'size' => false));
else // toggle on
$att = addToGET(array( 'listids' => '1', 'table' => false, 'size' => $this->results['hits']['total']));
echo 'search?'.$att; ?>"><i class="fa <?php echo ($this->listids ? 'fa-align-justify' : 'fa-list-ol');?>"></i> ID's</a>
	<?php } ?>

<div class="dropdown pull-right">
  <a data-toggle="dropdown" class="btn btn-default" href="#">Sort: <b><?php echo $this->curr_sort; ?></b> <i class="fa fa-caret-down"></i></a>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
    <?php if($this->filtertype and in_array($this->filtertype, array("task", "data", "flow", "task_type"))){ ?>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo str_replace("index.php/","",$_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'match', 'order' => 'desc')); ?>">Best match</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo str_replace("index.php/","",$_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'runs', 'order' => 'desc')); ?>">Most runs</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo str_replace("index.php/","",$_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'runs', 'order' => 'asc')); ?>">Fewest runs</a></li>
    <?php } ?>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo str_replace("index.php/","",$_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'date', 'order' => 'desc')); ?>">Most recent</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo str_replace("index.php/","",$_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'date', 'order' => 'asc')); ?>">Least recent</a></li>
    <?php if($this->filtertype and in_array($this->filtertype, array("data"))){ ?>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo str_replace("index.php/","",$_SERVER['PHP_SELF']) . "?" . addToGET(array( 'sort' => 'last_update', 'order' => 'desc')); ?>">Last update</a></li>
    <?php } ?>
  </ul>
</div>

<div class="searchstats"><?php echo $this->results['hits']['total'];?> results</div>
</div>
<?php } ?>
<?php
if( $this->results != false and $this->results['hits']['total'] > 0){ ?>
      <?php
      if($this->listids){?>
      <!-- copy id list -->
        <div class="panel-collapse <?php if(!array_key_exists("size",$_GET)) echo 'collapse';?>" id="collapseAllIDs">
          <div class="panel panel-body panel-default">
            <?php echo implode(', ', object_array_get_value( $this->results['hits']['hits'], '_id' ) ); ?>
          </div>
        </div>

    <?php } else if($this->table) {
	?>
	<div class="topmenu"></div>
	<table id="tableview" class="table table-striped table-bordered table-condensed dataTable no-footer responsive">
	<thead><tr>
    <?php foreach( $this->cols as $k => $v ) {
			echo '<th>'.$k.'</th>';
		}
	?>
	</tr></thead>
	<tbody></tbody>
	</table>
     <?php } else { ?>

	<div id="scrollingcontent">
	<div class="listitempage" id="itempage" data-url="<?php echo $this->ref_url . '?' . addToGET(array( 'from' => $this->from, 'dataonly' => 0, 'q' => $this->specialterms)); ?>" data-next-url="<?php echo $this->ref_url . '?' . addToGET(array( 'from' => $this->from+$this->size, 'dataonly' => 0, 'q' => $this->specialterms)); ?>" data-prev-url="<?php echo $this->ref_url . '?' . addToGET(array( 'from' => max(0,$this->from-$this->size), 'dataonly' => 0, 'q' => $this->specialterms));?>">
		 <?php
      foreach( $this->results['hits']['hits'] as $r ) {
        $type = $r['_type'];
				$rs = $r['_source'];
	   ?>
	<div class="searchresult panel">
		<?php if ($this->ion_auth->logged_in() and array_key_exists('uploader_id',$rs) and $this->user_id == $rs['uploader_id']){ ?>
			<div class="actionicon">
				<div class="delete_action" data-type="<?php echo $r['_type'];?>" data-id="<?php echo $r['_id'];?>" data-name="<?php echo (array_key_exists('name',$rs) ? $rs['name'].' ('.$rs['version'].')' : '');?>"><i class="fa fa-2x fa-trash"></i></div>
			</div>
		<?php } ?>

		  <?php if ($this->curr_sort == 'last update'){
			echo '<div class="update_date">'.$rs['last_update'].'</div><a href="u/'.$rs['uploader_id'].'">'.$rs['uploader'].'</a> ';
			if($rs['update_comment'])
				echo 'updated '.$type.':<div class="update_comment">'.$rs['update_comment'].'</div><div class="search-result">';
			else
				echo 'uploaded '.$type.':<div class="search-result">';
			}
			?>


		   <?php if($type == 'run') { ?>
				<div class="itemheadfull">
				<i class="<?php echo $this->icons[$type];?>" style="color:<?php echo $this->colors[$type];?>"></i>
				<a href="r/<?php echo  $r['_id'] ?>"><?php echo $rs['uploader'] ?> <span><i class="fa fa-fw fa-clock-o"></i> <?php echo get_timeago(strtotime(str_replace('.000Z','',$rs['date'])));?></span><br>
					<span>ran flow</span> <?php echo $rs['run_flow']['name'] ?> <span>on task</span> <?php echo $rs['run_task']['tasktype']['name'];?> on data set <?php echo $rs['run_task']['source_data']['name']; ?></a>
				</div>
				<div class="runStats statLine">
				<?php
				if(!array_key_exists('evaluations',$rs) or empty($rs['evaluations']))
					echo 'No evaluations yet (or not applicable)';
				else{
					$tn = "";
					$vals = array();
					foreach($rs['evaluations'] as $eval){
						if(array_key_exists('value', $eval))
							$vals[$eval['evaluation_measure']] = $eval['value']."";
					}
					if(array_key_exists('evaluation_measures',$rs['run_task'])){
						$tm = $rs['run_task']['evaluation_measures'];
						if(array_key_exists($tm,$vals))
							echo $tm.': '.$vals[$tm].', ';
					}
					foreach($vals as $k => $v){
						if(!isset($tm) or $k != $tm)
							echo $k.': '.$v.', ';
					}
				}
				?>
				</div>

		   <?php } elseif($type == 'user') { ?>
				<div class="itemheadhead">
					<?php
						$auth = $this->Author->getById($r['_id']);
						$authimg = "img/community/misc/anonymousMan.png";
						if ($auth)
							$authimg = htmlentities( authorImage( $auth->image ) );
					?>
					<i><img src="<?php echo $authimg; ?>" width="40" height="40" class="img-circle" /></i></div>
		   		<a href="u/<?php echo $r['_id']; ?>"><?php echo $rs['first_name'].' '.$rs['last_name']; ?></a>
					<div class="teaser"><?php echo $rs['bio']; ?> </div>
				  <div class="runStats statLine">
						<?php if($rs['affiliation']) echo '<i class="fa fa-fw fa-institution"></i>'.$rs['affiliation'];?>
						<?php if($rs['country']) echo '<i class="fa fa-fw fa-map-marker"></i>'.$rs['country'];?>
						<i class="fa fa-fw fa-clock-o"></i>Joined <?php echo date("Y-m-d", $rs['date']); ?>
				</div>

		   <?php } elseif($type == 'data') { ?>
				<div class="itemhead">
				<i class="<?php echo $this->icons[$type];?>" style="color:<?php echo $this->colors[$type];?>"></i>
		   		<a href="d/<?php echo $r['_id']; ?>"><?php echo $rs['name'].' ('.$rs['version'].')'; ?></a></div>
				<div class="teaser"><?php echo formatTeaser($r); ?> </div>
				<div class="runStats">
					<?php echo '<b>'.$rs['runs'].' runs</b>';
					 	if(array_key_exists('qualities', $rs)){
								$q = $rs['qualities'];
					      if(array_key_exists('NumberOfInstances', $q))    echo ' - '.$q['NumberOfInstances'].' instances';
					      if(array_key_exists('NumberOfFeatures', $q))     echo ' - '.$q['NumberOfFeatures'].' features';
					      if(array_key_exists('NumberOfClasses', $q))      echo ' - '.$q['NumberOfClasses'].' classes';
					      if(array_key_exists('NumberOfMissingValues', $q))echo ' - '.$q['NumberOfMissingValues'].' missing values';
							}?>
								</div>
		   <?php } elseif($type == 'task_type') { ?>
				<div class="itemhead">
				<i class="<?php echo $this->icons[$type];?>" style="color:<?php echo $this->colors[$type];?>"></i>
		   		<a href="tt/<?php echo $r['_id']; ?>"><?php echo $rs['name']; ?></a></div>
				<div class="teaser"><?php echo formatTeaser($r); ?></div>
				<div class="runStats">
					<?php echo '<b>'.$rs['tasks'].' tasks</b>';?>
        </div>
				<?php } elseif($type == 'study') { ?>
 				<div class="itemhead">
 				<i class="<?php echo $this->icons[$type];?>" style="color:<?php echo $this->colors[$type];?>"></i>
 		   		<a href="<?php echo 's/'.$r['_id']; ?>"><?php echo $rs['name']; ?></a></div>
 				<div class="teaser">
 					<?php echo formatTeaser($r); ?>
 				</div>
 				<div class="runStats">
					<?php
								echo $rs['datasets_included'] . ' datasets, '. $rs['tasks_included'] . ' tasks, ' . $rs['flows_included'] . ' flows, ' . $rs['runs_included'] . ' runs';
					?>
 				</div>
		   <?php } elseif($type == 'measure') { ?>
				<div class="itemhead">
				<i class="<?php echo $this->icons[$type];?>" style="color:<?php echo $this->colors[$type];?>"></i>
		   		<a href="<?php echo $this->measures[$rs['type']].'/'.$r['_id']; ?>"><?php echo $rs['name']; ?></a></div>
				<div class="teaser">
					<?php echo formatTeaser($r); ?>
				</div>
				<div class="runStats">
					<?php echo str_replace('_',' ',$rs['type']); ?>
				</div>

		   <?php } elseif($type == 'task') { ?>
				<div class="itemheadfull">
				  <i class="<?php echo $this->icons[$type];?>" style="color:<?php echo $this->colors[$type];?>"></i>
		   		<a href="t/<?php echo $r['_id']; ?>"><?php echo $rs['tasktype']['name'].' on '.$rs['source_data']['name']; ?></a>
				</div>
				<div class="runStats statLine">
					<?php
					  echo '<b>'.$rs['runs'].' runs</b>';
						foreach( $rs as $key => $value ) {
						if($key == 'task_id' or $key == 'suggest' or $key == 'source_data' or $key == 'visibility' or $key == 'data_splits' or $key == 'runs' or $key == 'tasktype' or $key == 'date' or $key == 'custom_testset' or !$value) { echo '';}
						elseif(is_array($value) and array_key_exists('name', $value)){
								echo ' - '.$key.' : '.$value['name'];}
						elseif(!is_array($value)){
							  echo ' - '.$key.' : '.$value;}
					  } ?>
				</div>

		   <?php } elseif($type == 'flow') { ?>
				<div class="itemhead">
				<i class="<?php echo $this->icons[$type];?>" style="color:<?php echo $this->colors[$type];?>"></i>
				<a href="f/<?php echo $r['_id']; ?>"><?php echo $rs['name'].' ('.$rs['version'].')'; ?></a></div>
				<div class="teaser"><?php echo formatTeaser($r); ?></div>
				<div class="runStats">
					<?php echo '<b>'.$rs['runs'].' runs</b>';?>
        </div>
		   <?php } ?>

		   <?php if ($this->curr_sort == 'last update'){
				echo '</div>';
		   } ?>
			</div>
<?php }
?>

</div>
</div>
<p class="loadingmore" style="color:#666"></p>
<?php if(!$this->table and $this->results['hits']['total']/50>1){ ?>
<ul class="pagination" style="display:none;">
  <li><a href="<?php echo $_SERVER['PHP_SELF'] . "?" . addToGET(array( 'from' => 0)); ?>" style="color:#666">Jump back to page</a></li>
<?php for ($x=0; $x<min($this->from+(10*$this->size),$this->results['hits']['total']); $x+=$this->size) { ?>
  <li><a href="<?php echo $_SERVER['PHP_SELF'] . "?" . addToGET(array( 'from' => $x)); ?>"><?php echo floor($x/$this->size) +1; ?></a></li>
<?php } ?>
</ul>
<?php } else { ?>
	<ul class="pagination" style="margin-bottom:50px"></ul>
<?php }}
	} else {
		if( $this->terms != false ) {
			o('no-search-results');
		} else {
	    o('no-results');
	  }
	}?>
