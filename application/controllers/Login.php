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
        $this->user_model->setLogin($this->input->post('login'));
        $this->user_model->setPassword($this->input->post('password'));
        $status="";
        $this->user_model->checkLoginAndPassword();
        if(!empty($this->user_model)) {
            $status="exist";
            header('Content-Type: application/json');
            echo json_encode($status);
        }
        else {
            $status="notExist";
            header('Content-Type: application/json');
            echo json_encode($status);
        }
    }

    public function register() {
        echo "Rejestracja";
        echo "<br>";
        $this->user_model->setLogin($this->input->post('login'));
        $this->user_model->setNick('nick');
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
        }
    }
}
?>
