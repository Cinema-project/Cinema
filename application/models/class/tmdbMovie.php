<?php

class tmdbMovie {
  public $MovieID;
  public $Title;
  public $Description;
  public $Popularity;
  public $Poster;
  public $Trailer;
  public $vote_average;
  public $Premiere_date;
  public $runtime;
  public function __construct($id, $title, $des, $pop, $pos, $tra, $vote, $premi, $time){
    $this->MovieID = $id;
    $this->Title = $title;
    $this->Description = $des;
    $this->Popularity = $pop;
    $this->Poster = $pos;
    $this->Trailer = $tra;
    $this->vote_average = $vote;
    $this->Premiere_date = $premi;
    $this->runtime = $time;
  }
}

?>
