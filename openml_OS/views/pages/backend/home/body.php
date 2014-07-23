<div class="container-fluid topborder">
  <div class="row">
    <div class="col-lg-10 col-sm-12 col-lg-offset-1 openmlsectioninfo">
      <?php foreach( $this->directories as $d ): ?>
        <a href="backend/page/<?php echo $d; ?>"><?php echo text_neat_ucwords($d); ?></a>&nbsp;
      <?php endforeach; ?>
    </div>
  </div>
</div>
