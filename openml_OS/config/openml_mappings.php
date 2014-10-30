<?php

$config['data_controller'] = BASE_URL . 'data/';

$config['data_tables'] = array( 
  'dataset','evaluation','evaluation_fold', 
  'evaluation_sample', 'evaluation_interval', 'runfile');

$config['xml_fields_dataset'] = array(
  'string'  => array(
     0 => 'name',
     1 => 'description',
     2 => 'format',
     5 => 'collection_date',
     6 => 'language',
     7 => 'licence',
     8 => 'url',
     9 => 'default_target_attribute',
    10 => 'row_id_attribute',
    12 => 'version_label',
    13 => 'citation',
    15 => 'visibility',
    16 => 'original_data_url',
    17 => 'paper_url'),
  'csv'     => array(
     3 => 'creator',
     4 => 'contributor',
    11 => 'ignore_attribute',
    14 => 'tag'
),
  'array'   => array(),
  'plain'   => array()
);

$config['xml_fields_dataset_update'] = array(
  'string'  => array(
     0 => 'id',
     1 => 'name',
     2 => 'description',
     3 => 'format',
     4 => 'licence',
     5 => 'url',
     6 => 'default_target_attribute',
     7 => 'row_id_attribute',
     9 => 'version_label',
    10 => 'visibility',
    11 => 'paper_url',
    12 => 'update_comment'),
  'csv'     => array(
     8 => 'ignore_attribute'
),
  'array'   => array(),
  'plain'   => array()
);

$config['xml_fields_implementation'] = array(
  'string'  => array(
    'name','external_version','description','licence',
    'language','fullDescription','installationNotes','dependencies',),
  'csv'     => array('creator','contributor','tag'),
  'array'   => array('bibliographical_reference','parameter','component'),
  'plain'   => array()
);

$config['xml_fields_run'] = array(
  'string'  => array( 'task_id', 'implementation_id', 'setup_string', 'error_message' ),
  'csv' => array( 'tag' ),
  'array'   => array( 'parameter_setting' ),
  'plain'   => array( 'output_data' )
);

$config['basic_qualities'] = array(
  "NumberOfInstances", "NumberOfFeatures", "NumberOfClasses", "NumberOfMissingValues", "NumberOfInstancesWithMissingValues", "NumberOfNumericFeatures"
);

$config['taggable_entities'] = array(
  'dataset' => 'Dataset_tag',
  'implementation' => 'Implementation_tag',
  'run' => 'Run_tag',
  'task' => 'Task_tag'
);

?>
