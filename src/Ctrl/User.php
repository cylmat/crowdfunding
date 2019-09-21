<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\User as UserRecord;

class User extends Ctrl
{
    function signinAction()
    {
        $isCreated=false;

        //Envoi du formulaire
        if($this->post) {
            $user = new UserRecord('user');
            $user->login = $this->post['login'];
            $user->password = $this->post['password'];
            $isCreated=true;
        }

        return [
            ['isCreated'=>$isCreated]
        ];
    }

    function subscribeAction()
    {

    }
}
