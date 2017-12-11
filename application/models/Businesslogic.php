<?php

class BusinessLogic extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->model('themoviedb');
    $this->load->model('tmdbmovie_model', 'movies');
  }

  public function getMovies($categoryId, $page, $sort, $year){
  }
  public function getCategoryList(){
  }
  public function getMovieDetails($id){
  }
  public function getLastest(){
  }
  public function getNowPlaying($page, $region){
  }
  public function getPopular($page, $region){
  }
  public function getTopRated($page, $region){
  }
  public function getUpcoming($page, $region){

  }
}

?>
