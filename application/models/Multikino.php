<?php
require_once('class/Movie.php');

class Multikino extends CI_Model {

  public function __construct(){
		parent :: __construct();
  }

  private function getXMLFilePath(){
    return 'https://apibeta.multikino.pl/repertoire.xml';
  }

  private function getXML($url){
    return simplexml_load_string( file_get_contents($url) , 'SimpleXMLElement', LIBXML_NOCDATA );
  }

  private function getXMLByCinemaId($id){
    return $this->getXML( $this->getXMLFilePath() . '?cinema_id=' . $id );
  }

  //@Date format yyyymmdd
  private function getXMLByDateAndID($dateFrom, $dateTo, $id){
    return $this->getXML( $this->getXMLFilePath() . '?cinema_id=' . $id . 'date_from=' . $dateFrom . 'date_to' . $dateTo );
  }

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
      $result .= $movie->toJson();
    }
    $result .= ']}';

    return $result;
  }

}
?>
