<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent :: __construct();
		$this->load->model('multikino');
		$this->load->model('themoviedb');
    $this->load->helper('url');
  }

	/**
	* Strona główna kontrolera
	* Wyświetla plik view/home.php
	*/
	public function index()
	{
		$data['multikino'] = $this->multikino->getCinemaRepertoire(3);
		$data['themoviedbLista'] = $this->themoviedb->getCategoryList();
		$data['themoviedbAkcja'] = $this->themoviedb->getMoviesFromCategory(18);
		$data['movieDetails'] = $this->themoviedb->getMovieDetails(290512);
		$data['poster'] = $this->themoviedb->getMoviePosterPath(290512);
		$this->load->view('home', $data);
	}

	/**
	* @example http://localhost/index.php/Home/getCinemaRepertoire/3
	*	@param int id - id kina sieci multikino.
	* @return string Zwraca repertuar dla Multikina w formacie JSON
	*/
	public function getCinemaRepertoire($id){
		echo $this->multikino->getCinemaRepertoire($id);
	}

	/**
	*	@example http://localhost/index.php/Home/getCategoryList
	*	@return string Zwraca listę kategorii w formacie JSON.
	*/
	public function getCategoryList(){
		echo $this->themoviedb->getCategoryList();
	}

	/**
	* Filmy z podanej kategorii
	* @example http://localhost/index.php/Home/getMoviesFromCategory/35/1
	* @param int id - id kategorii filmów
	* @param int page - numer strony
	* @return string zwraca listę filmów w formacie JSON.
	*/
	public function getMoviesFromCategory($id, $page = 1){
		echo $this->themoviedb->getMoviesFromCategory($id, $page);
	}

	/**
	* szczegółowe informacje o filmie
	* @example http://localhost/index.php/Home/getMovieDetails/290512
	*	@param int id - id filmu
	* @return string zwraca informacje o filmie w formacie JSON.
	*/
	public function getMovieDetails($id){
		echo $this->themoviedb->getMovieDetails($id);
	}

	/**
	* Plakat filmu
	*	@example http://localhost/index.php/Home/getMoviePoster/290512
	*	@param int id - id filmu
	* @return string zwraca ścieżkę do plakatu danego filmu.
	*/
	public function getMoviePoster($id){
		echo $this->themoviedb->getMoviePosterPath($id);
	}
}

?>
