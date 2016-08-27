<?php

/**
 * Created by IntelliJ IDEA.
 * User: bcli
 * Date: 8/23/16
 * Time: 5:53 PM
 */
class Tool
{
    private $CI;    // CodeIgniter instance
    private $out;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->out = $this->CI->conf->config;
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
     * set session language
     * @param $langCode, language code to be set
     * @return string,   session language
     */
    public function setSessionLang ($langCode)
    {
        if ($this->langSupported ($langCode))
        {
            // if we support this language, set session key 'lang' => 'langCode'
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
     * get language code from HTTP request header
     * @return string, language code
     */
    public function getBrowserLang ()
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
     * @return resumeCode, a randomly generated 4 chars string
     */
    public function generateResumeCode ()
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
            if (!$this->CI->m_exams->resumeCodeExists($resumeCode))
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
    public function getAgeByBirthday ($birthday)
    {
        $bday = new DateTime($birthday);
        $today = new DateTime();
        $diff = $today->diff($bday);
        return $diff->y;
    }

    /**
     * get duration of the exam
     * @param $startStr
     * @param $finishStr
     * @return int
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
     * create a new captcha
     * @param $ip, user IP address
     * @return string $imageURL
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
     * check if a given captcha is correct
     * @param $captcha, captcha which user submitted
     * @param $ip, user IP address
     * @return bool
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

    public function re ($uri)
    {
        redirect($this->out['SITE'].$uri);
    }


    /**
     * check if submitted answers are in a correct format
     * @param $in
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