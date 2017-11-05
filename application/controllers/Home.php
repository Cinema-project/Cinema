<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent :: __construct();
		$this->load->model('multikino');
    $this->load->helper('url');
  }

	public function index()
	{
		$data['multikino'] = $this->multikino->getCinemaRepertoire(3);
		$this->load->view('home', $data);
	}
}

?>
