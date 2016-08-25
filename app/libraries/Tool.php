<?php

/**
 * Created by IntelliJ IDEA.
 * User: bcli
 * Date: 8/23/16
 * Time: 5:53 PM
 */
class Tool
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
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
        $CONFIG = $this->CI->conf->config;
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

        $output = $sec + " s";
        if ($min != 0)
        {
            $output = $min + " m " + $output;
        }
        if ($hour != 0)
        {
            $output = $hour + " h " + $output;
        }
        if ($day != 0)
        {
            $output = $day + " d " + $output;
        }
        if ($month !=0)
        {
            $output = $month + " m " + $output;
        }
        if ($year !=0)
        {
            $output = $year + " y " + $output;
        }
        return $output;
    }
}