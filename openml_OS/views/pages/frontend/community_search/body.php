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
               <h2>Search on "<?php echo $this->terms;?>"</h2>
			   <?php o('community-search.php'); ?>
				<br/>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6" style="margin-top:30px">
		<?php foreach( $this->threads as $thread ): ?>
			<div class=" justify">
				<h4 class="softText"><a href="frontend/page/community_thread/tid/<?php echo $thread->id; ?>"><?php echo stripslashes( $thread->title ); ?></a></h4>
				<strong><i class="icon-folder-open"></i>Category: <a href="frontend/page/community_category/cid/<?php echo $thread->category_id; ?>"><?php echo $thread->category_title; ?></a></strong><br/>
				<i class="icon-calendar"></i><small>Posted on <?php echo dateNeat( $thread->post_date ); ?> at <?php echo timeNeat( $thread->post_date ); ?></small><br/>
				<?php echo stripslashes( teaser( $thread->body ) ); ?>
			</div>
			<div>&nbsp;</div>
		<?php endforeach; 
			  if( count( $this->threads ) === 0 ):?>
			  <div class=" justify"><strong>No threads found. </strong></div>
		<?php endif;?>
		
		<?php o( 'community-newthreadbtn.php' ); ?>
   </div>
</div>
