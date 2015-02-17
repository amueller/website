<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ElasticSearchLibrary {
  
  public function __construct() {
    $this->searchclient = null;
    try {
      $params['hosts'] = array ('http://openml.org:80');
      $this->searchclient = new Elasticsearch\Client($params);
    } catch( Exception $e ) {}
  }
  
  public function search( $params ) {
    $from  = array_key_exists( 'from', $params ) ? safe($params['from']) : 0;
    $size  = array_key_exists( 'size', $params ) ? safe($params['size']) : 0;
    $type  = array_key_exists( 'type', $params ) ? safe($params['type']) : 0;
    $sort  = array_key_exists( 'sort', $params ) ? safe($params['sort']) : 0;
    $order = array_key_exists( 'order', $params ) ? safe($params['order']) : 0;
    $filters = array_key_exists( 'filters', $params ) ? safe($params['filters']) : array();
    $query_terms = array_key_exists( 'query_terms', $params ) ? safe($params['query_terms']) : '';
    
    $query = '"match_all" : { }';
    if( $query_terms ) { $query = '"query_string" : { "query" : "' . $query_terms . '" }'; }
	  
    $jsonfilters = array();
    if($type) { $jsonfilters[] = '{ "type" : { "value" : "'.$type.'" } }'; }
    
    foreach($filters as $k => $v) {
	    if(strpos($v,'>') !== false and is_numeric(str_replace('>','',$v)))
		    $jsonfilters[] = '{ "range" : { "'.$k.'" : { "gt" : '.str_replace('>','',$v).' } } }';
	    elseif(strpos($v,'<') !== false and is_numeric(str_replace('<','',$v)))
		    $jsonfilters[] = '{ "range" : { "'.$k.'" : { "lt" : '.str_replace('<','',$v).' } } }';
	    elseif(strpos($v,'..') !== false and is_numeric(str_replace('..','',$v))){
		    $parts = explode("..",$v);
		    if(count($parts) == 2)
			    $jsonfilters[] = '{ "range" : { "'.$k.'" : { "gte" : '.$parts[0].', "lte" : '.$parts[1].' } } }';
		  }
	    else
		    $jsonfilters[] = '{ "term" : { "'.$k.'" : "'.str_replace('_',' ',$v).'"} }';
    }
    $fjson = implode(',', $jsonfilters);
    if(count($jsonfilters)>1)
	    $fjson = '"filter" : { "and" : ['.$fjson.'] },';
    elseif(count($jsonfilters)>0)
	    $fjson = '"filter" : '.$fjson.",\n";
    
    $search_params['index'] = 'openml';
    $search_params['body']  = 
      '{' . 
        '"from" : ' . $from . ",\n" .
        ($size ? '"size" : ' . $size . ",\n" : '') . 
        '"query" : {' . $query . '}, ' . 
        ($sort ? '"sort" : { "'.$sort.'" : "'.$order.'" },' : '') .
        ($fjson ? $fjson : '') . 
        '"highlight" : {
           "fields" : {
            "_all" : {}
           }
         },'."\n".
         '"facets" : {
           "type" : {
             "terms" : { "field" : "_type"}
           }
         }
       }';
    
    return $this->_search($search_params);
  }
  
  private function _search($params) {
    $results = array();
    try {
	    $results = $this->searchclient->search($params);

    } catch (Exception $e) {
	    $results['hits'] = array();
	    $results['hits']['total'] = 0;
	    $results['facets'] = array();
	    $results['facets']['type'] = array();
	    $results['facets']['type']['total'] = 0;
	    $results['facets']['type']['terms'] = array();
    }
    return $results;
  }
}
