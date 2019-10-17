<?php

function autoload($class)
{
    $file = str_replace('\\','/',CORE.$class.'.php');
    if(file_exists($file)) {
        require_once $file;
    } 
}

spl_autoload_register('autoload');

require_once 'tools.php';