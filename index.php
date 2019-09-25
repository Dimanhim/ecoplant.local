<?php

// Front controller
// Общие настройки

// Debug
// ini_set('display_errors', 1);
error_reporting(E_ALL);

// Production
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
/*ini_set('display_errors', 0);
error_reporting(0);*/

session_start();

define('ROOT', __DIR__);
define('PATH', str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']));

require_once(ROOT . '/config/params.php');
require_once(ROOT . '/components/Autoload.php');

// Вызов Router
$router = new Router();
$router->run();