<?php

class Cinemasmovie_model extends CI_Model
{
    private $movie_id;
    private $title;
    private $tmdbmovie_id;

    public function getMultikinioIdByTmdbId($tmdb){
      $query = $this->db->select('movie_id')->from('cinemamovies')->where('tmdbmovie_id', $tmdb)->get()->result();
      return count($query) != 0 ? $query[0]->movie_id : NULL;
    }

    /**
     * Cinemasmovie_model constructor.
     * @param $movie_id
     */
    public function __construct($id = null)
    {
      parent::__construct();
        if($id != null)
        {
            $sql = "SELECT * FROM cinemamovies WHERE movie_id = ?";
            $movie = $this->db->query($sql, $id)->result_array()[0];
            if(!empty($movie)) {
                $this->setMovie($movie);
            }
        }
    }

    public function getAll(){
      return $this->db->get('cinemamovies')->result();
    }

    public function save()
    {
        if ($this->title != null) {
            $data = array(
                'movie_id' => $this->movie_id,
                'title' => $this->title,
                'tmdbmovie_id' => $this->tmdbmovie_id
            );
            $this->db->insert('cinemamovies', $data);
        }
    }
    /**
     * @return mixed
     */
    public function getMovieId()
    {
        return $this->movie_id;
    }

    /**
     * @param mixed $movie_id
     */
    public function setMovieId($movie_id)
    {
        $this->movie_id = $movie_id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTmdbmovieId()
    {
        return $this->tmdbmovie_id;
    }

    /**
     * @param mixed $tmdbmovie_id
     */
    public function setTmdbmovieId($tmdbmovie_id)
    {
        $this->tmdbmovie_id = $tmdbmovie_id;
    }

    private function setMovie($movie)
    {
        $this->movie_id = $movie[0]['movie_id'];
        $this->title = $movie[0]['title'];
        $this->tmdbmovie_id = $movie[0]['tmdbmovie_id'];
    }
}
?>
