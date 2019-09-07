<?php

namespace Classes;

class Records
{
    /**
     * Database
     * 
     * @var PDOobject|null
     */
    protected $db=null;

    /**
     * Table name
     */
    protected $tableName;

    /**
     * Data storage
     * 
     * @var array
     */
    protected $data=[];

    public function __construct(string $tableName)
    {
        try {
            $access = new \PDO("mysql:host=".CONFIG['DB']['host'].";dbname=".CONFIG['DB']['dbname'],CONFIG['DB']['user'],CONFIG['DB']['pass']);
        } catch(\PDOException $e) { 
            echo $e;
            return null;
        }

        $this->db = $access;
        $this->tableName = $tableName;
    }

    public function __set(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get(string $name)
    {
        if(array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }

    public function create(): bool
    {
        
    }

    public function update(): bool
    {

    }

    public function delete(): bool
    {

    }

    public function get(): ?array
    {

    }

    public function getId(int $id): ?array
    {

    }
}