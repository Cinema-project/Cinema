<?php

class Awards_model extends CI_Model
{
	private $id_award;
	private $name;
	private $category;
	
	public function __construct($id = null)
    {
        if($id != null)
		{
			$sql = "SELECT * FROM awards WHERE AwardId = ?";
            $awards = $this->db->query($sql, $id)->result_array()[0];
			
			
			$this->id_award = $moviestmdb['AwardId'];
			$this->name = $moviestmdb['Name'];
			$this->category = $moviestmdb['Category'];
		}
	}
	
	
	public function getAwardId()
    {
        return $this->id_award;
    }
	////////////////////////
	public function getName()
    {
        return $this->name;
    }
   
    public function setName($name)
    {
        $this->name = $name;
    }
	//////////////////////////////
	
	public function getCategory()
    {
        return $this->category;
    }
   
    public function setCategory($category)
    {
        $this->category = $category;
    }
	///////////////////////////
}


?>