<div class="container-fluid topborder endless guidecontainer openmlsectioninfo">
  <div class="col-xs-12 col-md-10 col-md-offset-1 guidesection" id="mainpanel">

    <h1>Community Discussions</h1>

<?php o( 'community-search.php' ); ?>

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
