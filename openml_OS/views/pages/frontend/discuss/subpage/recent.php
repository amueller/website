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
    foreach ($threads as $thread) {
       $ttype = $this->category_code[$thread->category];
       $tid = end(explode('/', $thread->link));
       $message = "Could not retrieve message";
       if($ttype == 'general'){
         $t = $this->Thread->getById( $tid );
         if($t){
           $message = nl2br( stripslashes( $t->body ) );
           $title = nl2br( stripslashes( $t->title ) );
           $auth = $this->Author->getById( $t->author_id );
           $authname = user_display_text( $auth );
           $authimage = htmlentities( authorImage( $auth->image ) );
         }
       }
      ?>
      <div class="searchresult panel"><div class="itemheadfull">
       <?php if($ttype == 'general' and $t){ ?>
         <i><img src="<?php echo $authimage;?>" width="30" height="30" class="img-circle" /></i>
         <a href="discuss/tid/<?php echo $t->id; ?>"><?php echo stripslashes( teaser( $t->title, 100 ) );?></a>
       <?php } else { ?>
         <i class="<?php echo $this->icons[$this->category_code[$thread->category]];?>"></i>
         <a href="<?php echo $thread->link; ?>"><?php echo $thread->title;?></a>
       <?php } ?>
        (<?php echo $thread->posts;?> comments)
       <span><i class="fa fa-fw fa-clock-o"></i> <?php echo 'Created '.get_timeago(strtotime(str_replace('T',' ',$thread->createdAt)));?>
       <?php if($ttype == 'general' and $t){ echo ' by '.$authname; } ?>
       </span>
     </div>
     <div class="postmessage" id="postmessage_<?php echo $ttype; ?>_<?php echo $tid; ?>">
       <?php
           if($ttype == 'general'){
             echo $message;
           } else {?>
             <script>
             $(function() {
             client.get({index:'openml',type:'<?php echo $ttype; ?>',id:<?php echo $tid; ?>,fields:'description'}, function (error, response) {
              $('#postmessage_<?php echo $ttype; ?>_<?php echo $tid; ?>').html(response.fields.description[0].replace(/(?:\r\n|\r|\n)/g, ' ').substr(0,150) + " ...");
            });});
            </script>
     <?php } ?>
     </div>
   </div>
    <?php }
  ?>

  <?php foreach( $this->categories as $category ):?>
    <div class="topselectors">
    <a type="button" class="btn btn-default loginfirst" style="float:right; margin-left:10px;" href="#new" data-toggle="tab"><i class="fa fa-fw fa-edit"></i> New Topic</a>
    <div class="searchstats"><?php echo $category->title; ?> (<?php echo isset( $this->threadsPerCategory[$category->id] ) ? $this->threadsPerCategory[$category->id]->threads : '0'; ?>)</div>
    </div>

      <?php
      if( $this->threads[$category->id] == false ) {
        ?>No threads yet.<?php
      } else {
        foreach( $this->threads[$category->id] as $thread ):
          if($thread){
            $message = nl2br( stripslashes( $thread->body ) );
            $title = nl2br( stripslashes( $thread->title ) );
            $auth = $this->Author->getById( $thread->author_id );
            $authname = user_display_text( $auth );
            $authimage = htmlentities( authorImage( $auth->image ) );
          }
          ?>
        <div class="searchresult panel" >
          <div class="itemheadfull">
          <i><img src="<?php echo $authimage;?>" width="30" height="30" class="img-circle" style="margin-right:-15px;" /></i>
          <a href="discuss/tid/<?php echo $thread->id; ?>" style="margin-left:10px;"><?php echo stripslashes( teaser( $thread->title, 100 ) );?></a>
          <span><i class="fa fa-fw fa-clock-o"></i> <?php echo 'Created '.get_timeago(strtotime(str_replace('T',' ',$thread->post_date))).' by '.$authname; ?>
          </span></div>
          <div class="postmessage">
            <?php
            echo stripslashes( teaser( $message, 100 ) );
            ?>
          </div>
        </div>
        <?php
        endforeach;
      }?>
  <?php endforeach; ?>

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
