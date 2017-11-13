<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent :: __construct();
		$this->load->model('multikino');
		$this->load->model('themoviedb');
    $this->load->helper('url');
  }

	/*
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

	/*
	*	Zwraca repertuar dla Multikina/
	* Użycie: http://localhost/index.php/Home/getCinemaRepertoire/3
	*	@id - id kina sieci multikino.
	* @ID dla multikina są dostępne w PDF.
	*/
	public function getCinemaRepertoire($id){
		echo $this->multikino->getCinemaRepertoire($id);
	}

	/*
	*	Zwraca listę kategorii w formacie JSON.
	*	Użycie: http://localhost/index.php/Home/getCategoryList
	*/
	public function getCategoryList(){
		echo $this->themoviedb->getCategoryList();
	}

	/*
	*	Zwraca listę filmów z podanej kategorii w formacie JSON.
	* @id - id kategorii filmów
	* @page - numer strony
	* Użycie: http://localhost/index.php/Home/getMoviesFromCategory/35/1
	*/
	public function getMoviesFromCategory($id, $page = 1){
		echo $this->themoviedb->getMoviesFromCategory($id, $page);
	}

	/*
	* Zwraca informacje szczegółowe o filmie w formacie JSON.
	*	@id - id filmu
	* Użycie: http://localhost/index.php/Home/getMovieDetails/290512
	*/
	public function getMovieDetails($id){
		echo $this->themoviedb->getMovieDetails($id);
	}

	/*
	* Zwraca ścieżkę do plakatu danego filmu.
	*	@id - id filmu
	*	Użycie: http://localhost/index.php/Home/getMoviePoster/290512
	*/
	public function getMoviePoster($id){
		echo $this->themoviedb->getMoviePosterPath($id);
	}
}

?>
