<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Update extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('update_model');
  }
  /**
   * Aktualizuje tabele
   * @method update
   */
  public function update(){
    $this->initGeoCodeTable();
    $this->updateGenres();
    $this->updateCinemaMovies();
    $this->updateCinemaRepertoire();
  }
  /**
   * Inicjalizuje tabelę cinemas
   * @method initGeoCodeTable
   */
  public function initGeoCodeTable(){
    $this->load->model('config_model', 'c');
    if ( $this->c->checkIfExist('GEO_CODE', date('Y-m-d H:i:s')) ){
      echo 'Geo codes are up to date';
      return;
    }

    $this->load->model('Cinemas_geocode_model', 'geo');
    $this->geo->insertDataToDataBase();
  }
  /**
   * Inicjalizuje tabelę genres
   * @method updateGenres
   */
  public function updateGenres(){
    $this->update_model->updateGenres();
  }
  /**
   * Aktualizuje filmy Multikina
   * @method updateCinemaMovies
   * @return array lista filmów
   */
  public function updateCinemaMovies(){
    header('Content-Type: application/json');
    echo json_encode($this->update_model->updateCinemaMovies(), JSON_PRETTY_PRINT);
  }
  /**
   * Aktualizuje repertuar Multikina
   * @method updateCinemaRepertoire
   */
  public function updateCinemaRepertoire(){
    $this->load->model('multikino');
    $repertoire = $this->multikino->getCinemaRepertoire();
    $this->update_model->updateCinemaRepertoire($repertoire);
  }
}
?>
