<?php

/**
 * Created by IntelliJ IDEA.
 * User: bcli
 * Date: 8/8/16
 * Time: 11:51 AM
 */
class M_settings extends CI_Model
{
    private $table = "settings"; // table name

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->db->select('*');
        $this->db->where('id',1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
}