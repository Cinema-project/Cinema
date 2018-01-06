<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Comments extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('comments');
    }

    public function addComment(){
        $token = $this->input->post('token');
        $movie_id = $this->input->post('movie_id');
        $comment = $this->input->post('comment');
        $user = $this->token->tokenIsValid($token);
        if (is_numeric($user)){
            if ($user == -1){
                echo $this->statements->getJson(-1);
                return;
            }
        }
        $result = $this->comments->addComment($user, $movie_id, $comment);
        header('Content-Type: application/json');
        echo $this->statements->getJson($result);
    }
    public function getComments($movie_id){
        header('Content-Type: application/json');
        echo json_encode(array('results' => $this->comments->getComments($movie_id) ));
    }

}
?>