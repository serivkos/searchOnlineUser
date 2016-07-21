<?php

ini_set('display_errors', 1);
ini_set('xdebug.max_nesting_level', '250');
set_time_limit(0);
error_reporting(E_ALL);

define("PATH_TO_CONTROLLER", '/var/www/test/controller/');
define("PATH_TO_VIEW", '/var/www/test/view/');
define("PATH_TO_MODELS", '/var/www/test/models/');

define("DB_HOST", 'mysql');
define("DB_NAME", 'test');
define("DB_PASSWORD", 'web');
define("DB_CHARSET", 'UTF8');

require PATH_TO_CONTROLLER . 'IndexController.php';
$controller = new IndexController();
$groupList = $controller->indexAction();
require_once PATH_TO_VIEW . 'index.php';

exit;

switch ($_SERVER['REQUEST_URI'])
{
    case '/':
        require PATH_TO_CONTROLLER . 'IndexController.php';
        $controller = new IndexController();
        $groupList = $controller->indexAction();
        require_once PATH_TO_VIEW . 'index.php';
        break;

    case '/addGroup':
        break;

    case '/getGroup':
        break;

    case '/listGroup':
        break;

    default:
        echo '404 page not found';
}