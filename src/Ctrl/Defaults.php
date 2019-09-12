<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Records;

class Defaults
{
    function indexAction()
    {
        $params = [
            'index'=>'alphanu'
        ];
        return $params;
    }
}
