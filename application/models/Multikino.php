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
  * Pobiera repertuar dla konkretnego kina w formacie JSON
  * @method getCinemaRepertoire
  * @see INFORMACJA_O_PLIKACH_XML_MULTIKINO.pdf
  * @param    int       $id       id kina
  * @return   string              zwraca repertuar kin w formacie JSON
  */
  public function getCinemaRepertoire(){
    $xml = $this->getXML($this->getXMLFilePath())->children();
    $movies = $this->xmlToArray($xml);
    return $movies;
  }

  private function xmlToArray($xml){
    $movies = array();
    foreach ($xml->children() as $movie) {
      $child = $movie->children();
      $id = $child->film_id->__toString();
      $title = $child->film_title->__toString();
      $time = $child->event_time->__toString();
      $version = $child->version_name->__toString();
      $reservation_link = $child->direct_link->__toString();
      $cinemaId = $child->cinema_id->__toString();
      $release = $child->release_date->__toString();
      $movies[] = (new Movie($id, $title, $time, $version, $reservation_link, $cinemaId, $release))->toArray();
    }
    return $movies;
  }
}
?>
