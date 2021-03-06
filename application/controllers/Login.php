<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
/**
 * Login
 * Kontroler logowania
 */
class Login extends CI_Controller {

    /**
     * @method __construct
     */
    public function __construct() {
        parent :: __construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model("token");
    }
  /**
   * @method login
   * @return string token i nazwa użytkownika. Format JSON.
   */
	public function login() {
		$email = $this->input->post('login');
		$password = $this->input->post('password');

		if($this->user_model->checkLoginAndPassword($email,$password)) {
      		$status = array('token' => $this->token->generateToken($this->user_model->getUserId($email)),
                      'status' => $this->user_model->getUserNick($email));
		}
		else {
            $status = array('status' => 'notExist');
		}
		header('Content-Type: application/json');
		echo json_encode($status);
	}
  /**
   * @method register
   * @return string powodzenie lub rodzaj błędu. Format JSON.
   */
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
