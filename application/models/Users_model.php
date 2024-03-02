<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{

	public $users = "users_tbl";

	public function __construct()
	{
		parent::__construct();
	}

	public function searchByPhone($value = '')
	{
		if (empty($value)) {
			return NULL;
		}
		$q = $this->db->get_where($this->users, ['phone' => $value]);
		return $q->row_array();
	}

	public function insert($data = [])
	{
		$this->db->insert($this->users, $data);
		return $this->db->insert_id();
	}

	public function update($data = [], $cond = [])
	{
		$this->db->update($this->users, $data, $cond);
		return $this->db->affected_rows();
	}

	public function updateUser($data = [], $userid = '')
	{
		if (isset($data['username'])) {
			$data['username'] = strtolower($data['username']);
		}
		$this->db->update($this->users, $data, ['id' => $userid]);
		return $this->db->affected_rows();
	}

	public function get($value = '')
	{
		$q = $this->db->get_where($this->users, ['id' => $value]);
		return $q->row_array();
	}

	public function getUser($data = '')
	{

		if (isset($data->username) && !empty($data->username)) {
			$this->db->where(['username' => $data->username]);
		} else if (isset($data->userid)) {
			$this->db->where(['id' => $data->userid]);
		} else {
			return NULL;
		}
		$this->db->from($this->users);
		$q = $this->db->get();
		return $q->row_array();
	}

	public function isUsernameAvailable($value = '')
	{
		$q = $this->db->get_where($this->users, ['username' => strtolower($value)]);
		return $q->row_array();
	}
}

/* End of file  */
/* Location: ./application/models/ */