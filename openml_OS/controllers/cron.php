<?php
class Cron extends CI_Controller {
	
  function __construct() {
    parent::__construct();
		
    $this->controller = strtolower(get_class ($this));
    
    $this->load->model('Dataset');
    $this->load->model('Data_features');
    $this->load->model('Data_quality');
    $this->load->model('Log');
    
    $this->load->helper('Api');
  }
	
	function build_search_index() {
		$command = 'java -jar '.APPPATH.'third_party/OpenML/Java/luceneSearch.jar index -index '.DATA_PATH.'search_index -server '. DB_HOST_EXPDB .' -database '. DB_NAME_EXPDB .' -username '. DB_USER_EXPDB_READ .' -password ' . DB_PASS_EXPDB_WRITE;
		$code = 0;
		$res = array();
		
		exec($command,$res,$code);
		
		if( $code == 0 ) {
			$this->Log->cronjob( 'succes', 'build_search_index', 'Created a new search index. Java response supressed. ' );
		} else {
			$this->Log->cronjob( 'error', 'build_search_index', 'Failed to create a search index. Java response: ' . $res );
		}
	}
	
  // manually perform this cronjob. Type the following command:
  // watch -n 10 "wget -O - http://openml.liacs.nl/cron/process_dataset" (specify server correct)
	function process_dataset() {
		$datasets = $this->Dataset->getWhere( 'error = "false"', '`processed` ASC, `did` ASC' );
		
		$processed = 0;
		foreach( $datasets as $d ) {
			if(++$processed > 5 )break;
	
			$update = array( 'processed' => now() );
			$succes = $this->Dataset->update( $d->did, $update );
			
			if( strtolower($d->format) == 'arff' ) {
				// fill features and data quality table
				$dataFeatures = $this->Data_features->getByDid( $d->did );
				$dataQualities = $this->Data_quality->getByDid( $d->did );
				
				
				$result = get_arff_features( $d->url, $d->default_target_attribute );
					
				if( $result == false || property_exists( $result,  'error' )) {
					$this->_error( $d->did, 'Java library error. ' );
					continue;
				}
        
        // only insert features when these were not yet extracted.
				if($dataFeatures == false) 
					insert_arff_features( $d->did, $result->data_features );

        // insert qualities anyway. duplicate keys will not be inserted, (MySQL handles this)
        // but we might have obtained additional measures
				insert_arff_qualities( $d->did, $result->data_qualities );
				
			}
			
			// update the date
			if( $d->upload_date == '0000-00-00 00:00:00' ) {
				$update['upload_date'] = now();
			}
			
			// generate the checksum
			if( is_null( $d->md5_checksum ) ) {
				$md5_file = md5_file( $d->url );
				if( $md5_file === false ) {
					$this->_error( $d->did, 'Could not generate md5 hash' );
					continue;
				}
				$update['md5_checksum'] = $md5_file;
			}			
			
			// update database record
			$succes = $this->Dataset->update( $d->did, $update );
			if( $succes == false ) {
				$this->_error( $d->did, 'Could not update database record' );
			} else {
				$this->Log->cronjob( 'succes', 'process_dataset', 'Did ' . $d->did . ' processed succesfully. '  );
			}
		}
	}
	
	private function _error($did, $message) {
		$this->Dataset->update( $did, array( 'processed' => now(), 'error' => 'true' ) );
		$this->Log->cronjob( 'error', 'process_dataset', 'Did ' . $did . ' processed with error: ' . $message );
	}
}
?>
