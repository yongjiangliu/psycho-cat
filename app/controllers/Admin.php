<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Admin
 * controller of administrator login & data management
 * @author bcli, 2016-8-9
 */

class Admin extends CI_Controller
{
	private $out;   //

	public function __construct()
	{
		parent::__construct();
		$this->out = $this->conf->config;
	}

    /**
     * Default route of admin controller
     * @route http://www.mysite.com/admin
     */
	public function index()
	{
        // is admin session set ? (is user already logged in as admin?)
		if ($this->tool->adminSessionExists ()){
            // YES, redirect to panel
            $this->tool->re('admin/panel/exam/get/all');
		}
		else
        {
            // NO, redirect to login page
			$this->tool->re('admin/login');
		}
	}
    
	/**
     * Administrator login
	 * @route http://www.mysite.com/admin/login[/errCode]
	 * @param int $errCode
	 */
	public function login($errCode = -1)
	{
        $data = array ('errCode' => $errCode);
        $this->tool->render('admin_login', $data, true);
	}

    /**
     * check if admin username & password pair are correct
     */
	public function check()
	{
        // define local variables
        $user       = '';
        $pass       = '';
        $captcha    = '';
        $ip         = '';
        // [1]  XSS filter POST data, CI will show a '500 internal server error'
        //      if it detects a SQL injection string
        $in = $this->input->post(NULL, TRUE);

        // [2] Are fields 'username', 'password' and 'captcha' defined in POST data ?
        if (!isset($in['username']) || !isset($in['password']) || !isset($in['captcha']))
        {
            // NO, redirect to admin login page with error 'form submission failed'
            redirect($this->out['ADMIN']."/login/10");
        }
        else
        {
            // YES, get data from POST
            $user       = trim($in['username']);
            $pass       = trim($in['password']);
            $captcha    = trim($in['captcha']);
            $ip         = $this->input->ip_address();
        }

        // [3]  Is the submitted captcha correct ?
        //      All valid captcha are stored in database, each captcha is corresponding to an IP
        if (!$this->tool->captchaCorrect($captcha, $ip))
        {
            // NO, redirect to admin login page with error 'invalid captcha'
            redirect($this->out['ADMIN']."/login/15");
        }
            // YES, continue

        // [4]  Is username & password pair exists in database ?
        if (!$this->m_admins->userPassPairExists($user,$pass))
        {
            // NO, consider user login failed,
            // redirect to admin login page with error 'invalid username or password'
            redirect($this->out['ADMIN']."/login/14");
        }
        else
        {
            // YES, consider user has logged in, set session data and redirect to admin panel
            // NOTE: the admin panel CAN ONLY BE ACCESSED WITH A VALID SESSION
            //       which means the user must provide a encrypted
            //       cookie string in HTTP header which contains 'admin' = 'Ane_89M-2kn'
            $this->session->set_userdata('admin', 'Ane_89M-2kn');
            redirect($this->out['ADMIN']."/panel/exam/get/all");
        }
	}

