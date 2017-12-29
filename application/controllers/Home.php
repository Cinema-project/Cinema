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
     * Przykład użycia: http://localhost/index.php/Home/getCategoryList/PL
     * @method getCategoryList
     * @param string $language język
     * @return string zwraca listę kategorii w formacie JSON.
     */
    public function getCategoryList($language = 'PL'){
      header('Content-Type: application/json');
      echo json_encode($this->logic->getCategoryList($language));
    }

    /**
     * Pobiera filmy
     * Przykład użycia: http://localhost/index.php/Home/getMovies/PL/35/1/20/Premier_date.DESC,
     *                  http://localhost/index.php/Home/getMovies
     *
     * Dozwolone wartości dla parametru sortowania:
     * Title.DESC, Title.ASC, Popularity.DESC, Popularity.ASC,
     * vote_average.DESC, vote_average.ASC, Premiere_date.DESC,
     * Premiere_date.ASC, runtime.DESC, runtime.ASC
     * Domyślnie - Premiere_date.DESC
     * DESC - malejąco
     * ASC - rosnąco
     *
     * @method getMovies
     * @param string $language język
     * @param int $categoryId	id kategorii filmów
     * @param int $page	numer strony
     * @param int $onPage liczba filmów na stronie
     * @param string $sort sortowanie po kolumnie w bazie danych. ASC - rosnąco, DESC malejąco
     * @return string zwraca listę filmów w formacie JSON.
     */
    public function getMovies($language = 'PL', $categoryId = 'xx', $page = '0', $onPage = '20', $sort = 'Premiere_date.DESC') {
        $sort = str_replace('.', ' ', $sort);
        header('Content-Type: application/json');
        $result = array('results' => $this->logic->getMovies($language, $categoryId, $page, $onPage, $sort));
        echo json_encode($result);
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
        echo json_encode($this->logic->getMovieDetails($language, $id));
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
     * @param int $onPage na stronie
     * @return string zwraca dane w formacie JSON
     */
    public function getLastest($language = 'PL', $page = 0, $onPage = 10){
      header('Content-Type: application/json');
      echo json_encode(array( 'movies' => $this->logic->getLastest($language, $page, $onPage)));
    }

    /**
     * Aktualnie grane filmy w kinach
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getNowPlaying/20/1
     * @method getNowPlaying
     * @param int $count liczba filmów na stronie
     * @param int $page numer strony
     * @return string zwraca dane w formacie JSON
     */
    public function getNowPlaying($count = 20, $page = 0){
      header('Content-Type: application/json');
      echo json_encode(array( 'movies' => $this->logic->getNowPlaying($count, $page)));
    }

    /**
     * Popularne filmy
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getPopular/PL/20/1
     * @link https://developers.themoviedb.org/3/movies/get-popular-movies
     * @link https://pl.wikipedia.org/wiki/ISO_3166-1 Kody regionów
     * @method getPopular
     * @param string $language język
     * @param int $count liczba filmów na stronie
     * @param int $page numer strony
     * @return string zwraca dane w formacie JSON
     */
    public function getPopular($language = 'PL', $count = 20, $page = 0){
      header('Content-Type: application/json');
      echo json_encode(array('movies' => $this->logic->getPopular($language, $count, $page)));
    }

    /**
     * Najwyżej oceniane
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getTopRated/PL/20/1
     * @link https://developers.themoviedb.org/3/movies/get-top-rated-movies
     * @link https://pl.wikipedia.org/wiki/ISO_3166-1 Kody regionów
     * @method getTopRated
     * @param string $language język
     * @param int $count liczba filmów na stronie
     * @param int $page numer strony
     * @return string zwraca dane w formacie JSON
     */
    public function getTopRated($language = 'PL', $count = 20, $page = 0){
      header('Content-Type: application/json');
      echo json_encode(array('movies' => $this->logic->getTopRated($language, $count, $page)));
    }

    /**
     * Filmy, które nadchodzą
     * Przykład użycia: http://localhost/Cinema/index.php?/Home/getUpcoming/PL/20/0
     * @link https://developers.themoviedb.org/3/movies/get-upcoming
     * @method getUpcoming
     * @param string $language język
     * @param int $page numer strony
     * @param int $count na stronie
     * @return string zwraca dane w formacie JSON
     */
    public function getUpcoming($language = 'PL', $count = 20, $page = 0){
      header('Content-Type: application/json');
      echo json_encode(array('movies' => $this->logic->getUpcoming($language, $count, $page)));
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

    /**
    * Lokalizacje kin
    * Przykład użycia: http://localhost/Cinema/index.php/Home/getCinemasLocalization
    * @method getCinemasLocalization
    * @return string zwraca dane w formacie JSON
    */
    public function getCinemasLocalization(){
      $this->load->model('Cinemas_model', 'cinemas');
      header('Content-Type: application/json');
      echo json_encode( array( 'result' => $this->logic->getCinemas()));
    }
}
?>
