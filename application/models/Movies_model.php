<?php

class Movies_model extends CI_Model
{
	private $id_movie;
	private $id_director;
	private $title;
	private $id_type;
	
	private $length;
	private $description;
	private $premiereDate;
	
	
	public function __construct($id = null)
    {
        if($id != null)
		{
			$this->load->model('Director_model');
            $sql = "SELECT * FROM movies WHERE MovieId = ?";
            $movies = $this->db->query($sql, $id)->result_array()[0];
			
			$this->id_movie = $movies['MovieId'];
			$this->id_director = new Director_model($movies['DirectorId']);
			
			$this->title = $movies['Title'];
			$this->id_type = $movies['TypeId'];
			$this->length = $movies['Length'];
			$this->description = $movies['Description'];
			$this->premiereDate = $movies['PremiereDate'];
			
			
		}
	}
	
	
	public function getMovieId()
    {
        return $this->id_movie;
    }
	/////////////////////////
	public function getDirectorId()
    {
        return $this->id_director;
    }
	
	public function setDirectorId($id_director)
	{
		$this->id_director = $id_director;
	}
	
	//////////////////////////////
	
	public function getTitle()
    {
        return $this->title;
    }
	
    public function setTitle($title)
    {
        $this->title = $title;
    }
	//////////////////////////
	public function getTypeId()
    {
        return $this->title;
    }
	
    public function setTypeId($id_type)
    {
        $this->id_type = $id_type;
    }
	///////////////////////////
	public function getLength()
    {
        return $this->length;
    }
	
    public function setLength($length)
    {
        $this->length = $length;
    }
	///////////////////////////
	public function getDescription()
    {
        return $this->description;
    }
	
    public function setDescription($description)
    {
        $this->description = $description;
    }
	///////////////////////////////
	
	public function getPremiereDate()
    {
        return $this->premiereDate;
    }
	
    public function setPremiereDate($premiereDate)
    {
        $this->premiereDate = $premiereDate;
    }
	
	
	//////////////////////////////////////
}



?>