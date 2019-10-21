<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

define('APP', __DIR__.'/app/');
define('VIEW', APP.'views/');
define('CORE', APP.'/../src/');
define('CONFIG', parse_ini_file(APP.'config.ini',true));
define('ASSETS', APP.'../assets/');

/* lien relatif */
define('REL_ASSETS', 'assets/');

include 'app/autoload.php';

new Classes\App();