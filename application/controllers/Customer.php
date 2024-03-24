<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Customer extends CI_Controller
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
        $this->load->model('Customer_model', 'customer');
        $this->load->model('Customer_model');
    }



    public function getCustomer()

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
                $result = $this->customer->getCustomer($userid);
                $response = [];
                foreach ($result as $key => $obj) {
                    $images = $this->customer->getImages($obj['id']);

                    $temp = $obj;
                    $temp['images'] = $images;

                    $response[] = $temp;
                }
                $data['status'] = "SUCCESS";
                $data['message'] = "Customer fetched successfully!";
                $data['result'] = $response;
            } else {
                $data['status'] = "ERROR";
                $data['message'] = "Customer not fetched!";
                $data['result'] = [];
            }
        } else {
            http_response_code(401);
            $data['status'] = "ERROR";
            $data['message'] = "Required parameter is missing!";
        }
        echo json_encode($data);
    }
    // public function viewCustomer($customerId)
    // {
    //     try {
    //         // Fetch customer data by ID using the model
    //         $customerData = $this->Customer_model->getCustomerById($customerId);

    //         if ($customerData) {
    //             // Load your view with the customer data
    //             $data['customer'] = $customerData;
    //             $this->load->view('customer_view', $data);
    //         } else {
    //             // Handle case when customer is not found
    //             echo "Customer not found!";
    //         }
    //     } catch (Exception $e) {
    //         // Handle exceptions if any
    //         echo "Error: " . $e->getMessage();
    //     }
    // }
    public function getCustomerByName()
    {
        $groomName = $this->input->get('GroomName');
        $brideName = $this->input->get('BrideName');

        if (!empty($groomName) && !empty($brideName)) {
            // Fetch customer data based on $eventId
            $result = $this->Customer_model->getCustomerByName($groomName, $brideName);
            if ($result) {
                $eventId = $result['id'];

                // Fetch images associated with the customer
                $images = $this->Customer_model->getImage($eventId);

                // Add images to the result array
                $result['images'] = $images;

                $data['status'] = "SUCCESS";
                $data['message'] = "Customer fetched successfully!";
                $data['result'] = $result;
            } else {
                $data['status'] = "ERROR";
                $data['message'] = "Customer not found!";
                $data['result'] = [];
            }
        } else {
            http_response_code(401);
            $data['status'] = "ERROR";
            $data['message'] = "Required parameter is missing!";
        }
        echo json_encode($data);
    }
    public function addCustomer()

    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $post = $this->input->post();
            $last_id = $this->customer->insert($post);
            $json = json_decode(file_get_contents('php://input'));
            $data['status'] = "SUCCESS";
            $data['message'] = "Message sent successfully!";
            $data['body'] = $post;
            $data['id'] = $last_id;



            if (!empty($_FILES['customer_img']['name'][0]) && $last_id) {

                $config['upload_path'] = './assets/images/';

                $config['allowed_types'] = 'jpg|jpeg|png';

                $config['encrypt_name'] = TRUE;

                $config['max_size'] = 20480;

                $this->load->library('upload', $config);



                $uploaded_files = [];



                for ($i = 0; $i < count($_FILES['customer_img']['name']); $i++) {

                    $_FILES['userfile']['name'] = $_FILES['customer_img']['name'][$i];

                    $_FILES['userfile']['type'] = $_FILES['customer_img']['type'][$i];

                    $_FILES['userfile']['tmp_name'] = $_FILES['customer_img']['tmp_name'][$i];

                    $_FILES['userfile']['error'] = $_FILES['customer_img']['error'][$i];

                    $_FILES['userfile']['size'] = $_FILES['customer_img']['size'][$i];



                    if ($this->upload->do_upload('userfile')) {

                        $file = $this->upload->data();

                        $files['file_name'] = $file['file_name'];

                        $files['id'] = $last_id;

                        $files['type'] = 'customer';
                        $uploaded_files[] = $files;
                    }
                }



                if (count($uploaded_files) > 0) {

                    foreach ($uploaded_files as $key) {

                        $this->customer->insertImages($key);
                    }
                }
            }



            $data['status'] = "SUCCESS";

            $data['message'] = "Customer added successfully!";
        } else {

            http_response_code(401);

            $data['status'] = "ERROR";

            $data['message'] = "Please check request format!";
        }







        echo json_encode($data);
    }
}
