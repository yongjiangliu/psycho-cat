<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Project custom configurations
 *
 * @author	bcli
 * @date	2016-7-2
 */
class Conf {

  public $path;

  public function __construct()
  {
	  $CI =& get_instance();
	  $CI->load->helper('url');

	  // Resources
	  $this->path['CSS']		   = base_url().'res/css/';
	  $this->path['JS']		       = base_url().'res/js/';
	  $this->path['IMG']           = base_url().'res/img/';
	  $this->path['FONT']          = base_url().'res/fonts/';
	  $this->path['TEMPLATE']      = base_url().'res/template/';

	  // Controllers
	  $this->path['HOME']          = site_url().'/home';
	  $this->path['TEST']          = site_url().'/test';
	  $this->path['ADMIN']         = site_url().'/admin';
	  $this->path['ERROR']         = site_url().'/error';

	  // Title
	  $this->path['APP_NAME']	   = "PsychoCat";
	}
}
?>
