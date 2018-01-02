<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Update_model extends CI_Model {
    public function __construct(){
      parent::__construct();
      $this->load->model('themoviedb');
      $this->load->model('genre_model');
      $this->load->model('tmdbmovie_model');
      $this->load->model('config_model', 'c');
    }
    /**
     * Dodaje kategorię do filmu
     * @method addGenresToMovie
     * @param array $genres kategorie filmu
     * @param int $movie id filmu
     */
    private function addGenresToMovie($genres, $movie){
      foreach ($genres as $genre) {
        $this->tmdbmovie_model->insertToGenresMovies($genre->id, $movie);
      }
    }
    /**
     * Dodaje film z TMDB do bazy lokalnej
     * @method updateTmdbMovie
     * @param int $id id filmu
     * @return bool czy update filmu się udał
     */
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
    /**
     * Pibiera listę kategorii z TMDB i wstawia je do bazy lokalnej
     * @method updateGenres
     */
    public function updateGenres(){
      if ( $this->c->checkIfExist('GENRES_UPDATE', date('Y-m-d H:i:s')) ){
        return 'Genres are up to date';
      }

      $genres = json_decode($this->themoviedb->getCategoryList('PL'))->genres;
      foreach ($genres as $genre) {
        $this->genre_model->setId($genre->id);
        $this->genre_model->setName($genre->name);
        $this->genre_model->save();
      }
    }
    /**
     * Porównuje filmy z Multikina i TMDB
     * @method compareMovies
     * @param array $multi film z multikina
     * @param  object $tmdb film z tmdb
     * @return bool true jeśli filmy sobie odpowiadają w przeciwnym wypadku false
     */
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
    /**
     * Odszukuje film z TMDB odpowiadający filmowi z Multikina
     * @method findMovie
     * @param array $movie dane filmu z Multikina
     * @param  array $tmdb tablica obiektów filmów z TMDB
     * @return object zwraca film z TMDB odpowiadający filmowi z Multikina podanego w parametrze $multi
     */
    private function findMovie($movie, $tmdb){
      foreach ($tmdb as $tmdbMovie) {
        if ( $this->compareMovies($movie, $tmdbMovie) ) {
          return $tmdbMovie->MovieID;
        }
      }
      return NULL;
    }
    /**
     * Sprawdza czy film istnieje w bazie danych
     * @method isInDb
     * @param int  $id id filmu
     * @param  array $db filmy z bazy danych
     * @return boolean true jeśli film istnieje w bazie false w przeciwnym wypadku
     */
    public function isInDb($id, $db){
      foreach ($db as $row) {
        if ( $row->movie_id == $id ){
          return true;
        }
      }
      return false;
    }
    /**
     * Wyszukuje filmy w bazie TMDB i łączy je z filmami z Multikina
     * @method mergeMultikinoTmdbMovies
     * @param array $movies filmy z Multikina
     * @return array[] zwraca filmy pominięte, zaktualizowane, i nie znalezione w bazie TMDB
     */
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
    /**
     * Aktualizuje tabelę cinemamovies
     * @method updateCinemaMovies
     * @return array[] zwraca filmy pominięte, zaktualizowane, i nie znalezione w bazie TMDB
     */
    public function updateCinemaMovies(){
      ini_set('max_execution_time', 0);
      $this->load->model('multikino');
      $movies = $this->multikino->getCinemaFilms();

      if ($this->c->checkIfUpdate('CINEMA_MOVIES_UPDATE', $movies['created'])){
        return 'Movies are up to date';
      }

      return $this->mergeMultikinoTmdbMovies($movies['movies']);
    }
    /**
     * Aktualizuje repertuar dla kin. Skrypt może trwać do 5 minut.
     * @method updateCinemaRepertoire
     * @param  array $repertoire tablica wydarzeń
     */
    public function updateCinemaRepertoire($repertoire){
      if ($this->c->checkIfUpdate('CINEMA_REPERTOIRE_UPDATE', $repertoire['created'])){
        $this->event->removeOldEvent();
        return 'Repertoire is up to date';
      }

      ini_set('max_execution_time', 0);

      $this->load->model('event_model', 'event');
      $this->db->truncate('events');

      foreach ($repertoire['movies'] as $event) {
        $this->event->setTime($event['time']);
        $this->event->setIdMovie($event['movieId']);
        $this->event->setIdCinema($event['cinemaId']);
        $this->event->setLink($event['link']);
        $this->event->save();
      }
    }
    /**
     * Inicjalizuje tabelę cinemas jeżeli jest pusta
     * @method initGeoCodeTable
     */
    public function initGeoCodeTable(){
      if ( $this->c->checkIfExist('GEO_CODE', date('Y-m-d H:i:s')) ){
        return 'Geo codes are up to date';
      }

      $this->load->model('Cinemas_geocode_model', 'geo');
      $this->geo->insertDataToDataBase();
    }
}
?>
