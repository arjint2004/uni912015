<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Online_Users
 *
 * Currently Online Users library for Code Igniter.
 *
 * @package		Online Users
 * @author		Joseph Pugh
 * @version		1.0.0
 */

class Online_Users {
	
	private $ip;
	private $user_id;
	
	function __construct()
	{
		$session = session_data();
		$this->ci =& get_instance();		
		$this->ci->load->database();
		$this->ci->load->model('online');
		$this->user_id = $session['id_pengguna'];
		$this->ip = ip2long($_SERVER['REMOTE_ADDR']);
		$this->Run_Online();
	}
	
	/**
	 * Core logic for the Online Users library.
	 * 
	 * Check if user hit is unique, if so, insert in to database, else, update the last time.
	 * Also purge all expired online users.
	 *
	 * @return	void
	 */
	private function Run_Online() {
		$timeout = time() - 150;
		 
		if ($this->ci->online->is_online($this->user_id)==0) {
			$data = array(
				'user_id'	=> $this->user_id,
				'time'		=> time()
			);
			
			$this->ci->online->set_online($data);
			
		} else {
			$this->ci->online->update_online($this->user_id);
		}
		
		$this->ci->online->purge_expired($timeout);
	}
	
	/**
	 * Query the currently online users in an array of user id's.
	 *
	 * @return	array
	 */
	function get_online() {
		return $this->ci->online->get_online();
	}
}

/* End of file Online_Users.php */
/* Location: ./application/libraries/Online_Users.php */