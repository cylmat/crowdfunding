<?php

function autoload($class)
{
    $file = str_replace('\\','/',CORE.$class.'.php');

    if(file_exists($file)) {
        require $file;
    }
}

spl_autoload_register('autoload');