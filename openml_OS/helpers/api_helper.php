<?php

function validateXml( $xmlDocument, $xsdDocument, &$xmlErrors, $from_file = true ) {
  $xmlErrors = '';
  libxml_use_internal_errors(true);
  
  $xml = new DOMDocument(); 
  if($from_file)
    $xml->load( $xmlDocument );
  else
    $xml->loadXML( $xmlDocument );
  
  $cxmlErrors = '';
  foreach (libxml_get_errors() as $error) {
    $xmlErrors .= $error->message . '. ';
  }
  
  if ( $xml->schemaValidate( $xsdDocument ) ) { 
     return true;
  } else {
    $xmlErrors .= 'XML does not correspond to XSD schema. ';
    return false;
  }
}

/**
 *  @function all_tags_from_xml()
 *    returns an asociative array containing all selected tag-names as keys 
 *    and all tag content as the values. 
 *
 *  @param $xml (object): The an XML object containing the relevant children
 *    obtained from the XML. Could be obtained by XML->children('oml', true)
 *    or something similar, to get all childeren in the OML namespace. 
 *  @param $configuration (2d string array): an array configuring which fields to be
 *    included in the return value. $configuration can contain 4 sub arrays, 'array',
 *    'csv', 'plain' and 'string'. Putting a field in one of these sub arrays, deter-
 *    mines 
 *  @param $return_array (string array): The base array to add tags to. Usually, when
 *    some fields are already set, these can be joined with the fields to
 *    be set within this function.
 * 
 *  @return (MULTIPLE VALUES array): asociative array containing all selected tag-names 
 *    as keys and all tag content as the values. 
 */

function all_tags_from_xml( $xml, $configuration = array(), $return_array = array() ) {
  $csv_tags = array();
  $include = array_collapse($configuration);
  
  foreach( $xml as $key => $value ) {
    if( in_array( $key, $include ) ) {
      if( array_key_exists( 'array', $configuration ) && in_array( $key, $configuration['array'] ) ) { 
        // returned in plain array
        if( !array_key_exists( $key, $return_array ) ) {
          $return_array[$key] = array();
        }
        $return_array[$key][] = $value;
      } elseif( array_key_exists( 'csv', $configuration ) && in_array( $key, $configuration['csv'] ) ) { 
        // returned in CSV format
        if( !array_key_exists( $key, $csv_tags ) ) {
          $csv_tags[$key] = array();
        } 
        $csv_tags[$key][] = trim( $value );
      } elseif( array_key_exists( 'plain', $configuration ) && in_array( $key , $configuration['plain'] ) ) { 
        // returned plain (xml object)
        $return_array[$key] = $value;
      } elseif( array_key_exists( 'string', $configuration ) && in_array( $key , $configuration['string'] ) ) {
        // returned as string
        $return_array[$key] = trim($value);
      } else {
        // an illegal or undefined category
      }
    }
  }
  
  foreach( $csv_tags as $key => $value ) {
    $return_array[$key] = putcsv( $value );
  }
  return $return_array;
}

function xsd( $name ) {
  return APPPATH.'views/pages/rest_api/xsd/' . $name . '.xsd';
}

function sub_xml( $xmlFile, $source ) {
  $ci = &get_instance();
  $view = 'pages/rest_api/xml/'.$xmlFile.'.tpl.php';
  $ci->load->view( $view, $source );
}

function camelcaseToUnderscores( $string ) {
  return strtolower( preg_replace( '/(?<=\\w)(?=[A-Z])/', "_$1", $string ) ); 
}

function underscoresToCammelcase( $string ) {
  return lcfirst( str_replace( ' ', '', ucwords( str_replace( '_', ' ', $string ) ) ) );
}


