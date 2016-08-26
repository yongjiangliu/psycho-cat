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
		$this->tool->re('err/code/0');
	}

    /**
     * show error message by a given error code
     * @see ./app/lanuage
     * @param int $errCode, error code provided
     */
	public function code($errCode = 0)
	{
        $data = array ('errCode' => $errCode);
        $this->tool->render('error', $data);
	}
}
