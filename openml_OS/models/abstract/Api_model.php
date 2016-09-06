<?php
class Api_model extends CI_Model {

  protected $outputFormat = 'xml';

  function __construct() {
    parent::__construct();

    $this->openmlGeneralErrorCode = 450;
  }

  function xmlEscape($string) {
    return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
  }

  // taken from: http://outlandish.com/blog/xml-to-json/
  function xmlToArray($xml, $options = array()) {
    $defaults = array(
        'namespaceSeparator' => '',//you may want this to be something other than a colon
        'attributePrefix' => '',    //to distinguish between attributes and nodes with the same name
        'alwaysArray' => array(),   //array of xml tag names which should always become arrays
        'autoArray' => true,        //only create arrays for tags which appear more than once
        'textContent' => 'value',   //key used for the text content of elements
        'autoText' => true,         //skip textContent key if node has no attributes or child nodes
        'keySearch' => false,       //optional search and replace on tag and attribute names
        'keyReplace' => false       //replace values for above search values (as passed to str_replace())
    );
    $options = array_merge($defaults, $options);
    $namespaces = $xml->getDocNamespaces();
    $namespaces[''] = null; //add base (empty) namespace

    //get attributes from all namespaces
    $attributesArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        $prefix = ''; //ignore namespaces
        foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
            //replace characters in attribute name
            if ($options['keySearch']) $attributeName =
                    str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
            $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
            $attributesArray[$attributeKey] = (string)$attribute;
        }
    }

    //get child nodes from all namespaces
    $tagsArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        $prefix = ''; //ignore namespaces
        foreach ($xml->children($namespace) as $childXml) {
            //recurse into child nodes
            $childArray = $this->xmlToArray($childXml, $options);
            list($childTagName, $childProperties) = each($childArray);

            //replace characters in tag name
            if ($options['keySearch']) $childTagName =
                    str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
            //add namespace prefix, if any
            if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;

            if (!isset($tagsArray[$childTagName])) {
                //only entry with this key
                //test if tags of this type should always be arrays, no matter the element count
                $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                        ? array($childProperties) : $childProperties;
            } elseif (
                is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                === range(0, count($tagsArray[$childTagName]) - 1)
            ) {
                //key already exists and is integer indexed array
                $tagsArray[$childTagName][] = $childProperties;
            } else {
                //key exists so convert to integer indexed array with previous value in position 0
                $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
            }
        }
    }

    //get text content of node
    $textContentArray = array();
    $plainText = trim((string)$xml);
    if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;

    //stick it all together
    $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

    //return node as array
    return array(
        $xml->getName() => $propertiesArray
    );
  }

  public function returnError( $code, $version, $httpErrorCode = 450, $additionalInfo = null ) {
    $this->Log->api_error( 'error', $_SERVER['REMOTE_ADDR'], $code, $_SERVER['QUERY_STRING'], $this->load->apiErrors[$code] . (($additionalInfo == null)?'':$additionalInfo) );
    $error['code'] = $code;
    $error['message'] = htmlentities( $this->load->apiErrors[$code] );
    $error['additional'] = htmlentities( $additionalInfo );

    $httpHeaders = array( 'HTTP/1.0 ' . $httpErrorCode . ' Api Error' );
    $this->xmlContents( 'error-message', $version, $error, $httpHeaders );
  }

  protected function xmlContents( $xmlFile, $version, $source, $httpHeaders = array() ) {
    $view = 'pages/'.$this->controller.'/' . $version . '/' . $this->page.'/'.$xmlFile.'.tpl.php';
    foreach( $httpHeaders as $header ) {
      header( $header );
    }

    if ($this->outputFormat == 'json') {
      $jsonTemplate = 'pages/'.$this->controller.'/' . $version . '/json/'.$xmlFile.'.tpl.php';
      if (file_exists(APPPATH . 'views/' . $jsonTemplate)) { // if we have native json templates
        $json = $this->load->view($jsonTemplate, $source, true);
        header('Content-length: ' . strlen($json) );
        header('Content-type: application/json; charset=utf-8');
        echo $json;
      } else { // use xml template and convert to json
        $data = $this->load->view($view, $source, true);
        $xml = simplexml_load_string($data);
        $json = json_encode($this->xmlToArray($xml));
        header('Content-length: ' . strlen($json));
        header('Content-type: application/json; charset=utf-8');
        echo $json;
      }
    } else { // output format = xml, use plain xml templates
      $data = $this->load->view($view, $source, true);
      header('Content-length: ' . strlen($data) );
      header('Content-type: text/xml; charset=utf-8');
      echo $data;
    }
  }
}
?>
