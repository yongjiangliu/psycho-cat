<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model unit test
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
     * unit test of model m_admins
     * @since v0.1.0
     */
    public function admin()
    {
        /*
         * ---------- API list
         * getAll ()
         * getById ($admin_id)
         * getByUsername ($username)
         * usernameExists ($username)
         * idExists ($admin_id)
         * userPassPairExists ($username, $password)
         * authed ($username, $password, $ip, $datetime)
         * add ($username, $password, $id, $ip, $datetime)
         * changePassword ($admin_id, $oldPassword, $newPassword, $id, $ip, $datetime)
         * updateLoginInfo ($username, $password, $ip, $datetime)
         *  remove ($admin_id, $id, $ip, $datetime)
        */

        echo "Testing model admin";
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
     */
    public function question()
    {

    }

    /**
     * unit test of model m_exams
     */
    public function exam()
    {

    }

}