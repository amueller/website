    <a href="search?q=tags.tag%3Astudy_<?php echo $this->id; ?>&type=data" class="btn btn-primary pull-right">Search these data sets in more detail</a>
    <h1><i class="fa fa-database"></i> <?php echo $this->study['name'];?></h1>

    <div class="searchframefull">
    <?php
      $this->filtertype = 'data';
      $this->sort = 'date';
      $this->specialterms = 'tags.tag:study_'.$this->id;
      loadpage('search', true, 'pre');
      loadpage('search/subpage', true, 'results'); ?>
    </div>
