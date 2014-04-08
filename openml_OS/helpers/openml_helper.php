<?php

function getcsv( $string ) {
  if( $string === false || $string == null )
    return false;
  else {
    // str_getcsv only available from php version 5.3 and on
    $fh = fopen('php://temp', 'r+');
    fwrite($fh, $string);
    rewind($fh);
    $row = fgetcsv($fh);
    fclose($fh);
    return $row;
  }
}

function putcsv( $arr ) {
  return '"' . implode( '","', $arr ) . '"';
}

function array_collapse( $arr ) {
  $return_array = array();  
  foreach( $arr as $a ) {
    $return_array = array_merge($return_array, $a);
  }
  return $return_array;
}

function array_custom_filter( $arr, $include ) {
  $return_array = array();
  foreach( $arr as $key => $value ) {
    if( in_array($key, $include) ) {
      $return_array[$key] = $value;
    }
  }
  return $return_array;
}

function teaser( $body, $length = false ) {
  if( $length == false ) 
    $length =  $this->config->item('community_teaser_length');
  
  if( strlen( $body ) > $length ) {
    return substr( $body, 0, strrpos( substr( $body, 0, $length ), ' ' ) ) . '...'; 
  } else {
    return $body;
  }
}

function clean_array( $array, $allowed ) {
  foreach( $array as $key => $value ) {
    if( in_array( $key, $allowed ) == false )
      unset( $array[$key] );
  }
  
  return $array;
}

function user_display_text( $user = null ) {
  $ci = &get_instance();
  if( $user === null )
    $user = $ci->ion_auth->user()->row();
  
  $str = '';
  
  if( $user->first_name != false ) 
    $str .= $user->first_name . ' ';
  if( $user->last_name != false ) 
    $str .= $user->last_name;
  if( $user->first_name == false && $user->last_name == false ) 
    $str .= 'Anonymous';
  if( $user->external_source != false ) 
    $str .= ' (' . ucfirst($user->external_source) . ')';
    
  return $str;
}
  
function authorImage( $image ) {
  if( $image == '' || $image == false || $image == null )
    return 'img/community/misc/anonymousMan.png';
  else 
    return $image;
}


function sortByRuns($a, $b) {
  return $b['runs'] - $a['runs'];
}

function sortByName($a, $b) {
  if( strtolower($b->name) > strtolower($a->name)) {
    return -1;
  } elseif( strtolower($a->name) > strtolower($b->name) ) {
    return 1;
  } else {
    return 0;
  }
}

function object_array_get_property( $array, $property ) {
  $res = array();
  if($array !== false) {
    foreach( $array as $a ) {
      $res[] = $a->{$property};
    }
  }
  return $res;
}

function array_to_parsed_string($array, $string) {
  $total_string = '';
  if (is_array($array)){
	  foreach( $array as $key => $value ) {
	    $search = array('[KEY]', '[VALUE]');
	    $replace = array($key, (is_array($value)) ? implode(',',$value) : $value );
	    
	    $total_string .= str_replace($search, $replace, $string);
	  }
  }
  return $total_string;
}

function function_enabled( $function ) {
  return function_exists( $function ) && 
    !in_array($function, array_map('trim',explode(', ', ini_get('disable_functions'))));
}

// for auth library
function get_csrf_nonce() {
  $ci = &get_instance();
  $ci->load->helper('string');
  $key   = random_string('alnum', 8);
  $value = random_string('alnum', 20);
  $ci->session->set_flashdata('csrfkey', $key);
  $ci->session->set_flashdata('csrfvalue', $value);
  return array($key => $value);
}

function valid_csrf_nonce() {
  $ci = &get_instance();
  if ($ci->input->post($ci->session->flashdata('csrfkey')) !== FALSE &&
      $ci->input->post($ci->session->flashdata('csrfkey'))  == $ci->session->flashdata('csrfvalue')) {
    return TRUE;
  } else {
    return FALSE;
  }
}

function standard_deviation($aValues, $bSample = false) {
  $fMean = array_sum($aValues) / count($aValues);
  $fVariance = 0.0;
  foreach ($aValues as $i) {
    $fVariance += pow($i - $fMean, 2);
  }
  $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
  return (float) sqrt($fVariance);
}

function xml_array_to_plain_array( $xml, $field ) {
  $result = array();
  foreach( $xml->children('oml', true)->{$field} as $item ) {
    $result[] = $item . '';
  }
  return $result;
}

function array_to_js_array( $array ) {
  if( is_array($array) ) {
    return '["' . implode ( '","', $array ) . '"]';
  } else {
    return '[]';
  }
}

?>
