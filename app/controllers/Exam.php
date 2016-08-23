<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Exam
 * controller of exam, including question system and resume code submission
 *     // generate test code (hex of current timestamp)
		$test_code = dechex(time());
 *
 *	    $tz         = 'Asia/Shanghai';
 *		$timestamp  = time();
 * 		$dt         = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
 *		$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
 *		$datetime = $dt->format('Y-m-d, H:i:s');
 *
 * @author bcli, 2016-8-9
 */

class Exam extends CI_Controller
{
	private $out;
	// Constructor
	public function __construct()
	{
		parent::__construct();
        $this->out = $this->conf->config;
	}

	/**
	 * ------------------------------------
	 *              ROUTES
	 * ------------------------------------
	 */
	/**
	 *
	 * @route http://www.mysite.com/exam
	 */
	public function index ()
	{

	}
	/**
	 *
	 * @route http://www.mysite.com/home/form[/errCode]
	 * @param errCode null error code is defined in ./app/libraries/Conf.php
	 */
	public function start ()
	{
        // get exam_id from session
        $exam_id = $this->getSessionExamId();
        if ($exam_id == null)
        {
            // show 404
        }
        // check if exam_id exists

        // exists, set question_id

        // show exam start conformation page

	}


	public function resume ()
	{

	}


	// Default controller
	public function index()
	{
		$test_code = $this->input->post("test_code",true);
		$path = $this->path->get();
		$record;
		// if test code is null
		if ($test_code == "" || $test_code == null){
				// invalid test code
				redirect($path['ERROR']."/code/0", 'refresh');
		}
		// if not null ,check it
		else {
			// trim it
			$test_code = trim($test_code);
			$record = $this->m_answer->getShort($test_code);
			// can't get answer with that test_code, print error
			if ($record == null)
			{
				// invalid test code
				redirect($path['ERROR']."/code/0", 'refresh');
			}
			// got answer with that test_code, proceed
			else
			{
				// if test is finished, print error
				if ($record["finish_test"] == 1)
				{
					redirect($path['ERROR']."/code/1", 'refresh');
				}
				// if not, set session
				else
				{
					// prepare session data
					$count = $this->m_question->count("all");

					$sessData = array(	"name" 			=> $record["name"],
															"qid" 			=> $record["qid"],
															"aid"  			=> $record["aid"],
															"count" 		=> $count
														);
					// set session
					$this->session->set_userdata($sessData);
					// output jumper
					$out 							= $this->path->get();
					$out['name'] 			= $record["name"];
					$out['birthday'] 	= $record["birthday"];
					$out['count'] 		= $count;
					$out['qid']				= $record['qid'];
					$this->load->view('v_header',$out);
					$this->load->view('v_jumper',$out);
				}
			}
		}
	}

	/**
	 * http://www.mysite.com/exam/next
	 * show next question
	 * @since v0.1.0
	 */
	public function next()
	{
		$path = $this->path->get();
		// if pass session check
		if ($this->sessCheck()){
			// if there's answer and type field
			$answer		= $this->input->post('answer');
			$type 		= $this->input->post('type');
			if ($answer != null && $type != null)
			{
				// if answer format is correct
				if ($this->answerFormatCheck($type,$answer))
				{
					// then store answer
					$aid = intval($this->session->userdata('aid'));
					$qid = intval($this->session->userdata('qid'));
					$append_result = $this->m_answer->append($aid,$answer,$qid,$type);
					// if qid and database answer length doesn't match, throw error dismatch
					if ($append_result == "DISMATCH")
					{
						redirect($path['ERROR']."/code/11", 'refresh');
					}
					// if append failed, throw database error
					else if ($append_result == "FALSE")
					{
						redirect($path['ERROR']."/code/7", 'refresh');
					}
					// if append success,
					else if ($append_result == "TRUE")
					{
						// get qid
						$qid = intval($this->session->userdata('qid'));
						// display next question
						$this->displayQuestion($qid + 1);
					}
				}
				else
				{
					// if answer format is not correct, throw answer format error
					redirect($path['ERROR']."/code/8", 'refresh');
				}
			}
			else
			{
				// get qid
				$qid = intval($this->session->userdata('qid'));
				// if field answer is not set, display question by $qid
				$this->displayQuestion($qid);
			}
		}
		else
		{
			// session expired, need to re-enter test code
			redirect($path['ERROR']."/code/2", 'refresh');
		}
	}

