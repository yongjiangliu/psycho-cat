<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
	private $out;
	// Constructor
	public function __construct()
	{
		parent::__construct();
		$this->out = $this->conf->path;
	}

	// Default controller, admin login
	public function index()
	{
		$controller = $this->out;
		if ($this->sessCheck()){
			redirect($controller['ADMIN']."/panel/answer/get/all", 'refresh');
		}
		else {
			redirect($controller['ADMIN']."/login", 'refresh');
		}
	}

	public function login($status="")
	{
		$out = $this->out;
		if ($status == "failed"){
			$out['status'] = false;
		}
		else {
			$out['status'] = true;
		}
		$this->load->view('v_header', $out);
		$this->load->view('v_admin_login',$out);
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

	// check username/password and issue session
	public function check()
	{
		$path = $this->out;
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		if ($this->m_admin->get($username,$password) != null){
			$this->session->set_userdata('admin', 'Ane_89M-2kn');
			redirect($path['ADMIN']."/panel/answer/get/all", 'refresh');
		}
		else {
			// we have to do something against brute force
			$failedTimes = 1;
			if ($this->session->has_userdata("brute")){
				$failedTimes = intval($this->session->userdata('brute')) + 1;
				$this->session->set_userdata("brute", strval($failedTimes));
			}
			else {
				$this->session->set_userdata('brute', '1');
			}
			if ($failedTimes >= 15){
				redirect($path['ERROR']."/code/5", 'refresh');
			}
			else {
				redirect($path['ADMIN']."/login/failed", 'refresh');
			}
		}
	}

	// show different admin panels
	// type: answer, question, upload
	public function panel($object="", $cmd = "", $type = "", $val = "")
	{
		if ($this->sessCheck()){
			$out = $this->out;
			switch ($object) {
				case "answer":
						// fetch all answers (ordered by finish_time desc)
						if ($cmd == "get" && $type == "all")
						{
							$out['count'] 	= $this->m_question->count("all");
							$out['answer'] 	= $this->m_answer->getAll();
							$out['name'] 		= null;
							$this->load->view('v_header', $out);
							$this->load->view("v_admin_answer",$out);
							break;
						}
						// fetch answer by name (ordered by finish_time desc)
						else if ($cmd == "get" && $type == "name")
						{
							$out['count'] 	= $this->m_question->count("all");
							$out['answer'] 	= $this->m_answer->getByName($this->input->post("name"));
							$out['name'] 		= $this->input->post("name");
							$this->load->view('v_header', $out);
							$this->load->view("v_admin_answer",$out);
							break;
						}
						// fetch answer by aid
					 else if ($cmd == "get" && $type == "aid" && $val != "")
					 {
						 $out['count'] 					= $this->m_question->count("all");
						 $out['data'] 					= $this->m_answer->get($val);
						 //----------------------------- Answers display per row
						 $out['answer_per_row'] = 10;
						 //-----------------------------
						 $this->load->view('v_header', $out);
						 $this->load->view("v_admin_answer_detail",$out);
						 break;
					 }
					 else if ($cmd == "delete" && $type == "aid" && $val != "")
					 {
						 $this->m_answer->delete($val);
						 redirect($path['ADMIN']."/panel/answer/get/all", 'refresh');
						 break;
					 }
					 else if ($cmd =="")
					 {
						 redirect($path['ADMIN']."/panel/answer/get/all", 'refresh');
					 }
					 else {
						 show_404();
						 break;
					 }
		    case "question":
						if ($cmd == "get" && $type == "all")
						{
							$out['count_all'] = $this->m_question->count("all");
							$out['count_sc'] 	= $this->m_question->count("sc");
							$out['count_mc'] 	= $this->m_question->count("mc");
							$out['count_jg'] 	= $this->m_question->count("jg");
							$out['question'] 	= $this->m_question->getAll();
							$out['last_upload'] = file_get_contents("./upload/last_upload.txt");
							$this->load->view('v_header', $out);
							$this->load->view("v_admin_question",$out);
			      	break;
						}
						else if ($cmd == "get" && $type == "type" && $val != "")
						{
							$out['count_all'] = $this->m_question->count("all");
							$out['count_sc'] 	= $this->m_question->count("sc");
							$out['count_mc'] 	= $this->m_question->count("mc");
							$out['count_jg'] 	= $this->m_question->count("jg");
							$out['last_upload'] = file_get_contents("./upload/last_upload.txt");
							$out['question'] 	= $this->m_question->getByType($val);
							$this->load->view('v_header', $out);
							$this->load->view("v_admin_question",$out);
							break;
						}
						else if ($cmd == "")
						{
							redirect($path['ADMIN']."/panel/question/get/all", 'refresh');
							break;
						}
						else
						{
							show_404();
							break;
						}

		    case "upload":
						if ($cmd == "print" && $type == "error" && $val != "")
						{
							$out['errorMsg'] = $val;
							$this->load->view('v_header', $out);
							$this->load->view("v_admin_upload",$out);
							break;
						}
						else if ($cmd == "")
						{
							$this->load->view('v_header', $out);
							$this->load->view("v_admin_upload",$out);
							break;
						}
						else
						{
							show_404();
							break;
						}
				case "":
						redirect($path['ADMIN']."/panel/answer/get/all", 'refresh');
				default:
						show_404();
						break;
			}
		}
		else {
			redirect($path['ERROR']."/code/4", 'refresh');
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
				redirect($path['ADMIN']."/panel/upload/print/error/".$error, 'refresh');
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
			redirect($path['ERROR']."/code/4", 'refresh');
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

	// session check
	private function sessCheck()
	{
		if (!$this->session->has_userdata('admin')){
			$result = false;
		}
		else {
			$admin = $this->session->userdata('admin');
			if ($admin == "Ane_89M-2kn")
			{
				return true;
			}
			else {
				return false;
			}
		}
	}
}
