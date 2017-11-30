<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent :: __construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library("jwt");
    }

	public function index() {
		$this->load->view('login');
	}
  private function generateToken($user_id){
      $CONSUMER_KEY = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
      $CONSUMER_SECRET = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
      $CONSUMER_TTL = 86400;
      return $this->jwt->encode(array(
        'consumerKey'=>$CONSUMER_KEY,
        'userId'=>$user_id,
        'issuedAt'=>date(DATE_ISO8601, strtotime("now")),
        'ttl'=>$CONSUMER_TTL
      ), $CONSUMER_SECRET);
  }
	public function login() {
		$email = $this->input->post('login');
		$password = $this->input->post('password');

		if($this->user_model->checkLoginAndPassword($email,$password)) {
      		$status = array('token' => $this->generateToken($this->user_model->getUserId($email)),
                      'status' => $this->user_model->getUserNick($email));
		}
		else {
            $status = array('status' => 'notExist');
		}
		header('Content-Type: application/json');
		echo json_encode($status);
	}

	public function register() {
		$this->user_model->setEmail($this->input->post('login'));
		$this->user_model->setNick($this->input->post('nick'));
		$this->user_model->setPassword($this->input->post('password'));
		$checkUnique = $this->user_model->checkUniqueLoginAndNick();
		if($checkUnique != null) {
			if($checkUnique == $this->user_model->getLogin()) {
				$status = 'Email not unique';
			} else {
				$status = 'Nick not unique';
			}
		}
		else {
			$this->user_model->save();
			$status = "notExist";
		}
		header('Content-Type: application/json');
		echo json_encode($status);
	}
}
?>
