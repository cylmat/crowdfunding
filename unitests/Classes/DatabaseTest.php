<?php

namespace Classes;

class DatabaseTest extends \PHPUnit\Framework\TestCase
{
    function testConnexion()
    {
        $db = new Database;
        $this->assertInstanceOf(Database::class, $db);
    }
}