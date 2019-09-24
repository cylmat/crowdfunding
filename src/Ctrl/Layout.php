<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Session;

class Layout
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
        return [
            
        ];
    }
}
