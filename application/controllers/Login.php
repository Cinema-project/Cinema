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
    $login = $_POST['login'];
    $password = $_POST['password'];
    $status="";
    $user = new User_model();
    $user->checkLoginAndPassword($login,$password);
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

  public function register(){
    echo "Rejestracja";
    echo "<br>";
    $login = $_POST['login'];
    $nick = 'nick';
    $password = $_POST['password'];
    $user = new User_model();
    $checkUnique = $user->checkUniqueLoginAndNick($login,$nick);
    if($checkUnique != null)
    {
      if($checkUnique == $login) $status = 'Login not unigue';
      else $status = 'Nick not unique';
    }
    else
    {
      $user->addUser($login, $nick, $password);
    }
  }
}
?>
