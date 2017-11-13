<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 12.11.2017
 * Time: 20:39
 */

class Director_model extends CI_Model
{
    private $id;
    private $name;
    private $surname;
    private $biography;

    /**
     * Director_model constructor.
     * @param $id
     */
    public function __construct($id = null)
    {
        if($id != null)
        {
            $sql = "SELECT * FROM directors WHERE DirectorId = ?";
            $director = $this->db->query($sql, $id)->result_array()[0];
            $this->id = $director['DirectorId'];
            $this->name = $director['Name'];
            $this->surname = $director['Surname'];
            $this->biography = $director['Biography'];
        }
    }

    /**
     * @return mixed
     */
    public function getDirectorId()
    {
        return $this->directorId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param mixed $biography
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }

}