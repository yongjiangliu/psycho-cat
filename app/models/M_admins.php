<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class M_admin
 * model which interacts with table 'admins'
 * default username/password is 'admin/admin', modify it as soon as you deploy PsychoCat
 * to limit the maximum admin number modify 'MAX_ADMINS' in './app/libraries/Conf.php',
 * default maximum admin number is 10
 * @author bcli, 2016-8-9
 * @since v0.1.0
 */
class M_admins extends CI_Model {

    private $table = "admins";  // table name

    public function __construct()
    {
        parent::__construct();
    }
    //-----------
    //    SELECT
    //-----------
    /**
     * get everything in this table
     * @since v0.1.0
     * @return array
     */
    public function getAll ()
    {
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * get admin record by admin_id
     * @since v0.1.0
     * @param admin_id
     * @return array
     */
    public function getById ($admin_id)
    {
        $this->db->select("*");
        $this->db->where('admin_id', $admin_id);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * get admin record by username
     * @since v0.1.0
     * @param $username
     * @return array
     */
    public function getByUsername ($username)
    {
        $this->db->select("*");
        $this->db->where('username', $username);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result_array();
    }
    /**
     * check if a given username exists
     * @since v0.1.0
     * @param $username,    username to be checked
     * @return bool
     */
    public function usernameExists ($username)
    {
        $this->db->select("*");
        $this->db->where('username', $username);
        $this->db->from($this->table);
        $num = $this->db->count_all_results();
        if ($num != 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * check if given admin_id exists
     * @since v0.1.0
     * @param $admin_id,    admin id to be checked
     * @return bool
     */
    public function idExists ($admin_id)
    {
        $this->db->select("*");
        $this->db->where('admin_id', $admin_id);
        $this->db->from($this->table);
        $num = $this->db->count_all_results();
        if ($num != 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * check if a given username and password pair exists
     * @since v0.1.0
     * @param $username
     * @param $password
     * @return bool
     */
    public function userPassPairExists ($username, $password)
    {
        $this->db->select("*");
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->from($this->table);
        $num = $this->db->count_all_results();
        if ($num != 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * login authentication
     * @since v0.1.0
     * @param $username,    admin username
     * @param $password,    admin password
     * @param $auth_from,   authentication attempt came from which IP address
     * @param $auth_at,     when did this attempt took place (datetime)
     * @return bool
     */
    public function authed ($username, $password, $auth_from, $auth_at)
    {
        if ($this->userPassPairExists($username, $password))
        {
            if ($this->updateLoginInfo($username, $password, $auth_from, $auth_at))
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
    //-----------
    //    INSERT
    //-----------
    /**
     * add an admin to database
     * @since v0.1.0
     * @param $username,        username of the new admin
     * @param $password,        password of the new admin
     * @param $created_by,      created by which admin_id
     * @param $created_from,    created from which IP address
     * @param $created_at,      when is this admin created (datetime)
     * @return bool
     */
    public function add ($username, $password, $created_by, $created_from, $created_at)
    {
        if ($this->usernameExists($username))
        {
            return false;
        }
        else
        {
            $data = array(
                'username'      => $username,
                'password'      => $password,
                'created_by'    => $created_by,
                'created_from'  => $created_from,
                'created_at'    => $created_at
            );
            return $this->db->insert($this->table, $data);
        }
    }
    //-----------
    //    UPDATE
    //-----------
    /**
     * change admin password
     * @since v0.1.0
     * @param $username,        admin username
     * @param $oldPassword,     must provide old password for safety check
     * @param $newPassword,     new password to be set
     * @param $modified_from,   changed from which IP address
     * @return bool
     */
    public function changePassword ($username, $oldPassword, $newPassword, $modified_from)
    {
        if (!$this->userPassPairExists($username, $oldPassword))
        {
            return false;
        }
        else
        {
            $data = array(
                'password'              => $newPassword,
                'last_modified_from'    => $modified_from
            );
            $this->db->where('username', $username);
            $this->db->where('password', $oldPassword);
            return $this->db->update($this->table, $data);
        }
    }

    /**
     * update login information (last_login_ip, last_login_time)
     * @since v0.1.0
     * @param $username,    admin username
     * @param $password,    admin password
     * @param $login_from,  login IP
     * @param $login_at,    login time (datetime)
     * @return bool
     */
    public function updateLoginInfo ($username, $password, $login_from, $login_at)
    {
        if (!$this->userPassPairExists($username, $password))
        {
            return false;
        }
        else
        {
            $data = array(
                'last_login_from'   => $login_from,
                'last_login_at'     => $login_at
            );
            $this->db->where('username', $username);
            $this->db->where('password', $password);
            return $this->db->update($this->table, $data);
        }
    }

    //-----------
    //    DELETE
    //-----------
    /**
     * remove admin from database
     * @since v0.1.0
     * @param $admin_id,     target admin to be removed
     * @param $removed_by,   removed by which admin_id
     * @param $removed_from, removed from which IP address
     * @param $removed_at,   when this action took place (datetime)
     * @return bool
     */
    public function remove ($admin_id, $removed_by, $removed_from, $removed_at)
    {
        if (!$this->idExists($admin_id))
        {
            return false;
        }
        else
        {
            $this->db->where('admin_id', $admin_id);
            //TODO: log this event
            return $this->db->delete($this->table);
        }
    }
}
