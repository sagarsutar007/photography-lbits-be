<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	private $users = "users_tbl";

	public function __construct()
	{
		parent::__construct();
	}

	public function checkOtpUser($user_id='', $otp='')
	{
		
		$this->db->where('token', $otp);
		$this->db->or_where('pin', $otp);
		$this->db->where('id', $user_id);
		$this->db->from('users_tbl');
		$q = $this->db->get();
		return $q->row_array();
	}


	
}

/* End of file  */
/* Location: ./application/models/ */