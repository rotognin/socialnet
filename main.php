<?php

session_start();

/**
 * Página principal da Aplicação que irá chamar o controlador
 * 
 * Melhorias:
 * - Em vez de ficar chamando o Controller, passar uma identificação de onde estiver vindo
 *   para chamar o controlador específico.
 *   Exemplo: na criação de novo usuário, não precisa ir para Controller::newuser,
 *   criar uma identificação para ir para UserController::newuser.
 */

use app\Controller as Controller;

require 'lib' . DIRECTORY_SEPARATOR . 'definitions.php';

$action = (isset($_GET['action'])) ? $_GET['action'] . 'Action' : 'homeAction';
Controller\Controller::$action($_POST);

/**
 * A ser estudado e implementado para deixar mais dinâmica a chamada das classes de Controle
 */
//$target = (isset($_POST['target'])) ? 'Controller\\' . ucfirst($_POST['target']) . 'Controller' : 'Controller\\Controller';
//call_user_func(array($target, $action), $_POST);



