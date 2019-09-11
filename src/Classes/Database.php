<?php declare(strict_types = 1);

namespace Classes;

class Database
{
    protected $db=null;

    public function __construct()
    {
        try {
            $access = new \PDO("mysql:host=".CONFIG['DB']['host'].";dbname=".CONFIG['DB']['dbname'], CONFIG['DB']['user'], CONFIG['DB']['pass']);
            $this->db = $access;
        } catch(\PDOException $e) { echo $e; 
        }
    }
}
