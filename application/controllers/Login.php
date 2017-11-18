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
        $user = new User_model();
        $user->setLogin($this->input->post('login'));
        $user->setPassword($this->input->post('password'));
        $status="";
        $user->checkLoginAndPassword();
        if(!empty($user)) {
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
        $user = new User_model();
        $user->setLogin($this->input->post('login'));
        $user->setNick('nick');
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
        }
    }
}
?>
