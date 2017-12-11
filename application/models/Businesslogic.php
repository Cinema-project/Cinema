<?php

class BusinessLogic extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->model('themoviedb');
    $this->load->model('tmdbmovie_model', 'movies');
  }
  public function getMovies($categoryId, $page, $sort, $year){
    
  }
}

?>
