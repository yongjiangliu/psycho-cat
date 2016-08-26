<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Unit tests
 * @author bcli, 2016-8-9
 * @since v0.1.0
 */
class Test extends CI_Controller
{
    // Constructor
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * unit tests of model m_admins
     * @since v0.1.0
     */
    public function admin()
    {
        /*
         * ===================
         *  Model admin  APIs
         * ===================
         * -------------------------------------------------- SELECT
         * getAll ()
         * getById ($admin_id)
         * getByUsername ($username)
         * usernameExists ($username)
         * idExists ($admin_id)
         * userPassPairExists ($username, $password)
         * authed ($username, $password, $ip, $datetime)
         * -------------------------------------------------- INSERT
         * add ($username, $password, $id, $ip, $datetime)
         * ---------- UPDATE
         * changePassword ($admin_id, $oldPassword, $newPassword, $id, $ip, $datetime)
         * updateLoginInfo ($username, $password, $ip, $datetime)
         * -------------------------------------------------- DELETE
         * remove ($admin_id, $id, $ip, $datetime)
        */

        echo "======================<br>";
        echo " Testing model m_admins<br>";
        echo "======================<br>";
        $result = array();

        // getAll ()
        echo "<br><br>getAll<br>";
        $result = $this->m_admins->getAll();
        foreach ($result as $row) {var_dump($row);}

        // getById ($admin_id)
        echo "<br><br>getById<br>";
        $result = $this->m_admins->getById(2);
        foreach ($result as $row) {var_dump($row);}

        $result = $this->m_admins->getById(3);
        echo "<br>".count($result);

        // getByUsername ($username)
        echo "<br><br>getByUsername<br>";
        $result = $this->m_admins->getByUsername("admin");
        foreach ($result as $row) {var_dump($row);}

        // usernameExists ($username)
        echo "<br><br>usernameExists<br>";
        $bool =  $this->m_admins->usernameExists("admin");
        var_dump($bool);
        $bool =  $this->m_admins->usernameExists("someUser");
        var_dump($bool);

        // idExists ($admin_id)
        echo "<br><br>idExists<br>";
        $bool =  $this->m_admins->idExists(1);
        var_dump($bool);
        $bool =  $this->m_admins->idExists(5);
        var_dump($bool);

        // userPassPairExists ($username, $password)
        echo "<br><br>userPassPairExists<br>";
        $bool =  $this->m_admins->userPassPairExists("admin","admin");
        var_dump($bool);
        $bool =  $this->m_admins->userPassPairExists("admin","somePass");
        var_dump($bool);

        // authed ($username, $password, $ip, $datetime)
        echo "<br><br>authed<br>";
        $bool =  $this->m_admins->authed("admin","admin","10.10.10.10","2016-8-10 3:11:25");
        var_dump($bool);
        $bool =  $this->m_admins->authed("admin","somePass","10.10.10.10","2016-8-10 3:11:25");
        var_dump($bool);

        // add ($username, $password, $id, $ip, $datetime)
        echo "<br><br>add<br>";
        $bool =  $this->m_admins->add("test","test",1,"6.6.6.6","2016-8-10 3:11:25");
        var_dump($bool);
        $bool =  $this->m_admins->add("admin","somePass",1,"6.6.6.6","2016-8-10 3:11:25");
        var_dump($bool);

        // changePassword ($admin_id, $oldPassword, $newPassword)
        echo "<br><br>changePassword<br>";
        $bool =  $this->m_admins->changePassword("admin","ffff","newPass1","1.1.1.1");
        var_dump($bool);
        $bool =  $this->m_admins->changePassword("someUser","somePass","newPass","1.1.1.1");
        var_dump($bool);

        // updateLoginInfo ($username, $password, $ip, $datetime)
        echo "<br><br>updateLoginInfo<br>";
        $bool =  $this->m_admins->updateLoginInfo("admin","newPass1", "2.2.2.2", "1997-10-03 2:22:22");
        var_dump($bool);
        $bool =  $this->m_admins->updateLoginInfo("admin","somePass", "2.2.2.2", "1997-10-03 2:22:22");
        var_dump($bool);

        // remove ($admin_id, $id, $ip, $datetime)
        echo "<br><br>remove<br>";
        $bool = $this->m_admins->remove(4,1,"1.1.1.1","1987-10-03 2:22:22");
        var_dump($bool);
        $bool = $this->m_admins->remove(5,1,"1.1.1.1","1987-10-03 2:22:22");
        var_dump($bool);
    }

