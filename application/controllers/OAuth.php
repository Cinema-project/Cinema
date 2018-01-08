<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
  /**
   * OAuth
   * Kontroler logowania przez serwis Facebook
   */
  class OAuth extends CI_Controller {
    public function __construct(){
      parent::__construct();
      $this->load->model('Oauth_model', 'oauth');
    }

    /**
     * Przekierowuje do logowania na facebook'u a stamtąd do funkcji fb_callback
     * Przykład użycia: localhost/Cinema/index.php?/OAuth/login
     * @method login
     */
    public function login(){
      $this->oauth->login();
    }
    /**
     * Loguje do aplikacji dzięki tokenowi z facebooka oraz id użytkownika
     * @method fb_callback
     * @return string zwraca token i nick użytkownika
     */
    public function fb_callback() {
      header('Content-Type: application/json');
  		echo json_encode($this->oauth->callback());
    }
  }

?>
