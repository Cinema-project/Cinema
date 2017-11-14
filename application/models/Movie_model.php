<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 12.11.2017
 * Time: 20:35
 */

class Movie_model extends CI_Model
{
    private $movieId;
    private $director;
    private $title;
    private $typeId;
    private $length;
    private $description;
    private $premiereDate;

    /**
     * Movie_model constructor.
     */
    public function __construct($id = null)
    {
        if ($id != null)
        {
            $this->load->model('Director_model');
            $sql = "SELECT * FROM movies WHERE MovieId = ?";
            $movie = $this->db->query($sql, $id)->result_array()[0];
            $this->movieId = $movie['MovieId'];
            $this->director = new Director_model($movie['DirectorId']);
            $this->title = $movie['Title'];
            $this->typeId = $movie['TypeId'];
            $this->length = $movie['Length'];
            $this->description = $movie['Description'];
            $this->premiereDate = $movie['PremiereDate'];
        }
    }

    /**
     * @return mixed
     */
    public function getMovieId()
    {
        return $this->movieId;
    }

    /**
     * @return mixed
     */
    public function getDirectorId()
    {
        return $this->DirectorId;
    }

    /**
     * @param mixed $DirectorId
     */
    public function setDirectorId($DirectorId)
    {
        $this->DirectorId = $DirectorId;
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
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param mixed $typeId
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length)
    {
        $this->length = $length;
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
    public function getPremiereDate()
    {
        return $this->premiereDate;
    }

    /**
     * @param mixed $premiereDate
     */
    public function setPremiereDate($premiereDate)
    {
        $this->premiereDate = $premiereDate;
    }




}