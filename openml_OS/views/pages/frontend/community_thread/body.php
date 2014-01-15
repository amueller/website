<div class="container bs-docs-container">
   <br/>
   <div class="col-md-12">
        <div class="row">
			<?php o( 'community-breadcrumbs.php' ); ?>
        </div>
   </div>
</div>
<div class="container bs-docs-container">
   <div class="col-md-6">
      <div class="bs-header">
         <div class="container">
            <div class="row">
               <h2><?php echo $this->thread->title; ?></h2>
				<span style="font-size: 14px;"><i class="fa fa-calendar"></i>&nbsp;Posted by <?php echo user_display_text( $this->author ); ?> on <?php echo dateNeat( $this->thread->post_date ); ?> at <?php echo timeNeat( $this->thread->post_date ); ?></span><br/>

				<img src="<?php echo htmlentities( authorImage( $this->author->image ) ); ?>" width="120" class="img-circle" style="padding: 10px;" alt="<?php echo $this->author->first_name . ' ' . $this->author->last_name; ?>" />
				<?php if( $this->author->external_source != 'Anonymous' && $this->author->external_source != 'OpenML' ): ?>
				<img src="img/community/icons/<?php echo strtolower( $this->author->external_source ); ?>.png" width="24" style="position: absolute; right: 10px; bottom: 10px;" alt="<?php echo $this->author->external_source; ?>" />
				<?php endif; ?>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6" style="margin-top:30px">
		<?php echo nl2br( stripslashes( $this->thread->body ) );?>
		<br/>
		<br/>
		<div id="disqus_thread"></div>
		<script type="text/javascript">
			
			var disqus_shortname = '<?php echo DISQUS_USERNAME; ?>';
			<?php if( $_SERVER['SERVER_NAME'] == 'localhost' ) echo 'var disqus_developer = 1;';?>
			
			
			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
		</script>
		<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
   </div>
</div>
