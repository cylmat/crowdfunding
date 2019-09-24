<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\User as UserRecord;
use Classes\Session;

class User extends Ctrl
{
    function signinAction()
    {
        $creation=null;

        //Envoi du formulaire
        if($this->post) {
            $user = new UserRecord('user');
            $login = $this->post['login'];
            ////password_hash($this->post['password'], PASSWORD_DEFAULT);
            $password = $this->post['password']; 

            if(null !== ($id = $user->checkLoginPassword($login, $password))) {
                Session::set('id_user',$id);
            }
        }
        
        return [
            
        ];
    }
    
    function subscribeAction()
    {
        $creation=null;

        //Envoi du formulaire
        if($this->post) {
            $user = new UserRecord('user');
            $user->login = $this->post['login'];

            if($this->post['password'] === $this->post['retype_password'] && strlen($this->post['retype_password'])>3) {
                $pass = $this->post['password']; //password_hash($this->post['password'], PASSWORD_DEFAULT);
                $user->password = $pass;
            }

            if(false === $user->loginExists($this->post['login'])) {
                $creation = $user->create();
            } else {
                $creation = 'already_exists';
            }
        }
        $msg = \Model\User::getFormMessage($creation);
        
        return [
            'msg' => $msg
        ];
    }
}
