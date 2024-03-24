<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Portfolio_model extends CI_Model
{
    public $portfolio = "portfolio_tbl";
    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data = '')
    {
        $arr = [
            'event' => $data['event'],
            'location' => $data['location'],
            'eventdate' => $data['eventdate'],
            'eventdescription' => $data['eventdescription'],
            // 'Youtube_urls' => $data['youtubeUrls'],
            // 'Youtube_urls' => isset($data['youtubeUrls']) ? $data['youtubeUrls'] : null,
            'user_id' => $data['userid']
        ];
        // Check if YouTube URL is provided before including it
        if (isset($data['YoutubeURLs'])) {
            $arr['Youtube_urls'] = $data['YoutubeURLs'];
        }

        $this->db->insert('portfolio_tbl', $arr);


        return $this->db->insert_id();
    }

    // public function deleteImageById($id)
    // {
    //     $q = $this->db->delete('files_tbl', array('id' => $id));
    //     return $q->row_array();
    // }
    // public function deleteImageById($id)
    // {
    //     $arr = [
    //         // 'file_name' => $data['file_name'],
    //         'type' => 'portfolio',
    //         'rec_id' => $id['id'],
    //         'file_type' => 'img',
    //     ];

    //     $this->db->delete('files_tbl', $arr);
    //     return $this->db->delete_id();
    // }
    public function deleteImageById($id)
    {
        // Your logic to delete the image based on $id goes here
        // Use $id to identify and delete the image from the 'files_tbl' table

        // Example (you need to replace this with your actual database logic):
        $this->db->where('id', $id);
        $this->db->delete('files_tbl');

        return $this->db->affected_rows() > 0;
    }

    // public function deleteImage($id, $imageindex)
    // {
    //     // Your logic to delete the image from the database goes here
    //     // Use $portfolioId and $imageId to identify and delete the image

    //     // Example: (you need to replace this with your actual database logic)
    //     $this->db->where('files_tbl', $id);
    //     // $this->db->where('index', $imageindex);
    //     $this->db->delete('files_tbl', $imageindex);

    //     return $this->db->affected_rows() > 0;
    // }

    public function insertImages($data = '')
    {
        $arr = [
            'file_name' => $data['file_name'],
            'type' => 'portfolio',
            'rec_id' => $data['id'],
            'file_type' => 'img',
        ];

        $this->db->insert('files_tbl', $arr);
        return $this->db->insert_id();
    }
    // public function update($data = [], $cond = [])
    // {
    //     $this->db->update($this->users, $data, $cond);
    //     return $this->db->affected_rows();
    // }
    public function update($data = [], $cond = [])
    {
        $this->db->update('portfolio_tbl', $data, $cond);
        return $this->db->affected_rows();
    }
    // public function updatePortfolio($data = [], $cond = [])
    // {
    //     $this->db->update('portfolio_tbl', $data, $cond);
    //     return $this->db->affected_rows();
    // }

    public function updatePortfolio($data = [], $id = '')
    {
        // if (isset($data['username'])) {
        //     $data['username'] = strtolower($data['username']);
        // }
        $this->db->update($this->portfolio, $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
    // public function updatePortfolio($data = [], $userid = '')
    // {
    //     if (isset($data['userid'])) {
    //         $data['userid'] = strtolower($data['userid']);
    //     }
    //     $this->db->update($this->users, $data, ['id' => $userid]);
    //     return $this->db->affected_rows();
    // }
    public function get($value = '')
    {
        $q = $this->db->get_where($this->users, ['id' => $value]);
        return $q->result_array();
    }
    public function getPortfolioById($eventId)
    {
        $q = $this->db->get_where('portfolio_tbl', array('id' => $eventId));
        return $q->row_array();
    }
    public function getImage($eventId = '')
    {
        $q = $this->db->get_where('files_tbl', ['rec_id' => $eventId, 'file_type' => 'img', 'type' => 'portfolio']);
        return $q->result_array();
    }


    public function getPortfolio($user_id = '')
    {
        $q = $this->db->get_where('portfolio_tbl', ['user_id' => $user_id]);
        return $q->result_array();
    }

    public function getImages($id = '')
    {
        $q = $this->db->get_where('files_tbl', ['rec_id' => $id, 'file_type' => 'img', 'type' => 'portfolio']);
        return $q->result_array();
    }

    public function getYoutubeURLs($id = '')
    {
        $q = $this->db->get_where('files_tbl', ['rec_id' => $id, 'file_type' => 'youtube', 'type' => 'portfolio']);
        $result = $q->result_array();

        $youtubeURLs = [];
        foreach ($result as $row) {
            // Assuming the YouTube URLs are stored in the 'file_name' column
            $youtubeURLs[] = $row['file_name'];
        }

        return $youtubeURLs;
    }
}
