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
     * get question by a given type string
     * ASC by question_id
     * @param $typeString, can be 'jd' = judgement, 'sc' = single choice, 'mc' = multiple choice
     * @return array
     */
    public function getByTypeString ($typeString)
    {
        if (!$this->validTypeString($typeString))
        {
            return false;
        }
        $this->db->select('*');
        $this->db->where('question_type', $typeString);
        $this->db->order_by('question_id', 'ASC');
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
        if (!$this->validTypeString($typeString))
        {
            return false;
        }
        $this->db->select('*');
        $this->db->where('question_type', $typeString);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    //-----------
    //    INSERT
    //-----------
    /**
    * add a question to database
    * @since v0.1.0
    * @param $typeString,    question type, can be 'jd' for judgement, 'sc' for single choice,
    *                    'mc' for multiple choice
    * @param $question,  question content
    * @param $options,   array of options, count($options) == 10, set to '' if option not available
    * @param $scores,    array of scores corresponding to options, count($scores) == 10, set to 0 if option not available
    * @return mixed
    */
    public function add ($typeString, $question, $options, $scores)
    {
        // we need 10 options & 10 scores, set empty options as ''
        if (count($options) != 10 || count($scores) != 10)
        {
          return false;
        }
        // type must be 'jd', 'sc' or 'mc'
        else if (!$this->validTypeString($typeString))
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
            $data['question_type']      = trim($typeString);
            $data['question_content']  = trim($question);
            $data['option_1']  = trim($options[0]);
            $data['option_2']  = trim($options[1]);
            $data['option_3']  = trim($options[2]);
            $data['option_4']  = trim($options[3]);
            $data['option_5']  = trim($options[4]);
            $data['option_6']  = trim($options[5]);
            $data['option_7']  = trim($options[6]);
            $data['option_8']  = trim($options[7]);
            $data['option_9']  = trim($options[8]);
            $data['option_10'] = trim($options[9]);

            $data['score_1']    = trim($scores[0]);
            $data['score_2']    = trim($scores[1]);
            $data['score_3']    = trim($scores[2]);
            $data['score_4']    = trim($scores[3]);
            $data['score_5']    = trim($scores[4]);
            $data['score_6']    = trim($scores[5]);
            $data['score_7']    = trim($scores[6]);
            $data['score_8']    = trim($scores[7]);
            $data['score_9']    = trim($scores[8]);
            $data['score_10']   = trim($scores[9]);

            return $this->db->insert($this->table, $data);
        }
    }
    //-----------
    //    DELETE
    //-----------
    /**
     * delete a question by its id (not recommended, this will cause the question to be incautious)
     * @since v0.1.0
     * @param $question_id
     * @return bool
     */
    public function deleteById ($question_id)
    {
        if (!$this->idExists($question_id))
        {
            return false;
        }
        else
        {
            $this->db->where('question_id', $question_id);
            return $this->db->delete($this->table);
        }
    }

    /**
     * delete question by given type string
     * @since v0.1.0
     * @param $typeString
     * @return bool
     */
    public function deleteByTypeString ($typeString)
    {
        if (!$this->validTypeString($typeString))
        {
            return false;
        }
        else
        {
            $this->db->where('question_type', $typeString);
            return $this->db->delete($this->table);
        }
    }
    /**
    * truncate this table
    * @since v0.1.0
    * @return bool
    */
    public function truncate ()
    {
        $this->db->truncate($this->table);
    }

    //-----------
    //   Functions which does not interact with database
    //-----------
    /**
     * if a given type string is valid (equals 'jd', 'sc' or 'mc')
     * @param $typeString
     * @return bool
     */
    public function validTypeString ($typeString)
    {
        if ($typeString == 'jd' || $typeString == 'sc' || $typeString == 'mc')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}