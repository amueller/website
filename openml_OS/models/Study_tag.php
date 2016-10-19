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
      'AND (t.write_access = "public" OR s.creator = "' . $user_id . '") ' .
      'AND (t.window_start IS NULL OR t.window_start < "' . $time . '")' .
      'AND (t.window_end IS NULL OR t.window_end > "' . $time . '")';
    
    
    return $this->getColumnFromSql('tag', $sql);
  }
  
  function getDataIdsFromStudy($study_id) {
    $sql = 
      'SELECT d.did, d.name, GROUP_CONCAT(st.tag) AS tags '.
      'FROM study s, study_tag st, dataset_tag t, dataset d '.
      'WHERE d.did = t.id AND t.tag = st.tag AND st.study_id = s.id '.
      $this->getRestrictions($study_id)
      'GROUP BY d.did';
    return $this->getColumnFromSql('did', $sql);
  }
  
  function getTaskIdsFromStudy($study_id) {
    $sql = 
      'SELECT t.task_id, GROUP_CONCAT(st.tag) AS tags '.
      'FROM study s, study_tag st, task_tag t, task '.
      'WHERE task.task_id = t.id AND t.tag = st.tag AND st.study_id = s.id '.
      $this->getRestrictions($study_id)
      'GROUP BY t.task_id';
    return $this->getColumnFromSql('did', $sql);
  }
  
  private function getRestrictions($study_id) {
    return 'AND s.id = ' . $study_id . ' ' .
      'AND (st.window_start IS NULL OR t.date > st.window_start) '.
      'AND (st.window_end IS NULL OR t.date < st.window_end) '.
      'AND (st.write_access = "public" OR t.uploader = s.creator) ';
  }
}
?>
