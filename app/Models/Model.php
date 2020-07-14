<?php
namespace Commentout\Models;

abstract class Model
{
    public $db;

    public function __construct()
    {
        $this->db = new \Commentout\DB;
    }
}