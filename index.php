<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

define('APP', __DIR__.'/app/');
define('VIEW', APP.'views/');
define('CORE', __DIR__.'/src/');
define('CONFIG', parse_ini_file(APP.'config.ini',true));

include APP.'autoload.php';

new Classes\App();