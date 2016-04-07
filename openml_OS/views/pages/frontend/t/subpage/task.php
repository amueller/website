<?php
     foreach( $this->taskio as $r ):
	if($r['category'] != 'input') continue;
	if($r['type'] == 'Dataset'){
		$dataset = $r['dataset'];
		$dataset_id = $r['value'];
	}
     endforeach;

	if (!isset($this->task)){ ?>
        <div class="container-fluid topborder endless openmlsectioninfo">
          <div class="col-xs-12 col-md-10 col-md-offset-1" id="mainpanel">

             <div class="tab-content">
              <h3><i class="fa fa-warning"></i> This is not the task you are looking for</h3>
              <p>Sorry, this task does not seem to exist (anymore).</p>
            </div>
          </div>
        </div>
      <?php
      } else { ?>

		<ul class="hotlinks">
                <?php if ($this->ion_auth->logged_in()) {
                    //if ($this->ion_auth->user()->row()->id != $this->task['uploader_id']) {?>
                        <li><a id="likebutton" class="loginfirst btn btn-link" onclick="doLike()" title="Click to like"> <i id="likeicon" class="fa fa-heart-o fa-2x"></i></a><br><br></li>
                <?php }?>
		 <li><a class="loginfirst btn btn-link" onclick="doDownload()" href="<?php echo $_SERVER['REQUEST_URI']; ?>/json"><i class="fa fa-file-code-o fa-2x"></i></a><br>JSON</li>
		 <li><a class="loginfirst btn btn-link" onclick="doDownload()" href="api/?f=openml.task.get&task_id=<?php echo $this->task_id;?>"><i class="fa fa-file-code-o fa-2x"></i></a><br>XML</li>
		</ul>

		<h1><i class="fa fa-trophy"></i> <?php echo $this->record['type_name']; ?> on <?php echo $dataset; ?></h1>
		<div class="datainfo">
                <i class="fa fa-trophy"></i> Task <?php echo $this->task_id; ?>
                <i class="fa fa-flag"></i> <a href="t/type/<?php echo $this->record['type_id'];?>"><?php echo $this->record['type_name']; ?></a>
                <i class="fa fa-database"></i> <a href="d/<?php echo $dataset_id;?>"><?php echo $dataset; ?></a>
                <i class="fa fa-star"></i> <?php echo $this->record['runcount']; ?> runs submitted
                <br>
                <i class="fa fa-heart"></i> <span id="likecount"><?php if(array_key_exists('nr_of_likes',$this->task)): if($this->task['nr_of_likes']!=null): $nr_l = $this->task['nr_of_likes']; else: $nr_l=0; endif; else: $nr_l=0; endif; echo $nr_l.' likes'; ?></span>
                <i class="fa fa-cloud-download"></i><span id="downloadcount"><?php if(array_key_exists('nr_of_downloads',$this->task)): if($this->task['nr_of_downloads']!=null): $nr_d = $this->task['nr_of_downloads']; else: $nr_d = 0; endif; else: $nr_d = 0; endif; echo 'downloaded by '.$nr_d.' people'; ?>
                <?php if(array_key_exists('total_downloads',$this->task)): if($this->task['total_downloads']!=null): $nr_d = $this->task['total_downloads']; endif; endif; echo ', '.$nr_d.' total downloads'; ?></span>
                <?php if ($this->ion_auth->logged_in()) {
                        if ($this->ion_auth->user()->row()->gamification_visibility == 'show') {?>
                            <i class="fa fa-rss reach"></i><span id="reach"><?php if(array_key_exists('reach',$this->task)): if($this->task['reach']!=null): $r = $this->task['reach']; else: $r=0; endif; else: $r=0; endif; echo $r.' reach'; ?></span>
                            <i class="fa fa-warning impact"></i><span id="impact"><?php if(array_key_exists('impact',$this->task)): if($this->task['impact']!=null): $i = $this->task['impact']; else: $i=0; endif; else: $i=0; endif; echo $i.' impact'; ?></span>
                    <?php }?>
                        <i class="fa fa-warning task" data-toggle="collapse" data-target="#issues" title="Click to show/hide" style="cursor: pointer; cursor: hand;"></i><span id="nr_of_issues" data-toggle="collapse" data-target="#issues" title="Click to show/hide" style="cursor: pointer; cursor: hand;"><?php if(array_key_exists('nr_of_issues',$this->task)): if($this->task['nr_of_issues']!=null): $i = $this->task['nr_of_issues']; else: $i=0; endif; else: $i=0; endif; echo $i.' issues'; ?></span>
                        <i class="fa fa-thumbs-down"></i><span id="downvotes"><?php if(array_key_exists('nr_of_downvotes',$this->task)): if($this->task['nr_of_downvotes']!=null): $d = $this->task['nr_of_downvotes']; else: $d=0; endif; else: $d=0; endif; echo $d.' downvotes'; ?></span>    
               <?php }?>
</div>

<div class="col-xs-12 panel collapse" id="issues">
    <table class="table table-striped" id="issues_content">
    </table>
    <br>
    <br>
    <form role="form" id="issueform">
        <h5>Submit a new issue for this task</h5>
        <div class="form-group">
          <label for="Reason">Issue:</label>
          <input type="text" class="form-control" id="reason">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        <div id="succes" class="text-center hidden">Issue Submitted!</div>
        <div id="fail" class="text-center hidden">Can't submit issue </div>
    </form>
</div>

  <div class="col-xs-12 panel">
    <h2 style="margin-top:0px">Challenge</h2>
    <?php echo $this->typedescription; ?>

		<h2>Given inputs</h2>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'input' or !$r['value'] or $r['name'] == 'custom_testset') continue; ?>
		<tr><td><a class="pop" data-html="true" data-toggle="popover" data-placement="right" data-content="<?php echo $r['description']; ?>"><?php echo $r['name']; ?></td>
		<td><?php if($r['type'] == 'Dataset') { echo '<a href="d/' . $r['value']. '">' . $r['dataset'] . '</a>';}
		elseif($r['type'] == 'Estimation Procedure') { echo '<a href="a/estimation-procedures/' . $r['value']. '">' . $r['evalproc'] . '</a>';}
		elseif(strpos($r['value'], "http") === 0 ) { echo '<a href="' .$r['value']. '">' . 'download' . '</a>';}
		else { echo $r['value']; } ?></td>
		<!--<td><a class="pop" data-html="true" data-toggle="popover" data-placement="left" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a> (<?php echo $r['requirement']; ?>)</td>-->
		</tr>
		<?php endforeach; ?>
		</table></div>

		<h3>Expected outputs</h3>
		<div class='table-responsive'><table class='table table-striped'>
		<?php foreach( $this->taskio as $r ): if($r['category'] != 'output' || $r['requirement'] == 'hidden') continue; ?>
		<tr><td><?php echo $r['name']; ?></td>
		<td><?php echo $r['description']; ?></td>
		<td><a class="pop" data-html="true" data-toggle="popover" data-placement="left" data-content="<?php echo $r['typedescription']; ?>"><?php echo $r['type']; ?></a> (<?php echo $r['requirement']; ?>)</td>
		</tr>
		<?php endforeach; ?>
		</table></div>

		<h3>How to submit runs</h3>
    <b>Using your favorite machine learning environment</b><br>
		<p>Download this task directly in your environment and automatically upload your results</p>
    <a href="guide/#!plugin_weka" class="btn btn-primary btn-raised">WEKA</a>
    <a href="guide/#!plugin_moa" class="btn btn-primary btn-raised">MOA</a>
    <a href="guide/#!plugin_rm" class="btn btn-primary btn-raised">RapidMiner</a>

    <br><br>
    <b>From your own software</b><br>
    <p>Use one of our APIs to download data from OpenML and upload your results</p>
    <a href="guide/#!java" class="btn btn-primary btn-raised">Java</a>
    <a href="guide/#!r" class="btn btn-primary btn-raised">R</a>
    <a href="guide/#!python" class="btn btn-primary btn-raised">Python</a>

  </div>

      <h2>Discussions</h2>
      <div class="panel" id="disqus_thread">Loading discussions...</div>
      <script type="text/javascript">
          var disqus_shortname = 'openml'; // forum name
  	var disqus_category_id = '3353607'; // Data category
  	var disqus_title = '<?php echo $this->record['type_name']; ?> on <?php echo $dataset; ?>'; // Data name
  	var disqus_url = '<?php echo BASE_URL;?>t/<?php echo $this->task_id; ?>'; // Data url

          /* * * DON'T EDIT BELOW THIS LINE * * */
          (function() {
              var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
              dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
              (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
          })();
      </script>
<?php } ?>
