<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Token extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->library("jwt");
  }
  public function tokenIsValid($token){
    try {
      $encrypted = $this->jwt->decode($token, 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', false);

      $loggin_time = new DataTime($encrypted->issuedAt, 'DATE_ISO8601');
      $expiries = $loggin_time->add(new DateInterval('PT' . $encrypted->ttl));
      $timeToExpire = time() - strtotime($expiries->getTimestamp());
      if ($timeToExpire <= 0){
        return -1;
      }

      return $encrypted->userId;
    } catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
      return -1;
    }
  }

  public function generateToken($user_id){
      $CONSUMER_KEY = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
      $CONSUMER_SECRET = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
      $CONSUMER_TTL = 86400;
      return $this->jwt->encode(array(
        'consumerKey'=>$CONSUMER_KEY,
        'userId'=>$user_id,
        'issuedAt'=>date(DATE_ISO8601, strtotime("now")),
        'ttl'=>$CONSUMER_TTL
      ), $CONSUMER_SECRET);
  }
}
?>
