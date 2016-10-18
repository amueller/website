<?php
class Study_tag extends Database_write {

  function __construct() {
    parent::__construct();
    $this->table = 'study_tag';
    $this->id_column = array('study_id', 'tag');
  }
  
  // given a tagged entity, return all the studies that need to be updated with it
  function studiesToUpdate($tag, $time, $user_id) {
    $sql = 
      'SELECT t.tag FROM study_tag t, study s ' . 
      'WHERE t.study_id = s.id AND tag = "' . $tag . '" ' .
      'AND (t.write_access = public OR s.creator = "' . $user_id . '") ' .
      'AND (t.window_start IS NULL OR t.window_start < "' . $time . '")'
      'AND (t.window_end IS NULL OR t.window_end > "' . $time . '")';
    
    $res = array();
    foreach( $data->result() as $row ) {
      $res[] = $row->{'tag'};
    }
    return count( $res ) > 0 ? $res : false;
  }
}
?>
