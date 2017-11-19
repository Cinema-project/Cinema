<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent :: __construct();
        $this->load->helper('url');
        $this->load->model('user_model');
    }

	public function index() {
		$this->load->view('login');
	}

	public function login() {
		$login = $this->input->post('login');
		$password = $this->input->post('password');

		if($this->user_model->checkLoginAndPassword($login,$password)) {
			$status="exist";
		}
		else {
			$status="notExist";
		}
		header('Content-Type: application/json');
		echo json_encode($status);
	}

	public function register() {
		$this->user_model->setLogin($this->input->post('login'));
		$this->user_model->setNick($this->input->post('nick'));
		$this->user_model->setPassword($this->input->post('password'));
		$checkUnique = $this->user_model->checkUniqueLoginAndNick();
		if($checkUnique != null) {
			if($checkUnique == $this->user_model->getLogin()) {
				$status = 'Login not unigue';
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
