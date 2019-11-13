<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Classes\Session;

/**
 * Layout général
 */
class LayoutCtrl extends Ctrl
{
    function headerAction()
    {
        Session::start();
        
        $id_user = Session::get('id_user');
        $user = null!==$id_user ? Session::get('user_name') : false;
        $logged = null!==$id_user ? true : false;
        $admin = $logged?(Session::get('is_admin')?true:false):false;

        return [
            'user' => $user,
            'logged' => $logged,
            'is_admin' => $admin
        ];
    }

    /**
     * Bannière de la page d'accueil
     */
    function bannerAction()
    {     
        if(empty($_GET))
            return [
                'banner_html'=>1
            ];
        return ['banner_html'=>0];
    }

    function footerAction()
    {
        $id_user = Session::get('id_user');
        $user = null!==$id_user ? Session::get('user_name') : false;
        $logged = null!==$id_user ? true : false;
        $admin = $logged?(Session::get('is_admin')?true:false):false;

        return [
            'user' => $user,
            'logged' => $logged,
            'is_admin' => $admin
        ];
    }
}
