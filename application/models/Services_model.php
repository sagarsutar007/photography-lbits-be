<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Services_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function countServices($user_id='')
    {
    	$this->db->where(["user_id" => $user_id]);
    	$this->db->from("services_tbl");
    	return $this->db->count_all_results();
    }

    public function insert($data = "")
    {
        $arr = [
            "title" => $data["title"],
            "description" => $data["description"],
            "user_id" => $data["userid"],
        ];

        $this->db->insert("services_tbl", $arr);
        return $this->db->insert_id();
    }

    public function insertImages($data = "")
    {
        $arr = [
            "file_name" => $data["file_name"],
            "type" => "service",
            "rec_id" => $data["id"],
            "file_type" => "img",
        ];
        $this->db->insert("files_tbl", $arr);
        return $this->db->insert_id();
    }

    public function getServices($user_id = "")
    {
        $q = $this->db->get_where("services_tbl", ["user_id" => $user_id]);
        return $q->result_array();
    }

    public function getImages($id = "")
    {
        $q = $this->db->get_where("files_tbl", [
            "rec_id" => $id,
            "file_type" => "img",
            "type" => "service",
        ]);

        return $q->result_array();
    }
}

/* End of file Services_model.php */
/* Location: ./application/models/Services_model.php */
