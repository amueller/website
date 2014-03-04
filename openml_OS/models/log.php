<?php
class Log extends CI_Model {

  private $handle;
  private $dir;

  function __construct() {
    parent::__construct();
    $this->dir = DATA_PATH . 'log/';
    
    create_dir( $this->dir );
  }
  
  function cronjob( $level, $function, $message ) {
    $this->handle = fopen( $this->dir . 'cron.log', 'a' );
    fwrite( $this->handle, '[' . now() . '] [' . $level . '] ' . $function . ': ' . $message . "\n" );
    fclose($this->handle);
  }
  
  function api_error( $level, $user, $code, $function, $message ) {
    $this->handle = fopen( $this->dir . 'api_errors.log', 'a' );
    fwrite( $this->handle, '[' . now() . '] ['.$level.'] [' . $user . '] Errorcode: ' . $code . '. Function: ' . $function . '. Response: ' . $message . "\n" );
    fclose($this->handle);
  }
  
  function sql( $query, $type='server' ) {
    $this->handle = fopen( $this->dir . 'sql.log', 'a' );
    fwrite( $this->handle, '[' . now() . '] [' . $type . '] ' . str_replace( "\n", '', $query ) . "\n" );
    fclose($this->handle);
  }

  function cmd( $source, $cmd ) {
    $this->handle = fopen( $this->dir . 'cmd.log', 'a' );
    fwrite( $this->handle, '[' . now() . '] [' . $source . '] ' . $cmd . "\n" );
    fclose($this->handle);
  }
  
  function mapping( $file, $line, $message ) {
    $this->handle = fopen( $this->dir . 'mapping.log', 'a' );
    fwrite( $this->handle, '[' . now() . '] [' . $file . ': ' . $line . '] Inconsistent mapping: ' . $message . "\n" );
    fclose($this->handle);
  }
}
?>
