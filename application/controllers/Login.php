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
    echo "Logowanie";
    echo "<br>";
    $login = $_POST['login'];
    $password = $_POST['password'];
    echo $login;
    echo "<br>";
    echo $password;
  }

  public function register(){
    echo "Rejestracja";
    echo "<br>";
    $login = $_POST['login'];
    $password = $_POST['password'];
    echo $login;
    echo "<br>";
    echo $password;
  }
}
?>
