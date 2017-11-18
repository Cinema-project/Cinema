<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->helper('url');
		$this->load->model('User_model');
	}

	public function index() {
		$this->load->view('login');
	}

	public function login() {
		$login = $this->input->post('login');
		$password = $this->input->post('password');

		if($this->User_model->checkLoginAndPassword($login,$password)) {
			$status="exist";
		}
		else {
			$status="notExist";
		}
		header('Content-Type: application/json');
		echo json_encode($status);
	}

	public function register() {
		$user = new User_model();
		$user->setLogin($this->input->post('login'));
		$user->setNick('nock');
		$user->setPassword($this->input->post('password'));
		$checkUnique = $user->checkUniqueLoginAndNick();
		if($checkUnique != null) {
			if($checkUnique == $user->getLogin()) {
				$status = 'Login not unigue';
			} else {
				$status = 'Nick not unique';
			}
		}
		else {
			$user->save();
			$status = "notexist";
		}
		header('Content-Type: application/json');
		echo json_encode($status);

	}
}
?>
