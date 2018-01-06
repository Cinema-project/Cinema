<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Comments extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('comments_model');
        $this->load->model('user_model');
    }

    public function addComment(){
        $token = $this->input->post('token');
        $movie_id = $this->input->post('movie_id');
        $comment = $this->input->post('comment');
        $user = $this->token->tokenIsValid($token);
        if ($user != -1) {
          $this->comments_model->addComment($user, $movie_id, $comment);
        }
    }
    public function getComments($movie_id){
        header('Content-Type: application/json');
        echo json_encode(array('results' => $this->comments_model->getCommentsByMovieID($movie_id) ));
    }

    public function removeComment($comment_id){
        $token = $this->input->post('token');
        $user_id = intval($this->token->tokenIsValid($token));
        $userRole = $this->user_model->getUserRoleById($user_id);
        if ($userRole == 1){
           $this->comments_model->removeComment($comment_id);
        }
    }

}
?>
