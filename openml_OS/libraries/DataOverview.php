<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataOverview {
  
  public function __construct() {
    $this->CI = &get_instance();
  }

  public function generate_table( $table_name, $keys, $items, $api_delete_function = null ) {
    $variables = array();
    $variables['table_name'] = $table_name;
    $variables['keys'] = $keys;
    $variables['items'] = $items;
    $variables['api_delete_function'] = $api_delete_function;
    
    return $this->CI->load->view('library_templates/data_overview_default', $variables, true);
  }
  
  public function generate_xml( $root, $tag_configuration ) {
    $xml = new SimpleXMLElement('<oml:'.$root.' xmlns:oml="http://openml.org/openml"/>');
    
    // first obtain the indices
    $indices = array();
    foreach( $tag_configuration as $key => $value ) {
      $indices = array_merge( $indices, array_keys( $value ) );
    }
    sort( $indices );
    
    foreach( $indices as $index ) {
      foreach( $tag_configuration as $tag_type => $tags ) {
        foreach( $tags as $tag_index => $tag_name ) {
          if( $tag_index == $index ) {
            if( $this->CI->input->post( $tag_name ) ) {
              if( $tag_type == 'csv' ) {
                $values_exploded = explode( ',', $this->CI->input->post($tag_name) );
                foreach( $values_exploded as $value ) {
                  $xml->addChild('oml:'.$tag_name, $value);
                }
              } else { // TODO: add support for plain and array.
                $value = $this->CI->input->post($tag_name);
                $xml->addChild('oml:'.$tag_name, $value);
              }
            }
          }
        }
      }
    }
    return $xml->asXML();
  }
}
