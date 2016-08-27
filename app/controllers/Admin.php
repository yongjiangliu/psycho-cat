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

	public function database($cmd="", $val="")
	{
		switch ($cmd)
		{
			case "update":
					if (file_exists("./upload/INSERT_PRE.txt"))
					{
						$data;
						$lines 	= file("./upload/INSERT_PRE.txt");
						if ($lines != false)
						{
							// clear question table
							$this->m_question->clear();
							// insert new data
							foreach($lines as $line)
							{
								// trim line string (very important! each line may contain
								// multi \t at the end)
								$line = trim($line);
								// split data
								$data = explode("\t", $line);
								if ($data[0] == "")
								{
									continue;
								}
								$lineNum = 0;
								$lineNum++;
								if ($lineNum == 1)
								{
									$data[0] = preg_replace('/\x{EF}\x{BB}\x{BF}/','',$data[0]);
								}
								// insert
								$this->m_question->add($data);
							}
							$out = $this->out;
							echo "<html><head><title>更新成功！</title></head><body>\n";
							echo "<h1>数据库更新成功！</h1>\n";
							echo "<p><b><a href='".$out['ADMIN']."/panel/question/get/all'>到题目列表确认</a></b></p>\n";
							echo "</body></html>\n";
							// update last upload time
							$tz = 'Asia/Shanghai';
							$timestamp = time();
							$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
							$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
							file_put_contents("./upload/last_upload.txt",$dt->format('Y-m-d, H:i:s'));
							break;
						}
						else
						{
							$out = $this->out;
							echo "<html><head><title>更新失败！</title></head><body>\n";
							echo "<h1>数据库更新失败！</h1>\n";
							echo "<p><b>无法使用file()解析INSERT_PRE.txt</b></p>\n";
							echo "<p><b><a href='".$out['ADMIN']."/panel/question/upload>返回题目上传页面</a></b></p>\n";
							echo "</body></html>\n";
							break;
						}
					}
					else
					{
						$out = $this->out;
						echo "<html><head><title>更新成功！</title></head><body>\n";
						echo "<h1>数据库更新失败！</h1>\n";
						echo "<p><b>找不到INSERT_PRE.txt</b></p>\n";
						echo "<p><b><a href='".$out['ADMIN']."/panel/question/upload>返回题目上传页面</a></b></p>\n";
						echo "</body></html>\n";
						break;
					}
			case "drop":
					show_404();
					break;
			default:
					show_404();
					break;
		}
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

	// upload question txt file, clear table
  public function upload()
	{
		$path = $this->path->get();
		if ($this->sessCheck()){
			// txt file configerations
			$config['upload_path']          = './upload/';	// set upload folder file permission to 777
			$config['allowed_types']        = 'txt';			// we only allow txt file
			$config['file_name']        		= 'question_list.txt';			// rename the uploaded file
			$config['overwrite']						= true;			// allow file override
			$config['max_size']             = 0;				// max file size in kb, set as no limit, but php.ini may set it to 2048 kb max
			$this->load->library('upload', $config);		// load upload library
			// accept file
			if (!$this->upload->do_upload('file'))
			{
				// if error detected, send error to upload page
				$error = $this->upload->display_errors("","");
				redirect($path['ADMIN']."/panel/upload/print/error/".$error);
			}
			else
			{
				//echo phpinfo();
				// if no error detected, echo a simple page
				$file_data = $this->upload->data();
				$full_path = $file_data['full_path'];
				echo "<html><head><title>文件处理</title></head><body>\n";
				echo "<p><b>==========================================</b></p>\n";
				echo "<p><b>文件上传成功！</b></p>\n";
				//echo "<p><b>自动重命名为".$config['file_name']."</b></p>";
				echo "<p><b>文件大小：".$file_data['file_size']."KB</b></p>\n";
				$out = $this->path->get();
				echo "<p><b><a href='".$out['ADMIN']."/panel/upload'>返回上传页面</a></b></p>\n";
				echo "<p><b>==========================================</b></p>\n";
				echo "<p><b>文件格式检查：</b></p>\n";
				echo "<p><b>==========================================</b></p>\n";
				$this->fileCheck($full_path);
				echo "</body></html>\n";
			}
		}
		else {
			redirect($path['ERROR']."/code/4");
		}
	}

	private function fileCheck($full_path)
	{
		$error 		= 0 ;		// total error number
		$lineNum 	= 0;		// total line number
		$data;
		$lines 		= file($full_path);
		if ($lines != false) {
    	foreach($lines as $line)
			{
				// trim line string (very important! each line may contain
				// multi \t at the end)
				$line = trim($line);
				// split data
				$data = explode("\t", $line);
				// if we can't get question type or line is blank, ignore this line
				if ($data[0] == "" || $line == "")
				{
					continue;
				}
				// add line number
				$lineNum ++;
				// Since windows text editor uses UTF-8 BOM
				// at the begining of the file there's a anoying ? character
				// which we have to remove
				if ($lineNum == 1)
				{
					$data[0] = preg_replace('/\x{EF}\x{BB}\x{BF}/','',$data[0]);
				}
				//-----------------
        // parse data
				//-----------------
				// 1. array length check
				// 		data[0] = question_type, data[1] = question, data[2-6] = option_1 to 5
				// 		get data length
				$count = count($data);
				//		init line error
				$lineError = 0;
				// 		if array length is within range of 2+2=4 to 2+5 = 7
				if ($count < 4|| $count > 7)
				{
						echo "<p><b>第[".$lineNum."]行,非法的数据个数[".$count."]，该题目的选项是否少于2个或大于5个？（选项个数应为2,3,4或5）</p>\n";
						$lineError++;
						$error++;
				}
				if (!$this->undefinedDataCheck($data))
				{
						echo "<p><b>第[".$lineNum."]行,存在空数据，请确保EXCEL表符合编写规范</p>\n";
						$lineError++;
						$error++;
				}
				// question type check
				if (!$this->questionTypeCheck($data))
				{
						echo "<p><b>第[".$lineNum."]行,无法识别的题目类型[".$data[0]."] (题目类型应为判断，单选或多选）</b></p>\n";
						$lineError++;
						$error++;
				}
				// if we have error in this line, print detail information of this line
				if ($lineError > 0 )
				{
					$this->printLineErrorDetails($line,$data);
				}
    	}
			//-------------------------------
			if ($error == 0)
			{
				echo "<p><b>正确！</b></p>\n";
			}
			echo "<p><b>==========================================</b></p>\n";
			echo "<p><b>检查结果：</b></p>\n";
			echo "<p><b>行数：".$lineNum."</b></p>\n";
			echo "<p><b>错误：".$error."</b></p>\n";
			echo "<p><b>==========================================</b></p>\n";
			// copy txt file for database writting
			if ($error == 0)
			{
				if (file_put_contents("./upload/INSERT_PRE.txt", file_get_contents("./upload/question_list.txt")))
				{
					$out = $this->path->get();
					echo "<p><b><a href='".$out['ADMIN']."/database/update'>按照此文件更新题库(点击后请耐心等待，请不要重复点击)</a></b></p>\n";
					echo "<p><b><a href='".$out['ADMIN']."/panel/upload'>返回上传页面</a></b></p>\n";
				}
				else
				{
					echo "<p><b>错误：无法创建数据库写入准备文件，请检查文件夹权限设置</b></p>\n";
				}
			}
			if ($error > 0)
			{
				$out = $this->path->get();
				echo "<p><b>请更正错误后重新上传</b></p>";
				echo "<p><b><a href='".$out['ADMIN']."/panel/upload'>返回上传页面</a></b></p>\n";
			}
		}
		else {
    	echo "<p><b>无法打开文件</b></p>\n";
		}
	}

	private function printLineErrorDetails($line, $data)
	{
		echo "<p><b>&nbsp;&nbsp;&nbsp;&nbsp;原始文本：</b></p>\n";
		echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;".$line."</p>\n";
		echo "<p><b>&nbsp;&nbsp;&nbsp;&nbsp;数组文本：</b></p>\n";
		echo "<p>";
		var_dump($data);
		echo "</p>\n";
		echo "<p><b>&nbsp;&nbsp;&nbsp;&nbsp;问题文本：";
		var_dump($data[0]);
		echo "</b></p>";
		echo "<p><b>&nbsp;&nbsp;&nbsp;&nbsp;问题类型(UTF-8解码):";
		var_dump(utf8_decode($data[0]));
		echo "</b></p>\n";
		echo "<p>-----------------------------</p>\n";
	}

	private function undefinedDataCheck($data)
	{
		foreach ($data as $val)
		{
			if ($val == "" || $val == null)
			{
				return false;
			}
		}
		return true;
	}

	private function questionTypeCheck($data){
		if (array_key_exists(0,$data)){
			$a = strcmp($data[0],"判断");
			$b = strcmp($data[0],"单选");
			$c = strcmp($data[0],"多选");
			if ($a == 0 || $b == 0 || $c == 0)
			{
				return true;
			}
			else {
				return false;
			}
		}
		else {
			echo "<p><b>题目类型键0不存在</b></p>";
			return false;
		}
	}
}
