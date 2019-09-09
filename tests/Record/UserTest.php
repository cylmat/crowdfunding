<?php

namespace Record;

class UserTest extends \PHPUnit\Framework\TestCase
{
    function testAlpha()
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
        //$user->name = 'alpha';

        /*$userRepo = new UserRepo( $user );
        $userRepo->create();

        $userRepo->getId(3);*/
    }
}