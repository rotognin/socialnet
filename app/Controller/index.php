<?php

session_start();
require __DIR__ . DIRECTORY_SEPARATOR . 'definitions.php';

$action = (isset($_GET['action'])) ? $_GET['action'] . 'Action' : 'indexAction';

Controller::$action($_POST);