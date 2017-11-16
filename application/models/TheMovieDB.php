<?php
/**
* Klasa jest częściowym wraperem dla API strony themoviedb.org
* @link https://api.themoviedb.org/3
*/
class TheMovieDB extends CI_Model {

  /**
   * Klucz identyfikujący dla API w werji 3
   * @var string
   */
  private $authKeyV3 = '9a8e79615c34a10f3d14b49681855241';
  /**
   * Klucz identyfikujący dla API w wersji 4
   * @var string
   */
  private $authKeyV4 =
'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI5YThlNzk2MTVjMzRhMTBmM2QxNGI0OTY4MTg1NTI0MSIsInN1YiI6IjVhMDk1MzMzYzNhMzY4NjgwYTAxMzZhOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.OVbCSRykfDecay1EG1vq1ZEb16Ig9BRnxiRXXb3IqHA';
  /**
   * url do api
   * @var string
   */
  private $urlData = 'https://api.themoviedb.org/3';
  /**
   * url do obrazów
   * @var string
   */
  private $urlImage = 'http://image.tmdb.org/t/p/w500';
  /**
   * Preferowany język
   * @var string
   */
  private $language = 'pl';
  /**
   * Język alternatywny
   * @var string
   */
  private $alternativeLanguage = 'en';
  /**
   * Strefa czasowa
   * @var string
   */
  private $timeZone = 'Europe/Warsaw';

  public function __construct(){
		parent :: __construct();
  }

  /**
  * Tworzy zapytanie do strony pod adresem $this->url
  * @method querry
  * @param  string  $question zapytanie
  * @param  string  $more     dodatkowe informacje
  * @return string            Zwraca rezultat zapytania w formacie JSON
  */
  private function querry( $question, $more = null ){
    if ($more == null){
      $more = '';
    }
    $url = $this->urlData . $question . '?api_key=' . $this->authKeyV3 . '&language=' . $this->language . $more;
    return file_get_contents( $url );
  }

  /**
  * Pyta o kategorie
  * @method getCategoryList
  * @return string          Zwraca dostępne kategorie w formacie JSON
  * @link https://developers.themoviedb.org/3/genres/get-movie-list
  */
  public function getCategoryList(){
    return $this->querry( '/genre/movie/list' );
  }

  /**
  * Pyta o filmy z podanej kategorii
  * @method getMoviesFromCategory
  * @param  int     $categoryId id kategorii
  * @param  int     $page       numer strony
  * @return string              Zwraca filmy z podanej kategorii w formacie JSON
  * @link https://developers.themoviedb.org/3/discover
  */
  public function getMoviesFromCategory($categoryId, $page = 1){
    return $this->querry( '/discover/movie', '&with_genres=' . $categoryId . '&page=' . $page . '&sort_by=popularity.desc' );
  }

  /**
  * Pyta o szczegółowe informację o filmie
  * @method getMovieDetails
  * @param  int     $movieId  id filmu
  * @return string            Zwraca informację o filmie w formacie JSON
  * @link https://developers.themoviedb.org/3/movies
  */
  public function getMovieDetails($movieId){
    return $this->querry('/movie/' . $movieId);
  }

  /**
  * Funkcja wybiera pierwszy plakat w języku domyślnym (zdefiniowany na początku pliku)
  * Jeżeli nie ma plakatu dla domyślnego języka to wybiera pierwszy plakat dla języka alternatywnego (zdefiniowany na początku pliku).
  * @method getMoviePosterPath
  * @param  int     $movieId  id filmu
  * @return string            Zwraca link do plakatu
  */
  public function getMoviePosterPath($movieId){
    $json = $this->querry('/movie/' . $movieId . '/images', '&include_image_language=' . $this->language . ',' . $this->alternativeLanguage);
    $json = json_decode($json)->posters;
    $result = $json[0];
    foreach ( $json as $data ){
      if ( $data->iso_639_1 == $this->language ){
        $result = $data;
        break;
      }
    }
    $result = $this->urlImage . $result->file_path;

    return $result;
  }

  public function getQuerry(){
    return $this->getMovieList();
  }

}
?>
