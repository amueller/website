<?php
class Api_model extends CI_Model {
  
  protected $outputFormat = 'xml';
  
  function __construct() {
    parent::__construct();
    
  }
  
  protected function returnError( $code, $version, $httpErrorCode = 450, $additionalInfo = null ) {
    $this->Log->api_error( 'error', $_SERVER['REMOTE_ADDR'], $code, $_SERVER['QUERY_STRING'], $this->load->apiErrors[$code][0] . (($additionalInfo == null)?'':$additionalInfo) );
    $error['code'] = $code;
    $error['message'] = htmlentities( $this->load->apiErrors[$code][0] );
    $error['additional'] = htmlentities( $additionalInfo );

    $httpHeaders = array( 'HTTP/1.0 ' . $httpErrorCode );
    $this->xmlContents( 'error-message', $version, $error, $httpHeaders );
  }

  protected function xmlContents( $xmlFile, $version, $source, $httpHeaders = array() ) {
    $view = 'pages/'.$this->controller.'/' . $version . '/' . $this->page.'/'.$xmlFile.'.tpl.php';
    $data = $this->load->view( $view, $source, true );
    header('Content-length: ' . strlen($data) );
    header('Content-type: text/'.$this->outputFormat.'; charset=utf-8');
    foreach( $httpHeaders as $header ) {
      header( $header );
    }
    
    if ($this->outputFormat == 'json') {
      $xml = simplexml_load_string($xml_string);
      echo json_encode($xml);
    } else {
      echo $data;
    }
  }
}
?>
