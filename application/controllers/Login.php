<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct(){
    parent :: __construct();
    $this->load->helper('url');
  }

	public function index()
	{
		$this->load->view('login');
	}

  public function login(){
    $login = $_POST['login'];
    $password = $_POST['password'];
    $status="";
  
   
    $this->db->where('Login',$login);
    $this->db->where('Password',$password);
    $user = $this->db->get('users')->result();
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
    $password = $_POST['password'];

  }
}
?>