	// show different admin panels
	// type: answer, question, upload
	public function panel($object="", $cmd = "", $type = "", $val = "")
	{
        // [1] admin session check
		if (!$this->tool->adminSessionExists())
        {
            // redirect to error page and show 'session expired' if admin session check failed
            $this->re('err/code/3');
        }
        // [2] try to parse admin command
        switch ($object) {
            // exam command handler
            case "exam":
            // get all exam records, DESC by 'finish_at'
            // route: http://www.mysite.com/admin/panel/exam/get/all
                if ($cmd == "get" && $type == "all")
                {
                    $data['count_question_all']     = $this->m_questions->countAll();
                    $data['count_exam_all']         = $this->m_exams->countAll();
                    $data['count_exam_finished']    = $this->m_exams->countFinished();
                    $data['count_exam_unfinished']  = $this->m_exams->countUnfinished();
                    $data['exams']  = $this->m_exams->getAll();
                    $data['name']   = null;
                    $this->tool->render('admin_exam', $data);
                    break;
                }
                // get exam record by subject_name
                // route: http://www.mysite.com/admin/panel/exam/get/name/<subject_name>
                else if ($cmd == "get" && $type == "name")
                {
                    $data['count_question_all']     = $this->m_questions->countAll();
                    $data['count_exam_all']         = $this->m_exams->countAll();
                    $data['count_exam_finished']    = $this->m_exams->countFinished();
                    $data['count_exam_unfinished']  = $this->m_exams->countUnfinished();
                    $data['exams']  = $this->m_exams->getByName($this->input->post("name"));
                    $data['name'] 	= $this->input->post("name");
                    $this->tool->render('admin_exam', $data);
                    break;
                }
                // get exam record by exam_id
                // route: http://www.mysite.com/admin/panel/exam/get/id/<exam_id>
                else if ($cmd == "get" && $type == "id" && $val != "")
                {
                    $data['count_question_all']     = $this->m_questions->countAll();
                    $data['exams']  = $this->m_exams->getById($val);
                    $data['name']   = null;
                    //----------------------------- Answers displayed per row
                    $data['answer_per_row'] = 10;
                    //-----------------------------
                    $this->tool->render('admin_exam_detail', $data);
                    break;
                }
                // get exam record by finish status
                else if ($cmd == "get" && $type == "finish" && $val != "")
                {
                    if ($val != '1' && $val != '0')
                    {
                        $this->tool->re('err/code/17');
                    }
                    $data['count_question_all']     = $this->m_questions->countAll();
                    $data['count_exam_all']         = $this->m_exams->countAll();
                    $data['count_exam_finished']    = $this->m_exams->countFinished();
                    $data['count_exam_unfinished']  = $this->m_exams->countUnfinished();
                    $data['exams'] = null;
                    if ($val == '1')
                    {
                        $data['exams'] = $this->m_exams->getFinished();
                    }
                    else
                    {
                        $data['exam'] = $this->m_exams->getUnfinished();
                    }
                    $data['name']   = null;
                    $this->tool->render('admin_exam', $data);
                    break;
                }
                // delete exam record by exam_id
                // route: http://www.mysite.com/admin/panel/delete/id/<exam_id>
                else if ($cmd == "delete" && $type == "id" && $val != "")
                {
                    $this->m_exams->deleteById($val);
                    $this->tool->re("admin/panel/exam/get/all");
                    break;
                }
                else {
                    show_404();
                    break;
                }
        // question command handler
        case "question":
            // get all question records
            // route: http://www.mysite.com/admin/panel/question/get/all
            if ($cmd == "get" && $type == "all")
            {
                $data['count']          = $this->m_questions->countAll();
                $data['questions'] 	    = $this->m_questions->getAll();
                $data['settings']       = $this->m_settings->getAll();
                $data['count_sc']       = $this->m_questions->countByTypeString('sc');
                $data['count_mc']       = $this->m_questions->countByTypeString('mc');
                $this->tool->render('admin_question', $data);
                break;
            }
            // get question records by type
            // route: http://www.mysite.com/admin/panel/question/get/type/<question_type>
            else if ($cmd == "get" && $type == "type" && $val != "")
            {
                if ($val != 'sc' && $val != 'mc')
                {
                    $this->tool->re('err/code/16');
                }
                $data['count']          = $this->m_questions->countAll();
                $data['questions'] 	    = $this->m_questions->getByTypeString($val);
                $data['settings']       = $this->m_settings->getAll();
                $data['count_sc']       = $this->m_questions->countByTypeString('sc');
                $data['count_mc']       = $this->m_questions->countByTypeString('mc');
                $this->tool->render('admin_question', $data);
                break;
            }
            else if ($cmd == 'truncate' && $type == "" && $val == "")
            {
                if ($this->m_questions->truncate())
                {
                    echo "1";
                }
                else
                {
                    echo "0";
                }
            }
            else if ($cmd == 'format' && $type == "" && $val == "")
            {
                if ($this->m_questions->format())
                {
                    echo "1";
                }
                else
                {
                    echo "0";
                }
            }
            else
            {
                show_404();
                break;
            }
        // upload command handler
        case "upload":
            // get upload help
            // route: http://www.mysite.com/admin/panel/upload/help
            if ($cmd == "" && $type == "" && $val == "")
            {
                $this->tool->render('admin_upload');
                break;
            }
            else
            {
                show_404();
                break;
            }
        default:
            show_404(); break;
        }
    }
}
