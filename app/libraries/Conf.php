<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Conf
 *
 * PsychoCat configurations
 *
 * @since   v0.1.0
 * @author  bcli
 * @date	2016-7-2
 */
class Conf {

  	public $config;
    private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
        /*
         * ------------------------------------
         *          Application Name
         * ------------------------------------
         */
        $this->config['APP_NAME']	   = "PsychoCat";

        /*
         * ------------------------------------
         *                  URIs
         * ------------------------------------
         */

        // Site URL (ex: http://www.mysite.com), defined in ./app/config/config.php
        $this->config['SITE']          = site_url();

        // Controllers
        $this->config['HOME']          = site_url().'home';
        $this->config['EXAM']		   = site_url().'exam';
        $this->config['ADMIN']         = site_url().'admin';
        $this->config['ERROR']         = site_url().'err';

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

        /*
         * ------------------------------------
         *              Captcha
         * ------------------------------------
         */
        $this->config['CAPTCHA_TTL']   = 600;   // Captcha expiration time in seconds, default 600s = 10m

        /*
         * ------------------------------------
         *              Language
         * ------------------------------------
         */
		// Supported Languages, using language code defined by ISO 639-1
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
        /*
         * ------------------------------------
         *         Regular Expression
         * ------------------------------------
         */
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
