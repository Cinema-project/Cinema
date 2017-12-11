<?php
/**
* Klasa jest cz��ciowym wraperem dla API strony themoviedb.org
* @link https://api.themoviedb.org/3
*/
class TheMovieDB extends CI_Model {
  /**
   * Klucz identyfikuj�cy dla API w werji 3
   * @var string
   */
  private $authKeyV3 = '9a8e79615c34a10f3d14b49681855241';
  /**
   * Klucz identyfikuj�cy dla API w wersji 4
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
   * url do obraz�w
   * @var string
   */
  private $urlImage = 'http://image.tmdb.org/t/p/w500';
  /**
   * Strefa czasowa
   * @var string
   */
  private $timeZone = 'Europe/Warsaw';
  public function __construct(){
		parent :: __construct();
  }
  /**
   * Dodaje j�zyk do zapytania
   * @method addLaguage
   * @param string $language j�zyk
   * @return string zwraca j�zyk w formacie zapytania
   */
  private function laguage($language) {
    return '&language=' . $language;
  }
  /**
   * Dodaje region do zapytania
   * @method addRegion
   * @param string $region region
   * @return string zwraca region w formacie zapytania
   */
  private function region($region){
    return '&region=' . $region;
  }
  /**
   * Dodaje strone do zapytania
   * @method page
   * @param int $page numer strony
   * @return string zwraca numer strony w formacie zapytania
   */
  private function page($page){
    return '&page=' . $page;
  }
  /**
  * Tworzy zapytanie do strony pod adresem $this->url
  * @method querry
  * @param string $question zapytanie
  * @param string $more dodatkowe informacje
  * @return string Zwraca rezultat zapytania w formacie JSON
  */
  private function querry( $question, $more = null ){
    if ($more == null){
      $more = '';
    }
    $url = $this->urlData . $question . '?api_key=' . $this->authKeyV3 . $more;
    return file_get_contents( $url );
  }
  /**
  * Pyta o kategorie
  * @method getCategoryList
  * @param string $language j�zyk
  * @return string zwraca dost�pne kategorie w formacie JSON
  * @link https://developers.themoviedb.org/3/genres/get-movie-list
  */
  public function getCategoryList($language){
    return $this->querry( '/genre/movie/list',
                          $this->laguage($language) );
  }
  /**
 * Pobiera filmy
 *
 * Dozwolone warto�ci dla parametru sortowania:
 * popularity.asc, popularity.desc, release_date.asc,
 * release_date.desc, revenue.asc, revenue.desc,
 * primary_release_date.asc, primary_release_date.desc,
 * original_title.asc, original_title.desc, vote_average.asc,
 * vote_average.desc, vote_count.asc, vote_count.desc
 *
 * @method getMovies
 * @param string $language j�zyk
 * @param int $categoryId id kategorii
 * @param int $page numer strony
 * @param string $sort spos�b sortowania
 * @param int $year rok produkcji
 * @return string zwraca list� film�w w formacie JSON
 * @link https://developers.themoviedb.org/3/discover
 */
 public function getMovies($language, $categoryId, $page, $sort, $year ){
   $language = trim($language);
   $categoryId = trim($categoryId);
   $page = trim($page);
   $sort = trim($sort);
   $year = trim($year);
   $more = '';
   if ($language != ''){
     $more .= $this->laguage($language);
   }
   if ($categoryId != '' && is_numeric($page)){
     $more .= '&with_genres=' . $categoryId;
   }
   if ($page != '' && is_numeric($page)){
     $more .= $this->page($page);
   }
   if ($sort != '') {
     $more .= '&sort_by=' . $sort;
   }
   if ($year != '' && is_numeric($year)){
     $more .= '&year=' . $year;
   }
   return $this->querry( '/discover/movie', $more );
 }
  /**
  * Pyta o szczeg��owe informacj� o filmie
  * @method getMovieDetails
  * @param string $language j�zyk
  * @param int $movieId  id filmu
  * @return string Zwraca informacj� o filmie w formacie JSON
  * @link https://developers.themoviedb.org/3/movies
  */
  public function getMovieDetails($language, $movieId){
    return $this->querry('/movie/' . $movieId,
                          $this->laguage($language));
  }
  /**
  * Funkcja wybiera pierwszy plakat w j�zyku domy�lnym (zdefiniowany na pocz�tku pliku)
  * Je�eli nie ma plakatu dla domy�lnego j�zyka to wybiera pierwszy plakat dla j�zyka alternatywnego (zdefiniowany na pocz�tku pliku).
  * @method getMoviePosterPath
  * @param string $language j�zyk
  * @param int $movieId id filmu
  * @param string $alternativeLanguage j�zyk alternatywny
  * @return string Zwraca link do plakatu
  */
  public function getMoviePosterPath($language, $movieId, $alternativeLanguage = 'en'){
    $json = $this->querry('/movie/' . $movieId . '/images',
                          '&include_image_language=' . $language . ',' . $alternativeLanguage);
    $json = json_decode($json)->posters;
    var_dump($json);die();
    $result = NULL;
    if (count($json) != 0){
      $result = $json[0];
      foreach ( $json as $data ){
        if ( strtolower($data->iso_639_1) == strtolower($language) ){
          $result = $data;
          break;
        }
      }
      $result = $this->urlImage . $result->file_path;
    }
    return $result;
  }
  /**
   * S�owa kluczowe
   * @link https://developers.themoviedb.org/3/movies/get-movie-keywords
   * @method getKeywords
   * @param string $language j�zyk
   * @param int $id id filmu
   * @return string zwraca s�owa kluczowe w formacie JSON
   */
  public function getKeywords($language, $id){
    return $this->querry('/movie/' . $id . '/keywords',
                          $this->laguage($language));
  }
  /**
   * Ostatnie filmy
   * @link https://developers.themoviedb.org/3/movies/get-latest-movie
   * @method getLatest
   * @param string $language j�zyk
   * @param int $page numer strony
   * @return string zwraca dane w formacie JSON
   */
  public function getLatest($language, $page){
    return $this->querry( '/movie/latest',
                          $this->page($page) .
                          $this->laguage($language));
  }
  /**
   * Aktualnie grane filmy w kinach
   * @link https://pl.wikipedia.org/wiki/ISO_3166-1 Kody region�w
   * @link https://developers.themoviedb.org/3/movies/get-now-playing
   * @method getNowPlaying
   * @param string $language j�zyk
   * @param int $page numer strony
   * @param string $region kod regionu
   * @return string zwraca dane w formacie JSON
   */
  public function getNowPlaying($language, $page, $region){
    return $this->querry( '/movie/now_playing',
                          $this->page($page) .
                          $this->region($region) .
                          $this->laguage($language));
  }
  /**
   * Popularne filmy
   * @link https://developers.themoviedb.org/3/movies/get-popular-movies
   * @link https://pl.wikipedia.org/wiki/ISO_3166-1 Kody region�w
   * @method getPopular
   * @param string $language j�zyk
   * @param int $page numer strony
   * @param int $region kod regionu
   * @return string zwraca dane w formacie JSON
   */
  public function getPopular($language, $page, $region){
    return $this->querry( '/movie/popular',
                          $this->page($page) .
                          $this->region($region) .
                          $this->laguage($language));
  }
  /**
   * Najwy�ej oceniane
   * @link https://developers.themoviedb.org/3/movies/get-top-rated-movies
   * @link https://pl.wikipedia.org/wiki/ISO_3166-1 Kody region�w
   * @method getTopRated
   * @param string $language j�zyk
   * @param int $page numer strony
   * @param int $region kod regionu
   * @return string zwraca dane w formacie JSON
   */
  public function getTopRated($language, $page, $region){
    return $this->querry( '/movie/top_rated',
                          $this->page($page) .
                          $this->region($region) .
                          $this->laguage($language));
  }
  /**
   * Filmy, kt�re nadchodz�
   * @link https://developers.themoviedb.org/3/movies/get-upcoming
   * @link https://pl.wikipedia.org/wiki/ISO_3166-1 Kody region�w
   * @method getUpcoming
   * @param string $language j�zyk
   * @param int $page numer strony
   * @param int $region kod regionu
   * @return string zwraca dane w formacie JSON
   */
  public function getUpcoming($language, $page, $region){
    return $this->querry( '/movie/upcoming',
                          $this->page($page) .
                          $this->region($region) .
                          $this->laguage($language));
  }
  /**
   * Pobiera trailer do filmu.
   * Je�eli nie ma traileru w podanym j�zyku
   * to pobierany jest trailer w dowolnym innym j�zyku.
   * @link https://developers.themoviedb.org/3/movies/get-movie-videos
   * @method getTrailerPath
   * @param string $language j�zyk
   * @param int $id id filmu
   * @return string zwraca dane w formacie JSON
   */
  public function getTrailerPath($language, $id) {
    $json = $this->querry( '/movie/' . $id . '/videos',
                            $this->laguage($language) );
    $decode = json_decode($json);
    if (count($decode->results) == 0 ){
      $json = $this->querry( '/movie/' . $id . '/videos',
                              $this->laguage('xx') );
      $decode = json_decode($json);
    }
    if (count($decode->results) == 0){
      return null;
    }
    $result = array();
    foreach ($decode->results as $item){
      if ( $item->site == 'YouTube' ) {
        $result[] = 'https://www.youtube.com/watch?v=' . $item->key;
      }
    }
    return json_encode($result);
  }
  /**
   * Obsada i ekipa filmu
   * @link https://developers.themoviedb.org/3/movies/get-movie-credits
   * @method getCredits
   * @param int $id id filmu
   * @return string zwraca dane w formacie JSON
   */
  public function getCredits($id) {
    return $this->querry( '/movie/' . $id . '/credits');
  }
}
?>
