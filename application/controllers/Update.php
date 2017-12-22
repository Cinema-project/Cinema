<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Update extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('update_model');
  }
  public function updateGenres(){
    $this->update_model->updateGenres();
  }
  public function updateCinemaMovies(){
    echo json_encode($this->update_model->updateCinemaMovies(), JSON_PRETTY_PRINT);
  }
  public function updateCinemaRepertoire(){
    $this->load->model('multikino');
    $repertoire = $this->multikino->getCinemaRepertoire();
    $this->update_model->updateCinemaRepertoire($repertoire['movies']);
  }
}
?>
