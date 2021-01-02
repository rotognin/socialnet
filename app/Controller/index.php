<?php

session_start();
require __DIR__ . DIRECTORY_SEPARATOR . 'definitions.php';

$action = (isset($_GET['action'])) ? $_GET['action'] . 'Action' : 'indexAction';

require DIR['controller'] . 'Controller.php';
Controller::$action($_POST);