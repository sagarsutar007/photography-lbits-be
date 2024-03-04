<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Portfolio extends CI_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        parent::__construct();
        $this->load->model('Users_model', 'user');
        $this->load->model('Portfolio_model', 'portfolio');
        $this->load->model('Portfolio_model');
    }



    public function updatePortfolio()
    {
        $json = json_decode(file_get_contents('php://input'));
        if ($json != null && $json->id) {

            $id = $json->id;
            $arr = [];
            if (isset($json->event)) $arr['event'] = $json->event;
            if (isset($json->location)) $arr['location'] = $json->location;
            if (isset($json->eventdate)) $arr['eventdate'] = $json->eventdate;
            if (isset($json->eventdescription)) $arr['eventdescription'] = $json->eventdescription;
            if (isset($json->Youtube_urls)) $arr['Youtube_urls'] = $json->Youtube_urls;
            if (isset($json->location)) $arr['location'] = $json->location;

            $portfolio_updated = $this->portfolio->updatePortfolio($arr, $id);

            if ($portfolio_updated) {
                $data['status'] = "SUCCESS";
                $data['message'] = "Portfolio updated successfully!";
                $data['portfolio'] = $this->portfolio->get($id);
            } else {
                $data['status'] = "ERROR";
                $data['message'] = "Portfolio not updated!";
                $data['portfolio'] = $this->portfolio->get($id);
            }
        } else if ($this->input->method() == "post") {
            $post = $this->input->post();
            $id = $post['id'];
            if (!empty($_FILES['portfolio_img']['name'][0]) && $id) {
                $config['upload_path'] = './assets/images/';

                $config['allowed_types'] = 'jpg|jpeg|png';

                $config['encrypt_name'] = TRUE;

                $config['max_size'] = 20480;

                $this->load->library('upload', $config);
                $uploaded_files = [];
                for ($i = 0; $i < count($_FILES['portfolio_img']['name']); $i++) {

                    $_FILES['userfile']['name'] = $_FILES['portfolio_img']['name'][$i];

                    $_FILES['userfile']['type'] = $_FILES['portfolio_img']['type'][$i];

                    $_FILES['userfile']['tmp_name'] = $_FILES['portfolio_img']['tmp_name'][$i];

                    $_FILES['userfile']['error'] = $_FILES['portfolio_img']['error'][$i];

                    $_FILES['userfile']['size'] = $_FILES['portfolio_img']['size'][$i];



                    if ($this->upload->do_upload('userfile')) {

                        $file = $this->upload->data();

                        $files['file_name'] = $file['file_name'];

                        $files['id'] = $id;

                        $files['type'] = 'portfolio';
                        $uploaded_files[] = $files;
                    }
                }



                if (count($uploaded_files) > 0) {

                    foreach ($uploaded_files as $key) {

                        $this->portfolio->insertImages($key);
                    }
                }

                $this->load->library('upload', $config);
                $portfolio_updated = false;
                if ($this->upload->do_upload('userfile')) {
                    $file = $this->upload->data();
                    $arr['images'] = $file['file_name'];
                    $portfolio_updated = $this->portfolio->updatePortfolio($arr, $id);
                }
            }
            if ($portfolio_updated) {
                $data['status'] = "SUCCESS";
                $data['message'] = "Portfolio updated successfully!";
                $data['portfolio'] = $this->portfolio->get($id);
            } else {
                $data['status'] = "ERROR";
                $data['message'] = "Portfolio not updated!";
                $data['portfolio'] = $this->portfolio->get($id);
            }
        } else {
            http_response_code(401);
            $data['status'] = "ERROR";
            $data['message'] = "Required parameter is missing!";
        }
        echo json_encode($data);
    }
    // public function fetchPortfolio($value = '')
    // {
    //     $json = json_decode(file_get_contents('php://input'));
    //     if ($json != null && (isset($json->userid) || isset($json->username))) {
    //         $portfolio = $this->portfolio->getPortfolio($json);

    //         if ($user) {
    //             if (!empty($user['profile_img']) && file_exists('assets/images/' . $user['profile_img'])) {
    //                 $user['profile_img'] = base_url('assets/images/' . $user['profile_img']);
    //             } else {
    //                 $user['profile_img'] = NULL;
    //             }
    //             $user['services'] = $this->services->countServices($user['id']);
    //             $user['abstracts'] = $this->abstracts->countAbstracts($user['id']);

    //             $data['status'] = "SUCCESS";
    //             $data['message'] = "User found!";
    //             $data['user'] = $user;
    //         } else {
    //             $data['status'] = "ERROR";
    //             $data['message'] = "User not found!";
    //             $data['user'] = $user;
    //         }
    //     } else {
    //         http_response_code(401);
    //         $data['status'] = "ERROR";
    //         $data['message'] = "Required parameter is missing!";
    //     }
    //     echo json_encode($data);
    // }


    public function getPortfolioById()
    {
        $eventId = $this->input->get('id');
        if (!empty($eventId)) {
            // Fetch customer data based on $eventId
            $result = $this->Portfolio_model->getPortfolioById($eventId);
            if ($result) {
                // Fetch images associated with the customer
                $images = $this->Portfolio_model->getImage($eventId);

                // Add images to the result array
                $result['images'] = $images;

                $data['status'] = "SUCCESS";
                $data['message'] = "Portfolio fetched successfully!";
                $data['result'] = $result;
            } else {
                $data['status'] = "ERROR";
                $data['message'] = "Portfolio not found!";
                $data['result'] = [];
            }
        } else {
            http_response_code(401);
            $data['status'] = "ERROR";
            $data['message'] = "Required parameter is missing!";
        }
        echo json_encode($data);
    }


    public function getPortfolio()

    {

        $json = json_decode(file_get_contents('php://input'));

        if ($json != null && (isset($json->username) || isset($json->userid))) {
            if (!empty($json->username)) {
                $user = $this->user->isUsernameAvailable($json->username);
                $userid = $user['id'] ?? '';
            } else {
                $userid = $json->userid;
            }
            if ($userid) {
                $result = $this->portfolio->getPortfolio($userid);
                $response = [];
                foreach ($result as $key => $obj) {
                    $images = $this->portfolio->getImages($obj['id']);

                    $temp = $obj;
                    $temp['images'] = $images;

                    $response[] = $temp;
                }
                $data['status'] = "SUCCESS";
                $data['message'] = "Portfolio fetched successfully!";
                $data['result'] = $response;
            } else {
                $data['status'] = "ERROR";
                $data['message'] = "Portfolio not fetched!";
                $data['result'] = [];
            }
        } else {
            http_response_code(401);
            $data['status'] = "ERROR";
            $data['message'] = "Required parameter is missing!";
        }
        echo json_encode($data);
    }



    public function addPortfolio()

    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $post = $this->input->post();


            // return $this->portfolio->insert($post);

            $last_id = $this->portfolio->insert($post);
            $json = json_decode(file_get_contents('php://input'));
            $data['status'] = "SUCCESS";
            $data['message'] = "Message sent successfully!";
            $data['body'] = $post;
            $data['id'] = $last_id;



            if (!empty($_FILES['portfolio_img']['name'][0]) && $last_id) {

                $config['upload_path'] = './assets/images/';

                $config['allowed_types'] = 'jpg|jpeg|png';

                $config['encrypt_name'] = TRUE;

                $config['max_size'] = 20480;

                $this->load->library('upload', $config);



                $uploaded_files = [];



                for ($i = 0; $i < count($_FILES['portfolio_img']['name']); $i++) {

                    $_FILES['userfile']['name'] = $_FILES['portfolio_img']['name'][$i];

                    $_FILES['userfile']['type'] = $_FILES['portfolio_img']['type'][$i];

                    $_FILES['userfile']['tmp_name'] = $_FILES['portfolio_img']['tmp_name'][$i];

                    $_FILES['userfile']['error'] = $_FILES['portfolio_img']['error'][$i];

                    $_FILES['userfile']['size'] = $_FILES['portfolio_img']['size'][$i];



                    if ($this->upload->do_upload('userfile')) {

                        $file = $this->upload->data();

                        $files['file_name'] = $file['file_name'];

                        $files['id'] = $last_id;

                        $files['type'] = 'portfolio';
                        $uploaded_files[] = $files;
                    }
                }



                if (count($uploaded_files) > 0) {

                    foreach ($uploaded_files as $key) {

                        $this->portfolio->insertImages($key);
                    }
                }
            }



            $data['status'] = "SUCCESS";

            $data['message'] = "Portfolio added successfully!";
        } else {

            http_response_code(401);

            $data['status'] = "ERROR";

            $data['message'] = "Please check request format!";
        }







        echo json_encode($data);
    }
}
