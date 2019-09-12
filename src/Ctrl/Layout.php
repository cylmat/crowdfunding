<?php declare(strict_types = 1);

namespace Ctrl;

class Layout
{
    function headerAction()
    {
        return [
            'title'=>'titreendefault'
        ];
    }

    function footerAction()
    {
        return [
            'f'=>'ooter'
        ];
    }
}
