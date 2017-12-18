<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Update_model extends CI_Model {
    public function __construct(){
      parent::__construct();
      $this->load->model('themoviedb');
      $this->load->model('genre_model');
      $this->load->model('tmdbmovie_model');
    }

    private function addGenresToMovie($genres, $movie){
      foreach ($genres as $genre) {
        $this->tmdbmovie_model->insertToGenresMovies($genre->id, $movie);
      }
    }

    public function updateTmdbMovie($id){
      if ( $this->tmdbmovie_model->exist($id) == true ){
        return;
      }
      $details = $this->themoviedb->getMovieDetails('PL', $id);
      $details = json_decode($details);
      $genres = $details->genres;
      $overview = $details->overview;
      $poster = $details->poster_path;
      if ($poster != ''){
        $poster = 'http://image.tmdb.org/t/p/w500' . $poster;
      } else {
        $poster = NULL;
      }
      $title = $details->title;
      $vote = $details->vote_average;
      $premiere = $details->release_date;
      $trailer = $this->themoviedb->getTrailerPath('Pl', $id);
      $popularity = $details->popularity;

      $this->tmdbmovie_model->set($id, $title, $overview, $popularity, $poster, $trailer, $vote, $premiere);
      $this->tmdbmovie_model->save();
      $this->addGenresToMovie($genres, $id);
    }

    public function fullUpdateTmdbMovies(){
      set_time_limit(0);
      $day = 10;//date('d');
      $month = 12;//date('m');
      $year = 2017;//date('Y');
      $fileName = './file/movie_ids_'.$month.'_'.$day.'_'.$year.'.json';
      $str = file_get_contents($fileName);
      $records = json_decode($str, true);

      $ask = 20;
      $movies = 1000;
      foreach ($records as $record) {
        $id = $record['id'];
        $this->updateTmdbMovie($id);
        $ask--;
        if ( $ask == 0 ){
          $ask = 20;
          sleep(1);
        }
        $movies--;
        if ($movies == 0){
          return;
        }
      }
    }

    public function updateGenres(){
      $genres = json_decode($this->themoviedb->getCategoryList('PL'))->genres;
      foreach ($genres as $genre) {
        $this->genre_model->setId($genre->id);
        $this->genre_model->setName($genre->name);
        $this->genre_model->save();
      }
    }
}
?>
