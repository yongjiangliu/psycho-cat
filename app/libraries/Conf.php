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

		// Resources
		$this->config['CSS']		   = base_url().'res/css/';
		$this->config['JS']		       = base_url().'res/js/';
		$this->config['IMG']           = base_url().'res/img/';
		$this->config['FONT']          = base_url().'res/fonts/';
		$this->config['TEMPLATE']      = base_url().'res/template/';

		// Controllers
		$this->config['HOME']          = site_url().'/home';
		$this->config['TEST']          = site_url().'/test';
		$this->config['ADMIN']         = site_url().'/admin';
		$this->config['ERROR']         = site_url().'/error';

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
											'zh-tw' => '繁體中文',
										);
	}
}
?>
