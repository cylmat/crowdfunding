<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\User as UserRecord;
use Classes\Session;

class UserCtrl extends Ctrl
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
                redirect('/');
            }
        }
        
        return [
            
        ];
    }

    function disconnectAction()
    {
        Session::destroy();
        redirect('/');
    }
    
    function subscribeAction()
    {
        $creation=null;
        $msg = '';

        //Envoi du formulaire
        if($this->post) {
            $user = new UserRecord('user');
            $user->nom = $this->post['nom'];
            $user->prenom = $this->post['prenom'];
            $user->email = $this->post['email'];
            $user->telephone = $this->post['telephone'];
            $user->ville = $this->post['ville'];
            $user->login = $this->post['login'];

            if($this->post['password'] === $this->post['retype_password'] && strlen($this->post['retype_password'])>2) {
                $pass = $this->post['password']; //password_hash($this->post['password'], PASSWORD_DEFAULT);
                $user->password = $pass;
            }

            if(false === $user->loginExists($this->post['login'])) {
                //$user->debug = true;
                $creation = $user->create();
            } else {
                $creation = 'already_exists';
            }
            $msg = \Model\UserModel::getFormMessage($creation) . $user->getLastError();
        }
        
        return [
            'msg' => $msg
        ];
    }
}
