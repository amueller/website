<?php //o( 'community-search.php' );
?>

<div class="topselectors">
<a type="button" class="btn btn-default loginfirst" style="float:right; margin-left:10px;" href="#new" data-toggle="tab"><i class="fa fa-fw fa-edit"></i> New Topic</a>
<div class="searchstats"><?php echo 'Popular and recent'; ?></div>
</div>

<?php
    $results = get_popular();
    //print_r($results);
    // parse the desired JSON data into HTML
    $threads = $results->response;
    foreach ($threads as $thread) { ?>
      <div class="searchresult panel"><div class="itemheadfull">
       <i class="<?php echo $this->icons[$this->category_code[$thread->category]];?>"></i>
       <a href="<?php echo $thread->link; ?>"><?php echo $thread->title;?></a> (<?php echo $thread->posts;?> comments)
       <span><i class="fa fa-fw fa-clock-o"></i> <?php echo 'Created '.get_timeago(strtotime(str_replace('T',' ',$thread->createdAt)));?>
       Message: <?php echo 'Type '.$this->category_code[$thread->category].' id '.end(explode('/', $thread->link));?>
     </div></div>
    <?php }
  ?>

  <div class="topselectors">
  <div class="searchstats"><?php echo 'Recent posts'; ?></div>
  </div>

  <?php
      $results = get_posts();
      // parse the desired JSON data into HTML
      $posts = $results->response;
      foreach ($posts as $post) { ?>
        <div class="searchresult panel" onclick="location.href='<?php echo $post->thread->link; ?>'"><div class="itemheadfull">
         <i><img src="<?php echo $post->author->avatar->small->permalink;?>" width="40" height="40" class="img-circle" /></i>
         <?php echo $post->author->username;?> posted in
         <b><?php echo $post->thread->title;?></b>
         (<?php echo $this->category_code[$post->thread->category];?>)
         <span><i class="fa fa-fw fa-clock-o"></i> <?php echo get_timeago(strtotime(str_replace('T',' ',$post->createdAt)));?></span>
         <div class="postmessage">
         <?php echo $post->message;?>
         </div>
       </div></div>
      <?php }
    ?>

	<?php foreach( $this->categories as $category ):?>
    <div class="topselectors">
    <a type="button" class="btn btn-default loginfirst" style="float:right; margin-left:10px;" href="frontend/page/community_create/cid/<?php echo $category->id;?>"><i class="fa fa-fw fa-edit"></i> New Topic</a>
    <a type="button" class="btn btn-default" style="float:right; margin-left:10px;" href="frontend/page/community_category/cid/<?php echo $category->id;?>"><i class="fa fa-fw fa-list-ul"></i> View all</a>
    <div class="searchstats"><?php echo $category->title; ?> (<?php echo isset( $this->threadsPerCategory[$category->id] ) ? $this->threadsPerCategory[$category->id]->threads : '0'; ?>)</div>
    </div>

			<?php
			if( $this->threads[$category->id] == false ) {
				?>No threads yet.<?php
			} else {
				foreach( $this->threads[$category->id] as $thread ):?>
        <div class="searchresult panel">
        <a href="discuss/tid/<?php echo $thread->id; ?>"><?php echo stripslashes( teaser( $thread->title, 100 ) );?></a>
        </div>
        <?php
				endforeach;
			}?>
	<?php endforeach; ?>
