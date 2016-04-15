<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_question extends CI_Model {

  private $TABLE = "question";

  public function __construct()
  {
    parent::__construct();
  }

  //-----------
  //    SELECT
  //-----------
  //get question
  public function get($qid)
  {
    $this->db->select('*');
    $this->db->where('qid', $qid);
    $query = $this->db->get($this->TABLE);
    $row = $query->row_array();
    if ($row == null)
    {
      if (intval($qid) == ($this->count("all") + 1))
      {
        return "MAX";
      }
      else {
        return null;
      }
    }
    else {
      return $row;
    }
  }

  // get by type
  public function getByType($type)
  {
    $type_cn;
    switch($type)
    {
      case "all":
        return $this->getAll();
        break;
      // single choice
      case "sc":
        $type_cn = "单选";
        break;
      // multi choice
      case "mc":
        $type_cn = "多选";
        break;
      // judgement (y/n)
      case "jg":
        $type_cn = "判断";
        break;
      default:
        return null;
    }
    $this->db->select('*');
    $this->db->where('type', $type_cn);
    $this->db->order_by('qid', 'ASC');
    $query = $this->db->get($this->TABLE);
    return $query->result_array();
  }

  // get all
  public function getAll()
  {
    $this->db->select('*');
    $query = $this->db->get($this->TABLE);
    $array = $query->result_array();
    return $array;
  }

  // count line numbers
  public function count($type)
  {
    switch($type)
    {
      case "all":
        return $this->db->count_all($this->TABLE);
        break;
      // single choice
      case "sc":
        $this->db->select('qid');
        $this->db->where('type', '单选');
        $this->db->from($this->TABLE);
        return $this->db->count_all_results();
        break;
      // multi choice
      case "mc":
        $this->db->select('qid');
        $this->db->where('type', '多选');
        $this->db->from($this->TABLE);
        return $this->db->count_all_results();
        break;
      // judgement (y/n)
      case "jg":
        $this->db->select('qid');
        $this->db->where('type', '判断');
        $this->db->from($this->TABLE);
        return $this->db->count_all_results();
        break;
      default:
        return null;
    }
  }
  //-----------
  //    INSERT
  //-----------
  // add list of questions
  public function add($raw)
  {
    $data['type']       = trim($raw[0]);
    $data['question']   = trim($raw[1]);

    $option;
    for ($i = 2; $i < 7; $i++)
    {
      if (array_key_exists($i,$raw))
      {
        $option[$i - 2] = trim($raw[$i]);
      }
      else {
        $option[$i - 2] = "";
      }
    }
    $data['option_1']  = $option[0];
    $data['option_2']  = $option[1];
    $data['option_3']  = $option[2];
    $data['option_4']  = $option[3];
    $data['option_5']  = $option[4];

    return $this->db->insert($this->TABLE, $data);
  }
  //-----------
  //    DELETE
  //-----------

  // clear table (truncate will also reset PK)
  public function clear()
  {
    $this->db->truncate($this->TABLE);
  }


}
