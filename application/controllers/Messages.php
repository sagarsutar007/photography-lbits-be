<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Messages extends CI_Controller {

	public function __construct() {
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") { die(); }
		parent::__construct();
		$this->load->model('Users_model', 'user');
		$this->load->model('Messages_model', 'message');
	}

	public function fetchUserMessages() {
		$json = json_decode(file_get_contents('php://input'));
		if($json != null && $json->userid){
			$result = $this->message->getMessage($json->userid);
			$data['status'] = "SUCCESS";
			$data['message'] = "message fetched successfully!";
			$data['result'] = $result;
		} else{
			http_response_code(401);
			$data['status'] = "ERROR";
			$data['message'] = "Required parameter is missing!";
		}
		echo json_encode($data);
	}

	public function sendMessage(){
		$json = json_decode(file_get_contents('php://input'));
		if($json != null && isset($json->userid) && isset($json->to_user) && isset($json->message)){
			$json = json_decode(json_encode($json), true);
			$user = $this->user->isUsernameAvailable($json['to_user']);
			if ($user) {
				$json['to_user'] = $user['id'];
				$this->message->insertMessage($json);
				$data['status'] = "SUCCESS";
				$data['message'] = "Message sent successfully!";
			} else {
				$data['status'] = "ERROR";
				$data['message'] = "User is missing!";
			}
		} else{
			http_response_code(401);
			$data['status'] = "ERROR";
			$data['message'] = "Required parameter is missing!";
		}
		echo json_encode($data);
	}
}



/* End of file  */

/* Location: ./application/controllers/ */