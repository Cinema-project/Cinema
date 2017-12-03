
<?php

class Moviestmdb_model extends CI_Model
{
	private $id_movie;
	private $title;
	private $description;
	private $popularity;
	
	private $poster;
	private $trailer;
	private $vote_Average;
	private $premiere_Date;
	
	 /**
     * Director_model constructor.
     * @param $id
     */
    public function __construct($id = null)
    {
        if($id != null)
        {
            $sql = "SELECT * FROM moviestmdb WHERE MovieID = ?";
            $moviestmdb = $this->db->query($sql, $id)->result_array()[0];
			
            $this->id_movie = $moviestmdb['MovieID'];
            $this->title = $moviestmdb['Title'];
            $this->description = $moviestmdb['Description'];
            $this->popularity = $moviestmdb['Popularity'];
			
			$this->poster = $moviestmdb['Poster'];
			$this->trailer = $moviestmdb['Trailer'];
			$this->vote_Average = $moviestmdb['vote_average'];
			$this->premiere_Date = $moviestmdb['Premiere_date'];
			
        }
    }
   
    public function getMovieId()
    {
        return $this->id_movie;
    }
   
	////////////////////////////////////
    public function getTitle()
    {
        return $this->title;
    }
   
    public function setTitle($title)
    {
        $this->title = $title;
    }
	//////////////////////////////////
    public function getDescription()
    {
        return $this->description;
    }
  
	public function setDescription($description)
    {
        $this->description = $description;
    }
	////////////////////////////////////////
    public function getPopularity()
    {
        return $this->popularity;
    }
	
	public function setPopularity($popularity)
    {
        $this->popularity = $popularity;
    }
	//////////////////////////////
	public function getPoster()
    {
        return $this->poster;
    }
	
	public function setPoster($poster)
    {
        $this->poster = $poster;
    }
	///////////////////////////////
	public function getTrailer()
    {
        return $this->trailer;
    }
	
	public function setTrailer($trailer)
    {
        $this->trailer = $trailer;
    }
	///////////////////////////////
	public function getVote_Average()
    {
        return $this->vote_Average;
    }
	
	public function setVote_Average($vote_Average)
    {
        $this->vote_Average = $vote_Average;
    }
	/////////////////////////////
	
	
	public function getPremiere_Date()
    {
        return $this->premiere_Date;
    }
	
	public function setPremiere_Date($premiere_Date)
    {
        $this->premiere_Date = $premiere_Date;
    }
	////////////////////////////////
}






?>