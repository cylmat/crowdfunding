<?php

namespace Classes;

class RecordTest extends \PHPUnit\Framework\TestCase
{
    function setUp(): void
    {
        
    }

    function tearDown(): void
    {
        $userTest = $this->user();
        $userTest->delete($userTest->lastInsertId());
    }

    function user()
    {
        return new class('user') extends Record {
            protected $name, $email;
        };
    }

    function testCanCreate()
    {
        $userTest = $this->user();
        $this->assertInstanceOf(Record::class, $userTest);

        $userTest->name = 'alpha';
        $userTest->email = 'email';

        $userTest->create();
        return $userTest->lastInsertId();
    }

    function testException()
    {
        $userTest = $this->user();

        $this->expectException('\InvalidArgumentException');
        $userTest->caractere = 'huit';
    }

    /**
     * @depends testCanCreate
     */
    function testCanUpdate(int $lastId)
    {
        $userTest = $this->user();
        $userTest->get($lastId);

        $userTest->name='updated';
        $userTest->email='emailupdated';
        $userTest->update();

        $userTest = $this->user();
        $userTest->get($lastId);
        $this->assertSame('emailupdated', $userTest->email);
    }

    /**
     * @depends testCanCreate
     */
    function testCanDelete(int $lastId)
    {
        $userTest = $this->user();
        $this->assertTrue(is_int($lastId) && $lastId>1, 'Last id');
        $userTest->delete($lastId);
    }
}