<?php
class Run extends Database_write {
	
	function __construct() {
		parent::__construct();
		$this->table = 'run';
		$this->id_column = 'rid';
		
		$this->load->model('Cvrun');
		$this->load->model('Implementation');
    }
	
	function inputData( $run, $data, $table ) {
		if( !is_numeric($run) || !is_numeric($data) ) return false;
		$sql = 'INSERT INTO `input_data`(`run`,`data`,`name`) VALUES("'.$run.'","'.$data.'","'.$table.'"); ';
		return $this->db->query( $sql );
	}
	
	function outputData( $run, $data, $table ) {
		if( !is_numeric($run) || !is_numeric($data) ) return false;
		$sql = 'INSERT INTO `output_data`(`run`,`data`,`name`) VALUES("'.$run.'","'.$data.'","'.$table.'"); ';
		return $this->db->query( $sql );
	}
	
	function getInputData( $runId ) {
		if( !is_numeric($runId) ) return false;
		$sql = 'SELECT dataset.* FROM input_data, dataset WHERE input_data.data = dataset.did AND input_data.run = ' . $runId;
		$result = $this->db->query( $sql )->result();
    if(count($result)) 
      return $result;
    else
      return false;
	}
	
	function getOutputData( $runId ) {
		if( !is_numeric($runId) ) return false;
		$sql = 'SELECT dataset.* FROM output_data, dataset WHERE output_data.data = dataset.did AND output_data.run = ' . $runId;
		$datasets = $this->db->query( $sql )->result();
		$sql = 'SELECT evaluation.* FROM output_data, evaluation WHERE output_data.data = evaluation.did AND output_data.run = ' . $runId;
		$evaluations = $this->db->query( $sql )->result();
		
    $result = array();
    if(count($datasets)) $result['dataset'] = $datasets;
    if(count($evaluations)) $result['evaluations'] = $evaluations;
    
    if(count($result)) 
      return $result;
    else
      return false;
	}
	
    /*
     *	Does all the specialized things needed for registering a Supervised Classification Run.
     *	@pre: There must be a run record, and a task record
     *
     */
	function insertSupervisedClassificationRun( $user_id, $runRecord, $taskRecord, $setupId, $predictionsUrl, $userSpecifiedMetrices, &$errorCode, &$errorMessage ) {
		// create shortcut record
		$cvRunData = array(
			'rid' => $runRecord->rid,
			'uploader' => $user_id,
			'task_id' => $taskRecord->id,
			'inputData' => $taskRecord->did,
			'learner' => $setupId,
			'runType' => 'classification',
			'nrFolds' => $taskRecord->repeats,
			'nrIterations' => $taskRecord->folds
		);
		
		$cvrunId = $this->Cvrun->insert( $cvRunData );
		if( $cvrunId === false ) {
			$errorCode = 209;
			return false;
		}
				
		// attach input data
		$inputData = $this->inputData( $runRecord->rid, $taskRecord->did, 'dataset' ); // Based on the query, it has been garantueed that the dataset id exists.
		if( $inputData === false ) {
			$errorCode = 211;
			return false;
		}		
		$inputData = $this->Dataset->getById( $taskRecord->did );		
		
		// and now evaluate the run
		if( $this->evaluateRun( $runRecord->rid, $inputData->url, $taskRecord->splits_url, $predictionsUrl, $taskRecord->target_feature, $userSpecifiedMetrices, $errorMessage ) == false ) {
			$errorCode = 216;
			return false;
		}
		return true;
	}
  
