<?php
class CurlHandler {
	
	private $handle;
	private $header;
	
	function __construct() {
		$this->handle = curl_init();
	}
	
	function __destruct() {
		curl_close($this->handle);
	}
	
	function init($url) {
		$this->handle = curl_init($url);
		curl_setopt($this->handle, CURLOPT_NOBODY, true);
		curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->handle, CURLOPT_HEADER, true);
		//curl_setopt($this->handle, CURLOPT_FOLLOWLOCATION, true);
		$this->header = curl_exec($this->handle);
	}
	
	function succes() {
		$httpCode = curl_getinfo($this->handle, CURLINFO_HTTP_CODE);
		return ($httpCode == 200);
	}
	
	function getFilesize( $url ) {
		if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {
			$contentLength = (int)$matches[1];
			return $contentLength;
		} else {
			return -1;
		}
	}
}
?>
