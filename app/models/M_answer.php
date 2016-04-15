<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_answer extends CI_Model {

  private $TABLE = "answer";

  public function __construct()
  {
    parent::__construct();
  }
  //-----------
  //    SELECT
  //-----------
  //get by aid
  public function get($aid)
  {
    $this->db->select('*');
    $this->db->where('aid', $aid);
    $query = $this->db->get($this->TABLE);
    $row   = $query->row_array();
    return $row;
  }

  // get all
  public function getAll()
  {
    $this->db->select('*');
    $this->db->order_by('finish_time', 'DESC');
    $query = $this->db->get($this->TABLE);
    $array = $query->result_array();
    return $array;
  }

  // get by name
  public function getByName($name)
  {
    $this->db->select('*');
    $this->db->where('name', $name);
    $this->db->order_by('finish_time', 'DESC');
    $query = $this->db->get($this->TABLE);
    $array = $query->result_array();
    return $array;
  }

  // get basic answer information
  public function getShort($test_code)
  {
    $this->db->select('aid,name,qid,finish_test,birthday');
    $this->db->where('test_code', $test_code);
    $query = $this->db->get($this->TABLE);
    $row   = $query->row_array();
    return $row;
  }
  //-----------
  //    INSERT
  //-----------
  // add a answer record to DB
  //"name","occupation","gender","birthday","education","bloodType","marriage"
  public function add($in)
  {
    // generate test code (hex of current timestamp)
    $test_code = dechex(time());
    $data = array(  "name"        =>  $in['name'],
                    "occupation"  =>  $in['occupation'],
                    "gender"      =>  $in['gender'],
                    "birthday"    =>  $in['birthday'],
                    "education"   =>  $in['education'],
                    "bloodType"   =>  $in['bloodType'],
                    "marriage"    =>  $in['marriage'],
                    "finish_test" => 0,
                    "qid"         =>  1,
                    "test_code"   =>  $test_code);
    if ($this->db->insert($this->TABLE, $data))
    {
      return $test_code;
    }
    else {
      return false;
    }
  }
  //-----------
  //    UPDATE
  //-----------
  // update answer json
  public function updateAnswer($aid, $answer_array,$qid)
  {
    $answer_json = json_encode($answer_array);
    $data        = array(
                          'answer_json' => $answer_json,
                          'qid'         => $qid);
    $this->db->where('aid', $aid);
    return $this->db->update($this->TABLE, $data);
  }

  // push value to answer json
  public function append($aid, $option, $qid,$type)
  {
    $row          = $this->get($aid);
    $answer_array = array();

    if ($row != null)
    {
      if ($row['answer_json'] == "" || $row['answer_json'] == null)
      {
        array_push ($answer_array,$option);
      }
      else
      {
        // check if count(answer_json_array) == qid - 1
        $answer_array = json_decode($row['answer_json']);
        if (count($answer_array) == (intval($qid) - 1) || count($answer_array) == (intval($qid)) )
        {
            array_push($answer_array,$option);
        }
        else
        {
            return "DISMATCH";
        }
      }

      if ($this->updateAnswer($aid,$answer_array,$qid))
      {
        return "TRUE";
      }
      else
      {
        return "FALSE";
      }
    }
    else
    {
      return "FALSE";
    }
  }
  // called when user start the test
  public function start($aid)
  {
    $tz         = 'Asia/Shanghai';
    $timestamp  = time();
    $dt         = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp

    $this->db->set('start_time', $dt->format('Y-m-d, H:i:s'));
    $this->db->where('aid', $aid);
    return $this->db->update($this->TABLE);
  }
  // called when user finish the test
  public function finish($aid)
  {
    $tz         = 'Asia/Shanghai';
    $timestamp  = time();
    $dt         = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp

    $data       = array(
                        'finish_test' => 1,
                        'finish_time' => $dt->format('Y-m-d, H:i:s')
                        );
    $this->db->set($data);
    $this->db->where('aid', $aid);
    return $this->db->update($this->TABLE);
  }
  //-----------
  //    DELETE
  //-----------
  // delete answer by id
  public function delete($aid)
  {
    $this->db->where('aid', $aid);
    return $this->db->delete($this->TABLE);
  }
  // clear table (truncate will also reset PK)
  public function clear()
  {
    $this->db->truncate($this->TABLE);
  }
}
