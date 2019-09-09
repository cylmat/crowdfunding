<?php

namespace Classes;

class DatabaseTest extends \PHPUnit\Framework\TestCase
{
    function testAlpha()
    {
        new Database;
        $this->assertTrue(true);
    }
}