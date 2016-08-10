<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_questions extends CI_Model {

  private $table = "questions";

  public function __construct()
  {
    parent::__construct();
  }

  //-----------
  //    SELECT
  //-----------

  /**
   * get all questions
   * @since v0.1.0
   * @return array
   */
  public function getAll ()
  {
    $this->db->select('');
  }


  //get question
  public function get ($qid)
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


  /**
   * count number of all questions
   * @return number
   */
  public function countAll ()
  {
    return $this->db->count_all($this->table);
  }

  /**
   * count the number of questions by type
   * @param $type,  question type, can be 'jd' for judgement, 'sc' for single choice, 'mc' for multiple choice
   * @return number
   */
  public function countByType ($type)
  {
    switch($type)
    {
      // judgement
      case 'jg':
        $this->db->select('*');
        $this->db->where('type', 'jd');
        $this->db->from($this->table);
        return $this->db->count_all_results();
      // single choice
      case 'sc':
        $this->db->select('*');
        $this->db->where('type', 'sc');
        $this->db->from($this->table);
        return $this->db->count_all_results();
      // multiple choice
      case 'mc':
        $this->db->select('qid');
        $this->db->where('type', 'mc');
        $this->db->from($this->table);
        return $this->db->count_all_results();
      default:
        return null;
    }
  }
  //-----------
  //    INSERT
  //-----------
  /**
   * add a question to database
   * @param $type,      question type, can be 'jd' for judgement, 'sc' for single choice,
   *                    'mc' for multiple choice
   * @param $question,  question content
   * @param $options,   array of options, count($options) = 10
   * @return mixed
   */
  public function add ($type, $question, $options)
  {
    // we need 10 options set
    if (count($options) != 10)
    {
      return false;
    }
    // type must be 'jd', 'sc' or 'mc'
    else if ($type != "jd" && $type != "sc" && $type != "mc")
    {
      return false;
    }
    // question content can't be empty
    else if (trim($question) == "")
    {
      return false;
    }
    else
    {
      $data['type']      = $type;
      $data['question']  = $question;
      $data['option_1']  = $options[0];
      $data['option_2']  = $options[1];
      $data['option_3']  = $options[2];
      $data['option_4']  = $options[3];
      $data['option_5']  = $options[4];
      $data['option_6']  = $options[5];
      $data['option_7']  = $options[6];
      $data['option_8']  = $options[7];
      $data['option_9']  = $options[8];
      $data['option_10'] = $options[9];
      return $this->db->insert($this->TABLE, $data);
    }
  }
  //-----------
  //    DELETE
  //-----------
  /**
   * truncate this table
   * @since v0.1.0
   * @return bool
   */
  public function truncate ()
  {
    $this->db->truncate($this->TABLE);
  }
}