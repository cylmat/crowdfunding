<?php

namespace Classes;

class Record extends Database
{
    /**
     * Permet d'eviter les doublons
     * Obligation d'appeler get avant la function update 
     * 
     * @var bool
     */
    protected $getCalled = false;

    /**
     * throw InvalidArgumentException
     */
    function __set(string $name, $value)
    {
        if(property_exists($this, $name)) {
            $this->$name = $value;
            return;
        }
        throw new \InvalidArgumentException("Le paramètre $name n'existe pas");
    }

    /**
     * throw InvalidArgumentException
     */
    function __get(string $name)
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        throw new \InvalidArgumentException("Le paramètre $name n'existe pas");
    }

    function create(): bool
    {

    }

    function update(): bool
    {

    }

    function delete(string $id)
    {

    }

    function get(int $id): array
    {
        $this->getCalled = true;
    }

    function gets(): array
    {

    }

    function getLastInsertId(): int
    {

    }
}