    /**
     * unit test of model m_questions
     * @since v0.1.0
     */
    public function question()
    {
        /*
         * ===================
         *  Model admin  APIs
         * ===================
         * -------------------------------------------------- SELECT
         * getAll ()
         * getById ($question_id)
         * getByTypeString ($typeString)
         * idExists ($question_id)
         * countAll ()
         * countByTypeString ($typeString)
         * -------------------------------------------------- INSERT
         * add ($typeString, $question, $options, $scores)
         * -------------------------------------------------- DELETE
         * deleteById ($question_id)
         * deleteByTypeString ($typeString)
         * truncate ()
         */
        echo "======================<br>";
        echo " Testing model m_questions<br>";
        echo "======================<br>";
        $result = array();

        // getAll ()
        echo "<br><br>getAll<br>";
        $result = $this->m_questions->getAll();
        foreach ($result as $row) {var_dump($row);}

        // getById ($question_id)
        echo "<br><br>getById<br>";
        $result = $this->m_questions->getById(1);
        foreach ($result as $row) {var_dump($row);}

        // getByTypeString ($typeString)
        echo "<br><br>getByTypeString<br>";
        $result = $this->m_questions->getByTypeString('jd');
        foreach ($result as $row) {var_dump($row);}

        // idExists($questino_id)
        echo "<br><br>idExists<br>";
        $bool =  $this->m_questions->idExists(1);
        var_dump($bool);
        $bool =  $this->m_questions->idExists(-1);
        var_dump($bool);

        // countAll()
        echo "<br><br>countAll()<br>";
        $int =  $this->m_questions->countAll();
        var_dump($int);

        // countByTypeString ($typeString)
        echo "<br><br>countByTypeString()<br>";
        $int =  $this->m_questions->countByTypeString('jd');
        var_dump($int);
        $int =  $this->m_questions->countByTypeString('sc');
        var_dump($int);
        $int =  $this->m_questions->countByTypeString('mc');
        var_dump($int);

        // add ($typeString, $question, $options, $scores)
        $options    = array ('o1','o2','o3','o4','o5','o6','o7','o8','o9','o10');
        $scores     = array (1,2,3,4,5,6,7,8,9,10);
        echo "<br><br>add()<br>";
        $bool =  $this->m_questions->add('mc','choose a option',$options,$scores);
        var_dump($bool);

        // deleteById ($question_id)
        echo "<br><br>deleteById()<br>";
        $bool =  $this->m_questions->deleteById(3);
        var_dump($bool);

        // deleteByTypeString ($typeString)
        echo "<br><br>deleteByTypeString()<br>";
        $bool =  $this->m_questions->deleteByTypeString('sc');
        var_dump($bool);

        echo "<br><br>truncate()<br>";
        $bool = $this->m_questions->truncate();
        var_dump($bool);
    }

/**
* unit tests of model m_exams
* @since v0.1.0
*/
    public function exam()
    {
        /*
         * ===================
         *  Model exam  APIs
         * ===================
         * -------------------------------------------------- SELECT
         * getAll ()
         * getFinished ()
         * getUnfinished ()
         * getById ($exam_id)
         * getByName ($name)
         * getByGenderCode ($genderCode)
         * getByMarriageCode ($marriageCode)
         * getByEducation ($education)
         * getByBloodType ($bloodType)
         * getByAge ($age)
         * getByResumeCode ($resume_code)
         * getByResumeCodeAndName ($resume_code, $name)
         * getByAgeWithinRange ($minAge, $maxAge)
         * getByFinishTime ($datetime)
         * getByFinishTimeWithinRange ($startDatetime, $endDatetime)
         * nameExists ($name)
         * idExists ($exam_id)
         * resumeCodeExists ($resume_code)}
         * resumeCodeCorrect ($exam_id, $resume_code)
         * -------------------------------------------------- INSERT
         * add ($name, $occupation, $gender, $birthday, $education, $bloodType,
                             $marriage, $resume_code, $created_from, $created_at)
         *
         * -------------------------------------------------- UPDATE
         * appendAnswer ($exam_id, $answer)
         * setStartTime ($exam_id, $start_at)
         * setFinishTime ($exam_id, $finish_at)
         * finishExam ($exam_id)
         * -------------------------------------------------- DELETE
         * deleteById ($exam_id)
         * deleteByName ($name)
         * deleteBeforeDatetime ($datetime)
         * truncate ()
         */
        echo "======================<br>";
        echo " Testing model m_exam<br>";
        echo "======================<br>";
        $result = array();

        // getAll ()
        echo "<br><br>getAll<br>";
        $result = $this->m_exams->getAll();
        foreach ($result as $row) {var_dump($row);}

        // getFinished ()
        echo "<br><br>getFinished<br>";
        $result = $this->m_exams->getFinished();
        foreach ($result as $row) {var_dump($row);}

        // getUnfinished ()
        echo "<br><br>getUnfinished<br>";
        $result = $this->m_exams->getUnfinished();
        foreach ($result as $row) {var_dump($row);}

        // getById ($exam_id)
        echo "<br><br>getById<br>";
        $result = $this->m_exams->getById(1);
        foreach ($result as $row) {var_dump($row);}

        // getByName ($name)
        echo "<br><br>getByName<br>";
        $result = $this->m_exams->getByName("bcli");
        foreach ($result as $row) {var_dump($row);}

        // getByGenderCode ($genderCode)
        echo "<br><br>getByGenderCode<br>";
        $result = $this->m_exams->getByGenderCode(1);
        foreach ($result as $row) {var_dump($row);}

        // getByMarriageCode ($marriageCode)
        echo "<br><br>getByMarraigeCode<br>";
        $result = $this->m_exams->getByMarriageCode(1);
        foreach ($result as $row) {var_dump($row);}


        // getByEducation ($education)
        echo "<br><br>getByEducation<br>";
        $result = $this->m_exams->getByEducation("Master");
        foreach ($result as $row) {var_dump($row);}

        // getByBloodType ($bloodType)
         echo "<br><br>getByBloodType<br>";
        $result = $this->m_exams->getByBloodType("A");
        foreach ($result as $row) {var_dump($row);}

        // getByAge ($age)
         echo "<br><br>getByAge<br>";
        $result = $this->m_exams->getByAge(29);
        foreach ($result as $row) {var_dump($row);}

        // getByResumeCode ($resume_code)
        echo "<br><br>getByResumeCode<br>";
        $result = $this->m_exams->getByResumeCode("xyz");
        foreach ($result as $row) {var_dump($row);}

        // getByAgeWithinRange ($minAge, $maxAge)
        echo "<br><br>getByAgeWithinRange<br>";
        $result = $this->m_exams->getByAgeWithinRange(20,30);
        foreach ($result as $row) {var_dump($row);}

        // getByFinishTime ($datetime)
        echo "<br><br>getByFinishTime<br>";
        $result = $this->m_exams->getByFinishTime("2016-8-11 9:00:00");
        foreach ($result as $row) {var_dump($row);}

        // getByFinishTimeWithinRange ($startDatetime, $endDatetime)
        echo "<br><br>getByFinishTimeWithinRange<br>";
        $result = $this->m_exams->getByFinishTime("2016-8-11 9:00:00", "2016-8-11 10:00:00");
        foreach ($result as $row) {var_dump($row);}

        // nameExists ($name)
        echo "<br><br>nameExists<br>";
        $bool = $this->m_exams->nameExists("bcli");
        var_dump($bool);

        // idExists ($exam_id)
        echo "<br><br>idExists<br>";
        $bool = $this->m_exams->idExists(1);
        var_dump($bool);

        // resumeCodeExists ($resume_code)
        echo "<br><br>resumeCodeExists<br>";
        $bool = $this->m_exams->resumeCodeExists("xyz");
        var_dump($bool);

        // resumeCodeCorrect ($exam_id, $resume_code)
        echo "<br><br>resumeCodeCorrect<br>";
        $bool = $this->m_exams->resumeCodeCorrect(1,"xyz");
        var_dump($bool);

        // add ($name, $occupation, $gender, $birthday, $education, $bloodType,
        // $marriage, $resume_code, $created_from, $created_at)
        echo "<br><br>add<br>";
        $bool = $this->m_exams->add('bcli','slave','male','1987-10-03','master','A','unmarried','xxx',
            '2016-8-11 9:00:00','127.0.0.1');
        var_dump($bool);

        // appendAnswer ($exam_id, $answer)
        echo "<br><br>appendAnswer<br>";
        $bool = $this->m_exams->appendAnswer(1,"ABD");
        var_dump($bool);

        // setStartTime ($exam_id, $start_at)
        echo "<br><br>setStartTime<br>";
        $bool = $this->m_exams->setStartTime(1,"2016-8-11 11:00:00");
        var_dump($bool);

        // setFinishTime ($exam_id, $finish_at
        echo "<br><br>setFinishTime<br>";
        $bool = $this->m_exams->setFinishTime (1,"2016-8-11 12:00:00");
        var_dump($bool);

        // finishExam ($exam_id)
        echo "<br><br>finishExam<br>";
        $bool = $this->m_exams->finishExam (6);
        var_dump($bool);

        // deleteById ($exam_id)
        echo "<br><br>deleteById<br>";
        $bool = $this->m_exams->deleteById (7);
        var_dump($bool);

        // deleteByName ($name)
        echo "<br><br>deleteById<br>";
        $bool = $this->m_exams->deleteByName ("whoever");
        var_dump($bool);

        // deleteBeforeDatetime ($datetime)
        echo "<br><br>deleteBeforeDatetime<br>";
        $bool = $this->m_exams->deleteBeforeDatetime ("2016-1-1 1:11:11");
        var_dump($bool);

        // truncate ()
        echo "<br><br>truncate<br>";
        $bool = $this->m_exams->truncate ();
        var_dump($bool);
    }

    public function removeCap()
    {
        $exp = time() - $this->conf->config['CAPTCHA_TTL'];
        echo $exp;
        $this->tool->removeOldCaptcha($exp);
    }
}