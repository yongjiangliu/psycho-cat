<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Exam
 * controller of exam, including question system and resume code submission
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
	 * @route http://www.mysite.com/exam/
	 * @param errCode null error code is defined in ./app/libraries/Conf.php
	 */
	public function index ()
	{
		$in = $this->input->post(NULL, TRUE);
        // exit & show error if field 'resume_code' is not set
		if (!isset($in['resume_code']))
        {
            redirect($this->out['HOME']."/resume/12");
        }
        $resume_code = $in['resume_code'];
        // exit & show error if field 'resume_code' not exists in database
        if (!$this->m_exams->resumeCodeExists($resume_code))
        {
            redirect($this->out['HOME']."/resume/12");
        }
        // get exam record
        $recordArray = $this->m_exams->getByResumeCode($resume_code);
        $record = $recordArray[0];
        // exit & show message if the exam has been finished
        if ($record['finished'] == 1)
        {
            redirect($this->out['HOME']."/resume/2");
        }
        // passed checks, set session
        $this->session->set_userdata('exam_id', $record['exam_id']);
        // output exam starting guide page
        // check session language
        $lang = $this->tool->getSessionLang();
        // use browser language if language is not set
        if ($lang == null) {$lang = $this->tool->setSessionLang($this->tool->getBrowserLang());}
        // render & return page to user
        $out                = $this->out;
        $this->lang->load($lang,$lang);
        $this->load->view('v_header', 	$out);
        $this->load->view('v_exam_tip', $out);
        $this->load->view('v_footer',	$out);
	}
	/**
	 * http://www.mysite.com/exam/next
	 * show next question
	 * @since v0.1.0
	 */
	public function next ()
	{
        // 1. check if 'exam_id' in session is set
        if (!$this->session->has_userdata('exam_id'))
        {
            redirect($this->out['ERROR']."/code/3");
        }

        // 2. check if 'exam_id' exists in database
        $exam_id = $this->session->userdata('exam_id');
        if (!$this->m_exams->idExists($exam_id))
        {
            redirect($this->out['ERROR']."/code/13");
        }

        // 3. try to fetch exam record
        $result     = $this->m_exams->getById($exam_id);
        $exam    = $result[0];

        // 4. check if this exam has been finished
        if ($exam['finished'] == 1)
        {
            redirect($this->out['ERROR']."/code/2");
        }

        // 5. check if current question id > total question count, if so, finish the test
        $question_id  = intval($exam['question_id']);
        $question_num = $this->m_questions->countAll();
        if (($question_id + 1) > $question_num)
        {
            if ($this->m_exams->finishExam($exam_id))
            {
                // flush session
                $this->session->sess_destroy();
                // output exam finishing confirmation page
                // check session language
                $lang = $this->tool->getSessionLang();
                // use browser language if language is not set
                if ($lang == null) {$lang = $this->tool->setSessionLang($this->tool->getBrowserLang());}
                // render & return page to user
                $out                = $this->out;
                $out['name']        = $exam['subject_name'];
                $out['start_at']    = $exam['start_at'];
                $out['finish_at']   = date("Y-m-d H:i:s");
                $out['duration']    = $this->tool->getExamDuration($exam['start_at'], $out['finish_at']);
                $this->lang->load($lang,$lang);
                $this->load->view('v_header', 	$out);
                $this->load->view('v_exam_done', $out);
                $this->load->view('v_footer',	$out);
                return;
            }
            else
            {
                // show database error if can't set 'finished' = 1
                redirect($this->out['ERROR']."/code/6");
            }
        }
        // if question_id == 1, set exam start time
        else if ($question_id == 1)
        {
            if (!$this->m_exams->setStartTime($exam_id))
            {
                // show database error if can't set 'exam_start' = current DateTime
                redirect($this->out['ERROR']."/code/6");
            }
        }

        // 6. check if user submits any answers, if yes, check its format & store
        $in = $this->input->post(NULL, TRUE);
        if ($this->answerFormatCorrect($in))
        {
            if (!$this->m_exams->appendAnswer($exam_id, $in['answer']))
            {
                // if we failed to append the new answer, show 'database error'
                redirect($this->out['ERROR']."/code/6");
            }
            else
            {
                // if we appended the answer, increase question_id by 1
                $question_id ++;
                if (!$this->m_exams->setQuestionId($exam_id, $question_id))
                {
                    redirect($this->out['ERROR']."/code/6");
                }
            }
        }

        // 7. check if target question exists
        if (!$this->m_questions->idExists($question_id))
        {
            redirect($this->out['ERROR']."/code/9");
        }

        // 8. fetch target question
        $result   = $this->m_questions->getById($question_id);
        $question = $result[0];

        // 9. output
        // check session language
        $lang = $this->tool->getSessionLang();
        // use browser language if language is not set
        if ($lang == null) {$lang = $this->tool->setSessionLang($this->tool->getBrowserLang());}
        // render & return page to user
        $out                = $this->out;
        $question['count']  = $question_num;
        $out['question']    = $question;
        $out['exam']        = $exam;
        $this->lang->load($lang,$lang);
        $this->load->view('v_header', 	$out);
        $this->load->view('v_exam', $out);
        $this->load->view('v_footer',	$out);
	}

    /**
     * ------------------------------------
     *              METHODS
     * ------------------------------------
     */
    /**
     * check if submitted answers are in a correct format
     * @param $in
     * @return bool
     */
    private function answerFormatCorrect ($in)
    {
        if (isset($in['answer']) && isset($in['type']))
        {
            $regexArray     = $this->out['REGEX'];
            $regex          = $regexArray['question_form'];
            $answer         = $in['answer'];
            $type           = $in['type'];

            if (preg_match($regex[$type], $answer))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}
