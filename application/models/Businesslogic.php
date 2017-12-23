<?php

class BusinessLogic extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->model('themoviedb');
    $this->load->model('tmdbmovie_model', 'movies');
    $this->load->model('Movielist_model', 'list');
    $this->load->model('Update_model', 'update');
    $this->load->model('genre_model', 'genre');
  }

  public function getMovies($language, $categoryId, $page, $onPage, $sort){
    if ($page < 0){
      return null;
    }

    if (!is_numeric($categoryId)){
      $categoryId = null;
    }

    if (strtolower($language) != 'pl'){
      return json_decode($this->themoviedb->getMovies($language, $categoryId, $page));
    }

    ini_set('max_execution_time', 0);

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
  public function getCategoryList($language){
    if (strtolower($language) != 'pl'){
      return json_decode($this->themoviedb->getCategoryList($language));
    }
    $genres = $this->genre->get();
    if (count($genres) == 0){
      $this->update->updateGenres();
      $genres = $this->genre->get();
    }
    return $genres;
  }
  public function getMovieDetails($language, $id){
    if (strtolower($language) != 'pl'){
      $this->themoviedb->getMovieDetails($language, $id);
    } else {
    $movie = new Tmdbmovie_model($id);
      if ($movie->id == NULL){
        $this->update->updateTmdbMovie($id);
        return new Tmdbmovie_model($id);
      } else {
        return $movie;
      }
    }
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
  public function getCinemaRepertoire(){
    $this->load->model('multikino');
    $repertoire = $this->multikino->getCinemaRepertoire();
    $this->update->updateCinemaRepertoire($repertoire['movies']);
    return $repertoire;
  }
  public function getCinemas(){
    $this->load->model('Cinemas_model', 'cinemas');
    $result = $this->cinemas->getCinemas();
    if (count( $result ) == 0){
      $this->load->model('Cinemas_geocode_model', 'geo');
      $this->geo->insertDataToDataBase();
      $result = $this->cinemas->getCinemas();
    }
    return $result;
  }
}

?>
