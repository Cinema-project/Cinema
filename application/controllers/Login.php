<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct(){
        parent :: __construct();
        $this->load->helper('url');
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function login(){
        echo "Logowanie";
        echo "<br>";
        $login = $_POST['login'];
        $password = $_POST['password'];
        $user = new User_model();
        $user->checkLoginAndPassword($login, $password);
        if($user->getId() != null) {
            echo "Witamy ".$user->getNick()." na naszej stronie!";
        }
        else {
            echo "Przykro nam ale nie mamy Cię jeszcze w naszej bazie \n";
            echo "Może chcesz dołączyć?";
        }
    }

    public function register(){
        echo "Rejestracja";
        echo "<br>";
        $login = $_POST['login'];
        $password = $_POST['password'];

    }
}
?>
