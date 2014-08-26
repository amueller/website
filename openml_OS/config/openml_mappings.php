<?php

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
     8 => 'default_target_attribute',
     9 => 'row_id_attribute',
    10 => 'version_label',
    11 => 'citation',
    12 => 'visibility',
    13 => 'original_data_url',
    14 => 'paper_url'),
  'csv'     => array(
     3 => 'creator',
     4 => 'contributor'),
  'array'   => array(),
  'plain'   => array()
);

$config['xml_fields_implementation'] = array(
  'string'  => array(
    'name','external_version','description','licence',
    'language','fullDescription','installationNotes','dependencies',),
  'csv'     => array('creator','contributor',),
  'array'   => array('bibliographical_reference','parameter','component'),
  'plain'   => array()
);

?>
