<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 17.12.2017
 * Time: 12:59
 */

class TmdbMovieList_model extends CI_Model
{
    private $movieList = array();

    /**
     * @return array
     */
    public function getMovieList()
    {
        return $this->movieList;
    }

    /**
     * @param array $movieList
     */
    public function setMovieList($movieList)
    {
        $this->movieList = $movieList;
    }

    public function selectByGenre($genreName = null, $sortBy = null, $offset = 0)
    {
        if($genreName != null)
        {
            $sql = "SELECT id_genre FROM genres WHERE name = ?";
            $genreId = $this->db->query($sql, $genreName)->result_array()[0];
            if($genreId != null)
            {
                if($sortBy == null)
                {
                    $sql = "SELECT * FROM tmdbmovies JOIN genres_movie ON tmdbmovies.MovieID = genres_movie.id_movie WHERE id_genre = ? LIMIT 20 OFFSET ?";
                    $movies = $this->db->query($sql, $genreId, $offset*20)->result_array();
                }
                else
                {
                    $sql = "SELECT * FROM tmdbmovies JOIN genres_movie ON tmdbmovies.MovieID = genres_movie.id_movie WHERE id_genre = ? ORDER BY ? LIMIT 20 OFFSET ?";
                    $movies = $this->db->query($sql, $genreId, $sortBy, $offset*20)->result_array();
                }
                foreach ($movies as $movie) {
                    $movieModel = new Tmdbmovie_model();
                    $movieModel->setTmdbMovie($movie);
                    $this->movieList[] = $movieModel;
                }
            }
        }
    }

    public function selectByTime($startTime = null, $endTime = null, $sortBy = null, $offset = 0)
    {
        if($startTime != null && $endTime != null)
        {
            if($sortBy == null)
            {
                $sql = "SELECT * FROM tmdbmovies WHERE Premiere_date BETWEEN ? AND ? LIMIT 20 OFFSET ?";
                $movies = $this->db->query($sql, $startTime, $endTime, $offset*20)->result_array();
            }
            else {
                $sql = "SELECT * FROM tmdbmovies WHERE Premiere_date BETWEEN ? AND ? ORDER BY ? LIMIT 20 OFFSET ?";
                $movies = $this->db->query($sql, $startTime, $endTime, $sortBy, $offset*20)->result_array();
            }
            if($movies != null)
            {
                foreach ($movies as $movie) {
                    $movieModel = new Tmdbmovie_model();
                    $movieModel->setTmdbMovie($movie);
                    $this->movieList[] = $movieModel;
                }
            }
        }
    }

}
