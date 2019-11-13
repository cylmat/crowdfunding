<?php declare(strict_types = 1);

namespace Classes;

/**
 * Connexion à la base
 */
class Database
{
    protected $db=null;

    public function __construct()
    {
        try {
            $dns = "mysql:host=".CONFIG['DB']['host'].";dbname=".CONFIG['DB']['dbname'];
            $access = new \PDO($dns, CONFIG['DB']['user'], CONFIG['DB']['pass']);
            $this->db = $access;
        } catch(\PDOException $e) { 
            //echo $e; 
        }
    }
}
