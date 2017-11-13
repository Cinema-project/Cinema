<?php
class TheMovieDB extends CI_Model {

  private $authKeyV3 = '9a8e79615c34a10f3d14b49681855241';
  private $authKeyV4 =
'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI5YThlNzk2MTVjMzRhMTBmM2QxNGI0OTY4MTg1NTI0MSIsInN1YiI6IjVhMDk1MzMzYzNhMzY4NjgwYTAxMzZhOSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.OVbCSRykfDecay1EG1vq1ZEb16Ig9BRnxiRXXb3IqHA';


  private $urlData = 'https://api.themoviedb.org/3';
  private $urlImage = 'http://image.tmdb.org/t/p/w500';
  private $language = 'pl';
  private $alternativeLanguage = 'en';
  private $timeZone = 'Europe/Warsaw';

  public function __construct(){
		parent :: __construct();
  }

  /*
  * Tworzy zapytanie do strony pod adresem $this->url i zwraca rezultat
  * @question - zapytanie
  * @more - dodatkowe informacje
  */
  private function querry( $question, $more = null ){
    if ($more == null){
      $more = '';
    }
    $url = $this->urlData . $question . '?api_key=' . $this->authKeyV3 . '&language=' . $this->language . $more;
    return file_get_contents( $url );
  }

  /*
  * Zwraca dostępne kategorie
  */
  public function getCategoryList(){
    return $this->querry( '/genre/movie/list' );
  }

  /*
  * Zwraca filmy z podanej kategorii
  */
  public function getMoviesFromCategory($categoryId, $page = 1){
    return $this->querry( '/discover/movie', '&with_genres=' . $categoryId . '&page=' . $page . '&sort_by=popularity.desc' );
  }

  /*
  * Zwraca więcej informacji dla filmu o podanym id
  */
  public function getMovieDetails($movieId){
    return $this->querry('/movie/' . $movieId);
  }

  /*
  * Funkcja wybiera pierwszy plakat w języku domyślnym (zdefiniowany na początku pliku)
  * Jeżeli nie ma plakatu dla domyślnego języka to wybiera pierwszy plakat dla języka alternatywnego (zdefiniowany na początku pliku).
  */
  public function getMoviePosterPath($movieId){
    $json = $this->querry('/movie/' . $movieId . '/images', '&include_image_language=' . $this->language . ',' . $this->alternativeLanguage);
    $json = json_decode($json)->posters;
    $result = null;
    foreach ( $json as $data ){
      if ( $data->iso_639_1 == $this->language ){
        $result = $data;
        break;
      }
    }

    if ($result == null){
      $result = $json[0];
    }

    $result = $this->urlImage . $result->file_path;

    return $result;
  }

  public function getQuerry(){
    return $this->getMovieList();
  }

}
?>
