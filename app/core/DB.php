<?php
namespace Commentout;

class DB
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new \mysqli(
                "localhost",
                "root",
                "12341234",
                "commentout"
            );
        } catch (\mysqli_sql_exception $e) {
            print_r($e->getMessage());
            die;
        }

        $this->db->set_charset("utf8");
    }

    public function query($sql)
    {
        return $this->db->query($sql);
    }

    public function getDbInstatce()
    {
        return $this->db;
    }
}