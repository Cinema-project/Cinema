<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 03.12.2017
 * Time: 20:00
 */

class Tmdbmovie_model extends CI_Model
{
    public $id;
    public $title;
    public $description;
    public $popularity;
    public $poster;
    public $trailer;
    public $voteAverage;
    public $premierDate;

    private $genresList = array();
    /**
     * Tmdbmovie_model constructor.
     * @param $id
     */
    public function __construct($id = null)
    {
        if($id != null) {
            $sql = "SELECT * FROM tmdbmovies WHERE MovieID = ?";
            $tmdbMovie = $this->db->query($sql, $id)->result_array()[0];
            if(!empty($tmdbMovie))
            {
                $this->setTmdbMovie($tmdbMovie);
            }
            $sql = "SELECT id_genre FROM genres_movies WHERE id_movie = ?";
            $genres = $this->db->query($sql, $id)->result_array();
            foreach ($genres as $genre) {
                $this->genresList[] = $genre;
            }

        }
    }

    public function set($id, $title, $description, $popularity, $poster, $trailer, $vote, $premiere){
      $this->setId($id);
      $this->setTitle($title);
      $this->setDescription($description);
      $this->setPopularity($popularity);
      $this->setPoster($poster);
      $this->setTrailer($trailer);
      $this->setVoteAverage($vote);
      $this->setPremierDate($premiere);
    }

    public function save()
    {
        if ( $this->id != null && $this->title != null)
        {
            $data = array(
                'MovieID' => $this->id,
                'Title' => $this->title,
                'Description' => $this->description,
                'Popularity' => $this->popularity,
                'Poster' => $this->poster,
                'Trailer' => $this->trailer,
                'vote_average' => $this->voteAverage,
                'Premiere_date' => $this->premierDate
        );
            $this->db->insert('tmdbmovies', $data);
        }
    }

    public function insertToGenresMovies($genre, $movie){
        $data = array('id_movie' => $movie,
            'id_genre' => $genre);
        $this->db->insert('genres_movie', $data);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * @param mixed $popularity
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;
    }

    /**
     * @return mixed
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * @param mixed $poster
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;
    }

    /**
     * @return mixed
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * @param mixed $trailer
     */
    public function setTrailer($trailer)
    {
        $this->trailer = $trailer;
    }

    /**
     * @return mixed
     */
    public function getVoteAverage()
    {
        return $this->voteAverage;
    }

    /**
     * @param mixed $voteAverage
     */
    public function setVoteAverage($voteAverage)
    {
        $this->voteAverage = $voteAverage;
    }

    /**
     * @return mixed
     */
    public function getPremierDate()
    {
        return $this->premierDate;
    }

    /**
     * @param mixed $premierDate
     */
    public function setPremierDate($premierDate)
    {
        $this->premierDate = $premierDate;
    }

    public function exist($id){
      $query = $this->db->get_where('tmdbmovies', array('MovieID' => $id ));
      $count = $query->num_rows();
      if ($count === 0) {
          return false;
      } else {
        return true;
      }
    }

    public function setTmdbMovie($tmdbMovie)
    {
        //var_dump($tmdbMovie);die();
        $this->id = $tmdbMovie['MovieID'];
        $this->title = $tmdbMovie['Title'];
        $this->description = $tmdbMovie['Description'];
        $this->popularity = $tmdbMovie['Popularity'];
        $this->trailer = $tmdbMovie['Trailer'];
        $this->poster = $tmdbMovie['Poster'];
        $this->voteAverage = $tmdbMovie['vote_average'];
        $this->premierDate = $tmdbMovie['Premiere_date'];
        //var_dump($this);die();
    }
}
