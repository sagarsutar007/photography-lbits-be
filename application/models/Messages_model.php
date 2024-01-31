<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function getMessage($user_id='', $offset=NULL){

		$this->db->select('m.id, u.name, m.message, m.datetime');
		$this->db->where('m.to_user', $user_id);
		$this->db->limit(10, $offset);
		$this->db->order_by('m.datetime', 'desc');
		$this->db->from('messages_tbl m');
		$this->db->join('users_tbl u', 'u.id = m.from_user');
		$q = $this->db->get();
		return $q->result_array();
	}
	
	public function insertMessage($data=[]){
		$arr = [
			'from_user' => $data['userid'],
			'to_user' => $data['to_user'],
			'message' => $data['message'],
			'status' => 'delivered'
		];
		$this->db->insert('messages_tbl', $arr);
		return $this->db->insert_id();
	}

}



/* End of file  */

/* Location: ./application/models/ */