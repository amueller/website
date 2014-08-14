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

}
