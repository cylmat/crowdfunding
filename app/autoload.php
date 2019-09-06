<?php

function autoload($class)
{
    $file = str_replace('\\','/',CORE.$class.'.php');
    if(file_exists($file)) {
        require $file;
    } else {
        throw new InvalidArgumentException("La classe n'existe pas");
    }
}

spl_autoload_register('autoload');