<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Abstracts extends CI_Controller {



	public function __construct()

	{

		header('Access-Control-Allow-Origin: *');

		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");

		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		$method = $_SERVER['REQUEST_METHOD'];

		if($method == "OPTIONS") { die(); }

		parent::__construct();

		$this->load->model('Users_model', 'user');

		$this->load->model('Abstracts_model', 'abstract');

	}



	public function getAbstracts()

	{

		$json = json_decode(file_get_contents('php://input'));

		if($json != null && (isset($json->username) || isset($json->userid) )){
			if (!empty($json->username)) {
				$user = $this->user->isUsernameAvailable($json->username);
				$userid = $user['id']??'';
			} else {
				$userid = $json->userid;
			}
			if ($userid) {
				$result = $this->abstract->getAbstracts($userid);
				$response = [];
				foreach ($result as $key => $obj) {
					$images = $this->abstract->getImages($obj['id']);
					$files = $this->abstract->getFiles($obj['id']);
					$temp = $obj;
					$temp['images'] = $images;
					$temp['files'] = $files;
					$response[] = $temp;
				}
				$data['status'] = "SUCCESS";
				$data['message'] = "Abstracts fetched successfully!";
				$data['result'] = $response;
			} else {
				$data['status'] = "ERROR";
				$data['message'] = "Abstracts not fetched!";
				$data['result'] = [];
			}
		} else{
			http_response_code(401);
			$data['status'] = "ERROR";
			$data['message'] = "Required parameter is missing!";
		}
		echo json_encode($data);
	}



	public function addAbstract()

	{

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			$post = $this->input->post();

	        $last_id = $this->abstract->insert($post);

	        if (!empty($_FILES['abstract_img']['name'][0]) && $last_id) {

			    $config['upload_path'] = './assets/images/';

			    $config['allowed_types'] = 'jpg|jpeg|png';

			    $config['encrypt_name'] = TRUE;

			    $config['max_size'] = 20480;

			    $this->load->library('upload', $config);



			    $uploaded_images = [];



			    for ($i = 0; $i < count($_FILES['abstract_img']['name']); $i++) {

			        $_FILES['userfile']['name'] = $_FILES['abstract_img']['name'][$i];

			        $_FILES['userfile']['type'] = $_FILES['abstract_img']['type'][$i];

			        $_FILES['userfile']['tmp_name'] = $_FILES['abstract_img']['tmp_name'][$i];

			        $_FILES['userfile']['error'] = $_FILES['abstract_img']['error'][$i];

			        $_FILES['userfile']['size'] = $_FILES['abstract_img']['size'][$i];



			        if ($this->upload->do_upload('userfile')) {

			            $file = $this->upload->data();

			            $files['file_name'] = $file['file_name'];

			            $files['id'] = $last_id;

			            $uploaded_images[] = $files;

			        }

			    }



			    if (count($uploaded_images) > 0) {

			        foreach ($uploaded_images as $key) {

			        	$this->abstract->insertImages($key);

			        }

			    }

			}



			if (!empty($_FILES['abstract_files']['name'][0]) && $last_id) {

				$config = [];

			    $config['upload_path'] = './assets/uploads/';

			    $config['allowed_types'] = 'pdf|docx|ppt|pptx';

			    $config['encrypt_name'] = TRUE;

			    $config['max_size'] = 20480;

				$this->upload->initialize($config);

			    $uploaded_files = [];



			    for ($i = 0; $i < count($_FILES['abstract_files']['name']); $i++) {

			        $_FILES['userfile']['name'] = $_FILES['abstract_files']['name'][$i];

			        $_FILES['userfile']['type'] = $_FILES['abstract_files']['type'][$i];

			        $_FILES['userfile']['tmp_name'] = $_FILES['abstract_files']['tmp_name'][$i];

			        $_FILES['userfile']['error'] = $_FILES['abstract_files']['error'][$i];

			        $_FILES['userfile']['size'] = $_FILES['abstract_files']['size'][$i];



			        if ($this->upload->do_upload('userfile')) {

			            $file = $this->upload->data();

			            $files['file_name'] = $file['file_name'];

			            $files['id'] = $last_id;

			            $uploaded_files[] = $files;

			        }

			    }

			    

			    if (count($uploaded_files) > 0) {

			        foreach ($uploaded_files as $key) {

			        	$this->abstract->insertFiles($key);

			        }

			    }

			}



			$data['status'] = "SUCCESS";

			$data['message'] = "Abstract added successfully!";



		} else {

			http_response_code(401);

			$data['status'] = "ERROR";

			$data['message'] = "Please check request format!";

		}

		echo json_encode($data);

	}



}



/* End of file  */

/* Location: ./application/controllers/ */