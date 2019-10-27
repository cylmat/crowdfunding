<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\User as UserRecord;
use Classes\Session;

class UserCtrl extends Ctrl
{
    //connexion
    function signinAction()
    {
        $creation=null;

        //Envoi du formulaire
        if($this->post) {
            $user = new UserRecord();
            $login = $this->post['login'];
            $password = $this->post['password'];

            if(null !== ($id = $user->checkLoginPassword($login, $password))) {
                $user->get($id);
                $this->setLoginOn($user, $id);
                redirect(url('project_listmy'));
            }
        }
        
        return [
            
        ];
    }

    function setLoginOn(UserRecord $user, $id)
    {
        Session::set('id_user',$id);
        if('1' === $user->is_admin) {
            Session::set('id_admin', 1);
        }
        Session::set('nom_user',$user->nom);
        Session::set('prenom_user',$user->prenom);
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
            $user = new UserRecord();
            $user->nom = $this->post['nom'];
            $user->prenom = $this->post['prenom'];
            $user->email = $this->post['email'];
            $user->telephone = $this->post['telephone'];
            $user->ville = $this->post['ville'];
            $user->login = $this->post['login'];

            if($this->post['password'] === $this->post['retype_password'] && strlen($this->post['retype_password'])>2) {
                $pass = password_hash($this->post['password'], PASSWORD_DEFAULT);
                $user->password = $pass;
            }

            if(false === $user->loginExists($this->post['login'])) {
                $creation = $user->create();
                if($creation) {
                    $this->setLoginOn($user, $user->lastInsertId());
                    redirect(url('project_create'));
                }
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
