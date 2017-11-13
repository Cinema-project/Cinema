<?php

/**
* Klasa opisuje film
* @param int id - id filmu
* @param string title - tytuł filmu
* @param string time - data i czas rozpoczęcia filmu
* @param string version - format filmu
* @param string reservation_link - link do rezerwacji na strinie Multikina
*/
class Movie {

  /**
  * Konstruktor klasy
  * @param int id - id filmu
  * @param string title - tytuł filmu
  * @param string time - data i czas rozpoczęcia filmu
  * @param string version - format filmu
  * @param string reservation_link - link do rezerwacji na strinie Multikina
  */
  public function __construct($id, $title, $time, $version, $reservation_link){
    $this->id = $id;
    $this->title = $title;
    $this->time = $time;
    $this->version = $version;
    $this->reservation_link = $reservation_link;
  }

  private $id;
  private $title;
  private $time;
  private $version;
  private $reservation_link;

  /**
  * @return string zwraca obiekt w formacie JSON
  */
  public function toJson(){
    $result = '{ "id:":"' . $this->id .
              '", "title":"' . $this->title .
              '", "time":"' . $this->time .
              '", "version":"' . $this->version .
              '", "reservation_link":"' . $this->reservation_link . '"}';
    return $result;
  }
}

?>
