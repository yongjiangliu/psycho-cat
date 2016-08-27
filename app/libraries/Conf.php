<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Project custom configurations
 *
 * @since v0.1.0
 * @author	bcli
 * @date	2016-7-2
 */
class Conf {

  	public $config;

	public function __construct()
	{
		$CI =& get_instance();
		$CI->load->helper('url');

		// Captcha
		$this->config['CAPTCHA_TTL']   = 600;   // 10 min

        $this->config['SITE']          = site_url();

		// Resources
		$this->config['CSS']		   = base_url().'res/css/';
		$this->config['JS']		       = base_url().'res/js/';
		$this->config['IMG']           = base_url().'res/img/';
		$this->config['FONT']          = base_url().'res/fonts/';
		$this->config['TEMPLATE']      = base_url().'res/template/';
		$this->config['CAPTCHA']	   = base_url().'res/captcha/';
        $this->config['TEMPLATE']      = base_url().'res/template/';
        $this->config['UPLOAD']        = base_url().'upload';
        $this->config['EXAM_IMG']      = base_url().'res/exam_img/';

		// Controllers
		$this->config['HOME']          = site_url().'home';
		$this->config['EXAM']		   = site_url().'exam';
		$this->config['ADMIN']         = site_url().'admin';
		$this->config['ERROR']         = site_url().'err';
		$this->config['TEST']          = site_url().'test';


		// Title
		$this->config['APP_NAME']	   = "PsychoCat";

		// Languages
		$this->config['LANGS']		   = array (
											'ar' 	=> 'العربية',
											'en'	=> 'English',
											'es' 	=> 'Español',
											'ja' 	=> '日本語',
											'ko' 	=> '한국어',
											'ru' 	=> 'русский',
											'zh-cn' => '简体中文',
											'zh-tw' => '繁體中文'
										);
		// Regular expressions
		$this->config['REGEX']		 = array (
											'subject_form' => array (
																'name'	        => '/^(.){1,32}$/',
                                                                'occupation'    => '/^(.){1,64}$/',
																'gender'	    => '/^[0-1]{1}$/',
																'birthday'      => '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',
                                                                'education'     => '/^[1-6]{1}$/',
                                                                'bloodType'     => '/^(A|B|AB|O)$/',
                                                                'marriage'      => '/^[0-1]{1}$/'
																),
											'resume_code' => '/^(A-Z0-9){4}$/',
											'question_form' => array (
																'jd'	=> '/^(0|1)$/',
																'sc'	=> '/^[0-9]{1}$/',
																'mc'	=> '/^[0-9]{1,9}$/',
																'type'  => '/^(jd|sc|md)$/'
											)
									);

	}
}
?>
