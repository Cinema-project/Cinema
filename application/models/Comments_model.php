<?php
/**
 * Created by PhpStorm.
 * User: Arek
 * Date: 06.01.2018
 * Time: 20:58
 */
class Comments_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    public $user_id;
    public $movie_id;
    public $comment;
    public $date;

    public function getFormat(){
        return '%Y-%m-%d %h:%i:%s';
    }

    public function addComment($user_id, $movie_id,  $comment){
        $this->load->helper('date');
        $this->comment = trim($comment);
        $this->date = mdate($this->getFormat(), time());
        $this->user_id = $user_id;
        $this->movie_id = $movie_id;
        return $this->db->insert('comments', $this) ? true : false;
    }
    public function getCommentsByMovieID($movie_id){
        $this->db->select('comment_id, users.nick, comment, date');
        $this->db->from('comments');
        $this->db->join('users', 'users.UserId = comments.user_id');
        $this->db->where('movie_id', $movie_id);
        $this->db->order_by('date', 'DESC');
        return $this->db->get()->result();
    }

    public function removeComment($comment_id){
        return $this->db->where('comments.comment_id', $comment_id)->delete('comments') ? true : false;
    }
}
?>