<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Classes\Records;

class DefaultCtrl extends Ctrl
{
    function indexAction()
    {
        $params = [
            'index'=>'alphanu'
        ];
        return $params;
    }
}
