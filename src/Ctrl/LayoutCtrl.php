<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Classes\Session;

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