function insertImplementationFromXML( $xml, $configuration, $implementation_base = array() ) {
  $ci = &get_instance();
  
  $implementation_objects = all_tags_from_xml( $xml, array_custom_filter($configuration, array('plain','array')) );
  $implementation = all_tags_from_xml( $xml, array_custom_filter($configuration, array('string','csv')), $implementation_base );
  
  // insert the implementation itself
  $version = $ci->Implementation->incrementVersionNumber( $implementation['name'] );
  $implementation['fullName'] = $implementation['name'] . '(' . $version . ')';
  $implementation['version'] = $version;
  
  if( array_key_exists( 'source_md5', $implementation ) ) {
    if( array_key_exists( 'external_version', $implementation ) === false ) {
      $implementation['external_version'] = $implementation['source_md5'];
    }
  } elseif( array_key_exists( 'binary_md5', $implementation ) ) {
    if( array_key_exists( 'external_version', $implementation ) === false ) {
      $implementation['external_version'] = $implementation['binary_md5'];
    }
  }
  
  if( array_key_exists( 'implements', $implementation ) ) {
    if( in_array( $implementation['implements'], $ci->supportedMetrics ) == false && 
        in_array( $implementation['implements'], $ci->supportedAlgorithms == false ) ) {
      return false;
    }
  }
  
  // information illegal to insert
  unset($implementation['source_md5']);
  unset($implementation['binary_md5']);
  $res = $ci->Implementation->insert( $implementation );
  if( $res === false ) {
    return false;
  }
  
  // add to elastic search index. 
  //$this->ElasticSearch->index('flow', $res); 
  
  // insert all important "components"
  foreach( $implementation_objects as $key => $value ) {
    
    if( $key == 'component' ) {
      foreach($value as $entry) {
        $component = $entry->implementation->children('oml', true);
        $similarComponent = $ci->Implementation->compareToXml( $entry->implementation );
        if( $similarComponent === false ) {
          $component->version = $ci->Implementation->incrementVersionNumber( $component->name );
          $componentFullName = $component->name . '(' . $component->version . ')';
          $succes = insertImplementationFromXML( 
            $component, 
            $configuration, 
            array( 'uploadDate' => now(), 'uploader' => $implementation['uploader'] ) );
      
          if($succes == false) { return false; }
          $ci->Implementation->addComponent( $res, $succes, trim($entry->identifier) );
        } else {
          $ci->Implementation->addComponent( $res, $similarComponent, trim($entry->identifier) );
        }
      }
    } elseif( $key == 'bibliographical_reference' ) {
      foreach( $value as $entry ) {
        $children = $entry->children('oml', true);
        $children->implementation_id = $res;
        $succes = $ci->Bibliographical_reference->insert( $children );
      }
    } elseif( $key == 'parameter' ) {
      foreach( $value as $entry ) {
        $children = $entry->children('oml', true);
        $succes = $ci->Input->insert( 
          array(
            'fullName' => $implementation['fullName'] . '_' . $children->name,
            'implementation_id' => $res,
            'name' => trim($children->name),
            'defaultValue' => property_exists( $children, 'default_value') ? trim($children->default_value) : null,
            'description' => property_exists( $children, 'description') ? trim($children->description) : null,
            'dataType' => property_exists( $children, 'data_type') ? trim($children->data_type) : null,
            'recommendedRange' => property_exists( $children, 'recommended_range') ? trim($children->recommendedRange) : null
          ) 
        );
      }
    }
  }
  return $res;
}

function get_arff_features( $datasetUrl, $class = false ) {
  $ci = &get_instance();
  $eval = PATH . APPPATH . 'third_party/OpenML/Java/evaluate.jar';
  $res = array();
  $code = 0;
  
  $heap = '-Xmx' . ( $ci->input->is_cli_request() ? 
    $ci->config->item('java_heap_space_cli') : 
    $ci->config->item('java_heap_space_web') );
  
  $command = "java $heap -jar $eval -f data_features -d $datasetUrl";
  if($class != false)
    $command .= ' -c ' . $class;
  
  $ci->Log->cmd( 'ARFF Feature Extractor', $command ); 

  if(function_enabled('exec') === false ) {
    return false;
  }
  exec( CMD_PREFIX . $command, $res, $code );
  
  if( $code == 0 && is_array( $res ) ) {
    return json_decode( implode( "\n", $res ) );
  } else {
    return false;
  }
}

function features_array_contains( $value, $array, $case_insensitive = false ) {
  foreach( $array as $item ) {
    if( $item->name == $value ) {
      return true;
    } elseif( $case_insensitive && strtolower($item->name) == strtolower($value) ) {
      return true;
    }
  }
  return false;
}

function insert_arff_features( $did, $features ) {
  $ci = &get_instance();
  foreach( $features as $f ) {
    $feature_array = (array) $f;
    $feature_array['did'] = $did;
    $ci->Data_feature->insert( $feature_array );
  }
}

function insert_arff_qualities($did, $qualities) {
  $ci = &get_instance();
  foreach( $qualities as $q ) {
    $quality = array( 'data' => $did, 'quality' => $q->name, 'value' => $q->value );
    if( property_exists($q, 'label') ) {
      $quality['label'] = $q->label;
    }
    
    if( $ci->Data_quality->getWhere( assoc_to_string( $quality, array('value') ) ) === false ) {
      $ci->Data_quality->insert( $quality );
    }
  }
}

// @param: $filter: all entries of filter will NOT be used in result 
function assoc_to_string( $arr, $filter ) {
  $new_arr = array();
  foreach( $arr as $key => $value ) {
    if( in_array( $key, $filter ) == false ) {
      $new_arr[] = $key . ' = "' . $value . '" ';
    }
  }
  return implode( ' AND ', $new_arr );
}

function xml_size( $xml_resource, $xml_field ) {
  if( $xml_resource->children('oml', true)->{$xml_field} ) {
    return count( $xml_resource->children('oml', true)->{$xml_field} );
  } else {
    return 0;
  }
}

function xml_subsize( $xml_resource, $xml_field, $subfield ) {
  if( $xml_resource->children('oml', true)->{$xml_field} ) {
    return count( $xml_resource->children('oml', true)->{$xml_field}->children('oml', true)->{$subfield} );
  } else {
    return 0;
  }
}

function xml2object ( $xmlObject, $attributes = false ) {
    $out = new stdClass ();
    foreach ( (array) $xmlObject as $index => $node )
      $out->{$index} = ( is_object ( $node ) ) ? xml2object ( $node ) : $node;
    if( $attributes ) {
      foreach ( $xmlObject->attributes() as $index => $node ) {
        $out->{$index} = ''. $node;
      }
    }

    return $out;
}

function xml2assoc ( $xmlObject, $attributes = false ) {
    $out = array ();
    foreach ( (array) $xmlObject as $index => $node )
      $out[$index] = ( is_object ( $node ) ) ? xml2object ( $node ) : $node;
    if( $attributes ) {
      foreach ( $xmlObject->attributes() as $index => $node ) {
        $out[$index] = ''. $node;
      }
    }

    return $out;
}
?>
