<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 03.12.2017
 * Time: 20:00
 */

class Tmdbmovie_model extends CI_Model
{
    private $id;
    private $title;
    private $description;
    private $popularity;
    private $poster;
    private $trailer;
    private $voteAverage;
    private $premierDate;

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

    public function save()
    {
        if ($this->title != null && $this->description != null && $this->popularity != null && $this->poster != null
            && $this->trailer != null && $this->voteAverage != null && $this->premierDate != null)
        {
            $data = array(
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

    private function setTmdbMovie($tmdbMovie)
    {
        $this->id = $tmdbMovie[0]['MovieID'];
        $this->title = $tmdbMovie[0]['Title'];
        $this->description = $tmdbMovie[0]['Description'];
        $this->popularity = $tmdbMovie[0]['Popularity'];
        $this->Trailer = $tmdbMovie[0]['Trailer'];
        $this->voteAverage = $tmdbMovie[0]['vote_average'];
        $this->premierDate = $tmdbMovie[0]['Premiere_date'];
    }
}