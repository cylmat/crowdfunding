<?php

namespace Ctrl;

use Classes\Records;

class Defaults
{
    function indexAction()
    {
        //$user = new Record\User;
        //$user->name = 'alpha';
        /*
        $user->create();

        $user->getId(3);*/

        $params = [
            'index'=>'alphanu'
        ];
        return $params;
    }
}