<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Home extends CI_Controller {
    /**
     * Konstruktor ładuje potrzebne modele oraz biblioteki
     * @method __construct
     */
    public function __construct(){
        parent :: __construct();
        $this->load->model('multikino');
        $this->load->model('themoviedb');
        $this->load->helper('url');
        $this->load->model('BusinessLogic', 'logic');
    }

    public function initGeoCodeTable(){
      $this->load->model('Cinemas_geocode_model', 'geo');
      $this->geo->insertDataToDataBase();
    }

    /**
     * Strona główna kontrolera
     * Wyświetla plik view/home.php
     * @method index
     */
    public function index()
    {
        redirect(base_url('/index.html'));
    }

    /**
     * Przykład użycia: http://localhost/index.php/Home/getCinemaRepertoire/3
     * @method getCinemaRepertoire
     * @param int $id id kina sieci multikino.
     * @return string Zwraca repertuar dla Multikina w formacie JSON
     */
    public function getCinemaRepertoire($id){
        echo $this->multikino->getCinemaRepertoire($id);
    }

    /**
     * Przykład użycia: http://localhost/index.php/Home/getCategoryList/PL
     * @method getCategoryList
     * @param string $language język
     * @return string zwraca listę kategorii w formacie JSON.
     */
    public function getCategoryList($language){
        echo $this->themoviedb->getCategoryList($language);
    }

    /**
     * Pobiera filmy
     * Przykład użycia: http://localhost/index.php/Home/getMovies/PL/35/1/release_date.asc/2017,
     *                  http://localhost/index.php/Home/getMovies
     *
     * Dozwolone wartości dla parametru sortowania:
     * popularity.asc, popularity.desc, release_date.asc,
     * release_date.desc, revenue.asc, revenue.desc,
     * primary_release_date.asc, primary_release_date.desc,
     * original_title.asc, original_title.desc, vote_average.asc,
     * vote_average.desc, vote_count.asc, vote_count.desc
     * Domyślnie - popularity.desc
     *
     * @method getMovies
     * @param string $language język
     * @param int $categoryId	id kategorii filmów
     * @param int $page	numer strony
     * @param int $onPage liczba filmów na stronie
     * @return string zwraca listę filmów w formacie JSON.
     */
    public function getMovies($language = '', $categoryId = '', $page = '', $onPage = '') {
        header('Content-Type: application/json');
        $result = array('results' => $this->logic->getMovies($language, $categoryId, $page, $onPage));
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    /**
     * Szczegółowe informacje o filmie
     * Przykład użycia: http://localhost/index.php/Home/getMovieDetails/PL/290512
     * @method
     * @param string $language język
     * @param int $id	id filmu
     * @return string zwraca informacje o filmie w formacie JSON.
     */
    public function getMovieDetails($language, $id){
        header('Content-Type: application/json');
        echo $this->themoviedb->getMovieDetails($language, $id);
    }

    /**
     * Plakat filmu
     * Przykład użycia: http://localhost/index.php/Home/getMoviePoster/PL/290512
     * @method getMoviePoster
     * @param string $language język
     * @param int $id	id filmu
     * @return string zwraca ścieżkę do plakatu danego filmu.
     */
    public function getMoviePoster($language, $id){
        header('Content-Type: application/json');
        echo $this->themoviedb->getMoviePosterPath($language, $id);
    }

    /**
     * Słowa kluczowe
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getKeywords/PL/550
     * @link https://developers.themoviedb.org/3/movies/get-movie-keywords
     * @method getKeywords
     * @param string $language język
     * @param int $id id filmu
     * @return string zwraca słowa kluczowe w formacie JSON
     */
    public function getKeywords($language, $id){
      header('Content-Type: application/json');
      echo $this->themoviedb->getKeywords($language, $id);
    }

    /**
     * Ostatnie filmy
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getLatest/PL/1
     * @link https://developers.themoviedb.org/3/movies/get-latest-movie
     * @method getLatest
     * @param string $language język
     * @param int $page numer strony
     * @return string zwraca dane w formacie JSON
     */
    public function getLatest($language, $page){
      header('Content-Type: application/json');
      echo $this->themoviedb->getLatest($language, $page);
    }

    /**
     * Aktualnie grane filmy w kinach
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getNowPlaying/1/PL
     * Kod dla Polski PL
     * $region = XX - obojętnie gdzie grany film
     * @link https://pl.wikipedia.org/wiki/ISO_3166-1 Kody regionów
     * @link https://developers.themoviedb.org/3/movies/get-now-playing
     * @method getNowPlaying
     * @param int $page numer strony
     * @param string $region kod regionu - w formacie xx
     * @return string zwraca dane w formacie JSON
     */
    public function getNowPlaying($page, $region){
      header('Content-Type: application/json');
      echo $this->themoviedb->getNowPlaying($region, $page, $region);
    }

    /**
     * Popularne filmy
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getPopular/1/PL
     * @link https://developers.themoviedb.org/3/movies/get-popular-movies
     * @link https://pl.wikipedia.org/wiki/ISO_3166-1 Kody regionów
     * @method getPopular
     * @param int $page numer strony
     * @param int $region kod regionu
     * @return string zwraca dane w formacie JSON
     */
    public function getPopular($page, $region){
      header('Content-Type: application/json');
      echo $this->themoviedb->getPopular($region, $page, $region);
    }

    /**
     * Najwyżej oceniane
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getTopRated/1/PL
     * @link https://developers.themoviedb.org/3/movies/get-top-rated-movies
     * @link https://pl.wikipedia.org/wiki/ISO_3166-1 Kody regionów
     * @method getTopRated
     * @param int $page numer strony
     * @param int $region kod regionu
     * @return string             zwraca dane w formacie JSON
     */
    public function getTopRated($page, $region){
      header('Content-Type: application/json');
      echo $this->themoviedb->getTopRated($region, $page, $region);
    }

    /**
     * Filmy, które nadchodzą
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getUpcoming/1/PL
     * @link https://developers.themoviedb.org/3/movies/get-upcoming
     * @link https://pl.wikipedia.org/wiki/ISO_3166-1 Kody regionów
     * @method getUpcoming
     * @param int $page numer strony
     * @param int $region kod regionu
     * @return string zwraca dane w formacie JSON
     */
    public function getUpcoming($page, $region){
      header('Content-Type: application/json');
      echo $this->themoviedb->getUpcoming($region, $page, $region);
    }

    /**
     * Pobiera trailer do filmu.
     * Jeżeli nie ma traileru w podanym języku
     * to pobierany jest trailer w dowolnym innym języku.
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getTrailerPath/PL/383709
     * @link https://developers.themoviedb.org/3/movies/get-movie-videos
     * @method getTrailerPath
     * @param string $language język
     * @param int $id id filmu
     * @return string zwraca dane w formacie JSON
     */
    public function getTrailerPath($language, $id){
      header('Content-Type: application/json');
      echo $this->themoviedb->getTrailerPath($language, $id);
    }

    /**
     * Obsada i ekipa filmu
     * Przykład użycia: http://localhost/Cinema/index.php/Home/getCredits/550
     * @link https://developers.themoviedb.org/3/movies/get-movie-credits
     * @method getCredits
     * @param int $id id filmu
     * @return string zwraca dane w formacie JSON
     */
    public function getCredits($id){
      header('Content-Type: application/json');
      echo $this->themoviedb->getCredits($id);
    }

    public function getCinemasLocalization(){
      $this->load->model('Cinemas_model', 'cinemas');
      header('Content-Type: application/json');
      echo json_encode( array( 'result' => $this->cinemas->getCinemas()));
    }
}
?>
