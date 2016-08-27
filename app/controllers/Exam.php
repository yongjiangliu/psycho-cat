<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Exam
 * controller of exam, which includes exam session creation and answer submission
 * the detailed steps for answering questions
 * 1. user provides a resume code
 * 2. system checks whether this resume code is in database
 * 3. if in db, then has this test been finished ?
 * 4. if not finished, start test from stored question_id
 * 5. questions will be answered in order, no previous questions can be modified
 * 6. finish the test when question_id > question count
 *
 * @since v0.1.0
 * @author bcli, 2016-8-9
 */
class Exam extends CI_Controller
{
	private $out;   // config array
	public function __construct()
	{
		parent::__construct();
        $this->out = $this->conf->config;   // set config array in constructor
	}
	/**
	 * ------------------------------------
	 *              ROUTES
	 * ------------------------------------
	 */
	/**
	 * default controller of exam, used to check given resume code and set exam session,
     * here, the 'exam session' means key value pair 'exam_id' in cookie,
     * session string will be encrypted and sent to browser, then sent back later on.
     * After that it can be decrypted, checked, modified, then encrypted & sent again.
	 * @route http://www.mysite.com/exam/
	 * @param errCode, error code which corresponding to a error message, see ./app/language/ for more
	 */
	public function index ()
	{
        // [1]  XSS filter to prevent SQL injection attack
		$in = $this->input->post(NULL, TRUE);

        // [2] Have we got all fields we want ?
		if (!isset($in['resume_code']))
        {
            // NO, redirect to resume code submission page and print error 'form submission failed'
            $this->tool->re('home/resume/10');
        }
            // YES, continue to next step...

        // [3] Does resume_code exist (belongs to any test) in database ?
        $resume_code = $in['resume_code'];
        if (!$this->m_exams->resumeCodeExists($resume_code))
        {
            // NO, redirect to resume code submission page and print error 'invalid resume code'
            $this->tool->re('home/resume/12');
        }
            // YES, continue to next step...

        // [4] Has this test been finished ?
        $result = $this->m_exams->getByResumeCode($resume_code);
        $record = $result[0];
        if ($record['finished'] == 1)
        {
            // YES, since we can't resume a finished test, redirect to resume code submission
            // page and print error 'can't resume a finished test'
            $this->tool->re('home/resume/2');
        }
            // NO, continue to next step...

        // [5] Set exam session by setting 'exam_id', which is the PK of each test record
        $this->session->set_userdata('exam_id', $record['exam_id']);

        // [6] Render & output page
        $this->tool->render('exam_tip');
	}
	/**
     * [IMPORTANT] show next question, this sub-controller is the MOST IMPORTANT CONTROLLER of PsychoCat
     * it fetch question by a stored question_id, then do question_id ++,
     * when it finds out question_d > question count, set the 'finished' flag to 1 and output a finish page
	 * http://www.mysite.com/exam/next
	 * @since v0.1.0
	 */
	public function next ()
	{
        // [1]  Do we have 'exam_id' set in session ?
        if (!$this->session->has_userdata('exam_id'))
        {
            // NO, redirect to error page with 'session expired'
            $this->tool->re('err/code/3');
        }
            // YES, continue to next step...

        // [2]  Does 'exam_id' exist in database ?
        $exam_id = $this->session->userdata('exam_id');
        if (!$this->m_exams->idExists($exam_id))
        {
            // NO, redirect to error page with 'can't find this test'
            $this->tool->re('err/code/13');
        }
            // YES, continue to next step...

        // [3]  Can we fetch the test record by this 'exam_id' ?
        $result     = $this->m_exams->getById($exam_id);
        if ($result == null || !isset($result[0]))
        {
            // NO, redirect to error page with 'database error'
            $this->tool->re('err/code/10');
        }
        // YES, then store it to a var
        $exam       = $result[0];

        // [4]  Has this test been finished ?
        if ($exam['finished'] == 1)
        {
            // YES, redirect to error page with 'can't answer a test which has been finished'
            $this->tool->re('err/code/2');
        }
            // NO, continue to next step...

        // [5]  Have we reached the maximum question_id ?
        $question_id  = intval($exam['question_id']);
        $question_num = $this->m_questions->countAll();
        if (($question_id + 1) > $question_num)
        {
            // YES, then finish the test

            // [5.1]  Can we set the 'finished' flag to 1 ?
            if ($this->m_exams->finishExam($exam_id))
            {
                // YES, flush session
                $this->session->sess_destroy();
                // show test finish confirmation page
                $finish_at = date("Y-m-d H:i:s");
                $data   = array (
                                    'name'      => $exam['subject_name'],
                                    'start_at'  => $exam['start_at'],
                                    'finish_at' => $finish_at,
                                    'duration'  => $this->tool->getExamDuration($exam['start_at'], $finish_at)
                );
                $this->tool->render('exam_done', $data);
                // make sure to return so we won't execute the rest of this script
                return;
            }
            else
            {
                // NO, redirect to error page with 'database error'
                $this->tool->re('err/code/10');
            }
        }

        // [6]  Is the test just get started ?
        else if ($question_id == 1)
        {
            if (!$this->m_exams->setStartTime($exam_id))
            {
                // show database error if can't set 'exam_start' = current DateTime
                redirect($this->out['ERROR']."/code/6");
            }
        }

        // [7]  Does user submit any answers ?
        $in = $this->input->post(NULL, TRUE);
        if ($this->tool->answerFormatCorrect($in))
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

        // [8]  Does the target question exit ?
        if (!$this->m_questions->idExists($question_id))
        {
            $this->tool->re('error/code/9');
        }

        // [9] fetch target question
        $result   = $this->m_questions->getById($question_id);
        $question = $result[0];

        // [10] render page
        $data = array (
                        'count'     => $question_num,
                        'question'  => $question,
                        'exam'      => $exam
        );
        $this->tool->render('exam', $data);
	}
}
