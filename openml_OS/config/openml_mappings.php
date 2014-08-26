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
     8 => 'url',
     9 => 'default_target_attribute',
    10 => 'row_id_attribute',
    11 => 'version_label',
    12 => 'citation',
    13 => 'visibility',
    14 => 'original_data_url',
    15 => 'paper_url'),
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
