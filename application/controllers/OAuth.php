<?php

  class OAuth extends CI_Controller {
    public function __construct(){
      parent::__construct();
      $this->load->model('Oauth_model', 'oauth');
    }


    public function login(){
      $this->oauth->login();
    }

    public function fb_callback() {
      $this->oauth->callback();
    }
  }

?>
