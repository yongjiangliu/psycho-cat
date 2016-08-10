<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class M_exams
 * model which interacts with table 'exams'
 * each row is corresponding to a subject/exam paper, each exam paper has a unique resume code
 * @since v0.1.0
 * @author bcli, 2016-8-10
 */
class M_exams extends CI_Model {

  private $table = "exams"; // table name

  public function __construct()
  {
    parent::__construct();
  }
  //-----------
  //    SELECT
  //-----------
  /**
   * get all exam papers
   * DESC by 'finish_at'
   * @since v0.1.0
   * @return array
   */
  public function getAll ()
  {
    $this->db->select('*');
    $this->db->order_by('finish_at', 'DESC');
    $query = $this->db->get($this->table);
    $array = $query->result_array();
    return $array;
  }

  /**
   * get all finished exams papers
   * DESC by 'finish_at'
   * @since v0.1.0
   * @return array
   */
  public function getFinished ()
  {
    $this->db->select('*');
    $this->db->where('finished', 1);
    $this->db->order_by('finish_at', 'DESC');
    $query = $this->db->get($this->table);
    $array = $query->result_array();
    return $array;
  }

  /**
   * get all unfinished exam papers
   * DESC by 'start_at'
   * @since v0.1.0
   * @return array
   */
  public function getUnfinished ()
  {
    $this->db->select('*');
    $this->db->where('finished', 0);
    $this->db->order_by('start_at', 'DESC');
    $query = $this->db->get($this->table);
    $array = $query->result_array();
    return $array;
  }

  /**
   * get record by a given exam_id
   * @since v0.1.0
   * @param $exam_id
   * @return array
   */
  public function getById ($exam_id)
  {
    $this->db->select('*');
    $this->db->where('exam_id', $exam_id);
    $query = $this->db->get($this->table);
    return $query->result_array();
  }

  /**
   * get record by a given subject name
   * DESC by 'finished_at'
   * @since v0.1.0
   * @param $name
   * @return array
   */
  public function getByName ($name)
  {
    $this->db->select('*');
    $this->db->where('name', $name);
    $this->db->order_by('finish_at', 'DESC');
    $query = $this->db->get($this->table);
    return $query->result_array();
  }

  /**
   * get record by given subject gender
   * DESC by 'finished_at'
   * @since v0.1.0
   * @param $gender
   * @return array
   */
  public function getByGender ($gender)
  {
    $this->db->select('*');
    $this->db->where('subject_gender', $gender);
    $this->db->order_by('finish_at', 'DESC');
    $query = $this->db->get($this->table);
    return $query->result_array();
  }

  /**
   * get record by given subject education level
   * DESC by 'finished_at'
   * @since v0.1.0
   * @param $education
   * @return array
   */
  public function getByEducation ($education)
  {
    $this->db->select('*');
    $this->db->where('subject_education', $education);
    $this->db->order_by('finish_at', 'DESC');
    $query = $this->db->get($this->table);
    return $query->result_array();
  }

  /**
   * get record by given subject blood type
   * DESC by 'finished_at'
   * @since v0.1.0
   * @param $bloodType
   * @return array
   */
  public function getByBloodType ($bloodType)
  {
    $this->db->select('*');
    $this->db->where('subject_bloodType', $bloodType);
    $this->db->order_by('finish_at', 'DESC');
    $query = $this->db->get($this->table);
    return $query->result_array();
  }

  /**
   * get record by a given resume code
   * @since v0.1.0
   * @param $resume_code
   * @return array
   */
  public function getByResumeCode ($resume_code)
  {
    $this->db->select('*');
    $this->db->where('resume_code', $resume_code);
    $this->db->from($this->table);
    $query = $this->db->get();
    return $query->result_array();
  }

  /**
   * get record by a given subject age
   * @since v0.1.0
   * @param $age
   * @return array
   */
  public function getByAge ($age)
  {
    $this->db->select('*');
    $this->db->where('age', $age);
    $this->db->from($this->table);
    $query = $this->db-get();
    return $query->result_array();
  }

  /**
   * get record within a given subject age range
   * @since v0.1.0
   * @param $minAge
   * @param $maxAge
   * @return array
   */
  public function getByAgeWithinRange ($minAge, $maxAge)
  {
    $this->db->select('*');
    $this->db->where('age >=', $minAge);
    $this->db->where('age <=', $maxAge);
    $this->db->from($this->table);
    $query = $this->db-get();
    return $query->result_array();
  }

  /**
   * get all exam papers submitted in a certain datetime
   * @param $datetime
   * @return mixed
   */
  public function getByFinishTime ($datetime)
  {
    $this->db->select('*');
    $this->db->where('finished', 1);
    $this->db->where('finish_at', $datetime);
    $this->db->from($this->table);
    $query = $this->db-get();
    return $query->result_array();
  }

  /**
   * get all exam papers submitted within a time period
   * @param $startDatetime,  earliest time point
   * @param $endDatetime,    latest time point
   * @return array
   */
  public function getByFinishTimeWithinRange ($startDatetime, $endDatetime)
  {
    $this->db->select('*');
    $this->db->where('finished', 1);
    $this->db->where('finish_at >=', $startDatetime);
    $this->db->where('finish_at <=', $endDatetime);
    $this->db->from($this->table);
    $query = $this->db-get();
    return $query->result_array();
  }

