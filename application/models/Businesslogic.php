<?php

class BusinessLogic extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->model('themoviedb');
    $this->load->model('tmdbmovie_model', 'movies');
    $this->load->model('Movielist_model', 'list');
    $this->load->model('Update_model', 'update');
  }

  public function getMovies($language, $categoryId, $page, $onPage){
    if ($page < 0){
      return null;
    }

    if (!is_numeric($categoryId)){
      $categoryId = null;
    }

    if (strtolower($language) != 'pl'){
      return json_decode($this->themoviedb->getMovies($language, $categoryId, $page));
    }

    ini_set('max_execution_time', 300);

    $this->list->selectMovies($categoryId, $page, $onPage);
    $list = $this->list->getMovieList();
  
    $currentPage = $page;
    while (count($list) < $onPage){
      $insert = $this->themoviedb->getMovies($language, $categoryId, $currentPage);
      $insert = json_decode($insert);

      foreach ($insert->results as $movie) {
        $this->update->updateTmdbMovie($movie->id);
      }

      $this->list->selectMovies($categoryId, $page, $onPage);
      $list = $this->list->getMovieList();

      $currentPage--;
      if ($currentPage <= 0){
        break;
      }
    }

    return $list;
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
