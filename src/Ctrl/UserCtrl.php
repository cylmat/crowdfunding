<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\User as UserRecord;
use Classes\Session;

/**
 * Gestion utilisateurs
 */
class UserCtrl extends Ctrl
{
    /*
     * connexion
     */
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
        
        return [];
    }

    /**
     * Nouvelle inscription
     */
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
            $user->is_admin = 0;
            
            if(!ctype_digit($this->post['telephone'])) {
                $msg .= 'Le numéro de téléphone est erroné<br/>';
            }
           
            if($this->post['password'] === $this->post['retype_password'] && strlen($this->post['retype_password'])>2) {
                $pass = password_hash($this->post['password'], PASSWORD_DEFAULT);
                $user->password = $pass;
            } else {
                $msg .= 'Les mots de passe ne correspondent pas<br/>';
            }
            
            if(false !== $user->loginExists($this->post['login'])) {
                $msg .= "L'utilisateur existe déjà<br/>";
            } 

            //Check if user created
            if('' === $msg && $user->create()) {
                $this->setLoginOn($user, $user->lastInsertId());
                redirect(url('project_create'));
            }

            if($msg != '') {
                $msg = "Une erreur est survenue pendant la création du compte<br/>" . $msg;
            }
            
        }
        
        return [
            'msg' => $msg
        ];
    }
    
    /**
     * Deconnexion
     */
    function disconnectAction()
    {
        Session::destroy();
        redirect('/');
    }
    
    /**
     * Valide le login et l'insère en session 
     */
    private function setLoginOn(UserRecord $user, $id)
    {
        Session::set('id_user',$id);
        if('1' === $user->is_admin) {
            Session::set('id_admin', 1);
        }
        Session::set('nom_user',$user->nom);
        Session::set('prenom_user',$user->prenom);
    }
}
