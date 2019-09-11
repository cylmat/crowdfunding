<?php

define('APP', __DIR__.'/');
define('VIEW', APP.'views/');
define('CORE', __DIR__.'/../src/');
define('CONFIG', parse_ini_file(APP.'config.ini',true));

function autoload($class)
{
    $file = str_replace('\\','/',CORE.$class.'.php');
    if(file_exists($file)) {
        require_once $file;
    } 
}

spl_autoload_register('autoload');