	/**
	 * http://www.mysite.com/exam/done
	 * called when exam finishes
	 */
	public function done()
	{
		$path = $this->path->get();
		if ($this->sessCheck())
		{
			// get aid
			$aid 		= intval($this->session->userdata('aid'));
			$count	= $this->m_question->count("all");
			// set finish time and finish flag in DB
			$this->m_answer->finish($aid);
			// destroy session so user can no longer answer any questions by URL
			$this->session->sess_destroy();
			$record			= $this->m_answer->get($aid);
			if ($record == null)
			{
				redirect($path['ERROR']."/code/12", 'refresh');
			}
			$start_time 	=	$record['start_time'];
			$finish_time 	= $record['finish_time'];
			$name  				= $record['name'];
			$qid 					= $record['qid'];
			$test_code 		= $record['test_code'];

			// calculate time difference (hour, minute, second)
			$dteStart = new DateTime($start_time );
			$dteEnd   = new DateTime($finish_time);
			$dteDiff  = $dteStart->diff($dteEnd);
			$time 		= $dteDiff->format("%H:%I:%S");

			$out = $this->path->get();
			$out['qid'] 				= $qid;
			$out['count'] 			= $count;
			$out['time']				= $time;
			$out['start_time']	= $start_time;
			$out['finish_time']	= $finish_time;
			$out['name']				= $name;
			$out['test_code']		= $test_code;

			$this->load->view('v_header',$out);
			$this->load->view('v_test_done',$out);
			}
			else
			{
				// session expired
				redirect($path['ERROR']."/code/4", 'refresh');
			}
	}

	private function displayQuestion($qid)
	{
		$path = $this->path->get();
		$aid = intval($this->session->userdata('aid'));
		// if answering first question, update start time
		if ($qid == 1)
		{
			if (!$this->m_answer->start($aid))
			{
				// if store failed, throw a database error
				redirect($path['ERROR']."/code/7", 'refresh');
			}
		}
		//--------------------------------------------- fetch question
		// get next question & option by feteching qid
		$record = $this->m_question->get($qid);
		// if $qid + 1 == count(all_questions) + 1, then test complete
		if ($record == "MAX")
		{
			// redirect to Test Complete page
			redirect($path['TEST']."/done", 'refresh');
		}
		// if target qid not exists and $qid + 1 != count(all_questions) + 1,
		// then throw question can't be found error
		else if ($record == null)
		{
			redirect($path['ERROR']."/code/10", 'refresh');
		}
		// if we get the question and test is not complet
		else
		{
			// prepare for output
			$db_options = array (
								$record['option_1'],
								$record['option_2'],
								$record['option_3'],
								$record['option_4'],
								$record['option_5']);
			$options = $this->optionFilter($db_options);
			// set session, last_qid ++
			//$this->session->set_userdata('last_qid', strval($last_qid++));
			$this->session->set_userdata('qid', $qid);
			// show page
			$out = $this->path->get();
			$out['qid'] 			= $record['qid'];
			$out['question'] 	= $record['question'];
			$out['type']			= $record['type'];
			$out['options'] 	= $options;
			// print user name and count
			$out['name'] 			= $this->session->userdata('name');
			$out['count'] 		= $this->session->userdata('count');
			$this->load->view('v_header',$out);
			$this->load->view('v_test',$out);
		}
	}

	private function sessCheck()
	{
		$result = true;
		if (!$this->session->has_userdata('name'))
		{
			$result = false;
		}
		if (!$this->session->has_userdata('qid'))
		{
			$result = false;
		}
		if (!$this->session->has_userdata('aid'))
		{
			$result = false;
		}
		if (!$this->session->has_userdata('count'))
		{
			$result = false;
		}
		return $result;
	}

	private function answerFormatCheck($type, $answer)
	{
		// if it's single choice question or judgement
		if ($type == "jg")
		{
			switch ($answer)
			{
				case "是":
						return true;
				case "否":
						return true;
				case "不确定":
						return true;
				default:
						return false;
			}
		}
		else if ($type == "sc")
		{
			switch ($answer)
			{
				case "A":
						return true;
				case "B":
						return true;
				case "C":
						return true;
				case "D":
						return true;
				case "E":
						return true;
				default:
						return false;
			}
		}
		// multi choice question will be formatted as: "1,3,4"
		// in case it's multi choice question, we first split the data by ','
		// then check it like single choice questions
		else if ($type == "mc")
		{
			$splitted = str_split($answer);
			foreach ($splitted as $val)
			{
				switch ($val)
				{
					case "A":
							break;
					case "B":
							break;
					case "C":
							break;
					case "D":
							break;
					case "E":
							break;
					default:
							return false;
				}
				return true;
			}
		}
		else {
			return false;
		}
	}
	private function optionFilter($db_options)
	{
		$i = 0;
		$options;
		foreach($db_options as $val)
		{
			if ($val != "")
			{
				$options[$i] = $val;
				$i++;
			}
		}
		return $options;
	}



    private function getSessionExamId ()
    {
        if ($this->session->has_userdata('exam_id'))
        {
            return $this->session->userdata('exam_id');
        }
        else
        {
            return null;
        }
    }
}
