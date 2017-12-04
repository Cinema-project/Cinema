<?php

class Event_model extends CI_Model
{
	
	private $id_event;
	private $time;
	private $id_cinema;
	private $movie_title;
	
	public function __construct($id = null)
    {
        if($id != null)
		{
            $sql = "SELECT * FROM events WHERE id_event = ?";
            $event = $this->db->query($sql, $id)->result_array()[0];
            if(!empty($event)) {
                $this->setEvent($event);
            }
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
	
	public function setEvent($event)
    {
	    $this->time = $event[0]['time'];
	    $this->id_cinema = $event[0]['id_cinema'];
	    $this->id_movie = $event[0]['movie_title'];
    }
	
}


?>