<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
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
            'Youtube_urls' => isset($data['YoutubeUrls']) ? $data['YoutubeUrls'] : null,
            'user_id' => $data['userid']
        ];

        $this->db->insert('customer_tbl', $arr);
        return $this->db->insert_id();
    }
    public function getCustomerById($eventId)
    {
        $q = $this->db->get_where('customer_tbl', array('id' => $eventId));
        return $q->row_array();
    }
    public function getImage($eventId = '')
    {
        $q = $this->db->get_where('files_tbl', ['rec_id' => $eventId, 'file_type' => 'img', 'type' => 'customer']);
        return $q->result_array();
    }

    // public function getCustomerById($customerId)
    // {
    //     // Your logic to fetch customer data by ID from the database
    //     $query = $this->db->get_where('customers', array('id' => $customerId));
    //     return $query->row(); // Assuming you want a single customer
    // }

    public function insertImages($data = '')
    {
        $arr = [
            'file_name' => $data['file_name'],
            'type' => 'customer',
            'rec_id' => $data['id'],
            'file_type' => 'img',
        ];

        $this->db->insert('files_tbl', $arr);
        return $this->db->insert_id();
    }

    public function getCustomer($user_id = '')
    {
        $q = $this->db->get_where('customer_tbl', ['user_id' => $user_id]);
        return $q->result_array();
    }



    public function getImages($id = '')
    {
        $q = $this->db->get_where('files_tbl', ['rec_id' => $id, 'file_type' => 'img', 'type' => 'customer']);
        return $q->result_array();
    }

    public function getYoutubeURLs($id = '')
    {
        $q = $this->db->get_where('files_tbl', ['rec_id' => $id, 'file_type' => 'youtube', 'type' => 'customer']);
        $result = $q->result_array();

        $youtubeURLs = [];
        foreach ($result as $row) {
            // Assuming the YouTube URLs are stored in the 'file_name' column
            $youtubeURLs[] = $row['file_name'];
        }

        return $youtubeURLs;
    }
}
