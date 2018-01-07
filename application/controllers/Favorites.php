<?php
/**
 * Created by PhpStorm.
 * User: Arek
 * Date: 06.01.2018
 * Time: 22:41
 */

class Favorites extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Businesslogic', 'logic');
    }

    /**
     * Pobieranie ulubionych filmow
     * Przykład użycia: http://localhost/Cinema/index.php/Favorites/getFavorites/
     *
     * @method getFavorites
     * @POST token
     * @return string zwraca ulubione w formacie JSON
     */
    public function getFavorites() {
        $token = $this->input->post('token');
        $user_id = $this->token->tokenIsValid($token);
        if ($user_id != -1) {
            header('Content-Type: application/json');
            $movies = array($this->user_model->getFavoritesById($user_id));
            foreach ($movies as $movie){
            $result = (array('results' => $this->logic->getMovieDetails('PL', $movie[0]->MovieId)));
            }
            echo json_encode ($result);
        }
    }

    /**
     * Dodanie do ulubionych
     * Przykład użycia: http://localhost/Cinema/index.php/Favorites/addFavoriteMovie/401
     * @POST token
     * @method addFavoriteMovie
     * @param int $movie_id id filmu
     */
    public function addFavoriteMovie($movie_id){
        $token = $this->input->post('token');
        $user = $this->token->tokenIsValid($token);
        if ($user != -1) {
            $this->user_model->insertIntoFavorites($user, $movie_id);
        }
    }

    /**
     * Usuwanie z ulubionych
     * Przykład użycia: http://localhost/Cinema/index.php/Favorites/removeFavoriteMovie/401
     * @POST token
     * @method removeFavoriteMovie
     * @param int $movie_id id filmu
     */
    public function removeFavoriteMovie($movie_id){
        $token = $this->input->post('token');
        $user_id = intval($this->token->tokenIsValid($token));
        $this->user_model->removeFromFavorites($user_id, $movie_id);
    }
}
?>
