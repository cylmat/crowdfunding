<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Classes\Session;

class LayoutCtrl extends Ctrl
{
    function headerAction()
    {
        Session::start();
        
        $user = Session::get('id_user');
        $logged = null!==$user ? true : false;

        return [
            'user' => $user,
            'logged' => $logged
        ];
    }

    function footerAction()
    {
        $user = Session::get('id_user');
        $logged = null!==$user ? true : false;

        return [
            'user' => $user,
            'logged' => $logged
        ];
    }
}
