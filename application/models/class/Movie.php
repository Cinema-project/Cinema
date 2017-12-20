<?php

/**
* Klasa opisuje film
* @param int      $id                   id filmu
* @param string   $title                tytuł filmu
* @param string   $time                 data i czas rozpoczęcia filmu
* @param string   $version              format filmu
* @param string   $reservation_link     link do rezerwacji na strinie Multikina
*/
class Movie {

  /**
  * Konstruktor klasy
  * @method __construct
  * @param int      $id                   id filmu
  * @param string   $title                tytuł filmu
  * @param string   $time                 data i czas rozpoczęcia filmu
  * @param string   $version              format filmu
  * @param string   $reservation_link     link do rezerwacji na strinie Multikina
  */
  public function __construct($id, $title, $time, $version, $reservation_link, $cinemaId, $release){
    $this->id = $id;
    $this->title = $title;
    $this->time = $time;
    $this->version = $version;
    $this->reservation_link = $reservation_link;
    $this->cinemaId = $cinemaId;
    $this->release_date = $release;
  }

  private $id;
  private $title;
  private $time;
  private $version;
  private $reservation_link;
  private $cinemaId;
  private $release_date;

  /**
   * @method toArray
  *  @return string                        zwraca obiekt jako tablicę
  */
  public function toArray(){
    return array('movieId' => $this->id,
                  'title' => $this->title,
                  'time' => $this->time,
                  'version' => $this->version,
                  'link' => $this->reservation_link,
                  'cinemaId' => $this->cinemaId,
                  'release' => $this->release_date);
  }
}

?>
