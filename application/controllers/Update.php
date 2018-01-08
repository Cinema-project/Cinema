<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
/**
 * Update
 * Kontroler aktualizacji danych aplikacji
 */
class Update extends CI_Controller {
  /**
   * @method __construct konstruktor klasy
   */
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
    $this->update_model->initGeoCodeTable();
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
    echo json_encode($this->update_model->updateCinemaMovies());
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
