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
		$lang = $this->getSessionLang();
        // use browser language if not set
		if ($lang == null)
		{
			$lang = $this->setSessionLang($this->getBrowserLang());
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
		$this->setSessionLang($langCode);
		redirect($this->out['HOME'], 'refresh');
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
            $resume_code = $this->generateResumeCode();
            $ip          = $this->input->ip_address();
            $age         = $this->getAgeByBirthday($in['birthday']);
            // insert subject information to database
            $dbResult = $this->m_exams->add($in['name'], $in['occupation'], $in['gender'], $in['birthday'],$age, $in['education'],
                            $in['bloodType'], $in['marriage'], $resume_code, $ip, date("Y-m-d H:i:s"));
            // if insertion successful
            if ($dbResult)
            {
                // get exam_id
                $exam_record = $this->m_exams->getByResumeCodeAndName ($resume_code, $name);
                if (count($exam_record) != 0)
                {
                    // set exam_id in session
                    if (isset($exam_record['exam_id']))
                    {
                        // start exam
                        $this->session->set_userdata('exam_id', $exam_record['exam_id']);
                        echo "success";
                        redirect($this->out['EXAM'], 'refresh');
                    }
                    else
                    {
                        // show database error if we can't get exam_id
                        redirect($this->out['HOME']."/form/6");
                    }
                }
                else
                {
                    // show database error if we can't get inserted exam record
                    redirect($this->out['HOME']."/form/6");
                }
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

    /**
     * ------------------------------------
     *              METHODS
     * ------------------------------------
     */
	/**
	 * get session language, return null if not set
	 * @return langCode or null
	 */
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

	/**
	 * set session language
	 * @param $langCode, language code to be set
	 * @return string,   session language
	 */
	private function setSessionLang ($langCode)
	{
		if ($this->langSupported ($langCode))
        {
            // if we support this language, set session key 'lang' => 'langCode'
            $this->session->set_userdata('lang', $langCode);
            return $langCode;
        }
        else
        {
            // if we don't support this language, set session key 'lang' => 'en'
            $this->session->set_userdata('lang', 'en');
            return 'en';
        }
	}

	/**
	 * get language code from HTTP request header
	 * @return string, language code
	 */
	private function getBrowserLang ()
	{
		return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	}

	/**
	 * check if we support this language
     * to define a new supported language,
     * go to ./app/language to add a new folder & files, then modify config['LANGS'] in ./app/libraries/Conf.php
	 * @param $langCode, language code to be checked
	 * @return boolean
	 */
	private function langSupported ($langCode)
	{
		$CONFIG = $this->conf->config;
		$LANGS = $CONFIG['LANGS'];
		foreach ($LANGS as $key => $val)
		{
			if ($key == $langCode)
			{
				return true;
			}
		}
		return false;
	}

    /**
     * generate a random & unique resume code
     * @return resumeCode, a randomly generated 4 chars string
     */
    private function generateResumeCode ()
    {
        while(true)
        {
            $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789');
            shuffle($seed);
            $resumeCode = '';
            foreach (array_rand($seed, 4) as $k)
            {
                $resumeCode .= $seed[$k];
            }
            if (!$this->m_exams->resumeCodeExists($resumeCode))
            {
                return $resumeCode;
            }
        }

    }

    /**
     * get user age by birthday
     * @param birthday, birthday submitted by user in format of YYYY-MM-DD, ex 1900-01-01
     * @return age, calculated user age
     */
    private function getAgeByBirthday ($birthday)
    {

        $bday = new DateTime($birthday);
        $today = new DateTime();
        $diff = $today->diff($bday);
        return $diff->y;
    }

}