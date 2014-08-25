<?php
function text_neat_ucwords($input) {
  return ucwords(str_replace('_',' ',$input));
}

function text_to_underscored($input) {
  return strtolower(str_replace(' ','_',safe($input)));
}

function punc2uc($input) { // punctuation to underscores
  return preg_replace("/[^a-zA-Z0-9]+/", "_", $input );
}

function safe( $unsafe ) {
  return preg_replace("/[^a-zA-Z0-9\s.,-_()]/", "", $unsafe );
}

function is_safe( $unsafe ) {
  return !preg_match("/[^a-zA-Z0-9\s.,-_()]/", $unsafe );
}

function is_cs_numeric( $unsafe ) { // is comma separated numeric
  return !preg_match("/[^0-9\s.,-]/", $unsafe );
}

function cutoff( $input, $length ) {
  if( strlen( $input ) < $length + 5 ) return $input;
  
  return substr( $input, 0, $length ) . ' ...';
}

function rand_string( $length, $type='' ) {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
  if( $type == 'C' ) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  } elseif( $type == 'N' ) {
    $chars = '0123456789';
  } elseif( $type == 'CN' ) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  }
  
  $str = '';
  
  $size = strlen( $chars );
  for( $i = 0; $i < $length; $i++ ) {
    $str .= $chars[ rand( 0, $size - 1 ) ];
  }

  return $str;
}

function arr2string( $array ) {
  if( is_array( $array ) ) {
    $res = array();
    foreach( $array as $item ) {
      $res[] = arr2string( $item );
    }
    return '['.implode( ',', $res ).']';
  } else {
    return $array;
  }
}
?>
