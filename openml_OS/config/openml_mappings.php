<?php

$config['data_tables'] = array( 
  'dataset','evaluation','evaluation_fold', 
  'evaluation_sample', 'evaluation_interval', 'runfile');

$config['xml_fields_dataset'] = array(
  'string'  => array(
    'description','format','collection_date','language','licence',
    'default_target_attribute','row_id_attribute','version_label',
    'citation','visibility','original_data_url','paper_url','md5_checksum'),
  'csv'     => array('creator','contributor',),
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