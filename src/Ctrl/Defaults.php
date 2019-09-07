<?php

namespace Ctrl;

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