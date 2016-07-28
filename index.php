<?php
require_once 'config.php';

switch (substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?')))
{
    case '':
    case '/':
        require PATH_TO_CONTROLLER . 'IndexController.php';
        $controller = new IndexController();
        $groupList = $controller->getListAction();
        require_once PATH_TO_VIEW . 'index.php';
        break;

    case '/addGroup':
        require PATH_TO_CONTROLLER . 'IndexController.php';
        $controller = new IndexController();
        $status = $controller->addAction();
        require_once PATH_TO_VIEW . 'addGroup.php';
        break;

    case '/deleteGroup':
        require PATH_TO_CONTROLLER . 'IndexController.php';
        $controller = new IndexController();
        $groupList = $controller->deleteAction();
        break;

    default:
        echo '404 page not found';
}