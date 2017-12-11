<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Update extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('update_model');
  }
  public function updateMoviesTable(){
    $this->update_model->fullUpdateTmdbMovies();
  }
  public function updateGenres(){
    $this->update_model->updateGenres();
  }
}
?>
