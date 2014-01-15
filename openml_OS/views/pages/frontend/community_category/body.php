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
               <h2><?php echo $this->cat->title; ?></h2>
			   <?php o('community-search.php'); ?>
				<br/>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6" style="margin-top:30px">
		<?php 
		if( count( $this->threads ) === 0 || $this->threads === false ) {
			?><div class="justify"><strong>No threads in <?php echo $this->cat->title; ?>. </strong></div><?php
		} else {
			foreach( $this->threads as $thread ): ?>
			<div class="justify">
				<h4 class="softText"><a href="frontend/page/community_thread/tid/<?php echo $thread->id; ?>"><?php echo stripslashes( $thread->title ); ?></a></h4>
				<i class="fa fa-calendar"></i><small>Posted on <?php echo dateNeat( $thread->post_date ); ?> at <?php echo timeNeat( $thread->post_date ); ?></small><br/>
				<?php echo stripslashes( teaser( $thread->body ) ); ?>
			</div>
			<div class="row">&nbsp;</div><?php 
			endforeach;
		} 
		o( 'community-newthreadbtn.php' ); ?>
   </div>
</div>
