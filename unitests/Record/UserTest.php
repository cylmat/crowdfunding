<?php

namespace Record;

class UserTest extends \PHPUnit\Framework\TestCase
{
    function setUp(): void
    {
        $this->user = new User('user');
    }

    function tearDown(): void
    {
        $userTest = $this->user;
        $userTest->delete($userTest->lastInsertId());
    }

    function testCanCreate()
    {
        $userTest = $this->user;
        $this->assertInstanceOf(User::class, $userTest);

        $userTest->nom = 'alpha';
        $userTest->prenom = 'email';

        $userTest->create();
        return $userTest->lastInsertId();
    }

    function testException()
    {
        $userTest = $this->user;

        $this->expectException('\InvalidArgumentException');
        $userTest->caractere = 'huit';
    }

    /**
     * @depends testCanCreate
     */
    function testCanUpdate(int $lastId)
    {
        $userTest = $this->user;
        $userTest->get($lastId);

        $userTest->nom='updatednom';
        $userTest->prenom='preupdated';
        $userTest->update();

        $userTest = $this->user;
        $userTest->get($lastId);
        $this->assertSame('preupdated', $userTest->prenom);
    }

    /**
     * @depends testCanCreate
     */
    function testCanDelete(int $lastId)
    {
        $userTest = $this->user;
        $this->assertTrue(is_int($lastId) && $lastId>=0, 'Last id '.$lastId);
        $userTest->delete($lastId);
    }

    function testCanUpdateProperty()
    {
        $user = $this->user;
        $this->assertInstanceOf(User::class, $user);
        
        $user->nom = 'alpha';
        $this->assertEquals('alpha', $user->nom);

        $this->expectException('InvalidArgumentException');
        $user->notexistsproperty = 'nothing';
    }
}