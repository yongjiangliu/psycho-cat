<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Path {

  // Get vars from array $path
  private $path;

  public function __construct()
	{
		$CI =& get_instance();
		$CI->load->helper('url');

    // Site folder path
		$this->path['ROOT'] 	 	     = '/home/pi_ftp/www';

    // Resources
		$this->path['CSS']		       = base_url().'res/css/';
		$this->path['JS']		         = base_url().'res/js/';
    $this->path['IMG']           = base_url().'res/img/';
    $this->path['FONT']          = base_url().'res/fonts/';
    $this->path['ICON']          = base_url().'res/icon/';
    $this->path['TEMPLATE']      = base_url().'res/template/';

		// Base URL
		$this->path['BASE']          = base_url();

		// Site Url
		$this->path['SITE']          = site_url().'/';

		// Controllers
		$this->path['HOME']          = site_url().'/home';
    $this->path['TEST']          = site_url().'/test';
		$this->path['ADMIN']         = site_url().'/admin';
    $this->path['ERROR']         = site_url().'/error';

		// AJAX Url
		$this->path['TEST-AJAX'] 	= base_url().'/test/ajax';

    // title
    $this->path['TXT_TITLE'] = "心理测试";

	}
	public function get()
	{
		return $this->path;
	}
}

?>
