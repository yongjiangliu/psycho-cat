<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	private $out;

	// Constructor
	public function __construct()
	{
		parent::__construct();
		$this->out = $this->conf->path;
	}

	// Default controller
	public function index()
	{
		$out = $this->out;
		$this->load->view('v_header',$out);
		$this->load->view('v_home',$out);
	}

	public function getTestCode()
	{
		// check list
		$checkList = array ("name","occupation","gender","birthday","education","bloodType","marriage");
		// filter & get posts
		$in = $this->input->post(NULL, TRUE);
		//var_dump($data);
		// check if all fields are submitted & not empty
		$error = 0;
		foreach ($checkList as $val)
		{
			if (!isset($in[$val])){
				$error++;
			}
			else {
				if ($in[$val] == '')
				{
					$error++;
				}
			}
		}
		if ($error > 0){
			redirect(site_url(), 'refresh');
		}
		else {
			// store user info, generate test code
			$test_code = $this->m_answer->add($in);
			$out = $this->out;
			if ($test_code == false){
				$out['test_code'] = '--ERROR--';
			}
			else {
				$out['test_code'] = $test_code;
				$out['status']= "out";
			}
			$this->load->view('v_header',$out);
			$this->load->view('v_test_code',$out);
		}
	}
	public function inputTestCode()
	{
		$out = $this->out;
		$out['status'] = "in";
		$this->load->view('v_header',$out);
		$this->load->view('v_test_code',$out);
	}
}
