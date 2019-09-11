<?php

namespace Classes;

class DatabaseTest extends \PHPUnit\Framework\TestCase
{
    function testAlpha()
    {
        $db = new Database;
        $this->assertInstanceOf(Database::class, $db);
    }
}