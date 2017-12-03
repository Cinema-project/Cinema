<?php

class Event_model extends CI_Model
{
	
	private $id_event;
	private $time;
	private $id_cinema;
	private $id_movie;
	
	public function __construct($id = null)
    {
        if($id != null)
		{
			
		}
	
	
	}
	
	public function getEventId()
    {
        return $this->id_event;
    }
	////////////////////
	
	public function getTime()
    {
        return $this->time;
    }
	
    public function setTime($time)
    {
        $this->time = $time;
    }
	//////////////////////////
	public function getIdCinema()
	{
		return $this->id_cinema;
	}
	public function setIdCinema($id_cinema)
    {
        $this->id_cinema = $id_cinema;
    }
	///////////////////////////////
	public function getIdMovie()
	{
		return $this->id_movie;
	}
	public function setIdMovie($id_movie)
    {
        $this->id_movie = $id_movie;
    }
	////////////////////////////////
	
	
	
}


?>