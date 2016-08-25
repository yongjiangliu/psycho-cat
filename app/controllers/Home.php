<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Home
 * controller of the home page, which means
 * http://www.mysite.com/home/*
 *
 * steps for subject to take an exam:
 * 1. fill & submit 'subject information' form
 * 2. get resume code
 * 3. start exam
 * 4. stop & resume whenever he likes
 * 5. finish exam
 *
 * @since v0.1.0
 * @author bcli, 2016-8-9
 */
class Home extends CI_Controller
{
	private $out;	    // config array

	public function __construct()
	{
		parent::__construct();
		$this->out = $this->conf->config;	// add config array to default output
	}
    /**
     * ------------------------------------
     *              ROUTES
     * ------------------------------------
     */
    /**
     * Home page
     * @route http://www.mysite.com/home
     */
    public function index()
    {
        redirect($this->out['HOME']."/form", 'refresh');
    }
	/**
	 * (Actual) Home page
	 * @route http://www.mysite.com/home/form[/errCode]
     * @param errCode null error code is defined in ./app/libraries/Conf.php
	 */
	public function form ($errCode = null)
	{
		// check session language
		$lang = $this->tool->getSessionLang();
        // use browser language if not set
		if ($lang == null)
		{
			$lang = $this->tool->setSessionLang($this->tool->getBrowserLang());
		}
        // render & return page to user
		$out            = $this->out;
        $out['errCode'] = $errCode;
		$this->lang->load($lang,$lang);         // load ($langFolder, $langFile), ex: ./app/language/en/en_lang.php
		$this->load->view('v_header', 	$out);
		$this->load->view('v_home',		$out);
		$this->load->view('v_footer',	$out);
	}
	/**
     * set session language
     * we provide a API for user to set session language manually, this API can be accessed by
     * clicking the 'earth button' on navigation bar
	 * @route http://www.mysite.com/home/lang[/langCode]
	 * @param $langCode, language code to be set, ex: 'ja' for japanese, see ./app/language for supported languages
     * @see   http://www.w3schools.com/tags/ref_language_codes.asp for ISO 639-1 language codes
	 */
	public function lang ($langCode)
	{
        // NOTE: if you set a unsupported language, ex: 'ab' for `Abkhazian`,
        // the system will automatically reset it to 'en' for 'English'
		$this->tool->setSessionLang($langCode);
		redirect($this->out['HOME'], 'refresh');
	}

    public function resume ($errCode = -1, $resume_code = null)
    {
        // check session language
        $lang = $this->tool->getSessionLang();
        // use browser language if not set
        if ($lang == null) {$lang = $this->tool->setSessionLang($this->tool->getBrowserLang());}
        // render & return page to user
        $out                = $this->out;
        $out['errCode']     = $errCode;
        $out['resume_code'] = $resume_code;
        $this->lang->load($lang,$lang);
        $this->load->view('v_header', 	$out);
        $this->load->view('v_home_code',$out);
        $this->load->view('v_footer',	$out);
    }

	/**
     * check subject information
     * the 'subject information' will be POST to this route
	 * @route http://www.mysite.com/home/check
	 */
	public function check ()
	{
		// get regular expressions from Conf.php
        $regexArray = $this->out['REGEX'];
		// get POST array through CI XSS filter
		$in = $this->input->post(NULL, TRUE);
		// check if all fields are submitted & correct by regular expression
		$error = 0;
		foreach ($regexArray['subject_form'] as $field => $regex)
		{
			if (isset($in[$field]))
            {
                $in[$field] = trim($in[$field]);
                if (!preg_match($regex, $in[$field]))
                {
                    $error ++;
                }
                else
                {
                    continue;
                }
			}
			else
            {
                $error++;
			}
		}
        // count how many errors we got
        // if we got no errors, insert form information to database, set session and redirect
        // to resume code generation page
        if ($error == 0)
        {
            // show error if provided name exists
            $name        = $in['name'];
            if ($this->m_exams->nameExists($name))
            {
                redirect($this->out['HOME']."/form/11");
            }
            // else get necessary arguments
            $resume_code = $this->tool->generateResumeCode();
            $ip          = $this->input->ip_address();
            $age         = $this->tool->getAgeByBirthday($in['birthday']);
            // insert subject information to database
            $dbResult = $this->m_exams->add($in['name'], $in['occupation'], $in['gender'], $in['birthday'],$age, $in['education'],
                            $in['bloodType'], $in['marriage'], $resume_code, $ip, date("Y-m-d H:i:s"));
            // if insertion successful
            if ($dbResult)
            {
                // check session language
                $lang = $this->tool->getSessionLang();
                // use browser language if not set
                if ($lang == null) {$lang = $this->tool->setSessionLang($this->tool->getBrowserLang());}
                // render & return page to user
                redirect($this->out['HOME']."/resume/-1/".$resume_code);
            }
            else
            {
                // show database error if insertion failed
                redirect($this->out['HOME']."/form/6");
            }
        }
        else
        {
            // show 'invalid form' error if the submitted form failed to pass regex check
            redirect($this->out['HOME']."/form/10");
        }
	}
}