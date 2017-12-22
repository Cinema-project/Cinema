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
        return false;
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
      $runtime = $details->runtime;

      $this->tmdbmovie_model->set($id, $title, $overview, $popularity, $poster, $trailer, $vote, $premiere, $runtime);
      $this->tmdbmovie_model->save();
      $this->addGenresToMovie($genres, $id);
      return true;
    }

    public function updateGenres(){
      $genres = json_decode($this->themoviedb->getCategoryList('PL'))->genres;
      foreach ($genres as $genre) {
        $this->genre_model->setId($genre->id);
        $this->genre_model->setName($genre->name);
        $this->genre_model->save();
      }
    }

    private function compareMovies($multi, $tmdb){
      $res = false;

      if ($multi['title'] == $tmdb->Title){
        $res = true;
        /*if ($multi['runtime'] != NULL && $multi['runtime'] != '' && $tmdb->runtime != NULL ){
          if ( $multi['runtime'] != $tmdb->runtime ){
            $res = false;
          }
        }*/
        if ( $multi['premierDate'] != "" && $multi['premierDate'] != NULL && $tmdb->Premiere_date != NULL ){
          if ( date("Y", strtotime($multi['premierDate'])) != date("Y", strtotime($tmdb->Premiere_date)) ){
            $res = false;
          }
        }
      }
      return $res;
    }

    private function findMovie($movie, $tmdb){
      foreach ($tmdb as $tmdbMovie) {
        if ( $this->compareMovies($movie, $tmdbMovie) ) {
          return $tmdbMovie->MovieID;
        }
      }
      return NULL;
    }

    public function isInDb($id, $db){
      foreach ($db as $row) {
        if ( $row->movie_id == $id ){
          return true;
        }
      }
      return false;
    }

    private function mergeMultikinoTmdbMovies($movies){
      $this->load->model('Cinemasmovie_model', 'movie');
      $inDb = $this->movie->getAll();
      $result = array();
      $result['notFound'] = array();
      $result['updated'] = array();
      $result['skipped'] = array();
      foreach ($movies as $movie) {
        if ($this->isInDb($movie['id'], $inDb)){
          $result['skipped'][] = array('title' => $movie['title'], 'id' => $movie['id'] );
          continue;
        }
        $tmdb = $this->tmdbmovie_model->getByTitle($movie['title']);
        $tmdbId = NULL;
        if (count($tmdb) != 0){
            $tmdbId = $this->findMovie($movie, $tmdb);
        }

        if ($tmdbId == NULL){
          $year = $movie['premierDate'];
          $year = $year == '' ? NULL : date("Y", strtotime($year));
          $tmdb = $this->themoviedb->searchMovie($movie['title'], 'pl', $year);
          foreach ($tmdb as $mTmdb) {
            $this->updateTmdbMovie($mTmdb->id);
          }
          $tmdb = $this->tmdbmovie_model->getByTitle($movie['title']);
          $tmdbId = $this->findMovie($movie, $tmdb);
        }

        if ($tmdbId != NULL){
          $this->movie->setMovieId($movie['id']);
          $this->movie->setTitle($movie['title']);
          $this->movie->setTmdbmovieId($tmdbId);
          $this->movie->save();
          $result['updated'][] = array('title' => $movie['title'], 'id' => $movie['id'] );
        } else {
          $result['notFound'][] = array('title' => $movie['title'], 'id' => $movie['id'] );
        }
      }
      return $result;
    }

    public function updateCinemaMovies(){
      ini_set('max_execution_time', 0);
      $this->load->model('multikino');
      $movies = $this->multikino->getCinemaFilms();
      //Sprawdzenie ostatniej aktualizacji z tabelą config $movies['created'];
      return $this->mergeMultikinoTmdbMovies($movies['movies']);
    }

    public function updateCinemaRepertoire($repertoire){
      $this->load->model('event_model', 'event');
      ini_set('max_execution_time', 300);
      foreach ($repertoire as $event) {
        $this->event->setTime($event['time']);
        $this->event->setIdMovie($event['movieId']);
        $this->event->setIdCinema($event['cinemaId']);
        $this->event->save();
      }
    }
}
?>
