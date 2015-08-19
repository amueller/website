<div class="row">

<h2 id="team-core">Our Team</h2>
<p>OpenML is a community effort, and as such many people have contributed to it over the years.<br />
Want to join? Leave a message on the <a href="mailto:openml@googlegroups.com">community mailing list</a>.</p>

<?php
 if( $this->team != false ) {
    foreach( $this->team as $t ) { ?>
			<div class="col-md-4 head">
				<img src="<?php echo htmlentities( authorImage( $t->image ) );?>" class="img-circle" width="70" /><br/><br/>
				<span class="membername"><a href="u/<?php echo $t->id;?>"><?php echo $t->first_name.' '.$t->last_name; ?></a></span><br>
				<span class="memberline"><?php echo $t->bio; ?></span>
			</div>
<?php }}?>


  </div>
