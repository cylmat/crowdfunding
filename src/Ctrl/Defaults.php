<?php

namespace Ctrl;

class Defaults
{
    function indexAction()
    {
        /*$user = new UserEntity();
        $user->name = 'alpha';

        $userRepo = new UserRepo( $user );
        $userRepo->create();

        $userRepo->getId(3);*/

        $params = [
            'index'=>'alphanu'
        ];
        return $params;
    }
}