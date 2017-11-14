<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 12.11.2017
 * Time: 17:11
 */
class Role_model extends CI_Model
{
    private $id;
    private $name;

    /**
     * Role_model constructor.
     * @param $id
     */
    public function __construct($id = null)
    {
        if ($id != null)
        {
            $sql = "SELECT * FROM roles WHERE RoleId = ?";
            $role = $this->db->query($sql, $id)->result_array()[0];

            $this->id = $role['RoleId'];
            $this->name = $role['Name'];
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