<?php

/**
 * Class Tool
 *
 * PsychoCat shared functions
 *
 * @since   v0.1.0
 * @author  bcli
 * @date	2016-7-2
 */
class Tool
{
    private $CI;
    private $out;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->out = $this->CI->conf->config;
    }

    /**
     * get 'lang' field in session, return null if not set
     * @see    ISO 639-1
     * @return string $languageCode
     */
    public function getSessionLang ()
    {
        if ($this->CI->session->has_userdata('lang'))
        {
            return $this->CI->session->userdata('lang');
        }
        else
        {
            return null;
        }
    }

    /**
     * set 'lang' field in session
     * @see     ISO 639-1
     * @param   string $langCode, language code to be set
     * @return  string $languageCode, the language code which has been stored to the session
     */
    public function setSessionLang ($langCode)
    {
        if ($this->langSupported ($langCode))
        {
            // if we support this language (defined in ./app/libraries/Conf.php), set session key 'lang' => 'langCode'
            $this->CI->session->set_userdata('lang', $langCode);
            return $langCode;
        }
        else
        {
            // if we don't support this language, set session key 'lang' => 'en'
            $this->CI->session->set_userdata('lang', 'en');
            return 'en';
        }
    }

    /**
     * try to get browser language from HTTP header
     * @return string $languageCode, the default browser language code
     */
    public function getBrowserLang ()
    {
        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }

    /**
     * check if we support this language
     * you can follow these steps to add a new supported language
     * 1. add a new language folder & file under ./app/language,
     * 2. modify config['LANGS'] which is defined in ./app/libraries/Conf.php
     * @param $langCode, language code to be checked
     * @return boolean, whether the language is supported by PsychoCat
     */
    public function langSupported ($langCode)
    {
        $CONFIG = $this->out;
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
     * 'resume code' can be used to resume a test
     * @return resumeCode, a randomly generated 4 chars string
     */
    public function generateResumeCode ()
    {
        while(true)
        {
            // chars which can be used to construct a resume code
            $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789');
            shuffle($seed);
            $resumeCode = '';
            foreach (array_rand($seed, 4) as $k)
            {
                $resumeCode .= $seed[$k];
            }
            if (!$this->CI->m_exams->resumeCodeExists($resumeCode))
            {
                return $resumeCode;
            }
        }

    }

    /**
     * get age by his(her) birthday, please make sure you have set the timezone correctly,
     * which is located at ./app/config/config.php, $config['time_reference']
     * @see http://php.net/manual/en/timezones.php  for timezones avaliable in PHP
     * @param   string $birthday, birthday submitted by user in format of YYYY-MM-DD, ex 1900-01-01
     * @return  string $age,      calculated user age
     */
    public function getAgeByBirthday ($birthday)
    {
        $bday = new DateTime($birthday);
        $today = new DateTime();
        $diff = $today->diff($bday);
        return $diff->y;
    }

    /**
     * get duration of a exam
     * calculates the difference of two DateTimes and returns a formatted result
     * @param string $startStr, when the subject starts the exam
     * @param string $finishStr, when the subject finishes the exam
     * @return string $duration,
     */
    public function getExamDuration ($startStr, $finishStr)
    {
        $start  = new DateTime($startStr);
        $finish = new DateTime($finishStr);
        $diff   = $finish->diff($start);

        $year   = $diff->y;
        $month  = $diff->m;
        $day    = $diff->d;

        $hour   = $diff->h;
        $min    = $diff->i;
        $sec    = $diff->s;

        $output = $sec." s";
        if ($min != 0)
        {
            $output = $min." m ".$output;
        }
        if ($hour != 0)
        {
            $output = $hour." h ".$output;
        }
        if ($day != 0)
        {
            $output = $day." d ".$output;
        }
        if ($month !=0)
        {
            $output = $month." m ".$output;
        }
        if ($year !=0)
        {
            $output = $year." y ".$output;
        }
        return $output;
    }

    /**
     * generate a new captcha and store the image & data
     * @return string $captchaImageURL
     */
    public function createCaptcha ()
    {
        $ip = $this->CI->input->ip_address();
        $vals = array(
            'img_path'      => './res/captcha/',
            'img_url'       => $this->CI->conf->config['CAPTCHA'],
            'img_width'     => 150,
            'img_height'    => 30,
            'expiration'    => $this->CI->conf->config['CAPTCHA_TTL'],
            'word_length'   => 4,
            'font_size'     => 16,
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'        => array(
                'background'    => array(255, 255, 255),
                'border'        => array(255, 255, 255),
                'text'          => array(0, 0, 0),
                'grid'          => array(238, 160, 23)
            )
        );
        $cap = create_captcha($vals);
        $data = array(
            'captcha_time'  => $cap['time'],
            'ip_address'    => $ip,
            'word'          => $cap['word']
        );
        $query = $this->CI->db->insert_string('captcha', $data);
        $this->CI->db->query($query);
        return $cap['image'];
    }

    /**
     * if a submitted captcha is correct
     * @param string $captcha, submitted captcha
     * @return bool  $isCorrect
     */
    public function captchaCorrect ($captcha)
    {
        $ip = $this->CI->input->ip_address();
        $expiration = time() - $this->out['CAPTCHA_TTL'];
        $this->renewCaptcha();
        $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
        $binds = array(strtoupper($captcha), $ip, $expiration);
        $query = $this->CI->db->query($sql, $binds);
        $row = $query->row();
        if ($row->count == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * 
     */
    public function renewCaptcha ()
    {
        $expiration = time() - $this->out['CAPTCHA_TTL'];
        $this->CI->db->select('captcha_time');
        $this->CI->db->where('captcha_time < ', $expiration);
        $query = $this->CI->db->get('captcha');
        $tsArray = $query->result_array();
        
        foreach ($tsArray as $key => $val)
        {
            $mask = './res/captcha/'.$val['captcha_time'].'*.jpg';
            array_map( "unlink", glob($mask) );
        }
        $this->CI->db->where('captcha_time < ' ,$expiration);
        $this->CI->db->delete('captcha');
    }


    public function setLang()
    {
        // try to get language from session
        $lang = $this->getSessionLang();
        // use browser language if not set
        if ($lang == null)
        {
            $lang = $this->setSessionLang($this->getBrowserLang());
        }
        // set output language
        $this->CI->lang->load($lang, $lang);
    }


    public function render($view, $extra_data = null, $useCaptcha = false)
    {
        $this->setLang();
        $out                = $this->out;
        if ($extra_data != null)
        {
            foreach ($extra_data as $key => $val)
            {
                $out[$key] = $val;
            }
        }
        if ($useCaptcha)
        {
            $this->renewCaptcha();
            $out['captcha'] = $this->createCaptcha();
        }
        $this->CI->load->view('v_header', 	$out);
        $this->CI->load->view('v_'.$view,   $out);
        $this->CI->load->view('v_footer',	$out);
    }

    /**
     * page redirect
     * @param string $uri, NOTE: don't include the domain (ex: http://www.mysite.com) and don't start with "/"
     */
    public function re ($uri)
    {
        // ex: admin/panel/exam/get/all
        // ex: home/form
        redirect($this->out['SITE'].$uri);
    }

    /**
     * if answer
     * @param array $in, form POST
     * @return bool
     */
    public function answerFormatCorrect ($in)
    {
        if (isset($in['answer']) && isset($in['type']))
        {
            $regexArray     = $this->out['REGEX'];
            $regex          = $regexArray['question_form'];
            $answer         = $in['answer'];
            $type           = $in['type'];

            if (preg_match($regex[$type], $answer))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    // session check
    public function adminSessionExists ()
    {
        if (!$this->CI->session->has_userdata('admin')){
            return false;
        }
        else
        {
            if ($this->CI->session->userdata('admin') == "Ane_89M-2kn")
            {
                return true;
            }
            else {
                return false;
            }
        }
    }
}