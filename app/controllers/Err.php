<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Err
 * Show error message depend on given error code
 * The error code & error message pairs are defined in ./app/language
 * @since v0.1.0
 */
class Err extends CI_Controller
{
	private $out;

	public function __construct()
	{
		parent::__construct();
		$this->out = $this->conf->config;
	}

    /**
     * default controller, auto redirect to code/0
     * @route http://www.mysite.com/err
     */
	public function index()
	{
		redirect($this->out['ERROR']."/code/0");
	}

    /**
     * show error message by a given error code
     * @see ./app/lanuage
     * @param int $errCode, error code provided
     */
	public function code($errCode = 0)
	{
		// check session language
		$lang = $this->tool->getSessionLang();
		// use browser language if not set
		if ($lang == null) {$lang = $this->tool->setSessionLang($this->tool->getBrowserLang());}
		// render & return page to user
		$out                = $this->out;
		$out['errCode']     = $errCode;
		$this->lang->load($lang,$lang);
		$this->load->view('v_header', 	$out);
		$this->load->view('v_error',	$out);
		$this->load->view('v_footer',	$out);
	}
}
