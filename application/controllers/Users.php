<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
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
		$this->load->model('Services_model', 'services');
		$this->load->model('Abstracts_model', 'abstracts');
	}

	public function updateUser()
	{
		$json = json_decode(file_get_contents('php://input'));
		if ($json != null && $json->userid) {

			$user_id = $json->userid;
			$arr = [];
			if (isset($json->name)) $arr['name'] = $json->name;
			if (isset($json->email)) $arr['email'] = $json->email;
			if (isset($json->state)) $arr['state'] = $json->state;
			if (isset($json->city)) $arr['city'] = $json->city;
			if (isset($json->username)) {
				$this->load->library('ciqrcode');
				$arr['username'] = $json->username;
				$params['data'] = "https://chromagz/" . $arr['username'];
				$params['level'] = 'H';
				$params['size'] = 10;
				$params['savename'] = FCPATH . 'assets/qrcodes/' . $arr['username'] . '.png';
				$this->ciqrcode->generate($params);
				$arr['qrcode'] = base_url('assets/qrcodes/' . $arr['username'] . '.png');
			}
			if (isset($json->qualification)) $arr['qualification'] = $json->qualification;
			if (isset($json->pin)) $arr['pin'] = $json->pin;
			if (isset($json->phone)) $arr['phone'] = $json->phone;
			if (isset($json->telephone)) $arr['telephone'] = $json->telephone;

			if (isset($json->maps)) $arr['maps'] = $json->maps;
			if (isset($json->calendly)) $arr['calendly'] = $json->calendly;
			if (isset($json->youtube)) $arr['youtube'] = $json->youtube;
			if (isset($json->whatsapp)) $arr['whatsapp'] = $json->whatsapp;
			if (isset($json->linkedin)) $arr['linkedin'] = $json->linkedin;
			if (isset($json->telegram)) $arr['telegram'] = $json->telegram;
			if (isset($json->twitter)) $arr['twitter'] = $json->twitter;
			if (isset($json->website)) $arr['website'] = $json->website;
			if (isset($json->smartphone)) $arr['smartphone'] = $json->smartphone;
			if (isset($json->upi)) $arr['upi'] = $json->upi;

			$user_updated = $this->user->updateUser($arr, $user_id);

			if ($user_updated) {
				$data['status'] = "SUCCESS";
				$data['message'] = "User updated successfully!";
				$data['user'] = $this->user->get($user_id);
			} else {
				$data['status'] = "ERROR";
				$data['message'] = "User not updated!";
				$data['user'] = $this->user->get($user_id);
			}
		} else if ($this->input->method() == "post") {
			$post = $this->input->post();
			$user_id = $post['userid'];
			if (!empty($_FILES['resume']['name'])) {
				$config['upload_path'] = './assets/uploads/';
				$config['allowed_types'] = 'docx|pdf|doc';
				$config['encrypt_name'] = TRUE;
				$config['max_size'] = 20480;
				$this->load->library('upload', $config);
				$user_updated = false;
				if ($this->upload->do_upload('resume')) {
					$file = $this->upload->data();
					$arr['resume'] = $file['file_name'];
					$user_updated = $this->user->updateUser($arr, $user_id);
				}
			}
			if ($user_updated) {
				$data['status'] = "SUCCESS";
				$data['message'] = "User updated successfully!";
				$data['user'] = $this->user->get($user_id);
			} else {
				$data['status'] = "ERROR";
				$data['message'] = "User not updated!";
				$data['user'] = $this->user->get($user_id);
			}
		} else {
			http_response_code(401);
			$data['status'] = "ERROR";
			$data['message'] = "Required parameter is missing!";
		}
		echo json_encode($data);
	}

	public function checkUserName($value = '')
	{
		$json = json_decode(file_get_contents('php://input'));
		if ($json != null && $json->username) {

			$username = $json->username;
			$username_status = $this->user->isUsernameAvailable($username);

			if ($username_status) {
				$data['status'] = "ERROR";
				$data['message'] = "Username not available!";
				$data['available'] = false;
			} else {
				$data['status'] = "SUCCESS";
				$data['message'] = "Username available!";
				$data['available'] = true;
			}
		} else {
			http_response_code(401);
			$data['status'] = "ERROR";
			$data['message'] = "Required parameter is missing!";
		}
		echo json_encode($data);
	}

	public function fetchUser($value = '')
	{
		$json = json_decode(file_get_contents('php://input'));
		if ($json != null && (isset($json->userid) || isset($json->username))) {
			$user = $this->user->getUser($json);

			if ($user) {
				if (!empty($user['profile_img']) && file_exists('assets/images/' . $user['profile_img'])) {
					$user['profile_img'] = base_url('assets/images/' . $user['profile_img']);
				} else {
					$user['profile_img'] = NULL;
				}
				$user['services'] = $this->services->countServices($user['id']);
				$user['abstracts'] = $this->abstracts->countAbstracts($user['id']);

				$data['status'] = "SUCCESS";
				$data['message'] = "User found!";
				$data['user'] = $user;
			} else {
				$data['status'] = "ERROR";
				$data['message'] = "User not found!";
				$data['user'] = $user;
			}
		} else {
			http_response_code(401);
			$data['status'] = "ERROR";
			$data['message'] = "Required parameter is missing!";
		}
		echo json_encode($data);
	}

	public function updateProfile()
	{
		if ($this->input->method() === 'post') {
			$post = $this->input->post();
			if (isset($_FILES['profile_img'])) {
				$config['upload_path'] = './assets/images/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['encrypt_name'] = TRUE;
				$config['max_size'] = 20480;
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('profile_img')) {
					$file = $this->upload->data();
					$post['profile_img'] = $file['file_name'];
				}
			}

			$this->user->update($post, ['id' => $post['id']]);
			$data['status'] = "SUCCESS";
			$data['message'] = "Data saved successfully!";
		} else {
			http_response_code(401);
			$data['status'] = "ERROR";
			$data['message'] = "Please check request format!";
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	// echo json_encode($data);



	public function updatePin()
	{
		$json = json_decode(file_get_contents('php://input'));
		if ($json != null && $json->userid && isset($json->userid, $json->oldPin, $json->newPin)) {
			$user = $this->user->get($json->userid);

			if ($user) {
				if (isset($user['pin']) && $json->oldPin == $user['pin']) {
					$arr = ["pin" => $json->newPin];
					$cond = $json->userid;
					$this->user->updateUser($arr, $cond);
					$data['status'] = "SUCCESS";
					$data['message'] = "User pin updated!";
				} else {

					$data['status'] = "ERROR";
					$data['message'] = "User pin not updated!";
				}
			} else {
				$data['status'] = "ERROR";
				$data['message'] = "User not found!";
			}
		} else {
			http_response_code(401);
			$data['status'] = "ERROR";
			$data['message'] = "Required parameter is missing!";
		}
		echo json_encode($data);
	}
}
/* End of file  */
/* Location: ./application/controllers/ */