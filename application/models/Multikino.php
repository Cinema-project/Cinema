<?php
require_once('class/Movie.php');

class Multikino extends CI_Model {

  public function __construct(){
		parent :: __construct();
  }

  /*
  * Zwraca ścieżkę do pliku XML z repertuarem
  */
  private function getXMLFilePath(){
    return 'https://apibeta.multikino.pl/repertoire.xml';
  }

  /*
  * Pobiera repertuar ze strony w formacie XML
  * @url - link do strony
  */
  private function getXML($url){
    return simplexml_load_string( file_get_contents($url) , 'SimpleXMLElement', LIBXML_NOCDATA );
  }

  /*
  * Pobiera repertuar dla konkretnego kina w formacie XML
  * @id - id kina
  * @id kin znajdują się w pliku "INFORMACJA O PLIKACH XML MULTIKINO.pdf"
  */
  private function getXMLByCinemaId($id){
    return $this->getXML( $this->getXMLFilePath() . '?cinema_id=' . $id );
  }
  /*
  * Pobiera repertuar dla konkretnego kina z zakresu czasu w formacie XML
  * @dateFrom - początek okresu (format yyyymmdd)
  * @dateTo - koniec okresu (format yyyymmdd)
  * @id - id kina
  * @id kin znajdują się w pliku "INFORMACJA O PLIKACH XML MULTIKINO.pdf"
  */
  private function getXMLByDateAndID($dateFrom, $dateTo, $id){
    return $this->getXML( $this->getXMLFilePath() . '?cinema_id=' . $id . 'date_from=' . $dateFrom . 'date_to' . $dateTo );
  }

  /*
  * Pobiera repertuar dla konkretnego kina w formacie JSON
  * @id - id kina
  * @id kin znajdują się w pliku "INFORMACJA O PLIKACH XML MULTIKINO.pdf"
  */
  public function getCinemaRepertoire($id){

    $xml = $this->getXMLByCinemaId($id)->children();

    $movies = array();

    foreach ($xml->children() as $movie) {
      $child = $movie->children();
      $id = $child->film_id;
      $title = $child->film_title;
      $time = $child->event_time;
      $version = $child->version_name;
      $reservation_link = $child->direct_link;
      $movies[] = new Movie($id, $title, $time, $version, $reservation_link);
    }

    $result = '{"movies":[';
    foreach ($movies as $movie) {
      $result .= $movie->toJson() . ', ';
    }
    $result = substr($result, 0, -2) . ']}';

    return $result;
  }

}
?>
