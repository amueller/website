<?php
class Estimation_procedure extends Database_read {
  
  function __construct() {
    parent::__construct();
    $this->table = 'estimation_procedure';
    $this->id_column = 'id';
  }
	
	function sql_constraints( $id, $ttid, $columns = array('type','repeats','folds','percentage','stratified_sampling') ) {
		$evaluation_method = $this->getById( $id );
		if( $evaluation_method == false ) return false;
		if( $evaluation_method->ttid != $ttid ) return false;
		
		$repeat_str = ' AND ' . $columns[1] . (($evaluation_method->repeats == NULL) ? ' IS NULL ' : ' = ' . $evaluation_method->repeats);
		$fold_str = ' AND ' . $columns[2] . (($evaluation_method->folds == NULL) ? ' IS NULL ' : ' = ' . $evaluation_method->folds);
		$percentage_str = ' AND ' . $columns[3] . (($evaluation_method->percentage == NULL) ? ' IS NULL ' : ' = ' . $evaluation_method->percentage);
		$stratified = ' AND ' . $columns[4] . (($evaluation_method->stratified_sampling == NULL) ? ' IS NULL ' : ' = ' . $evaluation_method->stratified_sampling);
		return $columns[0].' = "' . $evaluation_method->type . '" ' . $repeat_str . $fold_str . $percentage_str . ' ';
	}
	
	function get_by_parameters( $ttid, $type, $repeats, $folds, $percentage, $stratified ) {
		
		$task_type  = 'ttid = ' . $ttid;
		$type    	= ' AND type  = "' . $type . '"';
		$repeats 	= ' AND repeats ' . (($repeats == NULL) ? ' IS NULL ' : ' = ' . $repeats);
		$folds   	= ' AND folds ' . (($folds == NULL) ? ' IS NULL ' : ' = ' . $folds);
		$percentage = ' AND percentage ' . (($percentage == NULL) ? ' IS NULL ' : ' = ' . $percentage);
		$stratified = ' AND stratified_sampling ' . (($stratified == NULL) ? ' IS NULL ' : ' = ' . $stratified);
		
		$ep = $this->getWhere( $task_type . $type . $repeats . $folds . $percentage );
		if($ep === false) 
			return false;
		else
			return end($ep);
	}
	
	function splits_arff_size( $ep, $instances ) {
		if( $ep->type == 'crossvalidation' ) {
			return $instances * $ep->folds * $ep->repeats;
		} elseif( $ep->type == 'leaveoneout' ) {
			return $instances * $instances;
		} elseif( $ep->type == 'holdout' ) {
			return $instances * $ep->repeats;
		} else {
			// TODO: implement other types.
			return -1;
		}
	}
	
	function toString( $ttep ) {
		$res = $ttep->type;
		if( $ttep->repeats != null )
			$res .= '_' . $ttep->repeats;
		if( $ttep->folds != null )
			$res .= '_' . $ttep->folds;
		if( $ttep->percentage != null )
			$res .= '_' . $ttep->percentage;
		return $res;
	}
}
?>
