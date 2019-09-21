<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\User as UserRecord;

class User extends Ctrl
{
    function signinAction()
    {
        
    }
    
    function subscribeAction()
    {
        $creation=false;

        //Envoi du formulaire
        if($this->post) {
            $user = new UserRecord('user');
            $user->login = $this->post['login'];

            if($this->post['password'] === $this->post['retype_password']) {
                $pass = password_hash($this->post['password'], PASSWORD_DEFAULT);
                $user->password = $pass;
            }

            if(false === $user->loginExists($this->post['login'])) {
                $creation = $user->create();
            } else {
                $creation = 'already_exists';
            }
        }

        return [
            'creation'=>$creation
        ];
    }
}
