  <div class="row">

         <h2 id="team-core">Our Team</h2>
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
  <div class="row">

         <h2 id="hall-fame">Hall of Fame</h2>
	 <p>The OpenML Hall of Fame is a special place where we honor the people who made small but significant contributions to OpenML.</p>


   </div>