  private function evaluateRun( $runId, $datasetUrl, $splitsUrl, $predictionsUrl, $targetFeature, $userSpecifiedMetrices, &$errorCode ) {
	  $eval = APPPATH . 'third_party/OpenML/Java/evaluate.jar';
	  $res = array();
	  $code = 0;
	  $command = "java -jar $eval -f evaluate_predictions -d $datasetUrl -s $splitsUrl -p $predictionsUrl -c $targetFeature";
    $this->Log->cmd( 'REST API::openml.run.upload', $command ); 
	
	  if(function_enabled('exec') === false ) {
		  $errorCode = 'failed to start evaluation engine.';
		  return false;
	  }
	  
    $this->Log->cmd( 'Evaluate Run', $command ); 
	  exec( $command, $res, $code );
	
	  $json = json_decode( implode( "\n", $res ) );
    
	  if( $code != 0 || $json === null ) {
		  $errorCode = implode( '; ', $res );
		  return false;
	  }
	  if( property_exists( $json, 'error' ) ) {
		  $errorCode = $json->error;
		  return false;
	  }
    
    // it seems we have a legal result from the evaluation engine. Let's add it to the database. 
	  $res = array();
    
    // global metrics:
    $did_global = $this->Dataset->getHighestIndex( $this->data_tables, 'did' );
    $this->Run->outputData( $runId, $did_global, 'evaluation' );
    $inconsistentMeasures = array();
    
    // TODO: the code blocks for global metrices, fold metrices and sample metrices are highly similar. 
    // collapse into one block once. 
    if( property_exists( $json, 'global_metrices' ) ) {
      foreach( $json->global_metrices as $metric ) {
        if( in_array( $metric->name, $this->supportedMetrics ) ) {
  		    $res[$metric->name] = property_exists( $metric, 'value' ) ? $metric->value : $metric->array_data;
          // TODO: smarter way to deal with this :)
          $implementation_record = $this->Implementation->getByFullName($metric->implementation);
          if( $implementation_record == false ) {
            $this->Log->mapping( __FILE__, __LINE__, 'Implementation ' . $metric->implementation . ' not found in database. ' );
            continue;
          }
          
          $data = array(
		        'did' => $did_global,
		        'source' => $runId,
		        'function' => $metric->name,
		        'implementation_id' => $implementation_record->id );
          if( property_exists($metric, 'label') )
            $data['label'] = ''.$metric->label;
          if( property_exists($metric, 'value') )
            $data['value'] = ''.$metric->value;
          if( property_exists($metric, 'array_data') )
            $data['array_data'] = arr2string( $metric->array_data );
          
          if( $this->measureConsistent($metric, $userSpecifiedMetrices) == false ) {
            $inconsistentMeasures[] = $metric->name;
          }
          
          $this->Evaluation->insert( $data );
        }
      }
    }
    
    // user defined metrics:
    foreach( $userSpecifiedMetrices as $metric ) { 
      // TODO: smarter way to deal with this :)
      $implementation_record = $this->Implementation->getByFullName($metric->implementation);
      if( $implementation_record == false ) {
        $this->Log->mapping( __FILE__, __LINE__, 'Implementation ' . $metric->implementation . ' not found in database. ' );
        continue;
      }
      $data = array(
		    'did' => $did_global,
		    'source' => $runId,
		    'function' => ''.$metric->name,
		    'implementation_id' => $implementation_record->id );
      if( property_exists($metric, 'label') )
        $data['label'] = ''.$metric->label;
      if( property_exists($metric, 'value') )
        $data['value'] = ''.$metric->value;
      if( property_exists($metric, 'array_data') )
        $data['array_data'] = arr2string( $metric->array_data );
      $this->Evaluation->insert( $data );
    }
    
    // fold metrics
    if( property_exists( $json, 'fold_metrices' ) ) {
      for( $repeat = 0; $repeat < count($json->fold_metrices); ++$repeat ) {
        for( $fold = 0; $fold < count($json->fold_metrices[$repeat]); ++$fold ) {
          $did = $this->Dataset->getHighestIndex( $this->data_tables, 'did' );
          $this->Run->outputData( $runId, $did, 'evaluation_fold' );
          foreach( $json->fold_metrices[$repeat][$fold] as $metric ) {
            if( in_array( $metric->name, $this->supportedMetrics ) ) {
              // TODO: smarter way to deal with this :)
              $implementation_record = $this->Implementation->getByFullName($metric->implementation);
              if( $implementation_record == false ) {
                $this->Log->mapping( __FILE__, __LINE__, 'Implementation ' . $metric->implementation . ' not found in database. ' );
                continue;
              }
              
              $data = array(
                'did' => $did,
                'source' => $runId,
                'parent' => $did_global,
                'function' => $metric->name,
                'implementation_id' => $implementation_record->id,
                'repeat' => $repeat,
                'fold' => $fold );
              if( property_exists($metric, 'label') )
                $data['label'] = '' . $metric->label;
              if( property_exists($metric, 'value') )
                $data['value'] = ''.$metric->value;
              if( property_exists($metric, 'array_data') )
                $data['array_data'] = arr2string( $metric->array_data );
              $this->Evaluation_fold->insert( $data );
            }
          }
        }
      }
    }
    
    // sample metrics
    if( property_exists( $json, 'sample_metrices' ) ) {
      for( $repeat = 0; $repeat < count($json->sample_metrices); ++$repeat ) {
        for( $fold = 0; $fold < count($json->sample_metrices[$repeat]); ++$fold ) {
          for( $sample = 0; $sample < count($json->sample_metrices[$repeat][$fold]); ++$sample ) {
            $did = $this->Dataset->getHighestIndex( $this->data_tables, 'did' );
            $this->Run->outputData( $runId, $did, 'evaluation_sample' );
            foreach( $json->sample_metrices[$repeat][$fold][$sample] as $metric ) {
              if( in_array( $metric->name, $this->supportedMetrics ) ) {
                // TODO: smarter way to deal with this :)
                $implementation_record = $this->Implementation->getByFullName($metric->implementation);
                if( $implementation_record == false ) {
                  $this->Log->mapping( __FILE__, __LINE__, 'Implementation ' . $metric->implementation . ' not found in database. ' );
                  continue;
                }
                
                $data = array(
		              'did' => $did,
		              'source' => $runId,
                  'parent' => $did_global,
		              'function' => $metric->name,
		              'implementation_id' => $implementation_record->id,
                  'repeat' => $repeat,
                  'fold' => $fold,
                  'sample' => $sample,
                  'sample_size' => $metric->sample_size );
                if( property_exists($metric, 'label') )
                  $data['label'] = '' . $metric->label;
                if( property_exists($metric, 'value') )
                  $data['value'] = ''.$metric->value;
                if( property_exists($metric, 'array_data') )
                  $data['array_data'] = arr2string( $metric->array_data );
                $this->Evaluation_sample->insert( $data );
              }
            }
          }
        }
      }
    }
    
    // check if there were any inconsistent measures:
    if($inconsistentMeasures) {
      $errorCode = 'Inconsistent evaluation measures: ' . implode( '; ', $inconsistentMeasures);
      return false;
    }

    return $res;
  }
  
  private function measureConsistent( $engine, &$user_all ) {
    for( $i = 0; $i < count($user_all); ++$i ) {
      $user_measure = $user_all[$i];
      if( ''.$user_measure->implementation == $engine->implementation && 
          ''.$user_measure->name == $engine->name ) {
        if( abs(doubleval($user_measure->value) - $engine->value) > $this->config->item('double_epsilon') ) {
          return false;
        } else {
          unset( $user_all[$i] );
          return true;
        }
      }
    }
    return true;
  }
}
?>
