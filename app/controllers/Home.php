<?php
// Add this line to avoid direct script access
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Home Page Controller
* Employee's basic information form submit & check
* @author bcli, 2016-4-24
* @since v1.0
*/
class Home extends CI_Controller
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
		$this->PATH = $this->path->get();
	}
	/**
	* URI: domain/ or domain/home
	* Home/index page of the site
	* redirect to domain/home/info
	*/
	public function index()
	{
		redirect($this->PATH['HOME']."/info", 'refresh');
	}
	/**
	* URI: domain/home/info/<invalidForm>
	* Home/index page of the site with form validation status flag
	* @param rejectedForm, whether the server has rejected the form submission
	*/
	public function info($rejectedForm=false)
	{
		$this->lang->load("home");
		$this->LANG = $this->lang;
		// gathering data
		$out 								= $this->PATH;
		$out['lang'] 				= $this->LANG;
		$out['rejectedForm'] = $rejectedForm;
		// output
		$this->load->view('v_header',$out);
		$this->load->view('v_home',$out);
		$this->load->view('v_footer',$out);
	}
	/**
	*	URI: domain/home/getTestId
	*	You will need to post the params of form @ domain/home to get a test id
	*/
	public function getTestId()
	{

		// check list
		$checkList = array ("name","occupation","gender","birthday","education","bloodType","marriage");
		// filter & get posts
		$in = $this->input->post(NULL, TRUE);
		//var_dump($data);
		// check if all fields are existed & filled
		$error = 0;
		foreach ($checkList as $val)
		{
			if (!isset($in[$val]))
			{
				$error++;
			}
			else
			{
				if ($in[$val] == '')
				{
					$error++;
				}
			}
		}
		// if error detected, return the home page
		if ($error > 0)
		{
			redirect($this->PATH['HOME']."/info/true", 'refresh');
		}
		// if no error, show test id page
		else
		{
			// store user info and generate test id
			$test_id 				= $this->m_answer->add($in);
			// gathering data
			$this->lang->load("test");
			$this->LANG = $this->lang;
			$out 						= $this->PATH;
			$out['lang'] 		= $this->LANG;
			if ($test_id == false)
			{
				$out['test_code'] = '--ERROR--';
			}
			else
			{
				$out['test_id'] = $test_id;
				$out['status']	= "out";
			}
			// output
			$this->load->view('v_header',$out);
			$this->load->view('v_test_id',$out);
			$this->load->view('v_footer',$out);
		}
	}
	/**
	* URI: domain/home/enterTestId
	* get test id input from user
	*/
	public function enterTestId()
	{
		$this->lang->load("test");
		$this->LANG = $this->lang;
		// gathering data
		$out 						= $this->PATH;
		$out['lang']		= $this->LANG;
		$out['status'] 	= "in";
		// output
		$this->load->view('v_header',$out);
		$this->load->view('v_test_id',$out);
		$this->load->view('v_footer',$out);
	}
}
