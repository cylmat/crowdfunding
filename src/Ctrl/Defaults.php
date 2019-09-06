<?php

namespace Ctrl;

class Defaults
{
    function indexAction()
    {
        echo 'i';
        $params = [
            'index'=>'test'
        ];
        return $params;
    }
}