  /**
   * if a given subject name exists
   * @since v0.1.0
   * @param $name
   * @return bool
   */
  public function nameExists ($name)
  {
    $this->db->select("*");
    $this->db->where('name', $name);
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
   * if a given exam id exists
   * @since v0.1.0
   * @param $exam_id
   * @return bool
   */
  public function idExists ($exam_id)
  {
    $this->db->select("*");
    $this->db->where('exam_id', $exam_id);
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
   * if a given resume code as been assigned to any exams
   * @since v0.1.0
   * @param $resume_code
   * @return bool
   */
  public function resumeCodeExists ($resume_code)
  {
    $this->db->select("*");
    $this->db->where('resume_code', $resume_code);
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
  //-----------
  //    INSERT
  //-----------
  /**
   * add a exam paper
   * @param $name,        subject full name
   * @param $occupation,  subject occupation
   * @param $gender,      subject gender
   * @param $birthday,    subject birthday
   * @param $education,   subject education
   * @param $bloodType,   subject blood type
   * @param $marriage,    subject martial status
   * @param $resume_code, resume code of this exam
   * @param $created_from,which IP created this record
   * @param $created_at,  when this action took place
   * @return bool
   */
  public function add ($name, $occupation, $gender, $birthday, $education, $bloodType,
                       $marriage, $resume_code, $created_from, $created_at)
  {
    $data = array(  "subject_name"          =>  $name,
                    "subject_occupation"    =>  $occupation,
                    "subject_gender"        =>  $gender,
                    "subject_birthday"      =>  $birthday,
                    "subject_education"     =>  $education,
                    "subject_bloodType"     =>  $bloodType,
                    "subject_marriage"      =>  $marriage,
                    "finished"              =>  0,
                    "question_id"           =>  1,
                    "resume_code"           =>  $resume_code,
                    "created_from"          =>  $created_from,
                    "created_at"            =>  $created_at
                  );
    return $this->db->insert($this->table, $data);
  }
  //-----------
  //    UPDATE
  //-----------
  /**
   * [important]
   * append a new answer to 'answer_array', the delimiter of answers is one whitespace ' '
   * @since v0.1.0
   * @param $exam_id,   which exam to add the answer to
   * @param $new_answer answer to be added
   * @return bool
   */
  public function appendAnswer ($exam_id, $new_answer)
  {
    $query = "update ".$this->table.
             " set answer_array = concat (answer_array,' ','".
              $new_answer."') where exam_id = ".$exam_id;
    if ($this->db->simple_query($query))
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  /**
   * set exam start time
   * @param $exam_id,   which exam_id to modify
   * @param $start_at,  exam start time (datetime)
   * @return bool
   */
  public function setStartTime ($exam_id, $start_at)
  {
    if (!$this->idExists($exam_id))
    {
      return false;
    }
    else
    {
      $this->db->set('start_at', $start_at);
      $this->db->where('exam_id', $exam_id);
      return $this->db->update($this->table);
    }
  }

  /**
   * set exam finish time
   * @param $exam_id,    which exam_id to modify
   * @param $finish_at,  when the exam is finished (datetime)
   * @return bool
   */
  public function setFinishTime ($exam_id, $finish_at)
  {
    if (!$this->idExists($exam_id))
    {
      return false;
    }
    else
    {
      $this->db->set('finish_at', $finish_at);
      $this->db->where('exam_id', $exam_id);
      return $this->db->update($this->table);
    }
  }

  /**
   * set 'finished' flag to 1, after it user will not be able to answer any questions
   * @param $exam_id,    which exam_id to modify
   * @return bool
   */
  public function finishExam ($exam_id)
  {
    if (!$this->idExists($exam_id))
    {
      return false;
    }
    else
    {
      $this->db->set('finished', 1);
      $this->db->where('exam_id', $exam_id);
      return $this->db->update($this->table);
    }
  }

    //-----------
    //    DELETE
    //-----------
  /**
   * delete exam record by exam_id
   * @since v0.1.0
   * @param $exam_id
   * @return mixed
   */
    public function deleteById ($exam_id)
    {
        $this->db->where('exam_id', $exam_id);
        return $this->db->delete($this->table);
    }

  /**
   * delete exam records according to the name of the subject
   * @since v0.1.0
   * @param $name,  name of the subject
   * @return bool
   */
    public function deleteByName ($name)
    {
        $this->db->where('name', $name);
        return $this->db->delete($this->table);
    }

    /**
     * delete all exam records submitted BEFORE a given datetime
     * @since v0.1.0
     * @param $datetime
     * @return bool
     */
    public function deleteBeforeDatetime ($time_point)
    {
      $this->db->where('finish_at <= ', $time_point);
      return $this->db->delete($this->table);
    }

    /**
     * truncate table, clear all exam records & reset primary key
     * @since v0.1.0
     * @return bool
     */
    public function truncate ()
    {
        return $this->db->truncate($this->table);
    }
}
