<?php

require_once './config.php';

require PATH_TO_CONTROLLER . 'IndexController.php';
$controller = new IndexController();
$groupList = $controller->syncAction();

echo 'success';