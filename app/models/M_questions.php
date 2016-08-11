<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class M_questions
 * model which interacts with table 'questions'
 * each row is corresponding to a question you can set questions by downloading & editing the Excel template
 * @since v0.1.0
 * @author bcli, 2016-8-10
 */

class M_questions extends CI_Model {

  private $table = "questions"; // table name

  public function __construct()
  {
    parent::__construct();
  }

    //-----------
    //    SELECT
    //-----------
    /**
    * get everything from database
    * ASC by 'question_id'
    * @since v0.1.0
    * @return array
    */
    public function getAll ()
    {
        $this->db->select('*');
        $this->db->order_by('question_id', 'ASC');
        $query = $this->db->get($this->table);
        $array = $query->result_array();
        return $array;
    }

    /**
     * get question by given question_id
     * @param $question_id
     * @return array
     */
    public function getById ($question_id)
    {
        $this->db->select('*');
        $this->db->where('question_id', $question_id);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * get question by given type string
     * ASC by question_id
     * @param $typeString, can be 'jd' = judgement, 'sc' = single choice, 'mc' = multiple choice
     * @return array
     */
    public function getByTypeString ($typeString)
    {
        $this->db->select('*');
        $this->db->where('type', $typeString);
        $this->db->order_by('question-id', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * if a given question id exists
     * @param $question_id
     * @return bool
     */
    public function idExists ($question_id)
    {
        $this->db->select("*");
        $this->db->where('question_id', $question_id);
        $this->db->from($this->table);
        $num = $this->db->count_all_results();
        if ($num != 0)
        {
            return true;
        }
        else
        {
            return false;
        }
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
     * count questions by type string
     * @param $typeString, can be 'jd' for judgement, 'sc' for single choice, 'mc' for multiple choice
     * @return mixed
     */
    public function countByTypeString ($typeString)
    {
        $this->db->select('*');
        $this->db->where('type', $typeString);
        $this->db->from($this->table);
        return $this->db->count_all_results();
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