  <div class="col-xs-12 panel">
    <h2 style="margin-top:0px">Challenge</h2>
    <?php echo $this->tasktype['description']; ?>

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
    <a href="guide/integrations" class="btn btn-primary btn-raised">OpenML integrations</a>

    <br><br>
    <b>From your own software</b><br>
    <p>Use one of our APIs to download data from OpenML and upload your results</p>
    <a href="guide/api" class="btn btn-primary btn-raised">OpenML APIs</a>

  </div>

      <h2>Discussions</h2>
      <div class="panel" id="disqus_thread">Loading discussions...</div>
      <script type="text/javascript">
          var disqus_shortname = 'openml'; // forum name
  	var disqus_category_id = '3353607'; // Data category
  	var disqus_title = '<?php echo $this->task['tasktype']['name']; ?> on <?php echo $this->task['source_data']['name']; ?>'; // Data name
  	var disqus_url = '<?php echo BASE_URL;?>t/<?php echo $this->task_id; ?>'; // Data url

          /* * * DON'T EDIT BELOW THIS LINE * * */
          (function() {
              var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
              dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
              (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
          })();
      </script>
