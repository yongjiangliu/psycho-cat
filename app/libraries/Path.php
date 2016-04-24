<?php
// Add this line to avoid direct script access
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	PATH Library
* Defines pathes
* @author bcli, 2016-4-24
* @since v1.0
*/
class PATH {

  // Store path information
  private $PATH;

  /**
  * CI library constructor
  */
  public function __construct()
	{
		$CI =& get_instance();
		$CI->load->helper('url');

    // Site folder PATH
		$this->PATH['ROOT'] 	 	     = '/home/pi_ftp/www';

    // Resources
		$this->PATH['CSS']		       = base_url().'res/css/';
		$this->PATH['JS']		         = base_url().'res/js/';
    $this->PATH['IMG']           = base_url().'res/img/';
    $this->PATH['FONT']          = base_url().'res/fonts/';
    $this->PATH['ICON']          = base_url().'res/icon/';
    $this->PATH['TEMPLATE']      = base_url().'res/template/';

		// Base URL
		$this->PATH['BASE']          = base_url();

		// Site Url
		$this->PATH['SITE']          = site_url().'/';

		// Controllers
		$this->PATH['HOME']          = site_url().'home';
    $this->PATH['TEST']          = site_url().'test';
		$this->PATH['ADMIN']         = site_url().'admin';
    $this->PATH['ERROR']         = site_url().'error';
	}
  /**
  * Get $PATH
  * @return PATH, containing pathes defined above
  */
	public function get()
	{
		return $this->PATH;
	}
}
?>
