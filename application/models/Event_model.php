<?php

class Event_model extends CI_Model
{

	private $id_event;
	private $time;
	private $id_cinema;
	private $movie_id;
	private $link;

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
	public function setLink($link){
		$this->link = $link;
	}

	public function removeOldEvent()
	{
		$actualDate = date("Y-m-d H:i:s");
		$this->db->where('time <', $actualDate);
		$this->db->delete('events');
	}
	/**
	 * Pobiera filmy grane w Multikinie
	 * @method getNowPlaying
	 * @param  int $count ilość filmów na stronie
	 * @param  int $page strona
	 * @return array filmy
	 */
	public function getNowPlaying($count, $page){
		$query = $this->db->select('tmdbmovies.*, events.movie_id')->
											from('events')->
											join('cinemamovies', 'events.movie_id = cinemamovies.movie_id')->
											join('tmdbmovies', 'cinemamovies.tmdbmovie_id = tmdbmovies.MovieID')->
											group_by('events.movie_id')->
											limit($count, $page*$count)->
											get()->
											result_array();
			$result = array();
			foreach ($query as $movie) {
					$movieModel = new Tmdbmovie_model();
					$movieModel->setTmdbMovie($movie);
					$result[] = $movieModel;
			}
			return $result;
	}

	public function save()
    {
        if ($this->time != null && $this->id_cinema != null && $this->movie_id != null)
        {
            $data = array(
                'time' => $this->time,
                'id_cinema' => $this->id_cinema,
                'movie_id' => $this->movie_id,
								'link' => $this->link
            );
            $this->db->insert('events', $data);
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
        $this->movie_id = $id_movie;
    }
	////////////////////////////////

	public function setEvent($event)
    {
	    $this->time = $event[0]['time'];
	    $this->id_cinema = $event[0]['id_cinema'];
	    $this->movie_id = $event[0]['movie_id'];
			$this->link = $event[0]['link'];
    }
	public function getRepertoire(){
		return $this->db->slect('events.time, events.link, cinemas.name, tmdbmovies.*')->
											from('events')->
											join('cinemas', 'cinemas.id_cinema = events.id_cinema')->
											join('cinemamovies', 'events.movie_id = cinemamovies.movie_id')->
											join('tmdbmovies', 'tmdbmovies.MovieId = cinemamovies.tmdbmovie_id')->
											get()->result();
	}

}


?>
