<?php 
$mapping = array(
  'id' => 'id',
  'uploader' => 'uploader',
  'name' => 'name',
  'version' => 'version',
  'external_version' => 'external_version',
  'description' => 'description',
  'creator' => 'creator',
  'contributor' => 'contributor',
  'upload_date' => 'uploadDate',
  'licence' => 'licence',
  'language' => 'language',
  'full_description' => 'fullDescription',
  'installation_notes' => 'installationNotes',
  'dependencies' => 'dependencies',
  'bibliographical_reference' => 'bibliographicalReference',
  'parameters' => 'parameterSetting',
  'components' => 'components',
  'tag' => 'tag',
  'source_url' => 'sourceUrl',
  'binary_url' => 'binaryUrl',
  'source_format' => 'sourceFormat',
  'binary_format' => 'binaryFormat',
  'source_md5' => 'sourceMd5',
  'binary_md5' => 'binaryMd5',
 ); ?>

<oml:flow xmlns:oml="http://openml.org/openml">
  <?php 
  foreach( $mapping as $key => $value ) {
    if( property_exists( $source, $value ) ){
      if( is_array( $source->$value ) ) {
        if( count( $source->$value ) > 0 ) {
          sub_xml( 'implementation-get.' . $value, array( 'source' => $source->$value ), 'v1' );
        }
      } elseif( $source->$value != false && $source->$value !== null ) { 
        echo '<oml:'.$key.'>'.htmlentities($source->$value).'</oml:'.$key.'>' . "\n";
      }
    }
  }?>
</oml:flow>
