
<?php

class Cinemas_model extends CI_Model
{
	
	private $id_cinema;
	private $name;
	private $locationEW;
	private $locationNS:
	
	public function __construct($id = null)
    {
        if($id != null)
		{
			$sql = "SELECT * FROM cinemas WHERE id_cinema = ?";
            $cinemas = $this->db->query($sql, $id)->result_array()[0];
			
			$this->id_cinema = $cinemas['id_cinema'];
			$this->name = $cinemas['name'];
		    $this->locationEW = $cinemas['locationEW'];
		    $this->locationNS = $cinemas['locationNS'];
			
		}
	
	
	}
	
	
	
	public function getCinemaId()
    {
        return $this->id_cinema;
    }
	////////////////////
	
	public function getName()
    {
        return $this->name;
    }
	
    public function setName($name)
    {
        $this->name = $name;
    }
	//////////////////////////////
	public function getLocationEW()
    {
        return $this->locationEW;
    }
	
    public function setLocationEW($locationEW)
    {
        $this->locationEW = $locationEW;
    }
	///////////////////////////////////
	public function getLocationNS()
    {
        return $this->locationNS;
    }
	
    public function setLocationNS($locationNS)
    {
        $this->locationNS = $locationNS;
    }
	//////////////////////////////////////
	
	
	
}
















?>