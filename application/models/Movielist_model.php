<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 17.12.2017
 * Time: 12:59
 */

class Movielist_model extends CI_Model
{
    private $movieList = array();

    public function __construct()
    {
        $this->load->model('tmdbmovie_model');
    }

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

    public function selectMovies($genreId, $page, $count, $sort) {
      if ( $page >= 0 && $count > 0){
        if ($genreId != null){
          return $this->selectByGenre($genreId, $sort, $page, $count);
        }

        $offset = $page * $count;
        $sql = "SELECT tmdbmovies.* FROM tmdbmovies ORDER BY $sort LIMIT $offset, $count";
        $movies = $this->db->query($sql)->result_array();
        foreach ($movies as $movie) {
            $movieModel = new Tmdbmovie_model();
            $movieModel->setTmdbMovie($movie);
            $this->movieList[] = $movieModel;
        }
      }
    }

    public function selectByGenre($genreId = null, $sortBy = null, $page = 0, $count = 20)
    {
      $offset = $page*$count;
      $sql = "SELECT id_genre FROM genres WHERE name = ?";

      if($genreId != null)
      {
          if($sortBy == null)
          {
              $sql = "SELECT * FROM tmdbmovies JOIN genres_movie ON tmdbmovies.MovieID = genres_movie.id_movie WHERE id_genre = ? LIMIT $offset,20";
              $movies = $this->db->query($sql, $genreId)->result_array();
          }
          else
          {
              $sql = "SELECT * FROM tmdbmovies JOIN genres_movie ON tmdbmovies.MovieID = genres_movie.id_movie WHERE id_genre = ? ORDER BY $sortBy LIMIT $offset,20";
              $movies = $this->db->query($sql, $genreId)->result_array();
          }
          foreach ($movies as $movie) {
              $movieModel = new Tmdbmovie_model();
              $movieModel->setTmdbMovie($movie);
              $this->movieList[] = $movieModel;
          }
      }
    }

    public function selectByTime($startTime = null, $endTime = null, $sortBy = null, $count = 20, $page = 0)
    {
        $offset = $page * $count;
        if($startTime != null && $endTime != null)
        {
            if($sortBy == null)
            {
                $sql = "SELECT * FROM tmdbmovies WHERE Premiere_date BETWEEN CAST('$startTime' AS DATE) AND CAST('$endTime' AS DATE) LIMIT $count OFFSET $offset";
                $movies = $this->db->query($sql)->result_array();
            }
            else {
                $sql = "SELECT * FROM tmdbmovies WHERE Premiere_date BETWEEN CAST('$startTime' AS DATE) AND CAST('$endTime' AS DATE) ORDER BY $sortBy LIMIT $count OFFSET $offset";
                $movies = $this->db->query($sql)->result_array();
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
