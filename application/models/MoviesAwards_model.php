<?php

class MoviesAwards_model extends CI_Model
{
	private $id_movie;
	private $id_award;
	
	
	public function __construct($id = null)
    {
        if($id != null)
		{
			
		}
	}
	
	
	
	
	
	public function getMovieId()
    {
        return $this->id_movie;
    }
	////////////////////////
	public function getAwardId()
    {
        return $this->id_award;
    }
	
	
	//////////////////////////////
	
	
}




?>