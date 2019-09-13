<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

/*IntlChar::chr(0x26b6).'<br/>'.
mb_convert_encoding("\x26\xb7", 'UTF-8', 'UTF-16') .'<br/>'.
"\u{1f600}".'<br/>';*/

include 'app/autoload.php';

new Classes\App();