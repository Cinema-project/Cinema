<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 03.12.2017
 * Time: 19:49
 */

class Genre_model extends CI_Model
{
    private $id;
    private $name;

    /**
     * Genre_model constructor.
     * @param $id
     */
    public function __construct($id = null)
    {
        if($id != null) {
            $sql = "SELECT * FROM genres WHERE id_genre = ?";
            $genre = $this->db->query($sql, $id)->result_array()[0];
            if(!empty($genre))
            {
                $this->id = $genre[0]['id_genre'];
                $this->name = $genre[0]['name'];
            }
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

}