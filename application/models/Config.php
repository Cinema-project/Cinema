<?php

class Config extends CI_Model {
  /**
   * @method insert
   * @param  string $name nazwa zmiennej
   * @param  string $date data
   * @return boolean Wynik akcji
   */
  public function insert($name, $date){
    return $this->db->insert('config', array('name' => $name, 'date' => $date));
  }
  /**
   * @method get
   * @param mixed $value jeżeli int to pobieranie po id jeżeli string to pobieranie po nazwie
   * @return array tablica wierszy zapytania
   */
  public function get($value){
    $this->db->select('*')->from('config');
    if (is_numeric($value)){
      $this->db->where('id', $value);
    } else {
      $this->db->where('name', $name);
    }
    return $this->db->get()->result();
  }
  /**
   * update
   * @param  mixed $value jeżeli int to aktualizacja po id jeżeli string to aktualizacja po nazwie
   * @param  string $date  data
   * @return boolean Wynik akcji
   */
  public function update($value, $date){
    $this->db->set('date', $date);
    if (is_numeric($value)){
      $this->db->where('id', $value);
    } else {
      $this->db->where('name', $value);
    }
    return $this->db->update('config');
  }
}

?>
