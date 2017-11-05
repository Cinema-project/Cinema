<?php

class Movie {
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
