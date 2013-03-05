<?php
define("ROOT_PATH",  realpath(dirname(dirname(__FILE__)))."/");

require ROOT_PATH.'vendor/autoload.php';

\Saros\Application::run();