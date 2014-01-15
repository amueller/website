<div class="marketing" style="margin-top: 50px;">


<div class="bs-masthead">
  <div class="container">
    <h1>Community Discussions</h1>
  </div>
</div>

	<?php o( 'community-search.php' ); ?>

<p style="margin-top:20px">
  <a data-toggle="collapse" data-target="#topics" class="btn btn-small btn-bs">Show all topics</a>
  <a data-toggle="collapse" data-target="#team" class="btn btn-small btn-bs">Meet the team</a>
</p>
</div>

<div class="container bs-docs-container">
<div class="collapse" id="topics"> 
<div class="row">
	<?php foreach( $this->categories as $category ):?>
	<div class="col-md-4">
		<h3 class="softText"><?php echo $category->title; ?></h3>
		<hr class="hardSmall" />
		<div class="uppercase doubleLineHeight">
			<i class="fa fa-list"></i> 
			<?php echo isset( $this->threadsPerCategory[$category->id] ) ? $this->threadsPerCategory[$category->id]->threads : '0'; ?> articles 
			<a href="frontend/page/community_category/cid/<?php echo $category->id;?>"><span class="label">View all</span></a>&nbsp;
			<a href="frontend/page/community_create/cid/<?php echo $category->id;?>"><span class="label">Ask new question</span></a>
		</div>
		<div>
			<ul>
			<?php 
			if( $this->threads[$category->id] == false ) {
				?><li class="doubleLineHeight"><strong>No threads in <?php echo $category->title;?>.</strong></li><?php
			} else {
				foreach( $this->threads[$category->id] as $thread ): 
				?><li class="doubleLineHeight"><strong><a href="frontend/page/community_thread/tid/<?php echo $thread->id; ?>"><?php echo stripslashes( teaser( $thread->title, 100 ) );?></a></strong></li><?php 
				endforeach; 
			}?>
			</ul>
		</div>
	</div>
	<?php if( ++$this->counter % 3 == 0 ) echo '</div><div class="verticalSpace50"></div><div class="row">'; ?>
	<?php endforeach; ?>
</div>
</div>

<div class="collapse" id="team"> 
<?php o( 'community-support.php' ); ?>
</div>
</div>
