<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 03.12.2017
 * Time: 19:56
 */

class Role_model extends CI_Model
{
    private $id;
    private $name;

    public function __construct($id = null)
    {
        if($id != null) {
            $sql = "SELECT * FROM roles WHERE RoleId = ?";
            $role = $this->db->query($sql, $id)->result_array()[0];
            if(!empty($role))
            {
                $this->id = $role[0]['RoleId'];
                $this->name = $role[0]['Name'];
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