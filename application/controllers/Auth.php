<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Auth extends CI_Controller {
    public function __construct() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        parent::__construct();
        $this->load->model('Auth_model', 'auth');
        $this->load->model('Users_model', 'user');
    }
    public function index() {
        $json = json_decode(file_get_contents('php://input'));
        $data = [];
        if ($json != null) {
            $phone = $json->phone;
            if (!empty($phone)) {
                $user = $this->user->searchByPhone($phone);
                $otp = rand(1000, 9999);
                if ($user) {
                    $pin = "";
                    $data['status'] = "SUCCESS";
                    $data['message'] = "Phone number found!";
                    if (empty($user['pin'])) {
                        $arr = ['token' => $otp];
                        $carr = ['id' => $user['id']];
                        $pin = $otp;
                        $this->user->update($arr, $carr);
                        $data['user_code'] = "NEW";

                        $key = "e2fezUjQdMCo6VZa";	
						$mbl = "+91" . $phone;
						$message_content=urlencode("Hello User, To update account you can use this one-time OTP: $otp ADCOLC");
						$templateid = "1307170374449021046";
						$senderid="ADCOLC";	$route= 1;
						$url = "http://www.text2india.store/vb/apikey.php?apikey=$key&templateid=$templateid&senderid=$senderid&number=$mbl&message=$message_content";
											
						$output = file_get_contents($url);
                    } else {
                        $pin = $user['pin'];
                        $data['user_code'] = "EXISTING";
                    }
                    $data['user'] = $user;
                    $data['otp'] = $pin;
                    $data['user_id'] = $user['id'];
                } else {
                    $arr = ['phone' => $phone, 'token' => $otp];
                    $user_id = $this->user->insert($arr);
                    $data['status'] = "SUCCESS";
                    $data['message'] = "Phone number not found!";
                    $data['user_code'] = "NEW";
                    $data['otp'] = $otp;
                    $data['user_id'] = $user_id;
                    $key = "e2fezUjQdMCo6VZa";	
						$mbl = "+91" . $phone;
						$message_content=urlencode("Hello User, To update account you can use this one-time OTP: $otp ADCOLC");
						$templateid = "1307170374449021046";
						$senderid="ADCOLC";	$route= 1;
						$url = "http://www.text2india.store/vb/apikey.php?apikey=$key&templateid=$templateid&senderid=$senderid&number=$mbl&message=$message_content";
											
						$output = file_get_contents($url);
                }
            } else {
                $data['status'] = "SUCCESS";
                $data['message'] = "Phone number is required!";
            }
        } else {
            http_response_code(401);
            $data['status'] = "SUCCESS";
            $data['message'] = "Required parameter is missing!";
        }
        echo json_encode($data);
    }
    public function getUserLoggedin($value = '') {
        $json = json_decode(file_get_contents('php://input'));
        if ($json != null && $json->enteredOtp && $json->userId) {
            $otp = $json->enteredOtp;
            $user_id = $json->userId;
            $user = $this->auth->checkOtpUser($user_id, $otp);
            if ($user) {
                if (!empty($user['profile_img']) && file_exists('assets/images/' . $user['profile_img'])) {
                    $user['profile_img'] = base_url('assets/images/' . $user['profile_img']);
                } else {
                    $user['profile_img'] = NULL;
                }
                $data['status'] = "SUCCESS";
                $data['message'] = "User found!";
                $data['user'] = $user;
            } else {
                http_response_code(401);
                $data['status'] = "ERROR";
                $data['message'] = "User not found!";
                $data['user'] = [];
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
