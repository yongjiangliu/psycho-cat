<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class M_exams
 * model which interacts with table 'exams'
 * each row is corresponding to a subject/exam paper,
 * resume code is unique
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
   * get record by name of subject
   * DESC by 'finish_at'
   * @since v0.1.0
   * @param $name
   * @return array
   */
  public function getByName ($name)
  {
    $this->db->select('*');
    $this->db->where('subject_name', $name);
    $this->db->order_by('finish_at', 'DESC');
    $query = $this->db->get($this->table);
    return $query->result_array();
  }

  /**
   * get record by gender of the subject
   * DESC by 'finish_at'
   * @since v0.1.0
   * @param $genderCode, 1 = male, 0 = female
   * @return array
   */
  public function getByGenderCode ($genderCode)
  {
    $this->db->select('*');
    $this->db->where('subject_gender', $genderCode);
    $this->db->order_by('finish_at', 'DESC');
    $query = $this->db->get($this->table);
    return $query->result_array();
  }

    /**
     * get record by martial status of the subject
     * DESC by 'finish_at'
     * @since v0.1.0
     * @param $marriageCode, 1 = married, 0 = unmarried
     * @return mixed
     */
    public function getByMarriageCode ($marriageCode)
    {
        $this->db->select('*');
        $this->db->where('subject_marriage', $marriageCode);
        $this->db->order_by('finish_at', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

  /**
   * get record by education level of subject
   * DESC by 'finish_at'
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
   * get record by blood type of subject
   * DESC by 'finish_at'
   * @since v0.1.0
   * @param $bloodType
   * @return array
   */
  public function getByBloodType ($bloodType)
  {
    $this->db->select('*');
    $this->db->where('subject_blood_type', $bloodType);
    $this->db->order_by('finish_at', 'DESC');
    $query = $this->db->get($this->table);
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
    $this->db->where('subject_age', $age);
    $query = $this->db->get($this->table);
    return $query->result_array();
  }
    /**
     * get record within a given age range of subject
     * @since v0.1.0
     * @param $minAge
     * @param $maxAge
     * @return array
     */
    public function getByAgeWithinRange ($minAge, $maxAge)
    {
        $this->db->select('*');
        $this->db->where('subject_age >=', $minAge);
        $this->db->where('subject_age <=', $maxAge);
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
    $query = $this->db->get($this->table);
    return $query->result_array();
  }

    /**
     * get record by a given resume code & name pair
     * @since v0.1.0
     * @param $resume_code
     * @param $name
     * @return mixed
     */
    public function getByResumeCodeAndName ($resume_code, $name)
    {
        $this->db->select('*');
        $this->db->where('resume_code', $resume_code);
        $this->db->where('name',        $name);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

  /**
   * get all exam papers submitted at a certain datetime
   * @since v0.1.0
   * @param $datetime
   * @return array
   */
  public function getByFinishTime ($datetime)
  {
    $this->db->select('*');
    $this->db->where('finished', 1);
    $this->db->where('finish_at', $datetime);
    $query = $this->db->get($this->table);
    return $query->result_array();
  }

  /**
   * get all exam papers submitted within a time period
   * @since v0.1.0
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
    $this->db->where('subject_name', $name);
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
   * if a given resume code as been assigned
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

    /**
     * whether a given exam_id & resume_code pair exists
     * @since v0.1.0
     * @param $exam_id
     * @param $resume_code
     * @return bool
     */
    public function resumeCodeCorrect ($exam_id, $resume_code)
    {
        $this->db->select("*");
        $this->db->where('exam_id', $exam_id);
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

    public function countAll ()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function countFinished ()
    {
        $this->db->select('*');
        $this->db->where('finished', 1);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function countUnfinished ()
    {
        $this->db->select('*');
        $this->db->where('finished', 0);
        $this->db->from($this->table);
        return $this->db->count_all_results();
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
  public function add ($name, $occupation, $gender, $birthday, $age, $education, $bloodType,
                       $marriage, $resume_code, $created_from, $created_at)
  {
    if ($this->nameExists($name))
    {
        return false;
    }
    else
    {
        $data = array(
            "subject_name"          =>  $name,
            "subject_occupation"    =>  $occupation,
            "subject_gender"        =>  intval($gender),
            "subject_birthday"      =>  $birthday,
            "subject_age"           =>  $age,
            "subject_education"     =>  intval($education),
            "subject_blood_type"    =>  $bloodType,
            "subject_marriage"      =>  intval($marriage),
            "finished"              =>  0,
            "question_id"           =>  1,
            "resume_code"           =>  $resume_code,
            "created_from"          =>  $created_from,
            "created_at"            =>  $created_at
        );
        return $this->db->insert($this->table, $data);
    }
  }
  //-----------
  //    UPDATE
  //-----------
  /**
   * [important]
   * append a new answer to 'answer_array', delimiter of each answer is ' '
   * @since v0.1.0
   * @param $exam_id,   which exam to add the answer to
   * @param $answer, answer to be added
   * @return bool
   */
  public function appendAnswer ($exam_id, $answer)
  {
      if (!$this->idExists($exam_id))
      {
          return false;
      }
      else
      {
          $query = "update ".$this->table.
              " set answer_array = concat (answer_array,' ','".
              $answer."') where exam_id = ".$exam_id;
          if ($this->db->simple_query($query))
          {
              return true;
          }
          else
          {
              return false;
          }
      }
  }

  /**
   * set exam start time
   * @since v0.1.0
   * @param $exam_id,   which exam_id to modify
   * @param $start_at,  exam start time (datetime)
   * @return bool
   */
  public function setStartTime ($exam_id)
  {
    if (!$this->idExists($exam_id))
    {
      return false;
    }
    else
    {
      $this->db->set('start_at', date("Y-m-d H:i:s"));
      $this->db->where('exam_id', $exam_id);
      return $this->db->update($this->table);
    }
  }

  /**
   * set exam finish time
   * @since v0.1.0
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
   * @since v0.1.0
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
      if ($this->db->update($this->table))
      {
          return $this->setFinishTime ($exam_id, date("Y-m-d H:i:s"));
      }
      else
      {
          return false;
      }
    }
  }

    /**
     * update question_id
     * @param $exam_id
     * @param $question_id
     * @return bool
     */
    public function setQuestionId ($exam_id, $question_id)
    {
        if (!$this->idExists($exam_id))
        {
            return false;
        }
        else
        {
            $this->db->set('question_id', $question_id);
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
        if (!$this->idExists($exam_id))
        {
            return false;
        }
        else
        {
            $this->db->where('exam_id', $exam_id);
            return $this->db->delete($this->table);
        }
    }

  /**
   * delete exam records according to the name of the subject
   * @since v0.1.0
   * @param $name,  name of the subject
   * @return bool
   */
    public function deleteByName ($name)
    {
        if (!$this->nameExists($name))
        {
            return false;
        }
        else
        {
            $this->db->where('subject_name', $name);
            return $this->db->delete($this->table);
        }
    }
    /**
     * delete all exam records submitted BEFORE a given datetime
     * @since v0.1.0
     * @param $datetime
     * @return bool
     */
    public function deleteBeforeDatetime ($datetime)
    {
      $this->db->where('finish_at <=', $datetime);
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
