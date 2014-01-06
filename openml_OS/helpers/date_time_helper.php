<?php
/**
* Date-Time Helper
* @package Datiq_OS 2.0
* @author Marcin Polak
* @version 2.0.0
*/

function now($days = false){ 
	if( ! $days) { 
		return date("Y-m-d H:i:s"); 
	} else { 
		return date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s") . " +".$days." day"));
	}
}

function today(){ 
	return date("Y-m-d"); 
}

function tomorrow() {
	$tomorrow = mktime( date("H"), date("i"), date("s"), date("m"), date("d")+1, date("y"));
	return date("Y-m-d H:i:s", $tomorrow); 
}

function timeNeat( $datetime ) {
	$dt_array = explode( ' ', $datetime );
	$time_array = explode( ':', $dt_array[1] );
	return $time_array[0] . ':' . $time_array[1];
}

function dateNeat( $datetime ) {
	$dt_array = explode( ' ', $datetime );
	$date_array = explode( '-', $dt_array[0] );
	return $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0];
}

function now_run() {
	return date("D M d H:i:s e Y"); 
}
?>
