<?php
class Study extends Database_write {

  function __construct() {
    parent::__construct();
    $this->table = 'study';
    $this->id_column = 'id';
  }

  function create( $tag, $name, $description, $creator ) {

    // insert
    $study_id = $this->insert( array( 'tag' => $tag, 'name' => $name, 'description' => $description, 'creator' => $creator ) );

    // add to elastic search index.
    $this->elasticsearch->index('study', $study_id );

  }

}
?>
