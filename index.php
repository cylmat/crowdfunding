<?php

error_reporting(E_ALL);

define('APP', __DIR__.'/app/');
define('VIEW', APP.'views/');
define('CORE', __DIR__.'/src/');

include APP.'autoload.php';

new Classes\App();