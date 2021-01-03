<?php

session_start();

/**
 * Página principal da Aplicação que irá chamar o controlador
 */

use app\Controller as Controller;

require 'lib' . DIRECTORY_SEPARATOR . 'definitions.php';

$action = (isset($_GET['action'])) ? $_GET['action'] . 'Action' : 'indexAction';

Controller\Controller::$action($_POST);