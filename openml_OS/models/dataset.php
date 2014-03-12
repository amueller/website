<?php
class Dataset extends Database_write {
  
  function __construct() {
    parent::__construct();
    $this->table = 'dataset';
    $this->id_column = 'did';
    }
  
  // returns all dataset with a given feature $feature and data type $type.
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
  
  // given an array with qualities, and an array with predicates about these arrays, 
  // this function returns all datasets that comply to the predicates stated on these
  // predicates.
  function getDatasetWithQualities( $qualities, $predicates, $onlyOriginal = false, $restricted = false ) {
    $sql = 'SELECT `d`.`did`, `d`.`name`, `d`.`url`';
    for( $i = 0; $i < count( $qualities ); ++$i ) {
      $sql .= ', `dq' . $i . '`.`value` AS `' . $qualities[$i] . '`'; 
    }
    $sql .= "\nFROM `dataset` `d` \n";
    for( $i = 0; $i < count( $qualities ); ++$i ) {
      $sql .= 'LEFT JOIN `data_quality` `dq' . $i . '` ON `dq' . $i . '`.`data` = `d`.`did` '.
              'AND `dq' . $i . '`.`quality` = "' . $qualities[$i] . '"' . "\n";
    }
    $sql .= 'WHERE 1 ';
    for( $i = 0; $i < count( $qualities ); ++$i ) {
      if( $predicates[$i] != NULL ) {
        $sql .= 'AND `dq' . $i . '`.`value` ' . $predicates[$i] . "\n";
      }
    }
    if($onlyOriginal) $sql .= ' AND `d`.`isOriginal` = "true"';
    if($restricted) $sql .= ' AND `d`.`error` = "false" AND `d`.`processed` IS NOT NULL ';
    
    return $this->query( $sql );
  }
  
  // given an array of dataset identifiers the form dataset_name(dataset_version), this 
  // function returns all ids that comply to these datasets
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
  
  function process( $did, &$message ) {
    $dataset = $this->getById( $did );
    
    $update = array( 'processed' => now() );
    
    // update the date, legacy dataset corrections, can be removed later
    if( $dataset->upload_date == '0000-00-00 00:00:00' ) {
      $update['upload_date'] = now();
    }
    
    // generate the checksum
    if( is_null( $dataset->md5_checksum ) ) {
      $md5_file = md5_file( $dataset->url );
      if( $md5_file === false ) {
        $message = 'Error in calculating MD5 string. ';
        return false;
      }
      $update['md5_checksum'] = $md5_file;
    }
    // try to update again ... 
    $succes = $this->Dataset->update( $dataset->did, $update );
    
    // and add features / qualities
    if( strtolower($dataset->format) == 'arff' ) {
      // fill features and data quality table
      $dataFeatures = $this->Data_features->getByDid( $dataset->did );
      $dataQualities = $this->Data_quality->getByDid( $dataset->did );
      $result = get_arff_features( $dataset->url, $dataset->default_target_attribute );
        
      if( $result == false || property_exists( $result,  'error' )) {
        $message = 'Error extracting features and qualities: ' . $result->error;
        return false;
      }
      
      // only insert features when these were not yet extracted.
      if($dataFeatures == false) insert_arff_features( $dataset->did, $result->data_features );

      // insert qualities anyway. duplicate keys will not be inserted, (MySQL handles this)
      // but we might have obtained additional measures
      insert_arff_qualities( $dataset->did, $result->data_qualities );
    }
    
    if( $succes == false ) {
      $message = 'Failed to insert meta data in database. ';
      return false;
    }
    
    return true;
  }
}
?>
