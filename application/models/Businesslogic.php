<?php
/**
 * BusinessLogic - logika aplikacji
 */
class BusinessLogic extends CI_Model{
  /**
   * Ładowanie potrzebnych modeli
   * @method __construct
   */
  public function __construct(){
    parent::__construct();
    $this->load->model('themoviedb');
    $this->load->model('tmdbmovie_model', 'movies');
    $this->load->model('Movielist_model', 'list');
    $this->load->model('Update_model', 'update');
    $this->load->model('genre_model', 'genre');
  }
  /**
   * Pobiera listę filmów z bazy lokalnej a w razie potrzeby odwołuje się do bazy TMDB
   * @method getMovies
   * @param  string $language język danych
   * @param  int $categoryId id kategorii
   * @param  int $page strona
   * @param  int $onPage ile filmów ma być na stronie
   * @param  string $sort sortowanie po kolumnie
   * @return array tablica filmów
   */
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

    $this->list->selectMovies($categoryId, $page, $onPage, $sort);
    $list = $this->list->getMovieList();

    $currentPage = $page;
    while (count($list) < $onPage){
      $insert = $this->themoviedb->getMovies($language, $categoryId, $currentPage);
      $insert = json_decode($insert);

      foreach ($insert->results as $movie) {
        $this->update->updateTmdbMovie($movie->id);
      }

      $this->list->selectMovies($categoryId, $page, $onPage, $sort);
      $list = $this->list->getMovieList();

      $currentPage--;
      if ($currentPage <= 0){
        break;
      }
    }

    return $list;
  }
  /**
   * Pobiera listę kategorii z bazy.
   * W razie potrzeby aktualizuje bazę.
   * @method getCategoryList
   * @param  string $language tłumaczenie kategorii
   * @return array tablica kategorii
   */
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
  /**
   * Odpytuje bazę i zwraca film o podanym id.
   * Jeżeli nie ma go w bazie odpytuje bazę TMDB i zpapisuje go w bazie lokalnej a następnie zwraca.
   * @method getMovieDetails
   * @param  string $language język danych
   * @param  int $id id filmu
   * @return array Film
   */
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
  public function getLastest($language, $page, $onPage){
    return $this->getMovies($language, 'xx', $page, $onPage, 'Premiere_date DESC');
  }
  public function getNowPlaying($count, $page){
    $this->load->model('Event_model', 'events');
    return $this->events->getNowPlaying($count, $page);
  }
  public function getPopular($page, $region){
  }
  public function getTopRated($page, $region){
  }
  public function getUpcoming($page, $region){
  }
  /**
   * Aktualizuje i zwraca repertuar kin
   * @method getCinemaRepertoire
   * @return array
   */
  public function getCinemaRepertoire(){
    $this->load->model('multikino');
    $repertoire = $this->multikino->getCinemaRepertoire();
    $this->update->updateCinemaRepertoire($repertoire['movies']);
    return $repertoire;
  }
  /**
   * Zwraca listę kin a w razie potrzeby dodaje je do bazy.
   * @method getCinemas
   * @return array
   */
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
