<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

define('APP', __DIR__.'/app/');
define('VIEW', APP.'views/');
define('CORE', __DIR__.'/src/');

include APP.'autoload.php';

new Classes\App();