<?php
// Add this line to avoid direct script access
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Error Controller
* Defines error code & error message
* @author bcli, 2016-4-24
* @since v1.0
*/
class Error extends CI_Controller
{
	// Language params defined in /app/language/
	// to use another lang, modify /app/config/config.php:config["language"]
	private $LANG;
	// Path params defined in /app/libraries/Path.php
	private $PATH;
	/**
	* Contructor of CI Controller
	*/
	public function __construct()
	{
		parent::__construct();
		$this->lang->load("error");
		$this->LANG = $this->lang;
		$this->PATH = $this->path->get();
	}

	/**
	*	URI: domain/error
	* redirect to /domain/error/code
	* which will show an unkown ERROR page
	* this function is used for error page debuging
	*/
	public function index()
	{
		redirect($this->PATH['ERROR']."/code", 'refresh');
	}

	/**
	*	URI: domain/error/code/<errorCode>
	* take error code and print corresponding error
	* @param errorCode, set to negetive or leave blank if it's an unkown error
	*/
	public function code($errorCode='-1')
	{
		// gathering data
		$out = $this->PATH;
		$out['lang'] = $this->LANG;
		$out['errorMsg'] = $this->parseErrorCode($errorCode);
		// output
		$this->load->view('v_header',$out);
		$this->load->view('v_error',$out);
		$this->load->view('v_footer',$out);
	}
	/**
	*	Parse given error code and return error message
	* @param errorCode, please note it's taken as string
	* @return errorMsg, error message defined in /app/language/../error_lang.php
	*/
	private function parseErrorCode($errorCode)
	{
		$errorMsg = "";
		switch ($errorCode) {
		    case '0':	// invalid test id
		    	$errorMsg 	= $this->LANG->line("err_0");
		    	break;
		    case '1':	// can't use this test id when test is completed
		    	$errorMsg 	= $this->LANG->line("err_1");
		    	break;
		    case '2': // session expired, please use "enter test id" to coninute
		    	$errorMsg 	= $this->LANG->line("err_2");
		    	break;
				case '3':	// can't find next question, please check the Excel
					$errorMsg 	= $this->LANG->line("err_3");
					break;
				case '4':	// session expired
						$errorMsg = $this->LANG->line("err_4");
						break;
				case '5':	// maximum login attempt reached
						$errorMsg = $this->LANG->line("err_5");
						break;
				case '6':	// can't find specified file
						$errorMsg = $this->LANG->line("err_6");
						break;
				case '7':	// database error
						$errorMsg = $this->LANG->line("err_7");
						break;
				case '8':	// invalid answer format
						$errorMsg = $this->LANG->line("err_8");
						break;
				case '9':	// answer submission error
						$errorMsg = $this->LANG->line("err_9");
						break;
				case '10':	// can't fetch this question
						$errorMsg = $this->LANG->line("err_10");
						break;
				case '11':	// answered question length error
						$errorMsg = $this->LANG->line("err_11");
						break;
				case '12':	// can't fetch test data
						$errorMsg = $this->LANG->line("err_12");
						break;
				default:	// unkown error
        	$errorMsg 	= $this->LANG->line("err_unkown");
					break;
		}
		return $errorMsg;
	}
}
