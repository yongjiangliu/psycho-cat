<?php
// Add this line to avoid direct script access
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Admin Table Model
* @author bcli, 2016-4-24
* @since v1.0
*/
class M_admin extends CI_Model
{
  // table name
  private $TABLE = "admin";
  /**
  * CI model constructor
  */
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
