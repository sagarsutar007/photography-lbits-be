<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Abstracts_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function countAbstracts($user_id='')
    {
    	$this->db->where(["user_id" => $user_id]);
    	$this->db->from("abstracts_tbl");
    	return $this->db->count_all_results();
    }

    public function insert($data = "")
    {
        $arr = [
            "title" => $data["title"],
            "author" => $data["author"],
            "description" => $data["description"],
            "published_at" => $data["published_at"],
            "published_year" => $data["published_year"],
            "user_id" => $data["userid"],
        ];

        $this->db->insert("abstracts_tbl", $arr);
        return $this->db->insert_id();
    }

    public function insertImages($data = "")
    {
        $arr = [
            "file_name" => $data["file_name"],
            "type" => "abstract",
            "rec_id" => $data["id"],
            "file_type" => "img",
        ];

        $this->db->insert("files_tbl", $arr);
        return $this->db->insert_id();
    }

    public function insertFiles($data = "")
    {
        $arr = [
            "file_name" => $data["file_name"],
            "type" => "abstract",
            "rec_id" => $data["id"],
            "file_type" => "file",
        ];

        $this->db->insert("files_tbl", $arr);
        return $this->db->insert_id();
    }

    public function getAbstracts($user_id = "")
    {
        $q = $this->db->get_where("abstracts_tbl", ["user_id" => $user_id]);
        return $q->result_array();
    }

    public function getImages($id = "")
    {
        $q = $this->db->get_where("files_tbl", [
            "rec_id" => $id,
            "file_type" => "img",
            "type" => "abstract",
        ]);

        return $q->result_array();
    }

    public function getFiles($id = "")
    {
        $q = $this->db->get_where("files_tbl", [
            "rec_id" => $id,
            "file_type" => "file",
            "type" => "abstract",
        ]);

        return $q->result_array();
    }
}

/* End of file Abstracts_model.php */

/* Location: ./application/models/Abstracts_model.php */
