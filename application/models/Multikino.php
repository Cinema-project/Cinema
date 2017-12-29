<?php
require_once('class/Movie.php');
/**
* Klasa jest cz��ciowym wraperem dla API strony Multikina
* @link https://apibeta.multikino.pl/
*/
class Multikino extends CI_Model {
  public function __construct(){
		parent :: __construct();
  }
 /**
  * @method getXMLFilePath
  * @return string Zwraca �cie�k� do pliku XML z repertuarem
  */
  private function getXMLFilePath(){
    return 'https://apibeta.multikino.pl/repertoire.xml';
  }
  /**
  * @method getXMLFilms
  * @return string Zwraca ścieżkę do pliku XML z filmami
  */
  private function getXMLFilms(){
    return 'https://apibeta.multikino.pl/xml/filmsxml';
  }
  /**
  * Pobiera repertuar ze strony
  * @method getXML
  * @param  string   $url  link do strony
  * @return string         zwraca repertuar w formacie XML
  */
  private function getXML($url){
    return simplexml_load_string( file_get_contents($url) , 'SimpleXMLElement', LIBXML_NOCDATA );
  }
  /**
  * Pobiera repertuar dla konkretnego kina
  * @method getXMLByCinemaId
  * @see INFORMACJA_O_PLIKACH_XML_MULTIKINO.pdf
  * @param    int         $id     id kina
  * @return   string              zwraca repertuar w formacie XML
  */
  private function getXMLByCinemaId($id){
    return $this->getXML( $this->getXMLFilePath() . '?cinema_id=' . $id );
  }
  /**
  * Pobiera repertuar dla konkretnego kina z zakresu czasu w formacie XML
  * @method getXMLByDateAndID
  * @see INFORMACJA_O_PLIKACH_XML_MULTIKINO.pdf
  * @param    string    $dateFrom pocz�tek okresu (format yyyymmdd)
  * @param    string    $dateTo   koniec okresu (format yyyymmdd)
  * @param    int       $id       id kina
  * @return   string              zwraca repertuar w formacie XML
  */
  private function getXMLByDateAndID($dateFrom, $dateTo, $id){
    return $this->getXML( $this->getXMLFilePath() . '?cinema_id=' . $id . 'date_from=' . $dateFrom . 'date_to' . $dateTo );
  }
  /**
  * Pobiera repertuar dla konkretnego kina
  * @method getCinemaRepertoire
  * @see INFORMACJA_O_PLIKACH_XML_MULTIKINO.pdf
  * @return array zwraca repertuar kin sieci Multikino oraz datę ostatniej aktualizacji
  */
  public function getCinemaRepertoire(){
    $xml = $this->getXML($this->getXMLFilePath());
    $result = array();
    $result['created'] = $xml->attributes()->created->__toString();
    $result['movies'] = $this->xmlToArray($xml->children());
    return $result;
  }
  /**
   * Pobiera filmy grane obecnie w Multikinie
   * @method getCinemaFilms
   * @return array tablica filmów w poolu 'movies' oraz data ostatniej aktualizacji w polu 'created'
   */
  public function getCinemaFilms(){
    $xml = $this->getXML($this->getXMLFilms());
    $movies = array();
    $movies['created'] = $xml->attributes()->created->__toString();
    $movies['movies'] = $this->xmlFilmsToArray($xml->children());
    return $movies;
  }
/**
 * Konwertuje dane filmów w postaci XML do tablicy
 * @method xmlFilmsToArray
 * @param XML $xml XML z filmami
 * @return array tablica filmów
 */
  private function xmlFilmsToArray($xml){
    $movies = array();
    foreach ($xml as $movie) {
      $child = $movie->children();
      $id = $child->id->__toString();
      $title = $child->title->__toString();
      $description = $child->description->__toString();
      $runtime = $child->runtime->__toString();
      $country = $child->country->__toString();
      $premiere = $child->{'premiere-date'}->__toString();
      $movies[] = array('id' => $id,
                          'title' => $title,
                          'description' => $description,
                          'runtime' => $runtime,
                          'country' => $country,
                          'premierDate' => $premiere);
    }
    return $movies;
  }
  /**
   * Konwertuje XML z repertuarem do tablicy
   * @method xmlToArray
   * @param XML $xml XML z repertuarem
   * @return array tablica repertuaru
   */
  private function xmlToArray($xml){
    $movies = array();
    foreach ($xml->children() as $movie) {
      $child = $movie->children();
      $id = $child->movie_id->__toString();
      $title = $child->film_title->__toString();
      $time = $child->event_time->__toString();
      $version = $child->version_name->__toString();
      $reservation_link = $child->direct_link->__toString();
      $cinemaId = $child->ig_cinema_id->__toString();
      $release = $child->release_date->__toString();
      $movies[] = (new Movie($id, $title, $time, $version, $reservation_link, $cinemaId, $release))->toArray();
    }
    return $movies;
  }
}
?>
