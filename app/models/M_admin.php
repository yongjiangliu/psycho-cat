<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

  private $TABLE = "admin";

  public function __construct()
  {
    parent::__construct();
  }
  //-----------
  //    SELECT
  //-----------
  // fetch admin data
  public function get($username, $password)
  {
    $this->db->select('*');
    $this->db->where('username', $username);
    $this->db->where('password', $password);
    $query = $this->db->get($this->TABLE);
    $row = $query->row_array();
    return $row;
  }
  //-----------
  //    INSERT
  //-----------
  //-----------
  //    UPDATE
  //-----------
  //-----------
  //    DELETE
  //-----------

}
