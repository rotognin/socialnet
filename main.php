<?php

/**
 * Página principal da Aplicação que irá chamar o controlador
 */

use App\Controller as Controller;

session_start();
require 'lib' . DIRECTORY_SEPARATOR . 'definitions.php';

$action = (isset($_GET['action'])) ? $_GET['action'] . 'Action' : 'indexAction';

Controller\Controller::$action($_POST);