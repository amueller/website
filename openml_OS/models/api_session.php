<?php
class Api_session extends Community {
	
	function __construct()
    {
		parent::__construct();
		$this->table = 'api_session';
		
		$this->load->model('Author');
    }
	
	function getByHash( $hash ) {
		$data = $this->db->where('`hash` = "'.$hash.'"')->get('api_session');
		return ( $data->num_rows() > 0 ) ? $data->row() : false;
	}
	
	function create( $username, $password ) {
		$users = $this->Author->getWhere('`username` = "'.$username.'" AND `password` = "'.$password.'"');
		
		if( $users == false || count($users) == 0 )
			return false;
		$user = $users[0];
		
		/*if( $this->ion_auth->hash_password_db($user->id, $password) == false ) {
			return false;
		}*/
		
		$hash = rand_string( 40, 'CN' );
		
		$id = $this->insert( array( 
			'author_id' => $user->id,
			'creation_date' => now(),
			'hash' => $hash ) );
		
		return ( $id !== false ) ? $hash : $false;
	}
	
	function isValidHash( $hash ) {
		$data = $this->getByHash( $hash );
		if( ! $data ) return false;
		if( $this->validUntil( $data->creation_date ) < now() ) {
			return false;
		}
		
		$this->update( $data->id, array( 'calls' => ($data->calls + 1) ) );
		return true;
	}
	
	function validUntil( $date ) {
		return date('Y-m-d H:i:s', strtotime($date . '+' . $this->config->item('api_session_length')));
	}
}
?>
