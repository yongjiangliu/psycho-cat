<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ErrorParser extends CI_Controller
{
	private $out;
	// Constructor
	public function __construct()
	{
		parent::__construct();
		$this->out = $this->conf->config;
	}

	// Default controller
	public function index()
	{
		$out = $this->out;
		$this->load->view('v_header',$out);
		$this->load->view('v_home',$out);
	}
	public function code($errorCode)
	{
		$out = $this->out;
		$out['errorMsg'] = $this->parseErrorCode($errorCode);
		$this->load->view('v_header',$out);
		$this->load->view('v_error',$out);
	}
	
	private function parseErrorCode($errorCode)
	{
		$errorMsg = "";
		switch ($errorCode) {
		    case '0':
		    	$errorMsg 	= "无效的试卷编号";
		    	break;
		    case '1':
		    	$errorMsg 	= "该试卷已完成，无法继续答题";
		    	break;
		    case '2':
		    	$errorMsg 	= "会话已过期<br><br>请选择<kbd>主页->输入试卷编号</kbd>继续答题";
		    	break;
				case '3':
					$errorMsg 	= "找不到下一个题目，请检查数据库题目序号是否连贯";
					break;
				case '4':
						$errorMsg = "会话已过期";
						break;
				case '5':
						$errorMsg = "登录尝试次数超限";
						break;
				case '6':
						$errorMsg = "找不到指定文件";
						break;
				case '7':
						$errorMsg = "数据库错误";
						break;
				case '8':
						$errorMsg = "答案格式错误";
						break;
				case '9':
						$errorMsg = "答案提交错误";
						break;
				case '10':
						$errorMsg = "无法获取此题目";
						break;
				case '11':
						$errorMsg = "答案数组长度与已答题目数不匹配";
						break;
				case '12':
						$errorMsg = "无法获取答卷数据";
						break;
				case '404':
						$errorMsg = "页面不存在";
				default:
        				$errorMsg 	= "未知错误类型";
					break;
		}
		return $errorMsg;
	}
}
