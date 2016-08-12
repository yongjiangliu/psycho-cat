<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Home
 * controller of index page
 *
 * normal procedure for a user to take an exam:
 * 1. fill the 'subject information' form
 * 2. get the resume code
 * 3. start exam
 *
 * @since v0.1.0
 * @author bcli, 2016-8-9
 */
class Home extends CI_Controller
{
	private $out;	// add configs to default output

	// Constructor
	public function __construct()
	{
		parent::__construct();
		$this->out = $this->conf->config;
	}

	/**
	 * http://www.mysite.com/home
	 * Index page if the site
	 */
	public function index()
	{
		$lang = $this->getSessionLang();
		// Get browser language settings if no 'lang' key in session
		if ($lang == null)
		{
			$lang = $this->setSessionLang($this->getBrowserLang());
		}
		$this->lang->load($lang,$lang);
		$this->load->view('v_header',$this->out);
		$this->load->view('v_home',$this->out);
		$this->load->view('v_footer',$this->out);
	}


	/**
	 * http://www.mysite.com/home/lang/<langCode>
	 * Manually set site language
	 * @param $langCode, lang code to set
	 */
	public function lang ($langCode)
	{
		$this->setSessionLang($langCode);
		redirect($this->out['HOME'], 'refresh');
	}

	/**
	 * http://www.mysite.com/home/getResumeCode
	 */
	public function getResumeCode()
	{
		// we don't want user to submit
		$this->session->
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

	private function getSessionLang ()
	{
		if ($this->session->has_userdata('lang'))
		{
			return $this->session->userdata('lang');
		}
		else
		{
			return null;
		}
	}

	private function setSessionLang ($lang)
	{
		$this->session->set_userdata('lang', $this->filterLangCode($lang));
		return $lang;
	}

	private function getBrowserLang ()
	{
		return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	}


	/**
	 * check if we have this translation (whether the lang code exists in $this->out->LANGS)
	 * @param $langCode
	 * @return String,  Filtered langCode
	 */
	private function filterLangCode ($langCode)
	{
		$CONFIG = $this->conf->config;
		$LANGS = $CONFIG['LANGS'];
		foreach ($LANGS as $key => $val)
		{
			// if the given lang code is defined, return it
			if ($key == $langCode)
			{
				return $langCode;
			}
		}
		// if the given lang code is not defined, return 'en'
		return 'en';
	}

}
