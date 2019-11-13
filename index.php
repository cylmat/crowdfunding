<?php

define('APP', __DIR__.'/app/');
define('VIEW', APP.'views/');
define('CORE', APP.'../src/');

define('ASSETS', APP.'../assets/');

/* lien relatif */
define('REL_ASSETS', 'assets/');


$dist = '';
if('crowdfunding:8888' == $_SERVER['HTTP_HOST']) {
    error_reporting(E_ALL);
    ini_set('display_errors',1);
}

if('3wa.camency.fr' == $_SERVER['HTTP_HOST']) {
    $dist = '.dist';
}

define('CONFIG', parse_ini_file(APP.'config.ini'.$dist,true));

//debug breakpoint
function d($brk, $txt='') 
{
    if(empty($_GET['debug'])) return;
    if($brk == $_GET['debug']) {
        exit($brk.' '.$txt); 
    }
}

include 'app/autoload.php';

new Classes\App();
