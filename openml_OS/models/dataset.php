<?php
class Dataset extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'dataset';
    $this->id_column = 'did';
    }
  
  function getDatasetsWithFeature( $datasets, $feature, $type, $onlyOriginal = false ) {
    $sql = '
      SELECT `d`.`did` , `d`.`name` , `df`.`index` , `df`.`name` AS `feature` , `df`.`data_type`, `dq`.`value` AS `instances`
      FROM `dataset` AS `d` , `data_feature` AS `df`, `data_quality` AS `dq`
      WHERE `d`.`did` = `df`.`did`
      AND `d`.`format` = "arff"
      AND `dq`.`quality` = "NumberOfInstances"
      AND `dq`.`data` = `d`.`did`
      AND `df`.`data_type` IN ("'.implode('","',$type).'") 
      AND `df`.`name` = ' . ( $feature ? '"'.safe($feature).'" ' : '`d`.`default_target_attribute`').'
      AND `d`.`did` IN ('.implode(',',$datasets).') ';
    
    if($onlyOriginal) $sql .= ' AND `d`.`isOriginal` = "true"';

    return $this->Dataset->query($sql);
  }
  
  function nameVersionConstraints( $datasets, $namespace = 'dataset' ) {
    if(trim($datasets) === '') return '1';
    $datasets = explode( ',', $datasets );
    $constraint_string = '';
    foreach( $datasets as $dataset ) {
      $name = strstr( $dataset, '(', true );
      $version = substr( $dataset, strlen($name)+1, -1 );
      $constraint_string .= 'OR (`'.$namespace.'`.`name` = "'.trim(safe($name)).
                  '" AND `'.$namespace.'`.`version` = "'.trim(safe($version)).'") ';
    }
    $res = '(' . substr($constraint_string, 3) . ')';
    return $res;
  }
}
?>
